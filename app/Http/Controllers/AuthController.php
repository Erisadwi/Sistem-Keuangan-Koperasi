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

            if (!$user->role || !$user->role->nama_role) {
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
        $roleName = strtoupper($user->role->nama_role);

        return match ($roleName) {
            'PINJAMAN'   => redirect()->route('dashboard.pinjaman'),
            'SIMPANAN'   => redirect()->route('dashboard.simpanan'),
            'ACCOUNTING' => redirect()->route('dashboard.akunting'),
            'PENGURUS'   => redirect()->route('dashboard.pengurus'),
            default      => redirect()->route('dashboard.master'),
        };
    }
}
