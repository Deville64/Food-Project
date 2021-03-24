<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

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
}
