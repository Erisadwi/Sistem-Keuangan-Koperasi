<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewDataAngsuran;
use Illuminate\Support\Facades\DB;

class PinjamanLunasController extends Controller
{
    public function index(Request $request)
    {
        $query = ViewDataAngsuran::where('status_lunas', 'LUNAS');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjaman', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('nama_anggota')) {
            $query->where('nama_anggota', 'like', '%' . $request->nama_anggota . '%');
        }

        if ($request->filled('kode_transaksi')) {
            $query->where('kode_transaksi', 'like', '%' . $request->kode_transaksi . '%');
        }

        $dataPinjamanLunas = $query->orderBy('tanggal_pinjaman', 'desc')->paginate(10);

        return view('admin.pinjaman.pinjaman-lunas', compact('dataPinjamanLunas'));
    }
    public function detail($id_pinjaman)
    {
        $data = ViewDataAngsuran::where('id_pinjaman', $id_pinjaman)->first();

        if (!$data) {
            return redirect()->route('pinjaman.lunas')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.pinjaman.detail-pelunasan', compact('data'));
    }
}
