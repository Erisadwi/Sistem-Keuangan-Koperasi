<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanSaldoKasController extends Controller
{
public function index(Request $request)
{
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));

    $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
    $endDate   = Carbon::create($tahun, $bulan, 1)->endOfMonth();
    $prevEnd   = (clone $startDate)->subMonth()->endOfMonth();

    $akunKas = DB::table('jenis_akun_transaksi')
        ->where('is_kas', 1)
        ->select('id_jenisAkunTransaksi as id_akun', 'nama_AkunTransaksi as nama_kas')
        ->get();

    $saldoBulanIni = DB::table('view_total_saldo_kas')
        ->select(
            'id_akun',
            DB::raw('SUM(jumlah) as total_saldo')
        )
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->groupBy('id_akun')
        ->pluck('total_saldo', 'id_akun');

    $saldoBulanLalu = DB::table('view_total_saldo_kas')
        ->select(
            'id_akun',
            DB::raw('SUM(jumlah) as total_saldo_lalu')
        )
        ->where('tanggal', '<=', $prevEnd)
        ->groupBy('id_akun')
        ->pluck('total_saldo_lalu', 'id_akun');

    $data = $akunKas->map(function ($item) use ($saldoBulanIni, $saldoBulanLalu) {

        $item->total_saldo = $saldoBulanIni[$item->id_akun] ?? 0;
        $item->total_saldo_lalu = $saldoBulanLalu[$item->id_akun] ?? 0;

        $item->selisih = $item->total_saldo - $item->total_saldo_lalu;

        return $item;
    });

    $saldo_periode_sebelumnya = $data->sum('total_saldo_lalu');
    $jumlah_kas = $data->sum('total_saldo');

    return view('admin.laporan.saldo-kas.laporan-saldo-kas', compact(
        'data', 'bulan', 'tahun', 'startDate', 'endDate',
        'saldo_periode_sebelumnya', 'jumlah_kas'
    ));
}



public function exportPdf(Request $request)
{
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));

    $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
    $endDate   = Carbon::create($tahun, $bulan, 1)->endOfMonth();
    $prevEnd   = (clone $startDate)->subMonth()->endOfMonth();

    $akunKas = DB::table('jenis_akun_transaksi')
        ->where('is_kas', 1)
        ->select('id_jenisAkunTransaksi as id_akun', 'nama_AkunTransaksi as nama_kas')
        ->get();

    $saldoBulanIni = DB::table('view_total_saldo_kas')
        ->select(
            'id_akun',
            DB::raw('SUM(jumlah) AS total_saldo')
        )
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->groupBy('id_akun')
        ->pluck('total_saldo', 'id_akun');

    $saldoBulanLalu = DB::table('view_total_saldo_kas')
        ->select(
            'id_akun',
            DB::raw('SUM(jumlah) AS total_saldo_lalu')
        )
        ->where('tanggal', '<=', $prevEnd)
        ->groupBy('id_akun')
        ->pluck('total_saldo_lalu', 'id_akun');


    $data = $akunKas->map(function ($item) use ($saldoBulanIni, $saldoBulanLalu) {

        $item->total_saldo = $saldoBulanIni[$item->id_akun] ?? 0;
        $item->total_saldo_lalu = $saldoBulanLalu[$item->id_akun] ?? 0;
        $item->selisih = $item->total_saldo - $item->total_saldo_lalu;

        return $item;
    });

    $saldo_periode_sebelumnya = $data->sum('total_saldo_lalu');
    $jumlah_kas = $data->sum('total_saldo');

    $pdf = Pdf::loadView('admin.laporan.saldo-kas.pdf', compact(
        'data', 'bulan', 'tahun', 'saldo_periode_sebelumnya',
        'jumlah_kas', 'startDate', 'endDate'
    ))->setPaper('a4', 'portrait');

    return $pdf->download("Laporan_Saldo_Kas_{$bulan}-{$tahun}.pdf");
}


}
