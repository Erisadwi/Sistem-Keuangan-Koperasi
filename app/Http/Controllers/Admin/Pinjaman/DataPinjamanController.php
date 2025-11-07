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
use Barryvdh\DomPDF\Facade\Pdf;
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

    // Ambil data suku bunga & admin dari tabel
    $biayaAdmin   = SukuBunga::firstOrFail();
    $ratePinjaman = (float) $biayaAdmin->suku_bunga_pinjaman; 
    $rateAdmin    = (float) $biayaAdmin->biaya_administrasi;  

    // Ambil lama angsuran dari tabel LamaAngsuran
    $lamaAngsuran = LamaAngsuran::findOrFail($request->id_lamaAngsuran);
    $lama = (int) $lamaAngsuran->lama_angsuran;

    // === PERHITUNGAN BARU ===
    // Bunga dibagi dengan lama angsuran
    $bunga_pinjaman = $lama > 0 
        ? round((($ratePinjaman / 100) * $jumlah) / $lama, 2)
        : 0;

    $biaya_admin = round(($rateAdmin / 100) * $jumlah, 2);

    // Total tagihan = jumlah pokok + total bunga (bunga per bulan × lama angsuran)
    $totalTagihan = $jumlah + ($bunga_pinjaman * $lama);

    // Generate ID pinjaman otomatis
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
        $pinjaman = Pinjaman::with(['ajuanPinjaman', 'user', 'anggota', 'lamaAngsuran', 'tujuan', 'sumber'])
            ->findOrFail($id);
        return view('admin.pinjaman.detail-peminjaman', compact('pinjaman'));
    }

    public function edit($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $ajuanPinjaman = AjuanPinjaman::all();
        $users = User::all();
        $anggota = Anggota::all();
        $lamaAngsuran = LamaAngsuran::all();
        $akunTransaksi = JenisAkunTransaksi::all();

        return view('admin.pinjaman.edit-data-pinjaman', compact(
            'pinjaman', 'ajuanPinjaman', 'users', 'anggota', 'lamaAngsuran', 'akunTransaksi'
        ));
    }

    public function destroy($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil dihapus!');
    }

    public function cetakNota($id)
{
    $pinjaman = Pinjaman::with(['anggota', 'lamaAngsuran'])->findOrFail($id);

    // Perhitungan sesuai format nota
    $pokok_pinjaman = $pinjaman->jumlah_pinjaman;
    $lama = $pinjaman->lamaAngsuran->lama_angsuran ?? 0;
    $angsuran_pokok = $lama > 0 ? $pokok_pinjaman / $lama : 0;
    $angsuran_bunga = $pinjaman->bunga_pinjaman ?? 0;
    $jumlah_angsuran = $angsuran_pokok + $angsuran_bunga;

    return view('admin.pinjaman.cetak-nota-dataPinjaman', compact(
        'pinjaman',
        'pokok_pinjaman',
        'angsuran_pokok',
        'angsuran_bunga',
        'jumlah_angsuran'
    ));
}

}
