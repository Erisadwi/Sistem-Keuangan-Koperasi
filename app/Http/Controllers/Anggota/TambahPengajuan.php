<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\AjuanPinjaman;
use App\Models\LamaAngsuran;
use App\Models\sukuBunga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TambahPengajuanController extends Controller
{
    public function create()
    {
        $lamaAngsuran = LamaAngsuran::all();
        $biayaAdministrasi = sukuBunga::all();

        return view('anggota.tambah-data-pengajuan', [
            'ajuan_pinjaman' => null,
            'lamaAngsuran' => $lamaAngsuran,
            'biayaAdministrasi' => $biayaAdministrasi
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_update' => 'required|date',
            'jenis_ajuan' => 'required|in:PINJAMAN BIASA,PINJAMAN DARURAT,PINJAMAN BARANG',
            'jumlah_ajuan' => 'required|numeric|min:100000',
            'keterangan' => 'required|string',
            'status_ajuan' => 'required|in:MENUNGGU KONFIRMASI,DISETUJUI,DITOLAK',
            'id_lamaAngsuran' => 'required|exists:lama_angsuran,id_lamaAngsuran',
            'id_biayaAdministrasi' => 'required|exists:suku_bunga,id_biayaAdministrasi',
        ]);

        $anggota = Auth::user();

        $validated['id_ajuanPinjaman'] = AjuanPinjaman::generateId();
        $validated['id_anggota'] = $anggota->id_anggota;

        AjuanPinjaman::create($validated);

        return redirect()->route('ajuan-pinjaman.index')
            ->with('success', 'Data pengajuan berhasil disimpan!');
    }

    public function simulasi(Request $request)
    {
        $jumlah = $request->jumlah_ajuan;
        $idLama = $request->id_lamaAngsuran;
        $idBiaya = $request->id_biayaAdministrasi;

        if (!$jumlah || !$idLama || !$idBiaya) {
            return response()->json(['error' => 'Data tidak lengkap'], 400);
        }

        $lamaAngsuran = LamaAngsuran::find($idLama);
        $biaya = sukuBunga::find($idBiaya);

        $lamaBulan = $lamaAngsuran->lama_bulan;
        $bunga = $biaya->suku_bunga_pinjaman / 100;
        $biayaAdmin = $biaya->biaya_administrasi;

        $pokok = $jumlah;
        $angsuranPokok = $pokok / $lamaBulan;
        $angsuranBunga = $pokok * $bunga;
        $totalAngsuran = $angsuranPokok + $angsuranBunga + $biayaAdmin;

        $simulasi = [];
        $sisa = $pokok;

        for ($i = 1; $i <= $lamaBulan; $i++) {
            $sisa -= $angsuranPokok;
            $simulasi[] = [
                'bulan_ke' => $i,
                'angsuran_pokok' => number_format($angsuranPokok, 0, ',', '.'),
                'angsuran_bunga' => number_format($angsuranBunga, 0, ',', '.'),
                'biaya_admin' => number_format($biayaAdmin, 0, ',', '.'),
                'total_angsuran' => number_format($totalAngsuran, 0, ',', '.'),
                'sisa_pinjaman' => number_format(max($sisa, 0), 0, ',', '.'),
            ];
        }

        return response()->json($simulasi);
    }
}
