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

    return view('admin.pinjaman.data-pengajuan', compact('ajuanPinjaman', 'filters'));
}


    public function disetujui($id)
    {   
        $ajuanPinjaman = AjuanPinjaman::with('anggota', 'lama_angsuran')->findOrFail($id);
        $ajuanPinjaman->status_ajuan = 'Disetujui';
        $ajuanPinjaman->save();

        $biayaAdmin   = SukuBunga::firstOrFail();
        $ratePinjaman = (float) $biayaAdmin->suku_bunga_pinjaman; 
        $rateAdmin    = (float) $biayaAdmin->biaya_administrasi;  
        $jumlah       = (float) $ajuanPinjaman->jumlah_ajuan;

        // rate disimpan sebagai 10.00 = 10%
        $bunga       = round(($ratePinjaman / 100) * $jumlah, 2);
        $biaya_admin = round(($rateAdmin    / 100) * $jumlah, 2);

        Pinjaman::create([
        'id_pinjaman' => Pinjaman::generateId(),
        'id_ajuanPinjaman' => $ajuanPinjaman->id_ajuanPinjaman,
        'id_user' => Auth::user()->id_user ?? null, 
        'id_anggota' => $ajuanPinjaman->id_anggota,
        'id_lamaAngsuran' => $ajuanPinjaman->id_lamaAngsuran ?? null,
        'tanggal_pinjaman' => now(),
        'bunga_pinjaman' => $bunga,
        'jumlah_pinjaman' => $ajuanPinjaman->jumlah_ajuan,
        'total_tagihan' => $ajuanPinjaman->jumlah_ajuan + $bunga + $biaya_admin, 
        'keterangan' => $ajuanPinjaman->keterangan ?? '-',
        'status_lunas' => 'BELUM LUNAS', 
        'biaya_admin' => $biaya_admin,
        'id_jenisAkunTransaksi_tujuan' => $ajuanPinjaman->id_jenisAkunTransaksi_tujuan ?? null,
        'id_jenisAkunTransaksi_sumber' => $ajuanPinjaman->id_jenisAkunTransaksi_sumber ?? null
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

    public function download()
{
    $data = AjuanPinjaman::with(['anggota','lama_angsuran'])->get();
$html = '
    <html>
    <head>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #999; padding: 6px; text-align: left; }
            th { background-color: #f3f4f6; }
            h2 { text-align: center; margin-bottom: 10px; }
        </style>
    </head>
    <body>
        <h2>Laporan Pengajuan Pinjaman</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Jenis Ajuan</th>
                    <th>Jumlah Ajuan</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($data as $i => $row) {
        $html .= '
            <tr>
                <td>' . ($i + 1) . '</td>
                <td>' . ($row->anggota->nama_anggota ?? '-') . '</td>
                <td>' . $row->jenis_ajuan . '</td>
                <td>Rp' . number_format($row->jumlah_ajuan, 0, ',', '.') . '</td>
                <td>' . $row->tanggal_pengajuan . '</td>
                <td>' . $row->status_ajuan . '</td>
            </tr>';
    }

    $html .= '
            </tbody>
        </table>
    </body>
    </html>';

    $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');

    return $pdf->download('laporan-pengajuan-pinjaman.pdf');
}

}
