<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Kalau belum login ATAU peran tidak sesuai → tolak akses
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, '⛔ Kamu tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}