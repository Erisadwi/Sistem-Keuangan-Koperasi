<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewNeraca;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanNeracaController extends Controller
{
    public function index(Request $request)
    {

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $tanggal = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $neraca = ViewNeraca::where(function($q) use ($tanggal){
                $q->whereDate('tanggal_transaksi', '<=', $tanggal)
                ->orWhereNull('tanggal_transaksi');
            })
            ->orderBy('kelompok_neraca')
            ->orderBy('kode_aktiva')
            ->get();

        $laba_bersih = DB::table('view_laba_rugi_extended')
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('laba_bersih');

        $neraca = $neraca->map(function ($item) use ($laba_bersih) {
            if ($item->kode_aktiva === 'I02.01') {
                $item->total_debit = $laba_bersih < 0 ? abs($laba_bersih) : 0;
                $item->total_kredit = $laba_bersih > 0 ? $laba_bersih : 0;
            }
            return $item;
        });

        $neracaGrouped = $neraca->groupBy('kelompok_neraca');

        $totalDebit  = $neraca->sum('total_debit');
        $totalKredit = $neraca->sum('total_kredit');

        $laba_bersih = DB::table('view_laba_rugi_extended')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('laba_bersih');

        $judul = 'LAPORAN NERACA PER TANGGAL ' . strtoupper($tanggal->translatedFormat('d F Y'));

        return view('admin.laporan.laporan-neraca.laporan-neraca', compact(
            'neracaGrouped',
            'tanggal',
            'judul',
            'totalDebit',
            'totalKredit',
            'laba_bersih',
            'bulan',
            'tahun'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $tanggal = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $neraca = ViewNeraca::where(function($q) use ($tanggal){
            $q->whereDate('tanggal_transaksi', '<=', $tanggal)
            ->orWhereNull('tanggal_transaksi');
        })
        ->orderBy('kelompok_neraca')
        ->orderBy('kode_aktiva')
        ->get();

        $laba_bersih = DB::table('view_laba_rugi_extended')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('laba_bersih');

        $neraca = $neraca->map(function ($item) use ($laba_bersih) {
            if ($item->kode_aktiva === 'I02.01') {
                    $item->total_debit = $laba_bersih < 0 ? abs($laba_bersih) : 0;
                    $item->total_kredit = $laba_bersih > 0 ? $laba_bersih : 0;
                }
                return $item;
            });

        $neracaGrouped = $neraca->groupBy('kelompok_neraca');

        $totalDebit  = $neraca->sum('total_debit');
        $totalKredit = $neraca->sum('total_kredit');

        $laba_bersih = DB::table('view_laba_rugi_extended')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('laba_bersih');

        $judul = 'LAPORAN NERACA PER TANGGAL ' . strtoupper($tanggal->translatedFormat('d F Y'));

        $pdf = Pdf::loadView('admin.laporan.laporan-neraca.pdf', compact(
            'neracaGrouped',
            'tanggal',
            'judul',
            'totalDebit',
            'totalKredit',
            'laba_bersih',
            'bulan',
            'tahun'
        ))->setPaper('A4', 'portrait');

        $namaFile = 'laporan_neraca_' . $tanggal->translatedFormat('d_F_Y') . '.pdf';

        return $pdf->download($namaFile);
    }
}
