<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\UseCases\RegisterUserUseCase;
use Illuminate\Http\Request;
use App\Application\UseCases\LoginUserUseCase;


class AuthController extends Controller
{
    public function register(
        Request $request,
        RegisterUserUseCase $registerUserUseCase
    ) {

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'role' => ['required', 'in:admin,teacher,student'],
        ]);

        $user = $registerUserUseCase->execute(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'],
            role: $validated['role']
        );

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }
    public function login(
        Request $request,
        LoginUserUseCase $loginUserUseCase
    ) {

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = $loginUserUseCase->execute(
            email: $validated['email'],
            password: $validated['password']
        );

        if (!$result) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => $result['user'],
            'token' => $result['token']
        ]);
    }
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

}
