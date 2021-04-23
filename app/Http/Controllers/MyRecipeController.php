<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyRecipeController extends Controller
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
            $ingredientsApiData = array();

            foreach ($recipesIngredients as $recipeIngredient) {
                $ingredientId = $recipeIngredient->ingredients_id;
                $ingredientQuantity = $recipeIngredient->quantity;
                $ingredients = DB::select('SELECT name FROM ingredients WHERE id = ? AND id_api IS NULL', [$ingredientId]);
                $ingredientsApi = DB::select('SELECT name, id_api, picture, nutriscore FROM ingredients WHERE id = ? AND id_api IS NOT NULL', [$ingredientId]);

                foreach ($ingredients as $ingredient) {
                    $ingredientName = $ingredient->name;
                    $data = array('name' => $ingredientName, 'quantity' => $ingredientQuantity);
                    json_encode($data);
                    $ingredientsData[] = $data;
                }

                foreach ($ingredientsApi as $ingredientApi) {
                    $ingredientId = $ingredientApi->id_api;
                    $ingredientPicture = $ingredientApi->picture; 
                    $ingredientName = $ingredientApi->name; 
                    $ingredientNutriscore = $ingredientApi->nutriscore; 
                    $data = array('id' => $ingredientId, 'picture' => $ingredientPicture, 'name' => $ingredientName, 'quantity' => $ingredientQuantity, 'nutriscore' => $ingredientNutriscore);
                    json_encode($data);
                    $ingredientsApiData[] = $data;
                }
            }
            return Inertia::render('MyRecipe', [
                'recipe' => $recipe,
                'ingredients' => $ingredientsData,
                'ingredientsApi' => $ingredientsApiData,
            ]);
        } else {
            abort(404);
        }
    }

    public function deleteRecepe($id)
    {
        $user = Auth::user();
        $userId = $user->id;
        $DataExist = DB::table('recipes')->where('id', $id)->value('user_id', $userId);
        if ($DataExist) {
            //Delete first ingredients then recipe
            DB::delete('DELETE FROM recipes_ingredients WHERE recipes_id = ?', [$id]);
            DB::delete('DELETE FROM recipes WHERE id = ?', [$id]);
            return redirect()->route('recipes');
        }
    }
}
