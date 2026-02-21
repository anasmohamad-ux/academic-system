<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;

class UpdateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(
        int $id,
        string $name,
        string $email,
        string $role
    ) {
        return $this->repository->update(
            id: $id,
            name: $name,
            email: $email,
            role: $role
        );
    }
}