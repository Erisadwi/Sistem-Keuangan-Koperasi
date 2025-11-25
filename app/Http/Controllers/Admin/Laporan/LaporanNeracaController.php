<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ViewNeraca;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanNeracaController extends Controller
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

        if ($preset === 'this_year') {
            $periode = "31 Desember " . now()->year;
        } elseif ($preset === 'last_year') {
            $periode = "31 Desember " . now()->subYear()->year;
        } elseif ($preset === 'custom' && $end_date) {
            $periode = "31 Desember " . date('Y', strtotime($end_date));
        } else {
            $periode = "31 Desember " . now()->year;
        }

        $activa = ViewNeraca::where('keterangan_akun', 'ACTIVA')->orderBy('id_akun')->get();
        $pasiva = ViewNeraca::where('keterangan_akun', 'PASIVA')->orderBy('id_akun')->get();

        $totalActiva = $activa->sum('total_debit');
        $totalPasiva = $pasiva->sum('total_kredit');

        $totalKeseluruhan = [
            'activa' => $totalActiva,
            'pasiva' => $totalPasiva
        ];

        return view('admin.laporan.laporan-neraca.laporan-neraca', compact(
            'start_date',
            'end_date',
            'periode',
            'activa',
            'pasiva',
            'totalActiva',
            'totalPasiva',
            'totalKeseluruhan'
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

        if ($preset === 'this_year') {
            $periode = "31 Desember " . now()->year;
        } elseif ($preset === 'last_year') {
            $periode = "31 Desember " . now()->subYear()->year;
        } elseif ($preset === 'custom' && $end_date) {
            $periode = "31 Desember " . date('Y', strtotime($end_date));
        } else {
            $periode = "31 Desember " . now()->year;
        }

        $activa = ViewNeraca::where('keterangan_akun', 'ACTIVA')->orderBy('id_akun')->get();
        $pasiva = ViewNeraca::where('keterangan_akun', 'PASIVA')->orderBy('id_akun')->get();

        $totalActiva = $activa->sum('total_debit');
        $totalPasiva = $pasiva->sum('total_kredit');

        $totalKeseluruhan = [
            'activa' => $totalActiva,
            'pasiva' => $totalPasiva
        ];

        $pdf = Pdf::loadView('admin.laporan.laporan-neraca.pdf', compact(
            'start_date',
            'end_date',
            'periode',
            'activa',
            'pasiva',
            'totalActiva',
            'totalPasiva',
            'totalKeseluruhan'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Neraca_Per_{$periode}.pdf");
    }
}
