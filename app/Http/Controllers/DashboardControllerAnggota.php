<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardControllerAnggota extends Controller
{
    public function index()
    {
        $user = Auth::guard('anggota')->user();
        $userId = $user->id_anggota;

        $hour = now()->format('H');
        if ($hour < 12) {
            $salam = 'Selamat Pagi';
        } elseif ($hour < 18) {
            $salam = 'Selamat Siang';
        } else {
            $salam = 'Selamat Malam';
        }

        $namaDepan = explode(' ', $user->nama_anggota)[0] ?? 'Pengguna';


        $simpanan = DB::table('simpanan')
            ->where('id_anggota', (string) $userId)
            ->selectRaw("
                SUM(
                    CASE 
                        WHEN type_simpanan = 'TRD' THEN jumlah_simpanan
                        WHEN type_simpanan = 'TRK' THEN -jumlah_simpanan
                        ELSE 0
                    END
                ) AS total
            ")
            ->value('total');


        $pinjaman = DB::table('pinjaman')
            ->where('id_anggota', $userId)
            ->sum('jumlah_pinjaman');

        $totalTransaksi = DB::table('bayar_angsuran')
            ->join('pinjaman', 'bayar_angsuran.id_pinjaman', '=', 'pinjaman.id_pinjaman')
            ->where('pinjaman.id_anggota', $userId)
            ->count();

        $totalTagihan = DB::table('pinjaman')
            ->where('id_anggota', $userId)
            ->count();

        $totalDana = $simpanan + $pinjaman;

        if ($totalDana > 0) {
            $persenSimpanan = round(($simpanan / $totalDana) * 100, 2);
            $persenPinjaman = round(($pinjaman / $totalDana) * 100, 2);
        } else {
            $persenSimpanan = $persenPinjaman = 0;
        }

        return view('anggota.beranda', compact(
            'salam',
            'namaDepan',
            'simpanan',
            'pinjaman',
            'totalTransaksi',
            'totalTagihan',
            'totalDana',
            'persenSimpanan',
            'persenPinjaman'
        ));
    }
}
