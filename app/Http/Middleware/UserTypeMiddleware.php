<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $guard = null;

        switch ($role) {
            case 'admin':
                $guard = 'admin';
                break;
            case 'superadmin':
                $guard = 'superadmin';
                break;
            default:
                $guard = 'web';
                break;
        }

        if (Auth::guard($guard)->check()) {
            return redirect("/{$role}/dashboard");
        }

        return $next($request);
    }
}
