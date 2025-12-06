<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\LamaAngsuran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanPinjamanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $data = DB::table('view_data_angsuran')
            ->where('username_anggota', $user->username_anggota)
            ->orderBy('tanggal_pinjaman', 'asc')
            ->paginate(10);

        $data->getCollection()->transform(function ($item) use ($user) {
            $item->tanggal = $item->tanggal_pinjaman;
            $item->jumlah = $item->jumlah_pinjaman;
            $item->bunga = $item->bunga_angsuran * $item->lama_angsuran;
            $item->administrasi = $item->biaya_admin;
            $item->tempo = $item->tanggal_jatuh_tempo;
            $item->lunas = $item->status_lunas; 
            $item->tagihan = $item->jumlah_pinjaman + $item->bunga + $item->biaya_admin;
            $item->total_bayar = DB::table('bayar_angsuran')
                ->where('id_pinjaman', $item->id_pinjaman)
                ->sum('angsuran_per_bulan');
            $item->sisa_tagihan = $item->tagihan - $item->total_bayar;
            $item->keterangan = null;
            return $item;
        });

        return view('anggota.laporan-pinjaman', compact('data'));
    }

    public function apiIndex(Request $request)
    {
        $username = $request->username_anggota;

        if (!$username) {
            return response()->json([
                'status' => 'error',
                'message' => 'username_anggota wajib dikirim'
            ], 400);
        }

        $data = DB::table('view_data_angsuran')
            ->where('username_anggota', $username)
            ->orderBy('tanggal_pinjaman', 'asc')
            ->paginate($request->per_page ?? 10);

        $data->getCollection()->transform(function ($item) {

            $totalBunga = $item->bunga_angsuran * $item->lama_angsuran;
            $tagihan = $item->jumlah_pinjaman + $totalBunga + $item->biaya_admin;

            $totalBayar = DB::table('bayar_angsuran')
                ->where('id_pinjaman', $item->id_pinjaman)
                ->sum('angsuran_per_bulan');

            return [
                'id_pinjaman'     => $item->id_pinjaman,
                'kode_transaksi'  => $item->kode_transaksi,
                'tanggal'         => $item->tanggal_pinjaman,
                'tempo'           => $item->tanggal_jatuh_tempo,
                'lama_angsuran'   => $item->lama_angsuran,

                'jumlah_pinjaman' => $item->jumlah_pinjaman,
                'total_bunga'     => $totalBunga,
                'biaya_admin'     => $item->biaya_admin,

                'tagihan_total'   => $tagihan,
                'total_bayar'     => $totalBayar,
                'sisa_tagihan'    => $tagihan - $totalBayar,

                'status_lunas'    => $item->status_lunas,
            ];
        });

        return response()->json([
            'status' => 'success',
            'username_anggota' => $username,
            'data' => $data
        ], 200);
    }

}
