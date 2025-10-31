<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardControllerAnggota extends Controller
{
    public function index()
    {
        $user = Auth::guard('anggota')->user();

        $hour = now()->format('H');
        if ($hour < 12) {
            $salam = 'Selamat Pagi';
        } elseif ($hour < 18) {
            $salam = 'Selamat Siang';
        } else {
            $salam = 'Selamat Malam';
        }

        $namaDepan = explode(' ', $user->nama_anggota)[0] ?? 'Pengguna';

        return view('anggota.beranda', compact('salam', 'namaDepan'));
    }
}
