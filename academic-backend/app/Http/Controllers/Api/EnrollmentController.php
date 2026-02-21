<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\UseCases\EnrollStudentUseCase;
use App\Application\UseCases\GetStudentCoursesUseCase;
use App\Domain\Exceptions\StudentAlreadyEnrolledException;
use Illuminate\Http\Request;
use App\Application\UseCases\CancelEnrollmentUseCase;
class EnrollmentController extends Controller
{
    public function store(
        Request $request,
        EnrollStudentUseCase $useCase
    ) {

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        try {
            $enrollment = $useCase->execute(
                userId: $request->user()->id,
                courseId: $validated['course_id']
            );

            return response()->json($enrollment, 201);

        } catch (StudentAlreadyEnrolledException $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 409); // 409 Conflict
        }
    }

    public function myCourses(
        GetStudentCoursesUseCase $useCase,
        Request $request
    ) {
        $courses = $useCase->execute($request->user()->id);

        return response()->json($courses);
    }


    public function destroy(
        int $courseId,
        CancelEnrollmentUseCase $useCase,
        Request $request
    ) {
        $useCase->execute(
            userId: $request->user()->id,
            courseId: $courseId
        );

        return response()->json([
            'message' => 'Enrollment cancelled'
        ]);
    }
}