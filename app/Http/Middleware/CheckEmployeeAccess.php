<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEmployeeAccess
{
    public function handle(Request $request, Closure $next)
    {
        $employee = $request->route('employee');

        if ($employee && !auth()->user()->is_admin && $employee->created_by !== auth()->id()) {
            abort(403, 'Você não tem permissão para acessar este funcionário.');
        }

        return $next($request);
    }
} 