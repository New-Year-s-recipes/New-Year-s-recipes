<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);

        return redirect()->intended('/recipes');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
           'email' => 'required|email',
           'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            return redirect()->intended('/');
        }
        return redirect()->back()->with('error', 'Неверный email или пароль');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function profile() {
        $user = Auth::user();
        $recipes = $user->recipes;

        $ratings = Rating::all();

        $averageRatings = $ratings->groupBy('recipe_id')->map(function ($ratings) {
            return $ratings->avg('rating');
        });

        return view('user.profile', compact('user', 'recipes', 'averageRatings'));
    }
}
