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

    $anggotaCredentials = [
        'username_anggota' => $request->username,
        'password' => $request->password,
    ];

    if (Auth::guard('anggota')->attempt($anggotaCredentials)) {
        $request->session()->regenerate();
        $user = Auth::guard('anggota')->user();
        return redirect()->intended('/anggota/beranda');
    }

    $userCredentials = [
        'username' => $request->username,
        'password' => $request->password,
    ];

    if (Auth::guard('user')->attempt($userCredentials))  {
        $request->session()->regenerate();
        $user = Auth::guard('user')->user();

        switch ($user->id_role) {
            case 'R04':
            case 'R05':
            case 'R06':
            case 'R07':
                return redirect()->route('dashboard');
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}