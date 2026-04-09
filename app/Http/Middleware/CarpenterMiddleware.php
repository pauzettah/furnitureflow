<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarpenterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'carpenter') {
            abort(403, 'Unauthorized - Carpenter access only');
        }
        return $next($request);
    }
}