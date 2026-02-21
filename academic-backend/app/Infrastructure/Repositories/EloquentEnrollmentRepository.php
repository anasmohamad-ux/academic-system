<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Enrollment;
use App\Domain\Entities\Course;
use App\Domain\Repositories\EnrollmentRepositoryInterface;
use App\Models\Enrollment as EloquentEnrollment;
use App\Models\Course as EloquentCourse;

class EloquentEnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function enroll(int $userId, int $courseId): Enrollment
    {
        $model = EloquentEnrollment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
        ]);

        return new Enrollment(
            id: $model->id,
            userId: $model->user_id,
            courseId: $model->course_id
        );
    }

    public function exists(int $userId, int $courseId): bool
    {
        return EloquentEnrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    public function cancel(int $userId, int $courseId): void
    {
        EloquentEnrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->delete();
    }

    public function getCoursesByStudent(int $userId): array
    {
        return EloquentCourse::whereHas('enrollments', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get()
            ->map(fn($course) => new Course(
                id: $course->id,
                title: $course->title,
                description: $course->description,
                createdBy: $course->created_by
            ))
            ->toArray();
    }
}