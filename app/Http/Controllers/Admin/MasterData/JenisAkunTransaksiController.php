<?php

namespace App\Http\Controllers\Admin\MasterData;
use App\Http\Controllers\Controller;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;

class JenisAkunTransaksiController extends Controller
{

        public function index()
    {
         $jenis_akun_transaksi = \App\Models\JenisAkunTransaksi::all();
         return view('admin.master_data.jenis-akun-transaksi', compact('jenis_akun_transaksi'));
    }
    public function create()
    {
        return view('admin.master_data.tambah-data-jenis-akun-transaksi', [
            'jenis_akun_transaksi' => null
        ]);
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aktiva'          => 'required|string|max:20',
            'nama_AkunTransaksi'   => 'required|string|max:100',
            'type_akun'            => 'required|in:ACTIVA,PASIVA',
            'pemasukan'            => 'required|in:Y,N',
            'pengeluaran'          => 'required|in:Y,N',
            'penarikan'            => 'required|in:Y,N',
            'transfer'             => 'required|in:Y,N',
            'status_akun'          => 'required|in:Y,N',
            'nonkas'               => 'required|in:Y,N',
            'simpanan'             => 'required|in:Y,N',
            'pinjaman'             => 'required|in:Y,N',
            'angsuran'             => 'required|in:Y,N',
            'labarugi'             => 'required|in:PENDAPATAN,BIAYA',
            ]);

        JenisAkunTransaksi::create($validated);

        return redirect()->route('jenis-akun-transaksi.index')
                         ->with('success', 'Jenis akun transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenis_akun_transaksi = JenisAkunTransaksi::findOrFail($id);
        return view('admin.master_data.edit-data-jenis-akun-transaksi', compact('jenis_akun_transaksi'));
    }

    public function update(Request $request, $id)
    {
        $jenis_akun_transaksi = JenisAkunTransaksi::findOrFail($id);
        $jenis_akun_transaksi->update($request->only(['kode_aktiva','nama_AkunTransaksi','type_akun','pemasukan','pengeluaran','penarikan','transfer','status_akun','nonkas','simpanan','pinjaman','angsuran','labarugi',]));
        return redirect()->route('jenis-akun-transaksi.index')->with('success', 'Data berhasil diperbarui');
    }
}
