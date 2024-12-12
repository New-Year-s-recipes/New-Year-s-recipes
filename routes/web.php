<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TipController;
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

Route::get('/', [RecipeController::class, 'index'])->name('homePage');
Route::get('/recipes/more/{id}', [RecipeController::class, 'more'])->name('recipesPage');
Route::get('/recipes/{category}', [RecipeController::class, 'category'])->name('recipesByCategory');
Route::post('/recipes', [SearchController::class, 'index'])->name('recipes.search');
Route::get('/recipes', [SearchController::class, 'sorting'])->name('recipes.sorting');
Route::get('/tips', [TipController::class, 'index'])->name('tips.index');
Route::get('/tips/more/{id}', [TipController::class, 'more'])->name('tipsPage');

Route::get('/experts-tips', function () {
    return view('experts-tips');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'registerPage'])->name('registerPage');
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::get('/login', [UserController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware('user')->group(function () {
        Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');

        Route::get('/recipes/add/new-recipe', [RecipeController::class, 'addRecipeShow'])->name('recipes.add');
        Route::post('/recipes/store', [RecipeController::class, 'store'])->name('recipes_store');

        Route::get('/destroy/recipe/{id}', [RecipeController::class, 'destroy'])->name('recipes_destroy');
        Route::get('/edit/recipe/{id}', [RecipeController::class, 'editShow'])->name('recipes_edit_show');
        Route::post('/edit/recipe/{id}', [RecipeController::class, 'edit'])->name('recipes_edit');

        Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
        Route::post('/recipes/{id}/favorite', [FavoriteController::class, 'store'])->name('favorite.add');
        Route::post('/recipes/{id}/unfavorite', [FavoriteController::class, 'destroy'])->name('favorite.remove');

        Route::post('/ratings', [RatingController::class, 'store'])->name('ratings_store');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin/approved/{id}', [AdminController::class, 'statusApproved'])->name('statusApproved');
        Route::get('/admin/rejected/{id}', [AdminController::class, 'statusRejected'])->name('statusRejected');
        Route::get('/admin/status={status}', [AdminController::class, 'index'])->name('admin');
    });

    Route::middleware('expert')->group(function () {
        Route::get('/my-tips', [TipController::class, 'myTip'])->name('myTip');

        Route::get('/tips/add/new-tip', [TipController::class, 'addTipShow'])->name('tips.add');
        Route::post('/tips/store', [TipController::class, 'store'])->name('tips_store');

        Route::get('/destroy/tip/{id}', [TipController::class, 'destroy'])->name('tips_destroy');
        Route::get('/edit/tip/{id}', [TipController::class, 'editShow'])->name('tips_edit_show');
        Route::post('/edit/tip/{id}', [TipController::class, 'edit'])->name('tips_edit');
    });
});
