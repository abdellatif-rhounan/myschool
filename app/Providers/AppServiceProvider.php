<?php

namespace App\Providers;

use App\Models\User;
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
        Route::model('admin', User::class);
        Route::model('teacher', User::class);
        Route::model('student', User::class);
        Route::model('parent', User::class);

        Paginator::useBootstrap();
    }
}
