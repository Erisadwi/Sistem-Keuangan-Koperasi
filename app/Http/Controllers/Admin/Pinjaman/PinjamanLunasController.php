<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewDataAngsuran;

class PinjamanLunasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index(Request $request)
    {
        $query = ViewDataAngsuran::query()
            ->where('status_lunas', 'LUNAS'); // hanya data lunas

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjaman', [$request->start_date, $request->end_date]);
        }

        if ($request->nama_anggota) {
            $query->where('nama_anggota', 'like', '%' . $request->nama_anggota . '%');
        }

        $dataLunas = $query->paginate(10);

        return view('admin.pinjaman.lunas.index', compact('dataLunas'));
    }
}
