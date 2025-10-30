<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaldoAwalNonKasController extends Controller
{
    public function index()
    {
        $saldoAwalNonKas = Transaksi::with(['tujuan'])
            ->where('type_transaksi', 'SANK') 
            ->get();

        return view('admin.master_data.tambah-saldo-awal-non-kas', compact('saldoAwalNonKas'));
    }

    public function create()
    {
        return view('admin.master_data.tambah-data-saldo-awal-non-kas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',
        ]);

        $transaksi = Transaksi::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            // 'id_user' => Auth::user()->id_user, // sementara dimatikan
            'type_transaksi' => 'SANK',
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi
        ]);


        $transaksi->kode_transaksi = 'SANK' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
        $transaksi->save();

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Non Kas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $saldoAwalNonKas = Transaksi::findOrFail($id);
        return view('admin.master_data.tambah-data-saldo-awal-non-kas', compact('saldoAwalNonKas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
        ]);

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Non Kas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('saldo-awal-non-kas.index')
            ->with('success', 'Data Saldo Awal Non Kas berhasil dihapus.');
    }
}
