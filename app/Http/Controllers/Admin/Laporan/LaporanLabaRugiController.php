<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ViewLabaRugi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanLabaRugiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai preset (this_year, last_year, custom)
        $preset     = $request->preset;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        // =========================
        // 1. Tentukan rentang tanggal
        // =========================

        if ($preset === 'this_year') {
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();
        }
        elseif ($preset === 'last_year') {
            $start_date = now()->subYear()->startOfYear()->toDateString();
            $end_date   = now()->subYear()->endOfYear()->toDateString();
        }
        elseif ($preset === 'custom') {
            // custom: biarkan start_date & end_date apa adanya
        }
        else {
            // default: jika user tidak memilih filter → gunakan tahun berjalan
            $start_date = now()->startOfYear()->toDateString();
            $end_date   = now()->endOfYear()->toDateString();
        }


        $periodeText = 'Periode ' 
            . \Carbon\Carbon::parse($start_date)->translatedFormat('j M Y')
            . ' - '
            . \Carbon\Carbon::parse($end_date)->translatedFormat('j M Y');



        $data = ViewLabaRugi::first();

        $pinjaman = collect([
            ['keterangan' => 'Total Pinjaman',  'jumlah' => $data->pinjaman_jumlah ?? 0],
            ['keterangan' => 'Total Angsuran',  'jumlah' => $data->pinjaman_angsuran ?? 0],
        ]);


        // =========================
        // 4. Bagian Pendapatan
        // =========================
        $pendapatan = DB::table('jenis_akun_transaksi AS j')
            ->leftJoin('detail_transaksi AS d', 'j.id_jenisAkunTransaksi', '=', 'd.id_jenisAkunTransaksi')
            ->leftJoin('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
            ->select(
                'j.nama_AkunTransaksi AS keterangan',
                DB::raw('COALESCE(SUM(d.kredit - d.debit), 0) AS jumlah')
            )
            ->where('j.labarugi', 'PENDAPATAN')
            ->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
            ->whereBetween('t.tanggal_transaksi', [$start_date, $end_date])
            ->groupBy('j.nama_AkunTransaksi')
            ->orderBy('j.nama_AkunTransaksi')
            ->get();


        // =========================
        // 5. Bagian Biaya
        // =========================
        $biaya = DB::table('jenis_akun_transaksi AS j')
            ->leftJoin('detail_transaksi AS d', 'j.id_jenisAkunTransaksi', '=', 'd.id_jenisAkunTransaksi')
            ->leftJoin('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
            ->select(
                'j.nama_AkunTransaksi AS keterangan',
                DB::raw('COALESCE(SUM(d.debit - d.kredit), 0) AS jumlah')
            )
            ->where('j.labarugi', 'BIAYA')
            ->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
            ->whereBetween('t.tanggal_transaksi', [$start_date, $end_date])
            ->groupBy('j.nama_AkunTransaksi')
            ->orderBy('j.nama_AkunTransaksi')
            ->get();


        return view(
            'admin.laporan.laporan-laba-rugi',
            compact('pinjaman', 'pendapatan', 'biaya', 'periodeText')
        );
    }
}
