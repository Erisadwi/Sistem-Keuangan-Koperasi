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
            ->where('status_lunas', 'BELUM LUNAS')
            ->sum('jumlah_pinjaman');

        $totalTransaksi = DB::table('bayar_angsuran')
            ->join('pinjaman', 'bayar_angsuran.id_pinjaman', '=', 'pinjaman.id_pinjaman')
            ->where('pinjaman.id_anggota', $userId)
            ->count();
            
        $totalTagihan = DB::table('view_data_angsuran')
            ->where('username_anggota', $user->username_anggota)
            ->where('status_lunas', 'Belum Lunas')
            ->selectRaw('SUM(jumlah_pinjaman + bunga_angsuran + biaya_admin) AS total')
            ->value('total') ?? 0;

        $totalDana = $simpanan + $pinjaman;

        if ($totalDana > 0) {
            $persenSimpanan = round(($simpanan / $totalDana) * 100, 2);
            $persenPinjaman = round(($pinjaman / $totalDana) * 100, 2);
        } else {
            $persenSimpanan = $persenPinjaman = 0;
        }

        $lastMonth = now()->subMonth()->format('m');
        $lastYear  = now()->subMonth()->format('Y');

        $simpananBulanLalu = DB::table('simpanan')
            ->where('id_anggota', (string) $userId)
            ->whereMonth('tanggal_transaksi', $lastMonth)
            ->whereYear('tanggal_transaksi', $lastYear)
            ->selectRaw("
                SUM(
                    CASE 
                        WHEN type_simpanan = 'TRD' THEN jumlah_simpanan
                        WHEN type_simpanan = 'TRK' THEN -jumlah_simpanan
                        ELSE 0
                    END
                ) AS total
            ")
            ->value('total') ?? 0;

        $pinjamanBulanLalu = DB::table('pinjaman')
            ->where('id_anggota', $userId)
            ->whereMonth('tanggal_pinjaman', $lastMonth)
            ->whereYear('tanggal_pinjaman', $lastYear)
            ->sum('jumlah_pinjaman') ?? 0;
        
                $currentMonth = now()->format('m');
        $currentYear  = now()->format('Y');

        $simpananBulanIni = DB::table('simpanan')
            ->where('id_anggota', (string) $userId)
            ->whereMonth('tanggal_transaksi', $currentMonth)
            ->whereYear('tanggal_transaksi', $currentYear)
            ->selectRaw("
                SUM(
                    CASE 
                        WHEN type_simpanan = 'TRD' THEN jumlah_simpanan
                        WHEN type_simpanan = 'TRK' THEN -jumlah_simpanan
                        ELSE 0
                    END
                ) AS total
            ")
            ->value('total') ?? 0;

        $pinjamanBulanIni = DB::table('pinjaman')
            ->where('id_anggota', $userId)
            ->whereMonth('tanggal_pinjaman', $currentMonth)
            ->whereYear('tanggal_pinjaman', $currentYear)
            ->sum('jumlah_pinjaman') ?? 0;

        $totalDanaBulanIni  = $simpananBulanIni  + $pinjamanBulanIni;
        $totalDanaBulanLalu = $simpananBulanLalu + $pinjamanBulanLalu;

        if ($totalDanaBulanIni > $totalDanaBulanLalu) {
            $statIcon = 'icons/statistic-up.png';
        } else {
            $statIcon = 'icons/statistic-down.png';
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
            'persenPinjaman',
            'statIcon',
            'totalDanaBulanIni',
            'totalDanaBulanLalu'
        ));
    }
}
