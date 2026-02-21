<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | Authentication Methods
    |--------------------------------------------------------------------------
    */

    public function create(
        string $name,
        string $email,
        string $password,
        string $role
    ): User {

        $eloquentUser = EloquentUser::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $eloquentUser->assignRole($role);

        return new User(
            id: $eloquentUser->id,
            name: $eloquentUser->name,
            email: $eloquentUser->email,
            role: $role
        );
    }

    public function findByEmail(string $email): ?User
    {
        $eloquentUser = EloquentUser::with('roles')
            ->where('email', $email)
            ->first();

        if (!$eloquentUser) {
            return null;
        }

        return new User(
            id: $eloquentUser->id,
            name: $eloquentUser->name,
            email: $eloquentUser->email,
            role: $eloquentUser->roles->first()?->name
        );
    }

    public function findModelByEmail(string $email): mixed
    {
        return EloquentUser::where('email', $email)->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Admin CRUD Methods
    |--------------------------------------------------------------------------
    */

    public function findAll(): array
    {
        return EloquentUser::with('roles')->get()
            ->map(fn($user) => new User(
                id: $user->id,
                name: $user->name,
                email: $user->email,
                role: $user->roles->first()?->name
            ))
            ->toArray();
    }

    public function findById(int $id): ?User
    {
        $user = EloquentUser::with('roles')->find($id);

        if (!$user) {
            return null;
        }

        return new User(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            role: $user->roles->first()?->name
        );
    }

    public function update(
        int $id,
        string $name,
        string $email,
        string $role
    ): User {
        $user = EloquentUser::findOrFail($id);

        $user->update([
            'name' => $name,
            'email' => $email,
        ]);

        $user->syncRoles([$role]);

        return new User(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            role: $role
        );
    }

    public function delete(int $id): void
    {
        EloquentUser::findOrFail($id)->delete();
    }
}