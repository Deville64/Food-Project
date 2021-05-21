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
            $ingredientsApiData = array();

            foreach ($recipesIngredients as $recipeIngredient) {
                $ingredientId = $recipeIngredient->ingredients_id;
                $ingredientQuantity = $recipeIngredient->quantity;
                $ingredients = DB::select('SELECT name FROM ingredients WHERE id = ? AND id_api IS NULL', [$ingredientId]);
                $ingredientsApi = DB::select('SELECT name, id_api, picture, nutriscore FROM ingredients WHERE id = ? AND id_api IS NOT NULL', [$ingredientId]);

                foreach ($ingredients as $ingredient) {
                    $ingredientName = $ingredient->name;
                    $test = array('id' => $ingredientId, 'name' => $ingredientName, 'quantity' => $ingredientQuantity);
                    json_encode($test);
                    $ingredientsData[] = $test;
                }

                foreach ($ingredientsApi as $ingredientApi) {
                    $ingredientId = $recipeIngredient->ingredients_id;
                    $ingredientPicture = $ingredientApi->picture;
                    $ingredientName = $ingredientApi->name;
                    $ingredientNutriscore = $ingredientApi->nutriscore;
                    $data = array('id' => $ingredientId, 'picture' => $ingredientPicture, 'name' => $ingredientName, 'quantity' => $ingredientQuantity, 'nutriscore' => $ingredientNutriscore);
                    json_encode($data);
                    $ingredientsApiData[] = $data;
                }
            }
            return Inertia::render('ModifyMyRecipe', [
                'recipe' => $recipe,
                'ingredients' => $ingredientsData,
                'ingredientsApi' => $ingredientsApiData,
            ]);
        } else {
            abort(404);
        }
    }

    public function updateRecipe(Request $request)
    {
        //Update data in recipes table
        $user = Auth::user();
        $userId = $user->id;
        $recipeId = $request->input('id');;
        $name = $request->input('name');
        $preparation_time = $request->input('preparation_time');
        $cooking_time = $request->input('cooking_time');
        $description = $request->input('description');

        DB::update('UPDATE recipes SET name=?, preparation_time=?, cooking_time=?, description=?, updated_at = NOW() WHERE id=? AND user_id=?', [$name, $preparation_time, $cooking_time, $description, $recipeId, $userId]);

        ///Update data in recipes_ingredients table
        $ingredientsToUpdate = $request->input('ingredientsToUpdate');

        for ($i = 0; $i < count($ingredientsToUpdate); $i++) {
            $quantity = $ingredientsToUpdate[$i]['quantity'];
            $ingredientId = $ingredientsToUpdate[$i]['ingredients_id'];

            DB::update('UPDATE recipes_ingredients SET quantity=?  WHERE recipes_id=? AND ingredients_id=?', [$quantity, $recipeId, $ingredientId]);
        }

        //If there are ingredients to delete, delete ingredients from recipes_ingredients table
        $ingredientsToDelete = $request->input('ingredientsToDelete');

        if ($ingredientsToDelete != null) {
            for ($i = 0; $i < count($ingredientsToDelete); $i++) {
                $ingredientId = $ingredientsToDelete[$i]['ingredients_id'];

                DB::delete('DELETE FROM recipes_ingredients WHERE recipes_id=? AND ingredients_id=?', [$recipeId, $ingredientId]);
            }
        }

        //If user create new ingredients, send data to recipes_ingredients table
        $ingredientsToAdd = $request->input('ingredientsToAdd');

        if ($ingredientsToAdd != null) {
            for ($i = 0; $i < count($ingredientsToAdd); $i++) {
                $ingredientId = $ingredientsToAdd[$i]['ingredients_id'];
                $quantity = $ingredientsToAdd[$i]['quantity'];

                DB::insert('INSERT INTO recipes_ingredients SET ingredients_id=?, quantity=?, recipes_id=?', [$ingredientId, $quantity, $recipeId]);
            }
        }

        return redirect()->route('recipes');
    }
}
