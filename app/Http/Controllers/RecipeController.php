<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use App\Models\Tip;
use App\Models\Step;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Log;
use Storage;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::withCount([
            'favorites' => function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30)) // Только за последние 30 дней
                    ->where('status', 'Одобрен'); // Только с статусом "Одобрен"
            }
        ])
            ->whereHas('favorites', function ($query) {
                $query->where('status', 'Одобрен'); // Учитываем только одобренные рецепты
            })
            ->orderByDesc('views') // Сортировка по просмотрам
            ->take(10) // Ограничиваем выборку до 10
            ->get();

        //Если нет фаворитов
        if ($recipes->isEmpty()) {
            $recipes = Recipe::where('status', 'Одобрен') // Только одобренные
                ->orderByDesc('views')
                ->take(10)
                ->get();
        }

        // расчёт популярности
        $popularRecipes = $recipes->map(function ($recipe) {
            $recipe->popularity_score = $recipe->views + ($recipe->favorites_count * 10); // Индекс популярности
            return $recipe;
        })->sortByDesc('popularity_score')->take(10);

        // Фильтры по категориям
        $hots = $popularRecipes->filter(function ($recipe) {
            return $recipe->category === 'Горячее';
        });

        $deserts = $popularRecipes->filter(function ($recipe) {
            return $recipe->category === 'Десерты';
        });

        $colds = $popularRecipes->filter(function ($recipe) {
            return $recipe->category === 'Холодное';
        });


        $ratings = Rating::all();

        $averageRatings = $ratings->groupBy('recipe_id')->map(function ($ratings) {
            return $ratings->avg('rating');
        });

        $adviceOfTheDay = Cache::remember('advice_of_the_day', Carbon::now()->addDay(), function () {
            return Tip::with('user')->inRandomOrder()->first();
        });

        return view('recipe.index', compact('popularRecipes', 'hots', 'deserts', 'colds', 'averageRatings', 'request', 'adviceOfTheDay'));
    }

    public function category($category)
    {
        $dishes = Recipe::all()->where('status', 'Одобрен')->where('category', $category);

        return view('recipe.recipesByCategory', compact('dishes', 'category'));
    }

    public function addRecipeShow()
    {
        return view('recipe.add');
    }

    public function store(Request $request)
    {
        // Валидация данных
        $data = $request->validate([
            'title' => 'required|string|max:100',
            'photo' => 'required|file|image|mimes:jpeg,jpg,png|max:2048',
            'description' => 'required|string',
            'mini_description' => 'required|string',
            'category' => 'required|in:Горячее,Холодное,Десерты',
            'complexity' => 'required|in:Высокая,Средняя,Низкая',
            'calorie' => 'required|integer|min:1',

            'cooking_hours' => 'required|integer|min:0|max:24',
            'cooking_minutes' => 'required|integer|min:0|max:59',

            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',

            'ingredient_quantity' => 'required|array|min:1',
            'ingredient_quantity.*' => 'required|integer|min:1',

            'ingredient_unit' => 'required|array|min:1',
            'ingredient_unit.*' => 'required|string|in:г,кг,мл,л,шт,чашка,ст. ложка,чайная ложка',

            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
            'step_photos.*' => 'nullable|file|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Сохранение главного изображения
        $photoPath = $request->file('photo')->store('images', 'public');

        // Сохранение рецепта
        $cookingTime = $data['cooking_hours'] . ':' . str_pad($data['cooking_minutes'], 2, '0', STR_PAD_LEFT);

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'mini_description' => $data['mini_description'],
            'data' => [
                'description' => $data['description'],
                'cooking_time' => $cookingTime,
                'calorie' => $data['calorie'],
                'ingredients' => array_map(function ($name, $index) use ($data) {
                    return [
                        'name' => $name,
                        'quantity' => $data['ingredient_quantity'][$index],
                        'unit' => $data['ingredient_unit'][$index],
                    ];
                }, $data['ingredients'], array_keys($data['ingredients'])),
            ],
            'category' => $data['category'],
            'complexity' => $data['complexity'],
            'path' => $photoPath,
        ]);

        // Сохранение шагов рецепта с фото
        $steps = $data['steps'];
        $stepPhotos = $request->file('step_photos');

        foreach ($steps as $index => $step) {
            $photoPath = null;

            // Если есть фото для этого шага, сохраняем его
            if (isset($stepPhotos[$index])) {
                $photoPath = $stepPhotos[$index]->store('steps_photos', 'public');
            }

            Step::create([
                'recipe_id' => $recipe->id,
                'description' => $step,
                'photo' => $photoPath,
            ]);
        }

        return redirect()->back()->with('success', 'Рецепт успешно добавлен!');
    }


    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return redirect()->back()->with('success', 'Рецепт удален');
    }

    public function editShow($id)
    {
        $recipe = Recipe::findOrFail($id);

        // Проверяем и преобразуем ingredients в массив
        $ingredients = isset($recipe->data['ingredients']) ? (
            is_string($recipe->data['ingredients']) ?
            json_decode($recipe->data['ingredients'], true) : (array) $recipe->data['ingredients']
        ) : [];

        // Проверяем и преобразуем steps в массив
        $steps = isset($recipe->data['steps']) ? (
            is_string($recipe->data['steps']) ?
            json_decode($recipe->data['steps'], true) : (array) $recipe->data['steps']
        ) : [];

        $recipe->setAttribute('data', [
            'ingredients' => $ingredients,
            'steps' => $steps,
            'description' => $recipe->data['description'] ?? '',
            'cooking_time' => $recipe->data['cooking_time'] ?? '00:00',
            'calorie' => $recipe->data['calorie'] ?? 0,
        ]);
        return view('recipe.edit', compact('recipe'));
    }

    public function edit(Request $request, $id)
    {
        $request->all(); 

        $validated = $this->validateData($request, true);

        // Обработка ингредиентов
        if (isset($validated['ingredients']) && is_array($validated['ingredients'])) {
            $ingredientsArray = [];
            foreach ($validated['ingredients'] as $index => $name) {
                if (trim($name)) {
                    $ingredientsArray[] = [
                        'name' => trim($name),
                        'quantity' => trim($validated['ingredient_quantity'][$index] ?? ''),
                        'unit' => trim($validated['ingredient_unit'][$index] ?? ''),
                    ];
                }
            }
        } else {
            $ingredientsArray = [];
        }

        // Обработка шагов
        if (isset($validated['steps']) && is_array($validated['steps'])) {
            $stepsArray = array_map('trim', $validated['steps']);
        } else {
            $stepsArray = [];
        }

        $cookingHours = $validated['cooking_hours'];
        $cookingMinutes = $validated['cooking_minutes'];

        try {
            $recipeData = [
                'description' => $validated['description'],
                'cooking_time' => $cookingHours . ':' . str_pad($cookingMinutes, 2, '0', STR_PAD_LEFT),
                'calorie' => $validated['calorie'],
                'ingredients' => json_encode($ingredientsArray),
                'steps' => json_encode($stepsArray),
            ];
        } catch (\Exception $e) {
            Log::error('Ошибка в формировании $recipeData: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при обновлении рецепта.');
        }

        $recipe = Recipe::findOrFail($id);
        $recipe->title = $validated['title'];
        $recipe->mini_description = $validated['mini_description'];
        $recipe->category = $validated['category'];
        $recipe->complexity = $validated['complexity'];
        $recipe->data = $recipeData;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images', 'public');
            $recipe->path = $path;
        }

        try {
            $recipe->save();
        } catch (\Exception $e) {
            Log::error('Ошибка при сохранении данных: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при обновлении рецепта.');
        }

        // Сохранение шагов рецепта
        $recipe->steps()->delete();  // Удаляем старые шаги
        if (isset($validated['steps']) && is_array($validated['steps'])) {
            foreach ($validated['steps'] as $index => $step) {
                $stepPhoto = null;
                // Проверяем, есть ли загрузка новой фотографии для шага
                if ($request->hasFile("step_photo." . $index)) {
                    $stepPhoto = $request->file("step_photo." . $index)->store('images', 'public');
                } else if (isset($validated['step_photo_delete']) && isset($validated['step_photo_delete'][$index])) {
                    // Если нужно удалить фото
                    $stepPhoto = null;
                } else if (isset($validated['old_step_photo']) && isset($validated['old_step_photo'][$index])) {
                    // Если фото осталось тем же
                    $stepPhoto = $validated['old_step_photo'][$index];
                }
                try {
                    Step::create([
                        'recipe_id' => $recipe->id,
                        'description' => trim($step),
                        'photo' => $stepPhoto,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Ошибка при создании шага: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Ошибка при обновлении рецепта.');
                }
            }
        }
        return redirect()->back()->with('success', 'Рецепт успешно обновлён!');
    }


    public function more($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->increment('views');
        $userRatings = Rating::all()->where('user_id', Auth::id())->where('recipe_id', $recipe->id)->first();

        $ratings = Rating::all();

        $averageRatings = $ratings->groupBy('recipe_id')->map(function ($ratings) {
            return $ratings->avg('rating');
        });

        return view('recipe.show', compact('recipe', 'userRatings', 'averageRatings'));
    }

    private function validateData(Request $request, $isUpdate = false)
    {
        $photoRule = $isUpdate ? 'image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048';

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'photo' => $photoRule,
            'description' => 'required|string',
            'mini_description' => 'required|string',
            'category' => 'required|in:Горячее,Холодное,Десерты',
            'complexity' => 'required|in:Высокая,Средняя,Низкая',
            'calorie' => 'required|integer|min:1',

            'cooking_hours' => 'required|integer|min:0|max:24',
            'cooking_minutes' => 'required|integer|min:0|max:59',

            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',

            'ingredient_quantity' => 'required|array|min:1',
            'ingredient_quantity.*' => 'required|string|min:1',

            'ingredient_unit' => 'required|array|min:1',
            'ingredient_unit.*' => 'required|string',

            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
        ]);

        return $validated;
    }
    public function show($id)
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            abort(404);
        }
        if (isset($recipe->data['ingredients'])) {
            if (is_string($recipe->data['ingredients'])) {
                $recipe->data['ingredients'] = json_decode($recipe->data['ingredients'], true);
            } else {
                $recipe->data['ingredients'] = (array) $recipe->data['ingredients'];
            }
        }

        if (isset($recipe->data['steps'])) {
            if (is_string($recipe->data['steps'])) {
                $recipe->data['steps'] = json_decode($recipe->data['steps'], true);
            } else {
                $recipe->data['steps'] = (array) $recipe->data['steps'];
            }
        }
        return view('recipe.show', ['recipe' => $recipe]);
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);
    
        if (!$recipe) {
            return back()->with('error', 'Рецепт не найден');
        }
    
        // 1. Получаем копию массива $data
        $data = $recipe->data;
    
        // 2. Обновляем поля в копии массива
        $data['description'] = $request->input('description', $data['description'] ?? '');
        $data['calorie'] = $request->input('calorie', $data['calorie'] ?? 0);
        $data['cooking_time'] = $request->input('cooking_hours') . ':' . $request->input('cooking_minutes');
    
        // 3. Присваиваем копию обратно полю data
        $recipe->data = $data;
        $recipe->save();
    
        // Обновление ингредиентов
        if ($request->has('ingredients')) {
           $ingredients = $request->input('ingredients', []);
           $quantities = $request->input('ingredient_quantity', []);
           $units = $request->input('ingredient_unit', []);
            $data = is_string($recipe->data) ? json_decode($recipe->data, true) : $recipe->data ?? [];
            $data['ingredients'] = [];
            foreach ($ingredients as $index => $ingredient) {
                $data['ingredients'][] = [
                   'name' => $ingredient,
                    'quantity' => $quantities[$index] ?? null,
                   'unit' => $units[$index] ?? null,
               ];
            }
             $recipe->data = $data;
           $recipe->save();
       }
    
        // Обновление шага рецепта
        $steps = $request->input('steps', []);
        $oldStepIds = collect($recipe->steps)->pluck('id')->all();
        $i = 0;
    
        foreach ($steps as $index => $description) {
            $step = Step::find($oldStepIds[$i] ?? null);
            if (!$step) {
                 $step = new Step();
             }
             $step->description = $description;
    
            if ($request->hasFile("step_photos.$index")) {
                // Удаляем старое фото, если оно есть
                if ($step->photo) {
                   Storage::disk('public')->delete($step->photo);
                }
                // Сохраняем новое фото
                $photoPath = $request->file("step_photos.$index")->store('steps_photos', 'public');
                $step->photo = $photoPath;
             }
    
            $recipe->steps()->save($step);
            $i++;
         }
    
        // Удаление старых шагов, которые больше не используются
        if (count($recipe->steps) > $i){
           $deleteSteps = $recipe->steps()->whereNotIn('id', array_slice($oldStepIds, 0, $i))->get();
            foreach ($deleteSteps as $step){
                if ($step->photo){
                   Storage::disk('public')->delete($step->photo);
                }
               $step->delete();
             }
          }
    
        // Если фото рецепта было обновлено, удаляем старое изображение
        if ($request->hasFile('photo')) {
            // Удаление старого фото
            if ($recipe->path && file_exists(storage_path('app/public/' . $recipe->path))) {
                Storage::disk('public')->delete($recipe->path);
            }
    
            // Сохранение нового фото
            $path = $request->file('photo')->store('images', 'public');
            $recipe->path = $path;
        }
    
        // Сохранение изменений рецепта
        $recipe->title = $request->input('title');
        $recipe->mini_description = $request->input('mini_description');
        $recipe->category = $request->input('category');
        $recipe->complexity = $request->input('complexity');
        $recipe->save();
    
        return back()->with('success', 'Рецепт успешно обновлен!');
    }
}
