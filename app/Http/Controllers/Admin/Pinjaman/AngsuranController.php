<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewAngsuran;

class AngsuranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index(Request $request)
    {
        $query = ViewAngsuran::query();

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjaman', [$request->start_date, $request->end_date]);
        }

        if ($request->kode_transaksi) {
            $query->where('kode_transaksi', 'like', '%'.$request->kode_transaksi.'%');
        }

        if ($request->nama_anggota) {
            $query->where('nama_anggota', 'like', '%'.$request->nama_anggota.'%');
        }

        $dataAngsuran = $query->paginate(10);

        return view('admin.angsuran.index', compact('dataAngsuran'));
    }

    public function bayar($id)
    {
        $angsuran = ViewAngsuran::where('id_pinjaman', $id)->firstOrFail();

        return view('admin.angsuran.bayar', compact('angsuran'));
    }
}
