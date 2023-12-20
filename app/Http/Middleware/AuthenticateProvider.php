<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateProvider
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('provider')->check()) {
            return $next($request);
        }

        return redirect('/');
    }
}
