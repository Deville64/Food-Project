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
        $users = DB::select('SELECT * FROM recipes WHERE id = ?', [$id]);
        return Inertia::render('Recipes', ['users' => $users]);
    }
}
