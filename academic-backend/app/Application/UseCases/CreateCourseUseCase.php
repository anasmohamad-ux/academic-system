<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\CourseRepositoryInterface;
use App\Domain\Entities\Course;

class CreateCourseUseCase
{
    public function __construct(
        private CourseRepositoryInterface $repository
    ) {
    }

    public function execute(
        string $title,
        ?string $description,
        int $createdBy
    ): Course {

        return $this->repository->create(
            title: $title,
            description: $description,
            createdBy: $createdBy
        );
    }
}
