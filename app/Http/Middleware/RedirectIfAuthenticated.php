<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Redirect sesuai role
                if ($user->role_id == 1) {
                    return redirect()->route('/');
                } elseif ($user->role_id == 2) {
                    return redirect()->route('pegawai.dashboard');
                }

                // default fallback
                return redirect('/home');
            }
        }

        return $next($request);
    }
}
