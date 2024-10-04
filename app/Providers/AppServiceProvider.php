<?php

namespace App\Providers;

use App\Models\Frame;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Tutor;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
