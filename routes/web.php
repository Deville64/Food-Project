<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Public
Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/food', function () {
    return Inertia::render('Food');
});

//Logged In
Route::get('/profile', [ProfileController::class, 'create'])
    ->middleware(['auth', 'verified']);

Route::post('/profile', [ProfileController::class, 'updateEmail'])
    ->middleware(['auth', 'verified'])
    ->name('profile');

Route::get('/recipes', [RecipesController::class, 'create'])
    ->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';
