<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function admin()
    {
        return response()->json([
            'totalUsers' => User::count(),
            'totalCourses' => Course::count(),
            'totalEnrollments' => Enrollment::count(),
        ]);
    }

    public function teacher(Request $request)
    {
        $teacherId = $request->user()->id;

        $courses = Course::where('created_by', $teacherId)->get();

        $totalStudents = Enrollment::whereIn('course_id', $courses->pluck('id'))->count();

        return response()->json([
            'totalCourses' => $courses->count(),
            'totalStudents' => $totalStudents,
        ]);
    }

    public function student(Request $request)
    {
        $studentId = $request->user()->id;

        $totalCourses = Enrollment::where('user_id', $studentId)->count();

        return response()->json([
            'totalCourses' => $totalCourses,
        ]);
    }
}