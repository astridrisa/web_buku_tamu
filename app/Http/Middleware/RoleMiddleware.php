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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roleIds
     */
    public function handle(Request $request, Closure $next, ...$roleIds): Response
    {
        if (Auth::check() && in_array(Auth::user()->role_id, $roleIds)) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}
