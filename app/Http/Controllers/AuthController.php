<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function login() :Response
    {
        return Inertia::render('Login');
    }

    public function  loginPost(LoginFormPostRequest $request): JsonResponse
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return response()->json([
                'userData'=>auth()->user(),
                'message' => 'Login Success',
            ]);
        }

        return response()->json(['errors' => ['message' => ['These credentials does not match our records.']]],422);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            Session()->flush();
            Session()->regenerate();
            return Inertia::render('Login');
        }
    }
}
