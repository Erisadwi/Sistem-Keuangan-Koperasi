<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaldoAwalKasController extends Controller
{
    public function index()
    {
        $saldoAwalKas = Transaksi::with(['tujuan'])
            ->where('type_transaksi', 'SAK') 
            ->get();

        return view('admin.master_data.saldo-awal-kas', compact('saldoAwalKas'));
    }

    public function create()
    {
        return view('admin.master_data.tambah-data-saldo-awal-kas');
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
            'type_transaksi' => 'SAK',
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi
        ]);


        $transaksi->kode_transaksi = 'SAK' . str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT);
        $transaksi->save();

        return redirect()->route('saldo-awal-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $saldoAwalKas = Transaksi::findOrFail($id);
        return view('admin.master_data.edit-data-saldo-awal-kas', compact('saldoAwalKas'));
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

        return redirect()->route('saldo-awal-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('saldo-awal-kas.index')
            ->with('success', 'Data Saldo Awal Kas berhasil dihapus.');
    }
}
