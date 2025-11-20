<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKasPinjamanController extends Controller
{
    public function index(Request $request)
    {
        $preset     = $request->preset;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        // ==============================
        //   ATUR PERIODE (SAMA PERSIS DGN LABA RUGI)
        // ==============================
        if ($preset === 'this_year') {
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();

        } elseif ($preset === 'last_year') {
            $start_date = now()->subYear()->startOfYear()->toDateString();
            $end_date   = now()->subYear()->endOfYear()->toDateString();

        } elseif ($preset !== 'custom') {
            // default: tahun ini
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();
        }

        // ==============================
        //   TULIS TEKS PERIODE
        // ==============================
        $periodeText = 'Periode ' 
            . Carbon::parse($start_date)->translatedFormat('j M Y')
            . ' - '
            . Carbon::parse($end_date)->translatedFormat('j M Y');

        // ==============================
        //   QUERY PINJAMAN & ANGSURAN
        // ==============================
        $pinjamanQuery = Pinjaman::whereBetween('tanggal_pinjaman', [$start_date, $end_date]);
        $angsuranQuery = Angsuran::whereBetween('tanggal_bayar', [$start_date, $end_date]);

        // hitungan
        $jumlahPeminjam      = $pinjamanQuery->count();
        $jumlahLunas         = $pinjamanQuery->where('status_lunas', 'lunas')->count();
        $jumlahBelumLunas    = $jumlahPeminjam - $jumlahLunas;

        $totalPokokPinjaman  = $pinjamanQuery->sum('jumlah_pinjaman');
        $totalTagihan        = $pinjamanQuery->sum('total_tagihan');
        $totalDenda          = $angsuranQuery->sum('denda');
        $totalSudahDibayar   = $angsuranQuery->sum('angsuran_per_bulan');
        $sisaTagihan         = ($totalTagihan + $totalDenda) - $totalSudahDibayar;

        return view('admin.laporan.kas-pinjaman.laporan-kas-pinjaman', compact(
            'start_date',
            'end_date',
            'periodeText',
            'jumlahPeminjam',
            'jumlahLunas',
            'jumlahBelumLunas',
            'totalPokokPinjaman',
            'totalTagihan',
            'totalDenda',
            'totalSudahDibayar',
            'sisaTagihan'
        ));
    }

    // ==============================
    //   EXPORT PDF
    // ==============================
    public function exportPdf(Request $request)
    {
        $preset     = $request->preset;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        // preset periode
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

        // format periode
        $periodeText = 'Periode ' 
            . Carbon::parse($start_date)->translatedFormat('j M Y')
            . ' - '
            . Carbon::parse($end_date)->translatedFormat('j M Y');

        // query
        $pinjamanQuery = Pinjaman::whereBetween('tanggal_pinjaman', [$start_date, $end_date]);
        $angsuranQuery = Angsuran::whereBetween('tanggal_bayar', [$start_date, $end_date]);

        $jumlahPeminjam      = $pinjamanQuery->count();
        $jumlahLunas         = $pinjamanQuery->where('status_lunas', 'lunas')->count();
        $jumlahBelumLunas    = $jumlahPeminjam - $jumlahLunas;

        $totalPokokPinjaman  = $pinjamanQuery->sum('jumlah_pinjaman');
        $totalTagihan        = $pinjamanQuery->sum('total_tagihan');
        $totalDenda          = $angsuranQuery->sum('denda');
        $totalSudahDibayar   = $angsuranQuery->sum('angsuran_per_bulan');
        $sisaTagihan         = ($totalTagihan + $totalDenda) - $totalSudahDibayar;

        $pdf = Pdf::loadView('admin.laporan.kas-pinjaman.pdf', compact(
            'start_date',
            'end_date',
            'periodeText',
            'jumlahPeminjam',
            'jumlahLunas',
            'jumlahBelumLunas',
            'totalPokokPinjaman',
            'totalTagihan',
            'totalDenda',
            'totalSudahDibayar',
            'sisaTagihan'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Kas_Pinjaman_{$start_date}_sampai_{$end_date}.pdf");
    }
}
