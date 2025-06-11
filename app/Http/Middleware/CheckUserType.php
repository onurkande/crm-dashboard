<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->user_type !== 'member') {
            return redirect('/')->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }
} 