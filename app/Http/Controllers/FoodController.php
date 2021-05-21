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


        //If id_api exist in db, add it to the recipe and redirect to modify recipe page
        if (DB::table('ingredients')->where('id_api', $id_api)->first()) {
            $ingredient_id = DB::select('SELECT id FROM ingredients WHERE id_api = ?', [$id_api]);
            $id = $ingredient_id[0]->id;
            DB::insert('INSERT INTO recipes_ingredients SET ingredients_id=?, recipes_id=?, quantity=0',  [$id, $recipe_id]);
            return redirect()->route('modifymyrecipe', ['id' => $recipe_id]);
        }
        //If id_api doesn't exist in db, add it in ingredients table and recipe then, redirect to modify recipe page
        else {
            $name_api = $request->input('name_api');
            $picture = $request->input('picture');
            $nutriscore = $request->input('nutriscore');

            DB::insert('INSERT INTO ingredients SET name=?, id_api=?, picture=?, nutriscore=?, created_at= NOW(), updated_at = NOW()',  [$name_api, $id_api, $picture, $nutriscore]);
            $ingredient_id = DB::getPdo()->lastInsertId();

            DB::insert('INSERT INTO recipes_ingredients SET ingredients_id=?, recipes_id=?, quantity=0',  [$ingredient_id, $recipe_id]);
            return redirect()->route('modifymyrecipe', ['id' => $recipe_id]);
        }
    }
}
