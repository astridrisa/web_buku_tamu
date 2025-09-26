<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roleId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // cek apakah role_id user sesuai
        if (Auth::user()->role_id != $roleId) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
