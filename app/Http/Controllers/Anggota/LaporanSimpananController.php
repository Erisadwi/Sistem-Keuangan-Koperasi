<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Simpanan;
use Illuminate\Http\Request;  

class LaporanSimpananController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();

        $data = Simpanan::where('id_anggota', $anggota->id_anggota)
            ->orderBy('tanggal_transaksi', 'asc')
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

    public function apiIndex(Request $request)
    {
        $username = $request->query('username_anggota');

        if (!$username) {
            return response()->json([
                'status' => 'error',
                'message' => 'username_anggota wajib dikirim'
            ], 400);
        }

        $anggota = \App\Models\Anggota::where('username_anggota', $username)->first();

        if (!$anggota) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan'
            ], 404);
        }

        $data = \App\Models\Simpanan::where('id_anggota', $anggota->id_anggota)
            ->orderBy('tanggal_transaksi', 'asc')
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

        return response()->json([
            'status' => 'success',
            'username_anggota' => $username,
            'total' => $data->total(),
            'data' => $data->items()
        ]);
    }

}
