<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SatpamMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'satpam') {
            return $next($request);
        }

        abort(403, 'Akses ditolak.');
    }
}
