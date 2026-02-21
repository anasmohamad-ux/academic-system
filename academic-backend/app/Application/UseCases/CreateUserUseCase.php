<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(
        string $name,
        string $email,
        string $password,
        string $role
    ) {
        return $this->repository->create(
            name: $name,
            email: $email,
            password: $password,
            role: $role
        );
    }
}