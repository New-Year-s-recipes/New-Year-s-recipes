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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cooking_time' => 'required|string|max:50',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
        ]);

        $ingredientsArray = preg_split('/\r\n|\r|\n/', $validated['ingredients']);
        $stepsArray = preg_split('/\r\n|\r|\n/', $validated['steps']);

        $recipeData = [
            'cooking_time' => $validated['cooking_time'],
            'ingredients' => array_map(function ($ingredient) {
                return ['name' => trim($ingredient)];
            }, $ingredientsArray),
            'steps' => array_map('trim', $stepsArray)
        ];

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'data' => $recipeData
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cooking_time' => 'required|string|max:50',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
        ]);

        // Преобразование ингредиентов и шагов в массивы
        $ingredientsArray = preg_split('/\r\n|\r|\n/', $validated['ingredients']);
        $stepsArray = preg_split('/\r\n|\r|\n/', $validated['steps']);

        // Обработка данных для сохранения в формате JSON
        $recipeData = [
            'cooking_time' => $validated['cooking_time'],
            'ingredients' => array_map(function ($ingredient) {
                return ['name' => trim($ingredient)];
            }, $ingredientsArray),
            'steps' => array_map('trim', $stepsArray)
        ];

        // Поиск рецепта по ID
        $recipe = Recipe::findOrFail($id);

        // Обновление полей рецепта
        $recipe->title = $validated['title'];
        $recipe->data = $recipeData;
        $recipe->save();

        return redirect()->back()->with('success', 'Рецепт успешно обновлён!');
    }

}
