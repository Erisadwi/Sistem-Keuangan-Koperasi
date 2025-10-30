<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JenisAkunTransaksi;


class SaldoAwalKasController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('type_transaksi', 'SAK')
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        return view('admin.master_data.saldo-awal-kas', compact('transaksi'));
    }

    public function create()
    {
        $jenisAkun = JenisAkunTransaksi::all();
        return view('admin.master_data.tambah-data-saldo-awal-kas', compact('jenisAkun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenisAkunTransaksi_sumber' => 'required|integer',
            'ket_transaksi' => 'nullable|string|max:255',
            'jumlah_transaksi' => 'required|numeric|min:0',
        ]);

        Transaksi::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'type_transaksi' => 'SAK',
            'kode_transaksi' => 'SAK-' . time(),
            'ket_transaksi' => $request->ket_transaksi,
            'tanggal_transaksi' => now(),
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'id_user' => Auth::check() ? Auth::user()->id : null,
        ]);

        return redirect()->route('saldo-awal-kas.index')->with('success', 'Saldo awal kas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('saldo-awal-kas.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ket_transaksi' => 'nullable|string|max:255',
            'jumlah_transaksi' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        return redirect()->route('saldo-awal-kas.index')->with('success', 'Saldo awal kas berhasil diperbarui.');
    }
}
