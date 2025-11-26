<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ViewRekapSimpanan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKasSimpananController extends Controller
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

        $periodeText = 'Periode ' .
            Carbon::parse($start_date)->translatedFormat('d M Y') .
            ' - ' .
            Carbon::parse($end_date)->translatedFormat('d M Y');

        $jenisTetap = ['Simpanan Sukarela', 'Simpanan Pokok', 'Simpanan Wajib'];

        $transaksi = ViewRekapSimpanan::whereBetween('tanggal_transaksi', [
            $start_date . ' 00:00:00',
            $end_date . ' 23:59:59'
        ])->get();

        $data = collect($jenisTetap)->map(function ($jenis) use ($transaksi) {
            $filtered = $transaksi->where('jenis_akun', $jenis);

            $simpanan = $filtered->sum('simpanan');
            $penarikan = $filtered->sum('penarikan');
            $jumlah = $simpanan - $penarikan;

            return (object)[
                'jenis_akun' => $jenis,
                'simpanan' => $simpanan,
                'penarikan' => $penarikan,
                'jumlah' => $jumlah,
            ];
        });

        $totalSimpanan  = $data->sum('simpanan');
        $totalPenarikan = $data->sum('penarikan');
        $totalJumlah    = $data->sum('jumlah');

        return view('admin.laporan.kas-simpanan.laporan-kas-simpanan', compact(
            'start_date',
            'end_date',
            'periodeText',
            'data',
            'totalSimpanan',
            'totalPenarikan',
            'totalJumlah'
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

        $periodeText = 'Periode ' .
            Carbon::parse($start_date)->translatedFormat('d M Y') .
            ' - ' .
            Carbon::parse($end_date)->translatedFormat('d M Y');

        $jenisTetap = ['Simpanan Sukarela', 'Simpanan Pokok', 'Simpanan Wajib'];

        $transaksi = ViewRekapSimpanan::whereBetween('tanggal_transaksi', [
            $start_date . ' 00:00:00',
            $end_date . ' 23:59:59'
        ])->get();

        $data = collect($jenisTetap)->map(function ($jenis) use ($transaksi) {
            $filtered = $transaksi->where('jenis_akun', $jenis);

            $simpanan = $filtered->sum('simpanan');
            $penarikan = $filtered->sum('penarikan');
            $jumlah = $simpanan - $penarikan;

            return (object)[
                'jenis_akun' => $jenis,
                'simpanan' => $simpanan,
                'penarikan' => $penarikan,
                'jumlah' => $jumlah,
            ];
        });

        $totalSimpanan  = $data->sum('simpanan');
        $totalPenarikan = $data->sum('penarikan');
        $totalJumlah    = $data->sum('jumlah');

        $pdf = Pdf::loadView('admin.laporan.kas-simpanan.pdf', compact(
            'start_date',
            'end_date',
            'periodeText',
            'data',
            'totalSimpanan',
            'totalPenarikan',
            'totalJumlah'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Kas_Simpanan_{$start_date}_sampai_{$end_date}.pdf");
    }
}
