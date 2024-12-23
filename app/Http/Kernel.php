<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // ... outros middlewares ...
        'check.person.access' => \App\Http\Middleware\CheckPersonAccess::class,
        'ensure.created_by' => \App\Http\Middleware\EnsureCreatedByIsSet::class,
    ];
} 