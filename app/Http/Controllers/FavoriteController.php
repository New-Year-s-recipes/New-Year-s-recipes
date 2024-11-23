<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recipes = $user->favorites;

        $ratings = Rating::all();

        $averageRatings = $ratings->groupBy('recipe_id')->map(function ($ratings) {
            return $ratings->avg('rating');
        });

        return view('user.favorite', compact('recipes', 'averageRatings'));
    }

    public function store($recipeId)
    {
        $user = Auth::user();

        // Проверка на существование
        if (!$user->favorites->contains($recipeId)) {
            $user->favorites()->attach($recipeId);
        }

        return redirect()->back()->with('success', 'Рецепт добавлен в избранное.');
    }

    public function destroy($recipeId)
    {
        $user = Auth::user();

        // Удаление из избранного
        $user->favorites()->detach($recipeId);

        return redirect()->back()->with('success', 'Рецепт удален из избранного.');
    }
}
