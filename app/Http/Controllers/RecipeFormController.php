<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class RecipeFormController extends Controller
{
    public function create()
    {
        // $results = DB::select('SELECT id, name FROM ingredients');

        // // get the q parameter from URL
        // $q = $_REQUEST["q"];
        // $hint = "";

        // // lookup all hints from array if $q is different from ""
        // if ($q !== "") {
        //     $len = strlen($q);
        //     foreach ($results as $ingredient) {
        //         if (stristr($q, substr($ingredient["ingredientName"], 0, $len))) {
        //             $hint = $hint . "<div onclick =selectHint(event," . $ingredient["id"] . ")>" . $ingredient["ingredientName"] . "</div>";
        //         }
        //     }
        // }
        // // Output "no suggestion" if no hint was found or output correct values
        // echo $hint === "" ? "Pas de suggestion" : $hint;

        return Inertia::render('RecipeForm');
    }

    public function getIngredients()
    {
        $results = DB::select('SELECT id, name FROM ingredients');

        // get the q parameter from URL
        $q = $_REQUEST["q"];
        $hint = "";

        // lookup all hints from array if $q is different from ""
        if ($q !== "") {
            $len = strlen($q);
            foreach ($results as $ingredient) {
                if (stristr($q, substr($ingredient["name"], 0, $len))) {
                    $hint = $hint . "<div onclick =selectHint(event," . $ingredient["id"] . ")>" . $ingredient["name"] . "</div>";
                }
            }
        }
        // Output "no suggestion" if no hint was found or output correct values
        echo $hint === "" ? "Pas de suggestion" : $hint;
    }
}
