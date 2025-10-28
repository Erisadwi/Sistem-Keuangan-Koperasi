<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roleId)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek role user berdasarkan role_id
        if (Auth::user()->id_role != (string) $roleId) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

