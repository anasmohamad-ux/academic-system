<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Enrollment;

interface EnrollmentRepositoryInterface
{
    public function enroll(int $userId, int $courseId): Enrollment;

    public function exists(int $userId, int $courseId): bool;

    public function getCoursesByStudent(int $userId): array;
    public function cancel(int $userId, int $courseId): void;
}
