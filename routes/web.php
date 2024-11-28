<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
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

Route::get('/', [RecipeController::class, 'index'])->name('homePage');
Route::get('/recipes/more/{id}', [RecipeController::class, 'more'])->name('recipesPage');
Route::get('/recipes/{category}', [RecipeController::class, 'category'])->name('recipesByCategory');

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'registerPage'])->name('registerPage');
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::get('/login', [UserController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/load-more-dishes', [RecipeController::class, 'loadMoreDishes'])->name('recipes.loadMore');


    Route::middleware('user')->group(function () {
        Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');

        Route::post('/recipes/store', [RecipeController::class, 'store'])->name('recipes_store');

        Route::get('/destroy/{id}', [RecipeController::class, 'destroy'])->name('recipes_destroy');
        Route::get('/edit/{id}', [RecipeController::class, 'editShow'])->name('recipes_edit_show');
        Route::post('/edit/{id}', [RecipeController::class, 'edit'])->name('recipes_edit');

        Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
        Route::post('/recipes/{id}/favorite', [FavoriteController::class, 'store'])->name('favorite.add');
        Route::post('/recipes/{id}/unfavorite', [FavoriteController::class, 'destroy'])->name('favorite.remove');

        Route::post('/ratings', [RatingController::class, 'store'])->name('ratings_store');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::get('/admin/approved/{id}', [AdminController::class, 'statusApproved'])->name('statusApproved');
        Route::get('/admin/rejected/{id}', [AdminController::class, 'statusRejected'])->name('statusRejected');
        Route::get('/admin/status={status}', [AdminController::class, 'status'])->name('recipe_status');
    });
});
