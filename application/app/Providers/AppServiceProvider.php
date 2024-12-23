<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        // Custom field validation rule
        Validator::extend('alpha_dash_space', function ($attribute, $value) {
            // This will only accept alpha, numbers, and spaces
            return preg_match('/^[\pL\d\s\-\_]+$/u', $value);  
        });
    }
}
