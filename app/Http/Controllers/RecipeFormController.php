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
        $results = DB::select('SELECT id, name FROM ingredients');

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
        // DB::insert('INSERT INTO recipes_ingredients SET ingredients_id =?, recipes_id =?, quantity=?', [$email, $id]);
        return Inertia::render('Home');
    }
}
