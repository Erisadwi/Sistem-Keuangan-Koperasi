<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Simpanan;

class LaporanSimpananController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();

        $data = Simpanan::where('id_anggota', $anggota->id_anggota)
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        $data->getCollection()->transform(function ($item) {

            if (str_starts_with($item->kode_simpanan, 'TRD')) {
                $item->jenis = 'Setoran';
            } elseif (str_starts_with($item->kode_simpanan, 'TRK')) {
                $item->jenis = 'Penarikan';
            } else {
                $item->jenis = '-';
            }

            $item->tanggal = $item->tanggal_transaksi;
            $item->jumlah = $item->jumlah_simpanan;

            return $item;
        });

        return view('anggota.laporan-simpanan', compact('data', 'anggota'));
    }
}
