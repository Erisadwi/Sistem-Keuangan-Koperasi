<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Str;
use Illuminate\View\View;              

class BerandaController extends Controller
{
    public function index(): View
    {
        $user = Auth::user(); 

        $h = now(config('app.timezone', 'Asia/Jakarta'))->hour;
        $salam = $h < 11 ? 'Selamat Pagi'
               : ($h < 15 ? 'Selamat Siang'
               : ($h < 19 ? 'Selamat Sore' : 'Selamat Malam'));

        $namaLengkap = Str::of($user?->name ?? 'anggota')->before(' ');

        return view('anggota.beranda', compact('salam', 'namaLengkap'));
    }
}
