<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanSaldoKasController extends Controller
{
    public function index(Request $request)
    {

        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate   = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $prevEnd = (clone $endDate)->subMonth()->endOfMonth();

        $saldoBulanIni = DB::table('jenis_akun_transaksi AS j')
            ->select(
                'j.id_jenisAkunTransaksi AS id_akun',
                'j.nama_AkunTransaksi AS nama_kas',
                DB::raw("
                    COALESCE((
                        SELECT SUM(d.debit - d.kredit)
                        FROM detail_transaksi d
                        JOIN transaksi t ON t.id_transaksi = d.id_transaksi
                        WHERE d.id_jenisAkunTransaksi = j.id_jenisAkunTransaksi
                        AND t.type_transaksi IN ('TKD', 'TKK', 'TRF', 'SAK')
                        AND t.tanggal_transaksi BETWEEN '{$startDate}' AND '{$endDate}'
                    ), 0)
                    +
                    COALESCE((
                        SELECT SUM(s.jumlah_simpanan)
                        FROM simpanan s
                        WHERE s.type_simpanan = 'TRD'
                        AND s.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                        AND s.tanggal_transaksi BETWEEN '{$startDate}' AND '{$endDate}'
                    ), 0)
                    -
                    COALESCE((
                        SELECT SUM(s.jumlah_simpanan)
                        FROM simpanan s
                        WHERE s.type_simpanan = 'TRK'
                        AND s.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                        AND s.tanggal_transaksi BETWEEN '{$startDate}' AND '{$endDate}'
                    ), 0)
                    -
                    COALESCE((
                        SELECT SUM(p.jumlah_pinjaman)
                        FROM pinjaman p
                        WHERE p.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                        AND p.tanggal_pinjaman BETWEEN '{$startDate}' AND '{$endDate}'
                    ), 0)
                    +
                    COALESCE((
                        SELECT SUM(b.angsuran_per_bulan)
                        FROM bayar_angsuran b
                        WHERE b.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                        AND b.tanggal_bayar BETWEEN '{$startDate}' AND '{$endDate}'
                    ), 0)
                AS total_saldo")
            )
            ->where('j.is_kas', 1)
            ->get();


        $saldoBulanLalu = DB::table('jenis_akun_transaksi AS j')
            ->select(
                'j.id_jenisAkunTransaksi AS id_akun',
                DB::raw("
                    COALESCE((
                        SELECT SUM(d.debit - d.kredit)
                        FROM detail_transaksi d
                        JOIN transaksi t ON t.id_transaksi = d.id_transaksi
                        WHERE d.id_jenisAkunTransaksi = j.id_jenisAkunTransaksi
                        AND t.type_transaksi IN ('TKD', 'TKK', 'TRF', 'SAK')
                        AND t.tanggal_transaksi <= '{$prevEnd}'
                    ), 0)
                    +
                    COALESCE((
                        SELECT SUM(s.jumlah_simpanan)
                        FROM simpanan s
                        WHERE s.type_simpanan = 'TRD'
                        AND s.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                        AND s.tanggal_transaksi <= '{$prevEnd}'
                    ), 0)
                    -
                    COALESCE((
                        SELECT SUM(s.jumlah_simpanan)
                        FROM simpanan s
                        WHERE s.type_simpanan = 'TRK'
                        AND s.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                        AND s.tanggal_transaksi <= '{$prevEnd}'
                    ), 0)
                    -
                    COALESCE((
                        SELECT SUM(p.jumlah_pinjaman)
                        FROM pinjaman p
                        WHERE p.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                        AND p.tanggal_pinjaman <= '{$prevEnd}'
                    ), 0)
                    +
                    COALESCE((
                        SELECT SUM(b.angsuran_per_bulan)
                        FROM bayar_angsuran b
                        WHERE b.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                        AND b.tanggal_bayar <= '{$prevEnd}'
                    ), 0)
                AS total_saldo_lalu")
            )
            ->where('j.is_kas', 1)
            ->get()
            ->pluck('total_saldo_lalu', 'id_akun');


        $data = $saldoBulanIni->map(function ($item) use ($saldoBulanLalu) {
            $item->total_saldo_lalu = $saldoBulanLalu[$item->id_akun] ?? 0;
            $item->selisih = $item->total_saldo - $item->total_saldo_lalu;
            return $item;
        });

        $saldo_periode_sebelumnya = $data->sum('total_saldo_lalu');
        $jumlah_kas = $data->sum('total_saldo');

        return view('admin.laporan.saldo-kas.laporan-saldo-kas', compact(
            'data', 'bulan', 'tahun', 'startDate', 'endDate',
            'saldo_periode_sebelumnya', 'jumlah_kas'
        ));
    }

public function exportPdf(Request $request)
{
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));

    $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
    $endDate   = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
    $prevEnd = (clone $endDate)->subMonth()->endOfMonth();

    // Saldo bulan ini
    $saldoBulanIni = DB::table('jenis_akun_transaksi AS j')
        ->select(
            'j.id_jenisAkunTransaksi AS id_akun',
            'j.nama_AkunTransaksi AS nama_kas',
            DB::raw("
                COALESCE((SELECT SUM(d.debit - d.kredit)
                          FROM detail_transaksi d
                          JOIN transaksi t ON t.id_transaksi = d.id_transaksi
                          WHERE d.id_jenisAkunTransaksi = j.id_jenisAkunTransaksi
                            AND t.type_transaksi IN ('TKD','TKK','TRF','SAK')
                            AND t.tanggal_transaksi BETWEEN '{$startDate}' AND '{$endDate}'),0)
                +
                COALESCE((SELECT SUM(s.jumlah_simpanan)
                          FROM simpanan s
                          WHERE s.type_simpanan = 'TRD'
                            AND s.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                            AND s.tanggal_transaksi BETWEEN '{$startDate}' AND '{$endDate}'),0)
                -
                COALESCE((SELECT SUM(s.jumlah_simpanan)
                          FROM simpanan s
                          WHERE s.type_simpanan = 'TRK'
                            AND s.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                            AND s.tanggal_transaksi BETWEEN '{$startDate}' AND '{$endDate}'),0)
                -
                COALESCE((SELECT SUM(p.jumlah_pinjaman)
                          FROM pinjaman p
                          WHERE p.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                            AND p.tanggal_pinjaman BETWEEN '{$startDate}' AND '{$endDate}'),0)
                +
                COALESCE((SELECT SUM(b.angsuran_per_bulan)
                          FROM bayar_angsuran b
                          WHERE b.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                            AND b.tanggal_bayar BETWEEN '{$startDate}' AND '{$endDate}'),0)
                AS total_saldo
            ")
        )
        ->where('j.is_kas', 1)
        ->get();

    // Saldo bulan lalu
    $saldoBulanLalu = DB::table('jenis_akun_transaksi AS j')
        ->select(
            'j.id_jenisAkunTransaksi AS id_akun',
            DB::raw("
                COALESCE((SELECT SUM(d.debit - d.kredit)
                          FROM detail_transaksi d
                          JOIN transaksi t ON t.id_transaksi = d.id_transaksi
                          WHERE d.id_jenisAkunTransaksi = j.id_jenisAkunTransaksi
                            AND t.type_transaksi IN ('TKD','TKK','TRF','SAK')
                            AND t.tanggal_transaksi <= '{$prevEnd}'),0)
                +
                COALESCE((SELECT SUM(s.jumlah_simpanan)
                          FROM simpanan s
                          WHERE s.type_simpanan = 'TRD'
                            AND s.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                            AND s.tanggal_transaksi <= '{$prevEnd}'),0)
                -
                COALESCE((SELECT SUM(s.jumlah_simpanan)
                          FROM simpanan s
                          WHERE s.type_simpanan = 'TRK'
                            AND s.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                            AND s.tanggal_transaksi <= '{$prevEnd}'),0)
                -
                COALESCE((SELECT SUM(p.jumlah_pinjaman)
                          FROM pinjaman p
                          WHERE p.id_jenisAkunTransaksi_sumber = j.id_jenisAkunTransaksi
                            AND p.tanggal_pinjaman <= '{$prevEnd}'),0)
                +
                COALESCE((SELECT SUM(b.angsuran_per_bulan)
                          FROM bayar_angsuran b
                          WHERE b.id_jenisAkunTransaksi_tujuan = j.id_jenisAkunTransaksi
                            AND b.tanggal_bayar <= '{$prevEnd}'),0)
                AS total_saldo_lalu
            ")
        )
        ->where('j.is_kas', 1)
        ->get()
        ->pluck('total_saldo_lalu', 'id_akun');

    // Gabungkan data
    $data = $saldoBulanIni->map(function ($item) use ($saldoBulanLalu) {
        $item->total_saldo_lalu = $saldoBulanLalu[$item->id_akun] ?? 0;
        return $item;
    });

    $saldo_periode_sebelumnya = $data->sum('total_saldo_lalu');
    $jumlah_kas = $data->sum('total_saldo');

    // Generate PDF
    $pdf = Pdf::loadView('admin.laporan.saldo-kas.pdf', compact(
        'data', 'bulan', 'tahun', 'saldo_periode_sebelumnya', 'jumlah_kas', 'startDate', 'endDate'
    ))
    ->setPaper('a4', 'portrait');

    return $pdf->download('Laporan_Saldo_Kas_'.$bulan.'-'.$tahun.'.pdf');
}

}
