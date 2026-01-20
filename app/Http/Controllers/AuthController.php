<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($validated)) {
            $user = auth()->user();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'data' => $user,
            ]);
        }
        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Deconnexion réussie']);
    }
}
