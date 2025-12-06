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
            ->orderBy('b.tanggal_bayar', 'asc')
            ->paginate(10);

        $data->getCollection()->transform(function ($item) {
            $item->jenis = ($item->angsuran_ke == $item->lama_angsuran) ? 'Pelunasan' : 'Angsuran';
            return $item;
        });

        return view('anggota.laporan-pembayaran', compact('data'));
    }

    public function apiIndex()
    {
        try {
            $username = request('username_anggota');

            if (!$username) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'username_anggota wajib dikirim.'
                ], 400);
            }

            $perPage = request('per_page', 10);

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
                ->where('v.username_anggota', $username)
                ->orderBy('b.tanggal_bayar', 'asc')
                ->paginate($perPage);

            $data->getCollection()->transform(function ($item) {
                $item->jenis = ($item->angsuran_ke == $item->lama_angsuran)
                    ? 'Pelunasan'
                    : 'Angsuran';
                return $item;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Data pembayaran berhasil diambil.',
                'data' => $data->items(),
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'total_pages'  => $data->lastPage(),
                    'per_page'     => $data->perPage(),
                    'total_data'   => $data->total()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data pembayaran.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
