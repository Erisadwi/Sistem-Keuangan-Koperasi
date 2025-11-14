<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ViewLabaRugi;
use Illuminate\Support\Facades\DB;
use App\Models\DetailTransaksi;

class LaporanLabaRugiController extends Controller
{
    public function index()
    {
        $data = ViewLabaRugi::first();

        $pinjaman = collect([
            [
                'keterangan' => 'Total Pinjaman',
                'jumlah'     => $data->pinjaman_jumlah ?? 0,
            ],
            [
                'keterangan' => 'Total Angsuran',
                'jumlah'     => $data->pinjaman_angsuran ?? 0,
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
            ->where(function($q){
                $q->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
                  ->orWhereNull('t.type_transaksi'); 
            })
            ->groupBy('j.nama_AkunTransaksi')
            ->orderBy('j.nama_AkunTransaksi')
            ->get();

        $biaya = DB::table('jenis_akun_transaksi AS j')
            ->leftJoin('detail_transaksi AS d', 'j.id_jenisAkunTransaksi', '=', 'd.id_jenisAkunTransaksi')
            ->leftJoin('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
            ->select(
                'j.nama_AkunTransaksi AS keterangan',
                DB::raw('COALESCE(SUM(d.debit - d.kredit), 0) AS jumlah')
            )
            ->where('j.labarugi', 'BIAYA')
            ->where(function($q){
                $q->whereIn('t.type_transaksi', ['TKD', 'TKK', 'TNK'])
                  ->orWhereNull('t.type_transaksi'); 
            })
            ->groupBy('j.nama_AkunTransaksi')
            ->orderBy('j.nama_AkunTransaksi')
            ->get();

        return view('admin.laporan.laporan-laba-rugi', compact('pinjaman', 'pendapatan', 'biaya'));
    }
}
