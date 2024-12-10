<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::all()->where('status', 'Одобрен');
        $ratings = Rating::all();

        $averageRatings = $ratings->groupBy('recipe_id')->map(function ($ratings) {
            return $ratings->avg('rating');
        });

        return view('recipe.index', compact('recipes', 'averageRatings', 'request'));
    }

    public function category($category) {
        $dishes = Recipe::all()->where('status', 'Одобрен')->where('category', $category);

        return view('recipe.recipesByCategory', compact('dishes', 'category'));
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

        $recipeData = [
            'description' => $validated['description'],
            'cooking_time' => $validated['cooking_time'],
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

        // Подготовка данных для хранения в формате JSON
        $recipeData = [
            'description' => $validated['description'],
            'cooking_time' => $validated['cooking_time'],
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
            'cooking_time' => 'required|string',

            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string|max:100',

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
