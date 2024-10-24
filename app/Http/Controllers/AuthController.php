<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{

    public function register(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255']
        ]);

        $exists = User::where('email', $credentials['email'])->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already used'
            ], 401);
        }

        $credentials['password'] = bcrypt($credentials['password']);
        User::create($credentials);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful'
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $user
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }
}
