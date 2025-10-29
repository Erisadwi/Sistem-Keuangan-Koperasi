<?php

namespace App\Http\Controllers\Admin\TransaksiKas;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class TransaksiPemasukanController extends Controller
{
    public function index()
    {
        $TransaksiPemasukan = Transaksi::with(['sumber', 'tujuan', 'data_user'])
        ->where('type_transaksi', 'TKD')
        ->get();
        return view('admin.transaksi_kas.pemasukan', compact('TransaksiPemasukan'));
    }

    public function create()
    {
        return view('admin.transaksi_kas.tambah-pemasukan');
    }

    public function store(Request $request)
    {

        $request->validate([
            'id_jenisAkunTransaksi_sumber' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiPemasukan = Transaksi::create([
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_user' => Auth::user()->id_user,
            'type_transaksi' => 'TKD',
            'kode_transaksi' => '',
            'ket_transaksi' => $request->ket_transaksi,
            'jumlah_transaksi' => $request->jumlah_transaksi,
        ]);

        $TransaksiPemasukan->kode_transaksi = 'TKD' . $TransaksiPemasukan->id_transaksi;
        $TransaksiPemasukan->save();

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $TransaksiPemasukan = Transaksi::findOrFail($id);
        return view('admin.transaksi_kas.edit-pemasukan', compact('TransaksiPemasukan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_transaksi' => 'required|numeric|min:0',
            'ket_transaksi' => 'nullable|string|max:255',
        ]);

        $TransaksiPemasukan = Transaksi::findOrFail($id);
        $TransaksiPemasukan->update([
            'jumlah_transaksi' => $request->jumlah_transaksi,
            'ket_transaksi' => $request->ket_transaksi,
        ]);

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Data Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $TransaksiPemasukan = Transaksi::findOrFail($id);
        $TransaksiPemasukan->delete();

        return redirect()->route('transaksi-pemasukan.index')->with('success', 'Data Transaksi berhasil dihapus');
    }
}
