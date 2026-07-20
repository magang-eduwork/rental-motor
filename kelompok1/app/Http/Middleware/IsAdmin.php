<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login ATAU belum
        // 2. Cek apakah kolom 'role' pada user yang login bernilai 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Lolos pengecekan, silakan masuk ke halaman admin
        }

        // Jika gagal pengecekan, tendang ke halaman beranda/login dengan alert error
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses ke halaman admin!');
    }
}