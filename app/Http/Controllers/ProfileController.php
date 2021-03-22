<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function create()
    {
        return Inertia::render('Profile');
    }

    public function updateEmail(Request $request) {
        $user = Auth::user();

        $email = $request->input('email');
        $id = $user->id;
        DB::update('UPDATE users SET email=?, updated_at = NOW() WHERE id = ?',[$email,$id]);
        return Inertia::render('Home');
        }
}



