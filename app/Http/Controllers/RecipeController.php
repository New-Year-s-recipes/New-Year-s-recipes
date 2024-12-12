<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use App\Models\Tip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::withCount(['favorites' => function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30)) // Только за последние 30 дней
            ->where('status', 'Одобрен'); // Только с статусом "Одобрен"
        }])
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

    public function category($category) {
        $dishes = Recipe::all()->where('status', 'Одобрен')->where('category', $category);

        return view('recipe.recipesByCategory', compact('dishes', 'category'));
    }

    public function addRecipeShow()
    {
        return view('recipe.add');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $path = $request->file('photo')->store('images', 'public');

        $ingredientsArray = array_map(function ($ingredient, $index) use ($validated) {
            return [
                'name' => trim($validated['ingredients'][$index]),
                'quantity' => trim($validated['ingredient_quantity'][$index]),
                'unit' => trim($validated['ingredient_unit'][$index]),
            ];
        }, $validated['ingredients'], array_keys($validated['ingredients']));

        $stepsArray = $validated['steps'];

        $cookingTime = $validated['cooking_hours'] . ':' . str_pad($validated['cooking_minutes'], 2, '0', STR_PAD_LEFT);

        $recipeData = [
            'description' => $validated['description'],
            'cooking_time' => $cookingTime,
            'calorie' => $validated['calorie'],
            'ingredients' => $ingredientsArray,
            'steps' => $stepsArray,
        ];

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'mini_description' => $validated['mini_description'],
            'data' => $recipeData,
            'category' => $validated['category'],
            'complexity' => $validated['complexity'],
            'path' => $path,
        ]);

        return redirect()->back()->with('success', 'Рецепт успешно записан!');
    }


    public function destroy($id) {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return redirect()->back()->with('success', 'Рецепт удален');
    }

    public function editShow($id) {
        $recipe = Recipe::findOrFail($id);

        return view('recipe.edit', compact('recipe'));
    }

    public function edit(Request $request, $id)
    {
        $validated = $this->validateData($request, true);

        // Обработка ингредиентов из трех отдельных массивов
        $ingredientsArray = array_map(function ($name, $index) use ($validated) {
            return [
                'name' => trim($name),
                'quantity' => trim($validated['ingredient_quantity'][$index]),
                'unit' => trim($validated['ingredient_unit'][$index]),
            ];
        }, $validated['ingredients'], array_keys($validated['ingredients']));

        // Обработка шагов
        $stepsArray = array_map('trim', $validated['steps']);

        $cookingHours = $validated['cooking_hours'];
        $cookingMinutes = $validated['cooking_minutes'];

        // Подготовка данных для хранения в формате JSON
        $recipeData = [
            'description' => $validated['description'],
            'cooking_time' => $cookingHours . ':' . str_pad($cookingMinutes, 2, '0', STR_PAD_LEFT),
            'calorie' => $validated['calorie'],
            'ingredients' => $ingredientsArray,
            'steps' => $stepsArray,
        ];

        // Поиск рецепта по ID
        $recipe = Recipe::findOrFail($id);

        // Обновление полей рецепта
        $recipe->title = $validated['title'];
        $recipe->mini_description = $validated['mini_description'];
        $recipe->category = $validated['category'];
        $recipe->complexity = $validated['complexity'];
        $recipe->data = $recipeData;

        // Если есть новое изображение, сохраняем его
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images', 'public');
            $recipe->path = $path;
        }

        $recipe->save();

        return redirect()->back()->with('success', 'Рецепт успешно обновлён!');
    }



    public function more($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->increment('views'); // Увеличивает поле `views` на 1
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
            'ingredient_quantity.*' => 'required|integer|min:1',

            'ingredient_unit' => 'required|array|min:1',
            'ingredient_unit.*' => 'required|string|in:г,кг,мл,л,шт,чашка,ст. ложка,чайная ложка',

            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
        ]);

        return $validated;
    }

}
