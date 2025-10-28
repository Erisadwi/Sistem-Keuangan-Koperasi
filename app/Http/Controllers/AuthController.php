<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->role || !$user->role->id_role) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun tidak memiliki role yang valid. Hubungi admin.',
                ]);
            }

            return $this->redirectByRole($user);
        }

        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Redirect berdasarkan role
protected function redirectByRole($user)
{
    $roleId = strtoupper($user->id_role);

    return match ($roleId) {
        'R05' => redirect()->route('dashboard.pinjaman'),
        'R04' => redirect()->route('dashboard.simpanan'),
        'R06' => redirect()->route('dashboard.akunting'),
        'R07' => redirect()->route('dashboard.pengurus'),
        default => redirect('/login')->withErrors([
            'login' => 'Role tidak dikenali.',
        ]),
    };
}
}

