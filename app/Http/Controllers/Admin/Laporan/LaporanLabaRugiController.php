<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ViewLabaRugi;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanLabaRugiController extends Controller
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

        $view = DB::table('view_laba_rugi')
            ->whereBetween('tanggal', [$start_date, $end_date])
            ->get();

        $pinjaman = collect([
            [
                'keterangan' => 'Jumlah Pinjaman',
                'jumlah'     => $view->where('kategori', 'PINJAMAN')->sum('kredit')
            ],
            [
                'keterangan' => 'Jumlah Angsuran',
                'jumlah'     => $view->where('kategori', 'ANGSURAN')->sum('debit')
            ],
        ]);

    $pendapatan = DB::table('view_laba_rugi')
        ->select('akun AS keterangan', DB::raw('COALESCE(SUM(debit), 0) AS jumlah'))
        ->where('kategori', 'PENDAPATAN')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->groupBy('akun')
        ->orderBy('akun')
        ->get();

    $pendapatanKosong = DB::table('jenis_akun_transaksi')
        ->where('labarugi', 'PENDAPATAN')
        ->get()
        ->filter(fn($akun) => !$pendapatan->contains('keterangan', $akun->nama_AkunTransaksi))
        ->map(fn($akun) => (object)[
            'keterangan' => $akun->nama_AkunTransaksi,
            'jumlah' => 0
        ]);
    $pendapatan = $pendapatan->merge($pendapatanKosong)->sortBy('keterangan');

    $biaya = DB::table('view_laba_rugi')
        ->select('akun AS keterangan', DB::raw('COALESCE(SUM(kredit), 0) AS jumlah'))
        ->where('kategori', 'BIAYA')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->groupBy('akun')
        ->orderBy('akun')
        ->get();

    $biayaKosong = DB::table('jenis_akun_transaksi')
        ->where('labarugi', 'BIAYA')
        ->get()
        ->filter(fn($akun) => !$biaya->contains('keterangan', $akun->nama_AkunTransaksi))
        ->map(fn($akun) => (object)[
            'keterangan' => $akun->nama_AkunTransaksi,
            'jumlah' => 0
        ]);
    $biaya = $biaya->merge($biayaKosong)->sortBy('keterangan');

            return view('admin.laporan.laba-rugi.laporan-laba-rugi', compact(
                'pinjaman', 'pendapatan', 'biaya', 'periodeText'
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

    $view = DB::table('view_laba_rugi')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->get();

    $pinjaman = (object)[
        'pinjaman_jumlah'   => $view->where('kategori', 'PINJAMAN')->sum('kredit'),
        'pinjaman_angsuran' => $view->where('kategori', 'ANGSURAN')->sum('debit'),
    ];

    $pendapatan = DB::table('view_laba_rugi')
        ->select('akun AS keterangan', DB::raw('COALESCE(SUM(debit),0) AS jumlah'))
        ->where('kategori', 'PENDAPATAN')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->groupBy('akun')
        ->orderBy('akun')
        ->get();

    $pendapatanKosong = DB::table('jenis_akun_transaksi')
        ->where('labarugi', 'PENDAPATAN')
        ->get()
        ->filter(fn($akun) => !$pendapatan->contains('keterangan', $akun->nama_AkunTransaksi))
        ->map(fn($akun) => (object)[
            'keterangan' => $akun->nama_AkunTransaksi,
            'jumlah' => 0
        ]);
    $pendapatan = $pendapatan->merge($pendapatanKosong)->sortBy('keterangan');

    $biaya = DB::table('view_laba_rugi')
        ->select('akun AS keterangan', DB::raw('COALESCE(SUM(kredit),0) AS jumlah'))
        ->where('kategori', 'BIAYA')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->groupBy('akun')
        ->orderBy('akun')
        ->get();

    $biayaKosong = DB::table('jenis_akun_transaksi')
        ->where('labarugi', 'BIAYA')
        ->get()
        ->filter(fn($akun) => !$biaya->contains('keterangan', $akun->nama_AkunTransaksi))
        ->map(fn($akun) => (object)[
            'keterangan' => $akun->nama_AkunTransaksi,
            'jumlah' => 0
        ]);
    $biaya = $biaya->merge($biayaKosong)->sortBy('keterangan');

    $totalPendapatan = $pendapatan->sum('jumlah');
    $totalBiaya      = $biaya->sum('jumlah');
    $labaBersih      = $totalPendapatan - $totalBiaya;

    $pdf = Pdf::loadView('admin.laporan.laba-rugi.pdf', compact(
        'start_date', 'end_date', 'periodeText',
        'pinjaman', 'pendapatan', 'biaya',
        'totalPendapatan', 'totalBiaya', 'labaBersih'
    ))->setPaper('a4', 'portrait');

    return $pdf->download("Laporan_Laba_Rugi_{$start_date}_sampai_{$end_date}.pdf");
}

public function apiIndex(Request $request)
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

    $view = DB::table('view_laba_rugi')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->get();

    $pinjaman = [
        'jumlah_pinjaman' => $view->where('kategori', 'PINJAMAN')->sum('kredit'),
        'jumlah_angsuran' => $view->where('kategori', 'ANGSURAN')->sum('debit'),
    ];

    $pendapatan = DB::table('view_laba_rugi')
        ->select('akun AS keterangan', DB::raw('COALESCE(SUM(debit),0) AS jumlah'))
        ->where('kategori', 'PENDAPATAN')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->groupBy('akun')
        ->orderBy('akun')
        ->get();

    $pendapatanKosong = DB::table('jenis_akun_transaksi')
        ->where('labarugi', 'PENDAPATAN')
        ->get()
        ->filter(fn($a) => !$pendapatan->contains('keterangan', $a->nama_AkunTransaksi))
        ->map(fn($a) => (object)[
            'keterangan' => $a->nama_AkunTransaksi,
            'jumlah' => 0
        ]);

    $pendapatan = $pendapatan->merge($pendapatanKosong)->sortBy('keterangan')->values();

    $biaya = DB::table('view_laba_rugi')
        ->select('akun AS keterangan', DB::raw('COALESCE(SUM(kredit),0) AS jumlah'))
        ->where('kategori', 'BIAYA')
        ->whereBetween('tanggal', [$start_date, $end_date])
        ->groupBy('akun')
        ->orderBy('akun')
        ->get();

    $biayaKosong = DB::table('jenis_akun_transaksi')
        ->where('labarugi', 'BIAYA')
        ->get()
        ->filter(fn($a) => !$biaya->contains('keterangan', $a->nama_AkunTransaksi))
        ->map(fn($a) => (object)[
            'keterangan' => $a->nama_AkunTransaksi,
            'jumlah' => 0
        ]);

    $biaya = $biaya->merge($biayaKosong)->sortBy('keterangan')->values();

    $totalPendapatan = $pendapatan->sum('jumlah');
    $totalBiaya      = $biaya->sum('jumlah');
    $labaBersih      = $totalPendapatan - $totalBiaya;

    return response()->json([
        'success' => true,
        'message' => 'Data laporan laba rugi berhasil diambil.',
        'periode' => [
            'text' => $periodeText,
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ],
        'pinjaman' => $pinjaman,
        'pendapatan' => $pendapatan->values(),
        'biaya' => $biaya->values(),
        'ringkasan' => [
            'total_pendapatan' => $totalPendapatan,
            'total_biaya'      => $totalBiaya,
            'laba_bersih'      => $labaBersih
        ]
    ]);
}

}
