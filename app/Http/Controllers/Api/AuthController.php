<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Proposition;
use App\Models\User;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

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
        $user->update([
            'tokenf' => $request->tokenf,
        ]);
        $user->token = $token;
        return response()->json(['user' => $user, 'message' => 'Logged in successfully'], 200);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $client = Client::create([
            'user_id' => $user->id,
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'User registered successfully'
        ], 201);
    }
  public function getUserByToken(Request $request){
    $user = Auth::user();
    $client = $user->client;
    $service_request = $client->serviceRequest;
    return $service_request;
  }
}
