<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\EnrollmentRepositoryInterface;

class CancelEnrollmentUseCase
{
    public function __construct(
        private EnrollmentRepositoryInterface $repository
    ) {
    }

    public function execute(int $userId, int $courseId): void
    {
        $this->repository->cancel($userId, $courseId);
    }
}