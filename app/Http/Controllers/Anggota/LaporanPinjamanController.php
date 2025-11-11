<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
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
            ->orderBy('tanggal_pinjaman', 'desc')
            ->paginate(10);

        $data->getCollection()->transform(function ($item) {
            $item->tanggal = $item->tanggal_pinjaman;
            $item->jumlah = $item->jumlah_pinjaman;
            $item->bunga = $item->bunga_angsuran;
            $item->administrasi = $item->biaya_admin;
            $item->tempo = $item->tanggal_jatuh_tempo;
            $item->lunas = $item->status_lunas; 
            $item->tagihan = $item->jumlah_pinjaman + $item->bunga_angsuran + $item->biaya_admin;
            $item->keterangan = null;
            return $item;
        });

        return view('anggota.laporan-pinjaman', compact('data'));
    }
}
