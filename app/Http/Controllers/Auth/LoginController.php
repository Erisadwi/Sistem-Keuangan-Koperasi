<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $anggota = \App\Models\Anggota::where('username_anggota', $request->username)->first();

    if ($anggota) {
        if ($anggota->status_anggota === 'nonaktif') {
            return back()->withErrors([
                'username' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.',
            ]);
        }

        $anggotaCredentials = [
            'username_anggota' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard('anggota')->attempt($anggotaCredentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/anggota/beranda');
        }
    }

    $user = \App\Models\User::where('username', $request->username)->first();

    if ($user) {
        if ($user->status === 'nonaktif') {
            return back()->withErrors([
                'username' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.',
            ]);
        }

        $userCredentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard('user')->attempt($userCredentials)) {
            $request->session()->regenerate();

            switch ($user->id_role) {
                case 'R04':
                case 'R05':
                case 'R06':
                case 'R07':
                    return redirect()->route('dashboard');
            }
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ]);
}




    public function logout(Request $request)
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        } elseif (Auth::guard('anggota')->check()) {
            Auth::guard('anggota')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }

    public function deactivateAccount(Request $request)
{

    if (Auth::guard('user')->check()) {
        /** @var \App\Models\User $user */
        $user = Auth::guard('user')->user();
        $user->status = 'nonaktif';
        $user->save();

        Auth::guard('user')->logout();
    } elseif (Auth::guard('anggota')->check()) {
        /** @var \App\Models\Anggota $anggota */
        $anggota = Auth::guard('anggota')->user();
        $anggota->status_anggota = 'nonaktif';
        $anggota->save();

        Auth::guard('anggota')->logout();
    }

    // Hapus sesi dan redirect
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Akun Anda telah dinonaktifkan.');
}

}