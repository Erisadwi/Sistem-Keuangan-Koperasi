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
                'jumlah'     => $view->where('kategori', 'PINJAMAN')->sum('debit')
            ],
            [
                'keterangan' => 'Jumlah Angsuran',
                'jumlah'     => $view->where('kategori', 'ANGSURAN')->sum('kredit')
            ],
        ]);

        $pendapatan = DB::table('jenis_akun_transaksi AS j')
            ->leftJoin('detail_transaksi AS d', 'j.id_jenisAkunTransaksi', '=', 'd.id_jenisAkunTransaksi')
            ->leftJoin('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
            ->select(
                'j.nama_AkunTransaksi AS keterangan',
                DB::raw('COALESCE(SUM(d.kredit - d.debit), 0) AS jumlah')
            )
            ->where('j.labarugi', 'PENDAPATAN')
            ->where(function ($q) use ($start_date, $end_date) {
                $q->whereBetween('t.tanggal_transaksi', [$start_date, $end_date])
                  ->orWhereNull('t.tanggal_transaksi');
            })
            ->where(function ($q) {
                $q->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
                  ->orWhereNull('t.type_transaksi');
            })
            ->groupBy('j.nama_AkunTransaksi')
            ->orderBy('j.nama_AkunTransaksi')
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

        $biaya = DB::table('jenis_akun_transaksi AS j')
            ->leftJoin('detail_transaksi AS d', 'j.id_jenisAkunTransaksi', '=', 'd.id_jenisAkunTransaksi')
            ->leftJoin('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
            ->select(
                'j.nama_AkunTransaksi AS keterangan',
                DB::raw('COALESCE(SUM(d.debit - d.kredit), 0) AS jumlah')
            )
            ->where('j.labarugi', 'BIAYA')
            ->where(function ($q) use ($start_date, $end_date) {
                $q->whereBetween('t.tanggal_transaksi', [$start_date, $end_date])
                  ->orWhereNull('t.tanggal_transaksi');
            })
            ->where(function ($q) {
                $q->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
                  ->orWhereNull('t.type_transaksi');
            })
            ->groupBy('j.nama_AkunTransaksi')
            ->orderBy('j.nama_AkunTransaksi')
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
        'pinjaman_jumlah'     => $view->where('kategori', 'PINJAMAN')->sum('debit'),
        'pinjaman_angsuran'   => $view->where('kategori', 'ANGSURAN')->sum('kredit'),
    ];


    $pendapatan = DB::table('jenis_akun_transaksi AS j')
        ->leftJoin('detail_transaksi AS d', 'j.id_jenisAkunTransaksi', '=', 'd.id_jenisAkunTransaksi')
        ->leftJoin('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
        ->select(
            'j.nama_AkunTransaksi AS keterangan',
            DB::raw('COALESCE(SUM(d.kredit - d.debit), 0) AS jumlah')
        )
        ->where('j.labarugi', 'PENDAPATAN')
        ->where(function ($q) use ($start_date, $end_date) {
            $q->whereBetween('t.tanggal_transaksi', [$start_date, $end_date])
              ->orWhereNull('t.tanggal_transaksi');
        })
        ->where(function ($q) {
            $q->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
              ->orWhereNull('t.type_transaksi');
        })
        ->groupBy('j.nama_AkunTransaksi')
        ->orderBy('j.nama_AkunTransaksi')
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


    $biaya = DB::table('jenis_akun_transaksi AS j')
        ->leftJoin('detail_transaksi AS d', 'j.id_jenisAkunTransaksi', '=', 'd.id_jenisAkunTransaksi')
        ->leftJoin('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
        ->select(
            'j.nama_AkunTransaksi AS keterangan',
            DB::raw('COALESCE(SUM(d.debit - d.kredit), 0) AS jumlah')
        )
        ->where('j.labarugi', 'BIAYA')
        ->where(function ($q) use ($start_date, $end_date) {
            $q->whereBetween('t.tanggal_transaksi', [$start_date, $end_date])
              ->orWhereNull('t.tanggal_transaksi');
        })
        ->where(function ($q) {
            $q->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
              ->orWhereNull('t.type_transaksi');
        })
        ->groupBy('j.nama_AkunTransaksi')
        ->orderBy('j.nama_AkunTransaksi')
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

}
