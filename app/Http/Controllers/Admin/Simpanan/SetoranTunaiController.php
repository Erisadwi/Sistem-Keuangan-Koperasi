<?php

namespace App\Http\Controllers\Admin\Simpanan;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use App\Models\Anggota;
use App\Models\JenisAkunTransaksi;
use App\Models\JenisSimpanan;
use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\SetoranTunaiExport;
use Maatwebsite\Excel\Facades\Excel;

class SetoranTunaiController extends Controller
{
    public function index()
    {
        $setoranTunai = Simpanan::with(['anggota', 'jenisSimpanan', 'sumber', 'tujuan'])
            ->where('type_simpanan', 'TRD')
            ->get();

        return view('admin.simpanan.setoran-tunai', compact('setoranTunai'));
    }

    public function create()
    {
    $anggota = Anggota::all();
    $jenisSimpanan = JenisSimpanan::all(['id_jenis_simpanan', 'jenis_simpanan', 'jumlah_simpanan']);
    $akunTransaksi = JenisAkunTransaksi::whereIn('nama_AkunTransaksi', [
        'Kas Besar',
        'Bank BNI',
        'Bank Mandiri',
        'Kas Niaga',
        'Kas Kecil'
    ])->get();

    return view('admin.simpanan.tambah-setoran-tunai', compact('anggota', 'jenisSimpanan', 'akunTransaksi'));
    }

   public function store(Request $request)
    {
    $request->validate([
        'id_anggota' => 'required|exists:anggota,id_anggota',
        'id_jenis_simpanan' => 'required|exists:jenis_simpanan,id_jenis_simpanan',
        'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
        'jumlah_simpanan' => 'required|numeric|min:0',
        'tanggal_transaksi' => 'required|date',
        'keterangan' => 'nullable|string|max:255',
        'bukti_setoran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $data = $request->only([
        'id_anggota',
        'id_jenis_simpanan',
        'id_jenisAkunTransaksi_tujuan',
        'jumlah_simpanan',
        'tanggal_transaksi',
        'keterangan'
    ]);

    $anggota = Anggota::find($request->id_anggota);
    if ($anggota && $anggota->id_user) {
        $data['id_user'] = $anggota->id_user;
    }

    $lastSimpanan = Simpanan::where('type_simpanan', 'TRD')
        ->orderBy('id_simpanan', 'desc')
        ->first();

    $nextNumber = $lastSimpanan ? ((int) substr($lastSimpanan->kode_simpanan, 3)) + 1 : 1;
    $data['kode_simpanan'] = 'TRD' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

    $akunPiutang = JenisAkunTransaksi::where('nama_AkunTransaksi', 'like', '%Piutang Anggota%')->first();
    $data['id_jenisAkunTransaksi_sumber'] = $akunPiutang ? $akunPiutang->id_jenisAkunTransaksi : null;

    if ($request->hasFile('bukti_setoran')) {
        $file = $request->file('bukti_setoran');
        $filename = time() . '_' . $file->getClientOriginalName();
        $data['bukti_setoran'] = $file->storeAs('bukti_setoran', $filename, 'public');
    }

    $data['type_simpanan'] = 'TRD';

    Simpanan::create($data);

    return redirect()->route('setoran-tunai.index')->with('success', '✅ Data setoran tunai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $setoranTunai = Simpanan::findOrFail($id);
        $anggota = Anggota::all();
        $jenisSimpanan = JenisSimpanan::all();

        $akunTransaksi = JenisAkunTransaksi::where('simpanan', 'Y')
            ->where('pemasukan', 'Y')
            ->where('status_akun', 'Y')
            ->orderBy('nama_akunTransaksi', 'asc')
            ->get();

        return view('admin.simpanan.edit-setoran-tunai', compact('setoranTunai', 'anggota', 'jenisSimpanan', 'akunTransaksi'));
    }

    public function update(Request $request, $id)
    {
        $setoranTunai = Simpanan::findOrFail($id);

        $request->validate([
            'jumlah_simpanan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
            'bukti_setoran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->only(['jumlah_simpanan', 'keterangan']);

        if ($request->hasFile('bukti_setoran')) {
            $file = $request->file('bukti_setoran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['bukti_setoran'] = $file->storeAs('bukti_setoran', $filename, 'public');
        }

        $setoranTunai->update($data);

        return redirect()->route('setoran-tunai.index')->with('success', '✅ Data setoran tunai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $setoranTunai = Simpanan::findOrFail($id);
        $setoranTunai->delete();

        return redirect()->route('setoran-tunai.index')->with('success', '🗑️ Data setoran tunai berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new SetoranTunaiExport, 'Data_Setoran_Tunai.xlsx');
    }

    public function cetak($id)
    {
    $setoran = Simpanan::with(['anggota', 'jenisSimpanan', 'tujuan', 'user'])
        ->findOrFail($id);

    return view('admin.simpanan.cetak-nota-setoran-tunai', compact('setoran'));
    }

}
