<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\CourseRepositoryInterface;

class GetCoursesUseCase
{
    public function __construct(
        private CourseRepositoryInterface $repository
    ) {
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}
