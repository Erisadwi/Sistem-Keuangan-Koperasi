<?php

namespace App\Http\Controllers\Admin\Pinjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AjuanPinjaman;
use App\Models\Pinjaman;
use App\Models\sukuBunga;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanPinjamanController extends Controller
{

     public function index(Request $request)
{
    $perPage = (int) $request->query('per_page', 10);
    
    $query = AjuanPinjaman::with(['anggota', 'lama_angsuran'])
        ->where('status_ajuan', '!=', 'Ditolak');

    if ($request->filled('startDate') && $request->filled('endDate')) {
        $query->whereBetween('tanggal_pengajuan', [
            $request->startDate,
            $request->endDate
        ]);
    }

    if ($request->filled('jenis')) {
        $query->where('jenis_ajuan', $request->jenis);
    }

    if ($request->filled('status')) {
        $query->where('status_ajuan', $request->status);
    }

    $ajuanPinjaman = $query
        ->orderByRaw("CASE 
            WHEN status_ajuan = 'Menunggu Konfirmasi' THEN 1 
            ELSE 2 
        END")
        ->orderBy('id_ajuanPinjaman', 'asc')
        ->paginate($perPage)
        ->appends($request->except('page'));

    $filters = [
        'startDate' => $request->startDate,
        'endDate'   => $request->endDate,
        'jenis'     => $request->jenis,
        'status'    => $request->status,
    ];

    return view('admin.pinjaman.ajuan-pinjaman.data-pengajuan', compact('ajuanPinjaman', 'filters'));
}


   public function disetujui($id)
{   
    $ajuanPinjaman = AjuanPinjaman::with('anggota', 'lama_angsuran')->findOrFail($id);
    $ajuanPinjaman->status_ajuan = 'DISETUJUI';
    $ajuanPinjaman->save();

    $biayaAdmin   = SukuBunga::firstOrFail();
    $ratePinjaman = (float) $biayaAdmin->suku_bunga_pinjaman; 
    $rateAdmin    = (float) $biayaAdmin->biaya_administrasi;  
    $jumlah       = (float) $ajuanPinjaman->jumlah_ajuan;
    $lama         = $ajuanPinjaman->lama_angsuran->lama_angsuran;

    $bungaDasar  = $ratePinjaman / 100;
    $bungaPersen = $bungaDasar * ($lama / 12);

    $angsuranPokok = $jumlah / $lama;

    $bunga = round(($angsuranPokok * $bungaPersen) / 100) * 100;

    $biaya_admin = $rateAdmin;

    Pinjaman::create([
        'id_pinjaman' => Pinjaman::generateId(),
        'id_ajuanPinjaman' => $ajuanPinjaman->id_ajuanPinjaman,
        'id_user' => Auth::user()->id_user ?? null,
        'id_anggota' => $ajuanPinjaman->id_anggota,
        'id_lamaAngsuran' => $ajuanPinjaman->id_lamaAngsuran,
        'tanggal_pinjaman' => now(),

        'bunga_pinjaman' => $bunga,
        'biaya_admin' => $biaya_admin,

        'jumlah_pinjaman' => $jumlah,
        'total_tagihan' => $jumlah + ($bunga * $lama) + $biaya_admin,

        'keterangan' => $ajuanPinjaman->keterangan ?? '-',
        'status_lunas' => 'BELUM LUNAS',
        'id_jenisAkunTransaksi_tujuan' => $ajuanPinjaman->id_jenisAkunTransaksi_tujuan,
        'id_jenisAkunTransaksi_sumber' => $ajuanPinjaman->id_jenisAkunTransaksi_sumber
    ]);

    return redirect()->route('pengajuan-pinjaman.index')
        ->with('success', 'Pengajuan pinjaman disetujui.');
}

    public function tolak($id)
    {
        $ajuanPinjamanPinjaman = AjuanPinjaman::findOrFail($id);
        $ajuanPinjamanPinjaman->status_ajuan = 'Ditolak';
        $ajuanPinjamanPinjaman->save();

        return redirect()->route('pengajuan-pinjaman.index')->with('success', 'Pengajuan pinjaman ditolak.');
    }



public function exportPdf(Request $request)
{

    $query = AjuanPinjaman::with(['anggota','lama_angsuran']);

    // === Periode (sama dengan transaksi)
    if ($request->filled('start_date') && $request->filled('end_date')) {

        $periodStart = $request->start_date . ' 00:00:00';
        $periodEnd   = $request->end_date   . ' 23:59:59';
        $query->whereBetween('tanggal_pengajuan', [$periodStart, $periodEnd]);

    } else {
        $tahun = date('Y');
        $periodStart = "$tahun-01-01 00:00:00";
        $periodEnd   = "$tahun-12-31 23:59:59";
        $query->whereBetween('tanggal_pengajuan', [$periodStart, $periodEnd]);
    }

    // === Search
    if ($request->filled('search')) {
        $query->where('jenis_ajuan', 'LIKE', "%{$request->search}%")
              ->orWhere('status_ajuan', 'LIKE', "%{$request->search}%")
              ->orWhereHas('anggota', function($q) use ($request){
                    $q->where('nama_anggota', 'LIKE', "%{$request->search}%");
              });
    }

    $data = $query->orderBy('id_ajuanPinjaman', 'desc')->get();

try {
    $pdf = Pdf::loadView('admin.pinjaman.ajuan-pinjaman.pengajuan-export-pdf', [
        'data'        => $data,
        'periodStart' => $periodStart,
        'periodEnd'   => $periodEnd,
    ])->setPaper('A4', 'landscape');

    return $pdf->download('laporan-ajuan-pinjaman.pdf');

} catch (\Exception $e) {
    return $e->getMessage();  // tampilkan error asli
}
}



}
