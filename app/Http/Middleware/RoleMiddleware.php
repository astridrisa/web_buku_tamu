<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  string  $roleId
     */
    public function handle(Request $request, Closure $next, $roleId): Response
    {
        if (Auth::check() && Auth::user()->role_id == $roleId) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}
