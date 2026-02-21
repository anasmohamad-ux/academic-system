<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::middleware('role:admin')
        ->get('/dashboard/admin', [DashboardController::class, 'admin']);

    Route::middleware('role:teacher')
        ->get('/dashboard/teacher', [DashboardController::class, 'teacher']);

    Route::middleware('role:student')
        ->get('/dashboard/student', [DashboardController::class, 'student']);



    Route::get('/courses', [CourseController::class, 'index']);

    Route::middleware('role:admin|teacher')
        ->post('/courses', [CourseController::class, 'store']);



    Route::middleware('role:student')->group(function () {

        Route::post('/enrollments', [EnrollmentController::class, 'store']);
        Route::get('/my-courses', [EnrollmentController::class, 'myCourses']);
        Route::delete('/enrollments/{courseId}', [EnrollmentController::class, 'destroy']);
    });



    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/users', [UserController::class, 'index']);
        Route::post('/admin/users', [UserController::class, 'store']);
        Route::put('/admin/users/{id}', [UserController::class, 'update']);
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
    });
});