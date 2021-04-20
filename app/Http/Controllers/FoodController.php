<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function getRecipesNames()
    {
        $user = Auth::user();
        $id = $user->id;
        $recipes = DB::select('SELECT id, name FROM recipes WHERE user_id = ?', [$id]);
        return response()->json($recipes);
    }

    public function addApiIngredient(Request $request)
    {
        $recipe_id = $request->input('recipe_id');
        $id_api = $request->input('id_api');
        $name_api = $request->input('name_api');
        $id_exist = false;

        $results = DB::select('SELECT id_api FROM ingredients');

        foreach ($results as $result) {
            if ($result === $id_api) {
                $id_exist = true;
            }
        }

        if ($id_exist === true) {
        } else {
            DB::insert('INSERT INTO ingredients SET name=?, id_api=?, created_at= NOW(), updated_at = NOW()',  [$name_api, $id_api]);
            $ingredientId = DB::getPdo()->lastInsertId();

            DB::insert('INSERT INTO recipes_ingredients SET ingredients_id=?, recipes_id=?, quantity=0',  [$ingredientId, $recipe_id]);
        }


        return Inertia::render('Food');
    }
}
