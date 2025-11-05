<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use App\Models\AjuanPinjaman;
use App\Models\User;
use App\Models\sukuBunga;
use App\Models\Anggota;
use App\Models\LamaAngsuran;
use App\Models\JenisAkunTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataPinjamanController extends Controller
{
public function index()
{
    $pinjaman = Pinjaman::with(['ajuanPinjaman', 'user', 'anggota', 'lamaAngsuran', 'tujuan', 'sumber'])->get();

    // === Perhitungan otomatis ===
    foreach ($pinjaman as $item) {
        $jumlah = $item->jumlah_pinjaman ?? 0;
        $lama   = $item->lamaAngsuran->lama_angsuran ?? 0;

        // Hitung pokok angsuran
        $item->pokok_angsuran = $lama > 0 ? round($jumlah / $lama, 2) : 0;
        $item->lama_angsuran_text = $lama > 0 ? $lama . ' Bulan' : '-';

        $bunga = $item->bunga_pinjaman ?? 0;
        $item->jumlah_angsuran_otomatis = $item->pokok_angsuran + $bunga;

        // ===== Tambahan baru: hitung sisa angsuran & sisa tagihan =====
        $sudahDibayar = $item->sudah_dibayar ?? 0;
        $totalTagihan = $item->total_tagihan ?? 0;
        $jumlahAngsuran = $item->jumlah_angsuran_otomatis ?? 0;

        // Jika sudah dibayar 0, maka seluruhnya masih tersisa
        $item->sisa_tagihan = max($totalTagihan - $sudahDibayar, 0);

        // Estimasi berapa kali angsuran tersisa (dibulatkan ke atas)
        $item->sisa_angsuran = $jumlahAngsuran > 0
            ? ceil($item->sisa_tagihan / $jumlahAngsuran)
            : '-';
    }

    return view('admin.pinjaman.data-pinjaman', compact('pinjaman'));
}

    public function create()
    {
        $ajuanPinjaman = AjuanPinjaman::all();
        $users = User::all();
        $anggota = Anggota::all();
        $lamaAngsuran = LamaAngsuran::all();
        $akunTransaksi = JenisAkunTransaksi::all();

        return view('admin.pinjaman.tambah-data-pinjaman', compact(
            'ajuanPinjaman', 'users', 'anggota', 'lamaAngsuran', 'akunTransaksi'
        ));
    }


    public function store(Request $request)
    {


        
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_jenisAkunTransaksi_tujuan' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'id_jenisAkunTransaksi_sumber' => 'required|exists:jenis_akun_transaksi,id_jenisAkunTransaksi',
            'id_lamaAngsuran' => 'required|exists:lama_angsuran,id_lamaAngsuran',
            'tanggal_pinjaman' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jumlah = $request->jumlah_pinjaman;

        $biayaAdmin   = SukuBunga::firstOrFail();
        $ratePinjaman = (float) $biayaAdmin->suku_bunga_pinjaman; 
        $rateAdmin    = (float) $biayaAdmin->biaya_administrasi;  

        // rate disimpan sebagai 10.00 = 10%
        $bunga_pinjaman    = round(($ratePinjaman / 100) * $jumlah, 2);
        $biaya_admin = round(($rateAdmin    / 100) * $jumlah, 2);

        $totalTagihan   = $jumlah + $bunga_pinjaman;

        $idPinjaman = Pinjaman::generateId();


        Pinjaman::create([
            'id_pinjaman' => $idPinjaman,
            'id_user' => Auth::user()->id_user,
            'id_anggota' => $request->id_anggota,
            'id_jenisAkunTransaksi_tujuan' => $request->id_jenisAkunTransaksi_tujuan,
            'id_jenisAkunTransaksi_sumber' => $request->id_jenisAkunTransaksi_sumber,
            'id_lamaAngsuran' => $request->id_lamaAngsuran,
            'tanggal_pinjaman' => $request->tanggal_pinjaman,
            'bunga_pinjaman' => $bunga_pinjaman,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'total_tagihan' => $totalTagihan,
            'keterangan' => $request->keterangan,
            'status_lunas' => 'BELUM LUNAS',
            'biaya_admin' => $biaya_admin,
        ]);

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil disimpan!');
    }

    public function show($id)
    {
        $pinjaman = Pinjaman::with(['ajuan_pinjaman', 'user', 'anggota', 'lamaAngsuran', 'tujuan', 'sumber'])
            ->findOrFail($id);
        return view('admin.transaksi.pinjaman.show', compact('pinjaman'));
    }

    public function edit($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $ajuanPinjaman = AjuanPinjaman::all();
        $users = User::all();
        $anggota = Anggota::all();
        $lamaAngsuran = LamaAngsuran::all();
        $akunTransaksi = JenisAkunTransaksi::all();

        return view('admin.transaksi.pinjaman.edit', compact(
            'pinjaman', 'ajuanPinjaman', 'users', 'anggota', 'lamaAngsuran', 'akunTransaksi'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pinjaman' => 'required|date',
            'bunga_pinjaman' => 'required|numeric|min:0',
            'jumlah_pinjaman' => 'required|numeric|min:0',
            'biaya_admin' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
            'status_lunas' => 'required|boolean',
        ]);

        $pinjaman = Pinjaman::findOrFail($id);

        $totalTagihan = $request->jumlah_pinjaman + ($request->jumlah_pinjaman * $request->bunga_pinjaman / 100);

        $pinjaman->update([
            'tanggal_pinjaman' => $request->tanggal_pinjaman,
            'bunga_pinjaman' => $request->bunga_pinjaman,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'total_tagihan' => $totalTagihan,
            'biaya_admin' => $request->biaya_admin ?? 0,
            'keterangan' => $request->keterangan,
            'status_lunas' => $request->status_lunas,
        ]);

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil dihapus!');
    }
}
