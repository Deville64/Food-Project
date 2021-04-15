<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function getRecipesNames()
    {
        $user = Auth::user();
        $id = $user->id;
        $recipes = DB::select('SELECT id, name FROM recipes WHERE user_id = ?', [$id]);
        return response()->json($recipes);
    }
}
