<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();

        return view('recipe.index', compact('recipes'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $ingredientsArray = preg_split('/\r\n|\r|\n/', $validated['ingredients']);
        $stepsArray = preg_split('/\r\n|\r|\n/', $validated['steps']);
        $path = $request->file('photo')->store('images', 'public');


        $recipeData = [
            'description' => $validated['description'],
            'cooking_time' => $validated['cooking_time'],
            'calorie' => $validated['calorie'],
            'ingredients' => array_map(function ($ingredient) {
                return ['name' => trim($ingredient)];
            }, $ingredientsArray),
            'steps' => array_map('trim', $stepsArray)
        ];

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
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

    public function edit(Request $request, $id) {
        $validated = $this->validateData($request, $isUpdate = true);

        // Преобразование ингредиентов и шагов в массивы
        $ingredientsArray = preg_split('/\r\n|\r|\n/', $validated['ingredients']);
        $stepsArray = preg_split('/\r\n|\r|\n/', $validated['steps']);

        // Обработка данных для сохранения в формате JSON
        $recipeData = [
            'description' => $validated['description'],
            'cooking_time' => $validated['cooking_time'],
            'calorie' => $validated['calorie'],
            'ingredients' => array_map(function ($ingredient) {
                return ['name' => trim($ingredient)];
            }, $ingredientsArray),
            'steps' => array_map('trim', $stepsArray)
        ];




        // Поиск рецепта по ID
        $recipe = Recipe::findOrFail($id);

        // Обновление полей рецепта
        $recipe->title = $validated['title'];
        $recipe->category = $validated['category'];
        $recipe->complexity = $validated['complexity'];
        $recipe->data = $recipeData;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images', 'public');
            $recipe->path = $path;
        }

        $recipe->save();

        return redirect()->back()->with('success', 'Рецепт успешно обновлён!');
    }

    private function validateData(Request $request, $isUpdate = false)
    {
        $photoRule = $isUpdate ? 'image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'photo' => $photoRule,
            'description' => 'required|string|max:255',
            'category' => 'required|in:Горячее,Холодное,Десерт',
            'complexity' => 'required|in:Высокая,Средняя,Низкая',
            'calorie'=> 'required|integer|min:1',
            'cooking_time' => 'required|string|max:50',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
        ]);

        return $validated;
    }

}
