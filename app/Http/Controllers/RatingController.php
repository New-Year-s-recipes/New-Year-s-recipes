<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
       $validator = $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $userRating = Rating::updateOrCreate(
            ['recipe_id' => $request->recipe_id, 'user_id' => Auth::id()],
            ['rating' => $request->rating]
        );
        return redirect()->back()->with('success', 'Рейтинг успешно добавлен!');
    }
}
