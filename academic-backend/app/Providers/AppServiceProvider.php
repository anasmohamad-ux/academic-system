<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\EloquentUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
        $this->app->bind(
            \App\Domain\Repositories\CourseRepositoryInterface::class,
            \App\Infrastructure\Repositories\EloquentCourseRepository::class
        );
        $this->app->bind(
            \App\Domain\Repositories\EnrollmentRepositoryInterface::class,
            \App\Infrastructure\Repositories\EloquentEnrollmentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
