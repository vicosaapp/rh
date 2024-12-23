<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCreatedByIsSet
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $request->merge(['created_by' => auth()->id()]);
        }

        return $next($request);
    }
}