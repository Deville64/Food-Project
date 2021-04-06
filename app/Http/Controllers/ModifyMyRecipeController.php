<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModifyMyRecipeController extends Controller
{
    public function create($id)
    {
        $user = Auth::user();
        $userId = $user->id;
        $DataExist = DB::table('recipes')->where('id', $id)->value('user_id', $userId);

        //Check if userId has this recipe, if yes show recepe otherwise display error
        if ($DataExist) {
            $recipe = DB::select('SELECT * FROM recipes WHERE id = ? AND user_id =?', [$id, $userId]);

            $recipesIngredients = DB::select('SELECT ingredients_id, quantity FROM recipes_ingredients WHERE recipes_id = ?', [$id]);
            $ingredientsData = array();

            foreach ($recipesIngredients as $recipeIngredient) {
                $ingredientId = $recipeIngredient->ingredients_id;
                $ingredientQuantity = $recipeIngredient->quantity;
                $ingredients = DB::select('SELECT name FROM ingredients WHERE id = ?', [$ingredientId]);

                foreach ($ingredients as $ingredient) {
                    $ingredientName = $ingredient->name;
                    $test = array('name' => $ingredientName, 'quantity' => $ingredientQuantity);
                    json_encode($test);
                    $ingredientsData[] = $test;
                }
            }
            return Inertia::render('ModifyMyRecipe', [
                'recipe' => $recipe,
                'ingredients' => $ingredientsData
            ]);
        } else {
            abort(404);
        }
    }
}
