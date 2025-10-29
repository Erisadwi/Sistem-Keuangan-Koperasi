<?php

namespace App\Http\Controllers\Admin\MasterData;
use App\Http\Controllers\Controller;
use App\Models\SaldoAwalKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SaldoAwalKasController extends Controller
{
    public function index()
    {
        // Menampilkan semua data saldo awal kas
        $saldoAwal = SaldoAwalKas::all();
        return view('admin.transaksi.saldo-awal.index', compact('saldoAwal'));
    }

    public function create()
    {
        return view('admin.transaksi.saldo-awal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenisAkunTransaksi_sumber' => 'required|integer',
            'id_jenisAkunTransaksi_tujuan' => 'required|integer',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        // generate kode_transaksi otomatis (gabung type + id sementara)
        $saldoAwal = SaldoAwalKas::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_user' => Auth::user()?->id,
            'type_transaksi' => 'SAK',
            'kode_transaksi' => 'SAK-' . uniqid(),
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        // update kode_transaksi agar mengandung id transaksi
        $saldoAwal->update([
            'kode_transaksi' => 'SAK-' . $saldoAwal->id_transaksi,
        ]);

        return redirect()->route('saldo-awal.index')->with('success', 'Saldo awal kas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $saldoAwal = SaldoAwalKas::findOrFail($id);
        return view('admin.transaksi.saldo-awal.edit', compact('saldoAwal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $saldoAwal = SaldoAwalKas::findOrFail($id);
        $saldoAwal->update([
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        return redirect()->route('saldo-awal.index')->with('success', 'Saldo awal kas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $saldoAwal = SaldoAwalKas::findOrFail($id);
        $saldoAwal->delete();

        return redirect()->route('saldo-awal.index')->with('success', 'Saldo awal kas berhasil dihapus');
    }
}
