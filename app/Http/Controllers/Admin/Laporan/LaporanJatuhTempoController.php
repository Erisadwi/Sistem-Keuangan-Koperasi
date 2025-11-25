<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanJatuhTempoController extends Controller
{
   public function index(Request $request)
    {
    $bulan = $request->get('bulan', date('m'));
    $tahun = $request->get('tahun', date('Y'));

    // Data paginated untuk tabel
    $dataPinjaman = DB::table('view_data_angsuran as v')
        ->leftJoin('bayar_angsuran as b', 'v.id_pinjaman', '=', 'b.id_pinjaman')
        ->select(
            'v.id_pinjaman',
            'v.kode_transaksi as kode_pinjam',
            DB::raw("CONCAT(v.username_anggota, ' - ', v.nama_anggota) as nama_anggota"),
            'v.tanggal_pinjaman as tanggal_pinjam',
            'v.tanggal_jatuh_tempo as tanggal_tempo',
            'v.lama_angsuran as lama_pinjam',
            DB::raw('COALESCE(v.total_tagihan, 0) as jumlah_tagihan'),
            DB::raw('COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0) as dibayar'),
            DB::raw('(COALESCE(v.total_tagihan, 0) - COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0)) as sisa_tagihan')
        )
        ->whereMonth('v.tanggal_jatuh_tempo', $bulan)
        ->whereYear('v.tanggal_jatuh_tempo', $tahun)
        ->where(function ($query) {
            $query->where('v.status_lunas', '=', 'BELUM LUNAS')
                  ->orWhereNull('v.status_lunas');
        })
        ->groupBy(
            'v.id_pinjaman',
            'v.kode_transaksi',
            'v.username_anggota',
            'v.nama_anggota',
            'v.tanggal_pinjaman',
            'v.tanggal_jatuh_tempo',
            'v.lama_angsuran',
            'v.total_tagihan',
            'v.status_lunas'
        )
        ->orderBy('v.tanggal_jatuh_tempo', 'asc')
        ->paginate(request('per_page', 10));

        $allData = DB::table('view_data_angsuran as v')
            ->leftJoin('bayar_angsuran as b', 'v.id_pinjaman', '=', 'b.id_pinjaman')
            ->select(
                DB::raw('COALESCE(v.total_tagihan, 0) as jumlah_tagihan'),
                DB::raw('COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0) as dibayar'),
                DB::raw('(COALESCE(v.total_tagihan, 0) - COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0)) as sisa_tagihan')
            )
            ->whereMonth('v.tanggal_jatuh_tempo', $bulan)
            ->whereYear('v.tanggal_jatuh_tempo', $tahun)
            ->where(function ($query) {
                $query->where('v.status_lunas', '=', 'BELUM LUNAS')
                    ->orWhereNull('v.status_lunas');
            })
            ->groupBy(
                'v.id_pinjaman',
                'v.total_tagihan'
            )
            ->get();

        $totalTagihan = $allData->sum('jumlah_tagihan');
        $totalDibayar = $allData->sum('dibayar');
        $totalSisa = $allData->sum('sisa_tagihan');

        $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');
        $periode = "{$namaBulan} {$tahun}";

        return view('admin.laporan.jatuh-tempo.laporan-jatuh-tempo', compact(
            'dataPinjaman', 'periode', 'bulan', 'tahun', 
            'totalTagihan', 'totalDibayar', 'totalSisa'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $data = DB::table('view_data_angsuran as v')
            ->leftJoin('bayar_angsuran as b', 'v.id_pinjaman', '=', 'b.id_pinjaman')
            ->select(
                'v.id_pinjaman',
                'v.kode_transaksi as kode_pinjam',
                DB::raw("CONCAT(v.username_anggota, ' - ', v.nama_anggota) as nama_anggota"),
                'v.tanggal_pinjaman as tanggal_pinjam',
                'v.tanggal_jatuh_tempo as tanggal_tempo',
                'v.lama_angsuran as lama_pinjam',
                DB::raw('COALESCE(v.total_tagihan, 0) as jumlah_tagihan'),
                DB::raw('COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0) as dibayar'),
                DB::raw('(COALESCE(v.total_tagihan, 0) - COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0)) as sisa_tagihan')
            )
            ->whereMonth('v.tanggal_jatuh_tempo', $bulan)
            ->whereYear('v.tanggal_jatuh_tempo', $tahun)
            ->where(function ($query) {
                $query->where('v.status_lunas', '=', 'BELUM LUNAS')
                    ->orWhereNull('v.status_lunas');
            })
            ->groupBy(
                'v.id_pinjaman',
                'v.kode_transaksi',
                'v.username_anggota',
                'v.nama_anggota',
                'v.tanggal_pinjaman',
                'v.tanggal_jatuh_tempo',
                'v.lama_angsuran',
                'v.total_tagihan',
                'v.status_lunas'
            )
            ->orderBy('v.tanggal_jatuh_tempo', 'asc')
            ->get();

        $totalTagihan = $data->sum('jumlah_tagihan');
        $totalDibayar  = $data->sum('dibayar');
        $totalSisa     = $data->sum('sisa_tagihan');

        $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');
        $periode = "{$namaBulan} {$tahun}";

        $pdf = Pdf::loadView('admin.laporan.jatuh-tempo.pdf', [
            'dataPinjaman' => $data,
            'periode' => $periode,
            'totalTagihan' => $totalTagihan,
            'totalDibayar' => $totalDibayar,
            'totalSisa' => $totalSisa
        ])->setPaper('A4', 'portrait');

        return $pdf->download("Laporan_Jatuh_Tempo_{$bulan}_{$tahun}.pdf");
    }

}
