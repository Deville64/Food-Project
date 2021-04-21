<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RecipeFormController extends Controller
{
    public function create()
    {
        return Inertia::render('RecipeForm');
    }

    public function ingredients()
    {
        $results = DB::select('SELECT id, name FROM ingredients WHERE id_api IS NULL');

        return response()->json($results);
    }

    public function createRecipe(Request $request)
    {
        //Send data to recipes table
        $user = Auth::user();
        $id = $user->id;
        $name = $request->input('name');
        $preparation_time = $request->input('preparation_time');
        $cooking_time = $request->input('cooking_time');
        $description = $request->input('description');
        DB::insert('INSERT INTO recipes SET name=?, preparation_time=?, cooking_time=?, description=?, user_id  = ?, created_at= NOW(), updated_at = NOW()', [$name, $preparation_time, $cooking_time, $description, $id]);

        //Send data to recipes_ingredients table
        $recipes_ingredients = $request->input('recipes_ingredients');
        $recipeId = DB::getPdo()->lastInsertId();

        $data = array();
        for ($i = 0; $i < count($recipes_ingredients); $i++) {
            $data[] = '("' . $recipeId . '","' . $recipes_ingredients[$i]['ingredients_id'] . '","' . $recipes_ingredients[$i]['quantity'] . '")';
        }
        DB::insert('INSERT INTO recipes_ingredients ( recipes_id, ingredients_id, quantity)  VALUES' . implode(',', $data));
        return redirect()->route('recipes');
    }
}
