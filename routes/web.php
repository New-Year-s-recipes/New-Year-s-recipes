<?php

use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/registerPage', [UserController::class, 'registerPage'])->name('registerPage')->middleware('guest');
Route::post('/register', [UserController::class, 'register'])->name('register')->middleware('guest');

Route::get('/login', [UserController::class, 'loginPage'])->name('loginPage')->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/', [RecipeController::class, 'index'])->name('homePage')->middleware('auth');
Route::post('/recipes/store', [RecipeController::class, 'store'])->name('recipes_store')->middleware('auth');

Route::get('/destroy/{id}', [RecipeController::class, 'destroy'])->name('recipes_destroy')->middleware('auth');
Route::get('/edit/{id}', [RecipeController::class, 'editShow'])->name('recipes_edit_show')->middleware('auth');
Route::post('/edit/{id}', [RecipeController::class, 'edit'])->name('recipes_edit')->middleware('auth');

Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile')->middleware('auth');

Route::post('/ratings', [RatingController::class, 'store'])->name('ratings_store');
