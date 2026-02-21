<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\EnrollmentRepositoryInterface;
use App\Domain\Entities\Enrollment;
use App\Domain\Exceptions\StudentAlreadyEnrolledException;

class EnrollStudentUseCase
{
    public function __construct(
        private EnrollmentRepositoryInterface $repository
    ) {
    }

    public function execute(int $userId, int $courseId): Enrollment
    {
        if ($this->repository->exists($userId, $courseId)) {
            throw new StudentAlreadyEnrolledException('Student already enrolled in this course.');
        }

        return $this->repository->enroll($userId, $courseId);
    }
}