<?php

namespace App\Http\Controllers\Admin\MasterData;
use App\Http\Controllers\Controller;
use App\Models\SaldoAwalNonKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SaldoAwalNonKasController extends Controller
{
    public function index()
    {
        $saldoAwal = SaldoAwalNonKas::all();
        return view('admin.master_data.tambah-data-saldo-awal-non-kas', compact('saldoAwalNonKas'));
    }

    public function create()
    {
        return view('admin.master_data.tambah-data-saldo-awal-non-kas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenisAkunTransaksi_sumber' => 'required|integer',
            'id_jenisAkunTransaksi_tujuan' => 'required|integer',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $saldoAwalNonKas = SaldoAwalNonKas::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_user' => auth()->user()->id ?? null,
            'type_transaksi' => 'SANK',
            'kode_transaksi' => 'SANK-' . uniqid(),
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        $saldoAwalNonKas->update([
            'kode_transaksi' => 'SANK-' . $saldoAwalNonKas->id_transaksi,
        ]);

        return redirect()->route('saldo-awal-non-kas.index')->with('success', 'Saldo awal non kas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $saldoAwalNonKas = SaldoAwalNonKas::findOrFail($id);
         return view('admin.master_data.tambah-data-saldo-awal-non-kas', compact('saldoAwalNonKas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $saldoAwalNonKas = saldoAwalNonKas::findOrFail($id);
        $saldoAwalNonKas->update([
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        return redirect()->route('saldo-awal-non-kas.index')->with('success', 'Saldo awal non kas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $saldoAwalNonKas = saldoAwalNonKas::findOrFail($id);
        $saldoAwalNonKas->delete();

        return redirect()->route('saldo-awal-non-kas.index')->with('success', 'Saldo awal non kas berhasil dihapus');
    }
}
