<?php

namespace App\Infrastructure\Services;

use App\Models\User;

class TokenService
{
    public function generate(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}
