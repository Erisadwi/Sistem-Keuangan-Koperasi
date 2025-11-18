<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        if (!$user) {
            return redirect()->route('login');
        }
        
        // ====== DATA ANGGOTA ======
        $anggota_aktif = DB::table('anggota')
            ->where('status_anggota', 'Aktif')
            ->count();

        $anggota_nonaktif = DB::table('anggota')
            ->where('status_anggota', 'Non Aktif')
            ->count();

        $anggota_total = DB::table('anggota')->count();


        // ====== DATA PEMINJAM ======
        $peminjam_total = DB::table('pinjaman')->count();

        $peminjam_lunas = DB::table('pinjaman')
            ->where('status_lunas', 'LUNAS')
            ->count();

        $peminjam_belum = DB::table('pinjaman')
            ->where('status_lunas', 'BELUM LUNAS')
            ->count();

        // ====== DATA PENGGUNA ======
        $user_aktif = User::where('status', 'aktif')->count();
        $user_nonaktif = User::where('status', 'nonaktif')->count();
        $user_total = User::count();


        $data = [
        
            'anggota_aktif' => $anggota_aktif,
            'anggota_nonaktif' => $anggota_nonaktif,
            'anggota_total' => $anggota_total,

            'peminjam_total' => $peminjam_total,
            'peminjam_lunas' => $peminjam_lunas,
            'peminjam_belum' => $peminjam_belum,

            'user_aktif' => $user_aktif,
            'user_nonaktif' => $user_nonaktif,
            'user_total' => $user_total,
        ];


        // role redirect
        switch ($user->id_role) {
            case 'R04':
            case 'R05':
            case 'R06':
            case 'R07':
                return view('dashboard.pengurus', $data);

            default:
                abort(403, 'Role tidak dikenali');
        }
    }
}
