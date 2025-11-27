<?php

namespace App\Http\Controllers\Admin\Laporan;

use Illuminate\Http\Request;
use App\Models\JenisAkunTransaksi;
use App\Models\AkunRelasiTransaksi;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanBukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $bulan   = $request->input('bulan', date('m'));
        $tahun   = $request->input('tahun', date('Y'));
        $periode = "$tahun-$bulan";

        $akunTransaksi = $this->getBukuBesarData($bulan, $tahun);

        return view('admin.laporan.buku-besar.laporan-buku-besar', compact(
            'akunTransaksi','periode','bulan','tahun'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan   = $request->input('bulan', date('m'));
        $tahun   = $request->input('tahun', date('Y'));
        $periode = "$tahun-$bulan";

        $akunTransaksi = $this->getBukuBesarData($bulan, $tahun);

        $pdf = Pdf::loadView('admin.laporan.buku-besar.pdf', compact(
            'akunTransaksi','periode','bulan','tahun'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-buku-besar-' . $periode . '.pdf');
    }


    // ==========================================================
    // GET DATA BUKU BESAR PER AKUN
    // ==========================================================
    private function getBukuBesarData($bulan, $tahun)
    {
        $akunTransaksi = JenisAkunTransaksi::orderBy('id_jenisAkunTransaksi')->get();

        foreach ($akunTransaksi as $akun)
        {
            $debitAwal = $kreditAwal = 0;
            $debitBulanIni = $kreditBulanIni = 0;

            // ======================================================
            // SALDO AWAL (SAK & SANK)
            // ======================================================
            $saldoAwalTransaksi = $akun->saldoAwal()
                ->whereHas('transaksi', fn($q) => $q->whereIn('type_transaksi', ['SAK','SANK']))
                ->get();

            foreach ($saldoAwalTransaksi as $sa) {
                $debitAwal  += $sa->debit;
                $kreditAwal += $sa->kredit;
            }
            $saldoAwal = $debitAwal - $kreditAwal;  // saldo posisi akhir periode sebelumnya


            // ======================================================
            // TRANSAKSI RELASI (Akun Relasi Buku Besar)
            // ======================================================
            $kasNonKas = AkunRelasiTransaksi::where('id_akun', $akun->id_jenisAkunTransaksi)
                ->whereYear('tanggal_transaksi', $tahun)
                ->whereMonth('tanggal_transaksi', $bulan)
                ->leftJoin('jenis_akun_transaksi AS akunLawan', 'akunLawan.id_jenisAkunTransaksi', '=', 'akun_relasi_transaksi.id_akun_berkaitan')
                ->select(
                    'akun_relasi_transaksi.*',
                    'akunLawan.nama_akunTransaksi as akun_lawan'
                )
                ->get();

            $akun->relasi_transaksi = $kasNonKas;

            foreach ($kasNonKas as $tr) {
                $debitBulanIni  += $tr->debit;
                $kreditBulanIni += $tr->kredit;
            }


            // ======================================================
            // SIMPANAN
            // ======================================================
            $simpanan = Simpanan::where(function($q) use ($akun) {
                    $q->where('id_jenisAkunTransaksi_tujuan', $akun->id_jenisAkunTransaksi)
                      ->orWhere('id_jenisAkunTransaksi_sumber', $akun->id_jenisAkunTransaksi);
                })
                ->whereYear('tanggal_transaksi', $tahun)
                ->whereMonth('tanggal_transaksi', $bulan)
                ->get();

            foreach ($simpanan as $s) {
                if ($s->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi)
                    $debitBulanIni  += $s->jumlah_simpanan;

                if ($s->id_jenisAkunTransaksi_sumber == $akun->id_jenisAkunTransaksi)
                    $kreditBulanIni += $s->jumlah_simpanan;
            }


            // ======================================================
            // PINJAMAN
            // ======================================================
            $pinjaman = Pinjaman::where(function($q) use ($akun) {
                    $q->where('id_jenisAkunTransaksi_tujuan', $akun->id_jenisAkunTransaksi)
                      ->orWhere('id_jenisAkunTransaksi_sumber', $akun->id_jenisAkunTransaksi);
                })
                ->whereYear('tanggal_pinjaman', $tahun)
                ->whereMonth('tanggal_pinjaman', $bulan)
                ->get();

            foreach ($pinjaman as $p) {
                if ($p->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi)
                    $debitBulanIni += $p->jumlah_pinjaman;

                if ($p->id_jenisAkunTransaksi_sumber == $akun->id_jenisAkunTransaksi)
                    $kreditBulanIni += $p->jumlah_pinjaman;
            }


            // ======================================================
            // ANGSURAN PINJAMAN
            // ======================================================
            $angsuran = Angsuran::where(function($q) use ($akun) {
                    $q->where('id_jenisAkunTransaksi_tujuan', $akun->id_jenisAkunTransaksi)
                      ->orWhere('id_jenisAkunTransaksi_sumber', $akun->id_jenisAkunTransaksi);
                })
                ->whereYear('tanggal_bayar', $tahun)
                ->whereMonth('tanggal_bayar', $bulan)
                ->get();

            foreach ($angsuran as $a) {
                if ($a->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi)
                    $debitBulanIni += $a->angsuran_per_bulan;

                if ($a->id_jenisAkunTransaksi_sumber == $akun->id_jenisAkunTransaksi)
                    $kreditBulanIni += $a->angsuran_per_bulan;
            }


            // ======================================================
            // HITUNG SALDO KUMULATIF AKHIR
            // ======================================================
            $akun->saldo_awal = $saldoAwal;
            $akun->transaksi_bulan_ini = ['debit' => $debitBulanIni, 'kredit' => $kreditBulanIni];
            $akun->saldo_kumulatif = $saldoAwal + ($debitBulanIni - $kreditBulanIni);
        }

        return $akunTransaksi;
    }
}
