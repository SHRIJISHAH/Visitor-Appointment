<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperadminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user is a Superadmin
        if (Auth::guard('superadmin')->check()) {
            return $next($request);
        }
        // Redirect if not a Superadmin
        if ($request->is('superadmin/*')) {
            return redirect('/superadmin/dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return $next($request);
    }
}
