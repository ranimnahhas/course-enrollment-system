<?php

namespace App\Providers;

use App\Repositories\CourseRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\CourseService;
use App\Services\EnrollmentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositories
        $this->app->bind(UserRepository::class, UserRepository::class);
        $this->app->bind(CourseRepository::class, CourseRepository::class);
        $this->app->bind(EnrollmentRepository::class, EnrollmentRepository::class);

        // Services
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService($app->make(UserRepository::class));
        });

        $this->app->bind(CourseService::class, function ($app) {
            return new CourseService($app->make(CourseRepository::class));
        });

        $this->app->bind(EnrollmentService::class, function ($app) {
            return new EnrollmentService($app->make(EnrollmentRepository::class));
        });
    }

    public function boot(): void
    {
        //
    }
}