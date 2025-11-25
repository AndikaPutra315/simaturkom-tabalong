<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Jangan lupa ini

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->role == 'suadmin') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan suadmin, tendang keluar (403 Forbidden) atau redirect
        abort(403, 'Akses Ditolak! Halaman ini khusus Super Admin.');
    }
}
