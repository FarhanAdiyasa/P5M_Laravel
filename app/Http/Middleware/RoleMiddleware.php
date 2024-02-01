<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->png_role, $roles)) {
            return $next($request);
        }

        return redirect('/'); // Ganti dengan rute atau URL tujuan jika peran tidak valid
    }
}
