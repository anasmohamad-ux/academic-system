<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;

class GetAllUsersUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(): array
    {
        return $this->repository->findAll();
    }
}