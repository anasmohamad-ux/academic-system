<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\UseCases\GetAllUsersUseCase;
use App\Application\UseCases\CreateUserUseCase;
use App\Application\UseCases\UpdateUserUseCase;
use App\Application\UseCases\DeleteUserUseCase;

class UserController extends Controller
{
    public function index(GetAllUsersUseCase $useCase)
    {
        return response()->json($useCase->execute());
    }

    public function store(Request $request, CreateUserUseCase $useCase)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,teacher,student'],
        ]);

        $user = $useCase->execute(
            $validated['name'],
            $validated['email'],
            $validated['password'],
            $validated['role']
        );

        return response()->json($user, 201);
    }

    public function update(
        int $id,
        Request $request,
        UpdateUserUseCase $useCase
    ) {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'role' => ['required', 'in:admin,teacher,student'],
        ]);

        $user = $useCase->execute(
            $id,
            $validated['name'],
            $validated['email'],
            $validated['role']
        );

        return response()->json($user);
    }

    public function destroy(
        int $id,
        DeleteUserUseCase $useCase
    ) {
        $useCase->execute($id);

        return response()->json(['message' => 'User deleted']);
    }
}