<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Course;


interface CourseRepositoryInterface
{
    public function create(
        string $title,
        ?string $description,
        int $createdBy
    ): Course;
    public function all(): array;

    // public function getCoursesByStudent(int $userId): array;
}