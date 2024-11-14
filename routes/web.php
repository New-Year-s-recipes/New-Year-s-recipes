<?php

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
