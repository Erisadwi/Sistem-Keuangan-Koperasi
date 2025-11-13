<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use PDF;
use Carbon\Carbon;

class LaporanSaldoKasExport
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function download()
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate   = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
        $prevEnd   = (clone $endDate)->subMonth()->endOfMonth();

        // Ambil saldo bulan ini
        $saldoBulanIni = DB::table('jenis_akun_transaksi AS j')
            ->select(
                'j.id_jenisAkunTransaksi AS id_akun',
                'j.nama_AkunTransaksi AS nama_kas',
                DB::raw("COALESCE((
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

        // Ambil saldo bulan lalu
        $saldoBulanLalu = DB::table('jenis_akun_transaksi AS j')
            ->select(
                'j.id_jenisAkunTransaksi AS id_akun',
                DB::raw("COALESCE((
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

        // Hitung selisih
        $data = $saldoBulanIni->map(function ($item) use ($saldoBulanLalu) {
            $item->total_saldo_lalu = $saldoBulanLalu[$item->id_akun] ?? 0;
            $item->selisih = $item->total_saldo - $item->total_saldo_lalu;

            return $item;
        });

        $saldo_periode_sebelumnya = $data->sum('total_saldo_lalu');
        $jumlah_kas = $data->sum('total_saldo');

        // Generate PDF
        $pdf = PDF::loadView('admin.laporan.pdf-saldo-kas', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'saldo_periode_sebelumnya' => $saldo_periode_sebelumnya,
            'jumlah_kas' => $jumlah_kas,
        ])
        ->setPaper('A4', 'landscape');

        return $pdf->download("Laporan_Saldo_Kas_{$bulan}_{$tahun}.pdf");
    }
}
