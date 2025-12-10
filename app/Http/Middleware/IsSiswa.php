<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSiswa
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ Pakai guard 'siswa', bukan guard default
        if (Auth::guard('siswa')->check() && Auth::guard('siswa')->user()->role === 'siswa') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda bukan siswa.');
    }
}