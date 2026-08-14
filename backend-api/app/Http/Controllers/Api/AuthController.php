<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(!Auth::attempt($request->only('email', 'password'))){
            return response() -> json([
                'message' => 'Email atau Password salah.',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' =>[
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            ],
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->Delete();

        return response()->json([
            'message' => 'Logout berhasil.',
        ]);
    }
}
