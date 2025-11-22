<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ViewJurnalPinjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKasPinjamanController extends Controller
{
    public function index(Request $request)
    {

        $preset     = $request->preset;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        if ($preset === 'this_year') {
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();
        } elseif ($preset === 'last_year') {
            $start_date = now()->subYear()->startOfYear()->toDateString();
            $end_date   = now()->subYear()->endOfYear()->toDateString();
        } elseif ($preset !== 'custom') {
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();
        }

        $periodeText = 'Periode ' 
            . Carbon::parse($start_date)->translatedFormat('j M Y') 
            . ' - '
            . Carbon::parse($end_date)->translatedFormat('j M Y');

        $data = ViewJurnalPinjaman::whereBetween('tanggal_pinjaman', [$start_date, $end_date])->get();

        $totalPokokPinjaman = $data->sum('debit');
        $totalTagihan = $data->sum('kredit');
        $totalDenda = 0;

        $totalSudahDibayar = DB::table('bayar_angsuran')
            ->whereBetween('tanggal_bayar', [$start_date, $end_date])
            ->sum('angsuran_per_bulan');

        $sisaTagihan = $totalTagihan - $totalSudahDibayar;

        $pinjamanTable = DB::table('pinjaman')
            ->whereBetween('tanggal_pinjaman', [$start_date, $end_date])
            ->get();

        $jumlahPeminjam   = $pinjamanTable->count();
        $jumlahLunas      = $pinjamanTable->where('status_lunas', 'LUNAS')->count();
        $jumlahBelumLunas = $jumlahPeminjam - $jumlahLunas;

        return view('admin.laporan.kas-pinjaman.laporan-kas-pinjaman', compact(
            'start_date',
            'end_date',
            'periodeText',
            'totalPokokPinjaman',
            'totalTagihan',
            'totalDenda',
            'totalSudahDibayar',
            'sisaTagihan',
            'jumlahPeminjam',
            'jumlahLunas',
            'jumlahBelumLunas'
        ));
    }

    public function exportPdf(Request $request)
    {

        $preset     = $request->preset;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        if ($preset === 'this_year') {
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();
        } elseif ($preset === 'last_year') {
            $start_date = now()->subYear()->startOfYear()->toDateString();
            $end_date   = now()->subYear()->endOfYear()->toDateString();
        } elseif ($preset !== 'custom') {
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();
        }

        $periodeText = 'Periode ' 
            . Carbon::parse($start_date)->translatedFormat('j M Y') 
            . ' - '
            . Carbon::parse($end_date)->translatedFormat('j M Y');


        $data = ViewJurnalPinjaman::whereBetween('tanggal_pinjaman', [$start_date, $end_date])->get();

        $totalPokokPinjaman = $data->sum('debit');
        $totalTagihan       = $data->sum('kredit');
        $totalDenda         = 0;

        $totalSudahDibayar = DB::table('bayar_angsuran')
            ->whereBetween('tanggal_bayar', [$start_date, $end_date])
            ->sum('angsuran_per_bulan');

        $sisaTagihan = $totalTagihan - $totalSudahDibayar;


        $pinjamanTable = DB::table('pinjaman')
            ->whereBetween('tanggal_pinjaman', [$start_date, $end_date])
            ->get();

        $jumlahPeminjam   = $pinjamanTable->count();
        $jumlahLunas      = $pinjamanTable->where('status_lunas', 'LUNAS')->count();
        $jumlahBelumLunas = $jumlahPeminjam - $jumlahLunas;


        $pdf = Pdf::loadView('admin.laporan.kas-pinjaman.pdf', compact(
            'start_date',
            'end_date',
            'periodeText',
            'totalPokokPinjaman',
            'totalTagihan',
            'totalDenda',
            'totalSudahDibayar',
            'sisaTagihan',
            'jumlahPeminjam',
            'jumlahLunas',
            'jumlahBelumLunas'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Kas_Pinjaman_{$start_date}_sampai_{$end_date}.pdf");
    }
}
