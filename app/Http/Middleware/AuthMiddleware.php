<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user belum login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Jika ada parameter role di middleware
        if (!empty($roles)) {
            // Cek apakah role user sesuai dengan salah satu yang diizinkan
            if (!in_array($user->id_role, $roles)) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return $next($request);
    }
}
