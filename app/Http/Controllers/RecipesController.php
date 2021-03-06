<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipesController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $id = $user->id;
        $recipes = DB::select('SELECT * FROM recipes WHERE user_id = ?', [$id]);
        return Inertia::render('Recipes', ['recipes' => $recipes]);
    }
}
