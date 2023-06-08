<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
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

        $token = $user->createToken('auth-token', ['create', 'update', 'delete'])->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(LogoutRequest $request)
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