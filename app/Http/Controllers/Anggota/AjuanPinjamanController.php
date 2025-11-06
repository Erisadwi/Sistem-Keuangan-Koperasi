<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\AjuanPinjaman;
use App\Models\LamaAngsuran;
use App\Models\sukuBunga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjuanPinjamanController extends Controller
{
public function index(Request $request)
{

    $anggota = Auth::user();

    $ajuanPinjaman = AjuanPinjaman::where('id_anggota', $anggota->id_anggota)
        ->with(['lama_angsuran', 'biaya_administrasi']) // relasi opsional jika sudah ada
        ->orderBy('tanggal_pengajuan', 'desc')
        ->get();
    
    $perPage = (int) $request->query('per_page', 10);
    $query = AjuanPinjaman::query();
    $ajuanPinjaman = $query->orderBy('id_ajuanPinjaman', 'asc')->paginate($perPage);

    return view('anggota.data-pengajuan', [
        'ajuanPinjaman' => $ajuanPinjaman
    ]);
}

    public function create()
    {
        $lamaAngsuran = LamaAngsuran::all();
        $biayaAdministrasi = sukuBunga::first();

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
            'keterangan' => 'nullable|string',
            'status_ajuan' => 'required|in:MENUNGGU KONFIRMASI,DISETUJUI,DITOLAK',
            'id_lamaAngsuran' => 'required|exists:lama_angsuran,id_lamaAngsuran',
            'id_biayaAdministrasi' => 'required|exists:biaya_administrasi,id_biayaAdministrasi',
        ]);


        
        $anggota = Auth::user();

        $validated['id_ajuanPinjaman'] = AjuanPinjaman::generateId();
        $validated['id_anggota'] = $anggota->id_anggota;
        $validated['jumlah_ajuan'] = str_replace('.', '', $validated['jumlah_ajuan']);

        AjuanPinjaman::create($validated);

        return redirect()->route('anggota.pengajuan.index')
            ->with('success', 'Data pengajuan berhasil disimpan!');
    }

public function simulasi(Request $request)
{
    $jumlah = str_replace('.', '', $request->jumlah_ajuan);
    $lamaAngsuran = LamaAngsuran::find($request->id_lamaAngsuran);
    $biaya = sukuBunga::find($request->id_biayaAdministrasi);

    if (!$jumlah || !$lamaAngsuran || !$biaya) {
        return response()->json(['error' => 'Data tidak lengkap'], 422);
    }

    $lamaBulan = $lamaAngsuran->lama_angsuran;
    $bungaPersen = $biaya->suku_bunga_pinjaman / 100;
    $biayaAdmin = (float) $biaya->biaya_administrasi;

    $angsuranPokok = $jumlah / $lamaBulan;


    $totalBunga = $jumlah * $bungaPersen;
    $angsuranBungaPerBulan = $totalBunga / $lamaBulan;

    $tanggalPengajuan = now();
    $simulasi = [];
    $sisa = $jumlah;

    for ($i = 1; $i <= $lamaBulan; $i++) {
        $totalAngsuran = $angsuranPokok + $angsuranBungaPerBulan + $biayaAdmin;
        $sisa -= $angsuranPokok;

        $jatuhTempo = $tanggalPengajuan->copy()->addMonth($i)->day(30)->toDateString();
        $simulasi[] = [
            'bulan_ke' => $i,
            'jatuh_tempo' => $jatuhTempo,
            'angsuran_pokok' => number_format($angsuranPokok, 0, ',', '.'),
            'angsuran_bunga' => number_format($angsuranBungaPerBulan, 0, ',', '.'),
            'biaya_admin' => number_format($biayaAdmin, 0, ',', '.'),
            'total_angsuran' => number_format($totalAngsuran, 0, ',', '.'),
            'sisa_pinjaman' => number_format(max($sisa, 0), 0, ',', '.'),
        ];
    }

    return response()->json($simulasi);
}


}
