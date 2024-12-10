<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $recipes = Recipe::query()
            ->where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('category', 'LIKE', "%{$searchTerm}%")
            ->orWhere('complexity', 'LIKE', "%{$searchTerm}%")
            ->orWhere('user_id', function ($query) use ($searchTerm) {
                $query->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%{$searchTerm}%");
            })
            ->orWhereJsonContains('data->description', $searchTerm)
            ->orWhereJsonContains('data->ingredients', $searchTerm)
            ->orWhereJsonContains('data->steps', $searchTerm)
            ->get();

        return view('recipe.index', compact('recipes', 'searchTerm', 'request'));
    }

    public function sorting(Request $request)
    {
        $query = Recipe::query();

        // Фильтрация
        if ($request->category != null && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->complexity != null && $request->complexity) {
            $query->where('complexity', $request->complexity);
        }

        if ($request->min_calories != null && $request->max_calories != null) {
            $query->whereBetween('data->calorie', [$request->min_calories, $request->max_calories]);
        }

        // Сортировка
        if ($request->sort_by != null) {
            $sortBy = $request->sort_by;
            $sortOrder = $request->has('sort_order') && $request->sort_order === 'desc' ? 'desc' : 'asc';

            switch ($sortBy) {
                case 'cooking_time':
                    $query->orderBy('data->cooking_time', $sortOrder);
                    break;
                case 'calorie':
                    $query->orderBy('data->calorie', $sortOrder);
                    break;
            }
        }

        $recipes = $query->get();

        return view('recipe.index', compact('recipes', 'request'));
    }



}
