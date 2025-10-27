<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses login
    public function login(Request $request)
    {
        // Validasi input dari form
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            // keamanan session fixation
            $request->session()->regenerate();

            // Ambil user yang sudah login
            $user = Auth::user();

            // Pastikan user punya role (supaya nggak error kalau kosong)
            if (!$user->role || !$user->role->nama_role) {
                // Kalau tidak ada role → langsung logout biar aman
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun tidak memiliki role yang valid. Hubungi admin.',
                ]);
            }

            // Arahkan user sesuai role
            return $this->redirectByRole($user);
        }

        // Kalau gagal login
        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput();
    }

    // 3. Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // 4. Fungsi bantu: redirect sesuai role
    protected function redirectByRole($user)
    {
        // baca nama role dari relasi
        $roleName = $user->role->nama_role; // contoh: 'PINJAMAN'

        switch ($roleName) {
            case 'PINJAMAN':
                return redirect()->route('dashboard.pinjaman');
            case 'SIMPANAN':
                return redirect()->route('dashboard.simpanan');
            case 'ACCOUNTING':
                return redirect()->route('dashboard.akunting');
            case 'PENGURUS':
                return redirect()->route('dashboard.pengurus');
            default:
                // fallback aman
                return redirect()->route('dashboard.master');
        }
    }
}