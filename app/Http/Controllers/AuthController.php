<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'Usuário não existente'
            ], 401);
        }
        
        $user = null;

        try {
            $user = User::where('EMAIL', $request['email'])->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Usuário não existente']);
        };

        $token = $user->createToken('auth-token', ['user:all'])->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(AuthRequest $request)
    {
        $user = null;

        try {
            $user = User::where('EMAIL', $request['email'])->firstOrFail();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Usuário não existente']);
        };

        $user->tokens()->delete();
    }
}