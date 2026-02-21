<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;

class DeleteUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(int $id): void
    {
        $this->repository->delete($id);
    }
}