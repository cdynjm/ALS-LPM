<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// IMPLEMENTATION:
use App\Repositories\Implementation\AdminRepository;
use App\Repositories\Implementation\TeacherRepository;
use App\Repositories\Implementation\StudentRepository;
use App\Repositories\Implementation\GlobalRepository;

//INTERFACE:
use App\Repositories\Interface\AdminRepositoryInterface;
use App\Repositories\Interface\TeacherRepositoryInterface;
use App\Repositories\Interface\StudentRepositoryInterface;
use App\Repositories\Interface\GlobalRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(GlobalRepositoryInterface::class, GlobalRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
