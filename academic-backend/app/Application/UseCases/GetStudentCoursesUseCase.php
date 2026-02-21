<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\EnrollmentRepositoryInterface;

class GetStudentCoursesUseCase
{
    public function __construct(
        private EnrollmentRepositoryInterface $repository
    ) {
    }

    public function execute(int $userId): array
    {
        return $this->repository->getCoursesByStudent($userId);
    }
}