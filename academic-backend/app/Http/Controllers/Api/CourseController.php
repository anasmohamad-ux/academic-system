<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\UseCases\CreateCourseUseCase;
use Illuminate\Http\Request;
use App\Application\UseCases\GetCoursesUseCase;

class CourseController extends Controller
{
    public function store(
        Request $request,
        CreateCourseUseCase $useCase
    ) {

        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $course = $useCase->execute(
            title: $validated['title'],
            description: $validated['description'] ?? null,
            createdBy: $request->user()->id
        );

        return response()->json($course, 201);
    }
    public function index(
        GetCoursesUseCase $useCase
    ) {
        $courses = $useCase->execute();
        return response()->json($courses);
    }
}
