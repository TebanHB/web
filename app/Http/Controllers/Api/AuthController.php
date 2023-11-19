<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Credenciales Inválidas'
            ], 403);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        // Incluir el token como parte del objeto user
        $user->token = $token;

        return response()->json(['user' => $user, 'message' => 'Logged in successfully'], 200);
    }
}
