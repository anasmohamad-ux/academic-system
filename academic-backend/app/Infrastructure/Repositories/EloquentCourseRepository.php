<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Course;
use App\Domain\Repositories\CourseRepositoryInterface;
use App\Models\Course as EloquentCourse;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function create(
        string $title,
        ?string $description,
        int $createdBy
    ): Course {

        $model = EloquentCourse::create([
            'title' => $title,
            'description' => $description,
            'created_by' => $createdBy,
        ]);

        return new Course(
            id: $model->id,
            title: $model->title,
            description: $model->description,
            createdBy: $model->created_by
        );
    }

    public function all(): array
    {
        return EloquentCourse::all()
            ->map(fn($model) => new Course(
                id: $model->id,
                title: $model->title,
                description: $model->description,
                createdBy: $model->created_by
            ))
            ->toArray();
    }
}
