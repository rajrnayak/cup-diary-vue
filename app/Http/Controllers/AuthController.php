<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function login() :Response
    {
        return Inertia::render('Login');
    }

    public function logout()
    {
        // return to_route('login');
        return Inertia::location('login');
    }
}
