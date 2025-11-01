<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Contoh penggunaan:
     * ->middleware('role:R04')       // satu role
     * ->middleware('role:R04,R05')   // beberapa role
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Tentukan user berdasarkan guard aktif
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
        } elseif (Auth::guard('anggota')->check()) {
            $user = Auth::guard('anggota')->user();
        } else {
            // Jika belum login di kedua guard
            return redirect('/login');
        }

        // Jika role user tidak ada di daftar yang diizinkan
        if (!in_array($user->id_role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
