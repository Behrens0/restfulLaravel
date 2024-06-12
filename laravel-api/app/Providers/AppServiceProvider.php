<?php

namespace App\Providers;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Jetstream::ignoreRoutes();
        Paginator::useBootstrap();

    }
}
