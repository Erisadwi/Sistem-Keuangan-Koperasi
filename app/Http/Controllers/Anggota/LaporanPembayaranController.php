<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanPembayaranController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();

        $data = DB::table('bayar_angsuran as b')
            ->join('view_data_angsuran as v', 'b.id_pinjaman', '=', 'v.id_pinjaman')
            ->select(
                'b.tanggal_bayar',
                'b.angsuran_ke',
                'b.denda',
                'b.angsuran_per_bulan',
                'b.keterangan',
                'v.lama_angsuran'
            )
            ->where('v.username_anggota', $anggota->username_anggota)
            ->orderBy('b.tanggal_bayar', 'desc')
            ->paginate(10);

        // Tentukan jenis: Angsuran atau Pelunasan
        $data->getCollection()->transform(function ($item) {
            $item->jenis = ($item->angsuran_ke == $item->lama_angsuran) ? 'Pelunasan' : 'Angsuran';
            return $item;
        });

        return view('anggota.laporan-pembayaran', compact('data'));
    }
}
