<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;

class RegisterUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(
        string $name,
        string $email,
        string $password,
        string $role
    ): User {

        return $this->userRepository->create(
            name: $name,
            email: $email,
            password: $password,
            role: $role
        );
    }
}
