<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\MyRecipeController;
use App\Http\Controllers\ModifyMyRecipeController;
use App\Http\Controllers\RecipeFormController;
use App\Http\Controllers\FoodController;

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
    ->middleware(['auth']);

Route::post('/profile', [ProfileController::class, 'updateEmail'])
    ->middleware(['auth'])
    ->name('updateEmail');

Route::get('/recipes', [RecipesController::class, 'create'])
    ->middleware(['auth'])
    ->name('recipes');

Route::get('/recipeform', [RecipeFormController::class, 'create'])
    ->middleware(['auth']);

Route::get('/ingredients', [RecipeFormController::class, 'ingredients'])
    ->middleware(['auth']);

Route::post('/recipeform', [RecipeFormController::class, 'createRecipe'])
    ->middleware(['auth'])
    ->name('createRecipe');

Route::get('/myrecipe/{id}', [MyRecipeController::class, 'create'])
    ->middleware(['auth']);

Route::get('/deletemyrecipe/{id}', [MyRecipeController::class, 'deleteRecepe'])
    ->middleware(['auth']);

Route::get('/modifymyrecipe/{id}', [ModifyMyRecipeController::class, 'create'])
    ->middleware(['auth'])
    ->name('modifymyrecipe');

Route::post('/updateRecipe', [ModifyMyRecipeController::class, 'updateRecipe'])
    ->middleware(['auth'])
    ->name('updateRecipe');

Route::get('/getrecipesnames', [FoodController::class, 'getRecipesNames'])
    ->middleware(['auth']);

Route::post('/food', [FoodController::class, 'addApiIngredient'])
    ->middleware(['auth'])
    ->name('addApiIngredient');;

require __DIR__ . '/auth.php';
