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


    private function getBukuBesarData($bulan, $tahun)
{
    $akunTransaksi = JenisAkunTransaksi::orderBy('id_jenisAkunTransaksi')->get();

    foreach ($akunTransaksi as $akun)
    {
        $bukuBesar = [];
        $totalDebit = 0;
        $totalKredit = 0;

        // ======================================================
        // SALDO AWAL
        // ======================================================
        $saldoAwal = $akun->saldoAwal()
            ->whereHas('transaksi', fn($q) => $q->whereIn('type_transaksi', ['SAK','SANK']))
            ->get();

        $akun->saldo_awal = $saldoAwal->sum('debit') - $saldoAwal->sum('kredit');



        // ======================================================
        // 1. TRANSAKSI KAS & NON KAS
        // ======================================================
        $kas = AkunRelasiTransaksi::where('id_akun', $akun->id_jenisAkunTransaksi)
            ->whereYear('tanggal_transaksi', $tahun)
            ->whereMonth('tanggal_transaksi', $bulan)
            ->get();

        foreach ($kas as $tr) {
            $bukuBesar[] = [
                'tanggal' => $tr->tanggal_transaksi,
                'akun_lawan' => $tr->akunLawan->nama_AkunTransaksi ?? '-',
                'debit' => $tr->debit,
                'kredit' => $tr->kredit
            ];

            $totalDebit += $tr->debit;
            $totalKredit += $tr->kredit;
        }


        // ======================================================
        // 2. SIMPANAN
        // ======================================================
        $simpanan = Simpanan::where(function($q) use ($akun) {
                $q->where('id_jenisAkunTransaksi_tujuan', $akun->id_jenisAkunTransaksi)
                  ->orWhere('id_jenisAkunTransaksi_sumber', $akun->id_jenisAkunTransaksi);
            })
            ->whereYear('tanggal_transaksi', $tahun)
            ->whereMonth('tanggal_transaksi', $bulan)
            ->get();

       foreach ($simpanan as $s) {
            $bukuBesar[] = [
                'tanggal' => $s->tanggal_transaksi,
                'akun_lawan' =>
                    ($s->akunTujuan->nama_AkunTransaksi ?? null)
                    ?: ($s->akunSumber->nama_AkunTransaksi ?? '-'),

                'debit' => $s->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi ? $s->jumlah_simpanan : 0,
                'kredit' => $s->id_jenisAkunTransaksi_sumber == $akun->id_jenisAkunTransaksi ? $s->jumlah_simpanan : 0,
            ];

            $totalDebit  += end($bukuBesar)['debit'];
            $totalKredit += end($bukuBesar)['kredit'];
        }


        // ======================================================
        // 3. PINJAMAN
        // ======================================================
        $pinjaman = Pinjaman::where(function($q) use ($akun) {
                $q->where('id_jenisAkunTransaksi_tujuan', $akun->id_jenisAkunTransaksi)
                  ->orWhere('id_jenisAkunTransaksi_sumber', $akun->id_jenisAkunTransaksi);
            })
            ->whereYear('tanggal_pinjaman', $tahun)
            ->whereMonth('tanggal_pinjaman', $bulan)
            ->get();

       foreach ($pinjaman as $p) {
            $bukuBesar[] = [
                'tanggal' => $p->tanggal_pinjaman,
                'akun_lawan' =>
                    ($p->akunTujuan->nama_AkunTransaksi ?? null)
                    ?: ($p->akunSumber->nama_AkunTransaksi ?? '-'),

                'debit' => $p->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi ? $p->jumlah_pinjaman : 0,
                'kredit' => $p->id_jenisAkunTransaksi_sumber == $akun->id_jenisAkunTransaksi ? $p->jumlah_pinjaman : 0,
            ];

            $totalDebit  += end($bukuBesar)['debit'];
            $totalKredit += end($bukuBesar)['kredit'];
        }


        // ======================================================
        // 4. ANGSURAN PINJAMAN
        // ======================================================
        $angsuran = Angsuran::where(function($q) use ($akun) {
                $q->where('id_jenisAkunTransaksi_tujuan', $akun->id_jenisAkunTransaksi)
                  ->orWhere('id_jenisAkunTransaksi_sumber', $akun->id_jenisAkunTransaksi);
            })
            ->whereYear('tanggal_bayar', $tahun)
            ->whereMonth('tanggal_bayar', $bulan)
            ->get();

       foreach ($angsuran as $a) {
            $bukuBesar[] = [
                'tanggal' => $a->tanggal_bayar,
                'akun_lawan' =>
                    ($a->akunTujuan->nama_AkunTransaksi ?? null)
                    ?: ($a->akunSumber->nama_AkunTransaksi ?? '-'),

                'debit' => $a->id_jenisAkunTransaksi_tujuan == $akun->id_jenisAkunTransaksi ? $a->angsuran_per_bulan : 0,
                'kredit' => $a->id_jenisAkunTransaksi_sumber == $akun->id_jenisAkunTransaksi ? $a->angsuran_per_bulan : 0,
            ];

            $totalDebit  += end($bukuBesar)['debit'];
            $totalKredit += end($bukuBesar)['kredit'];
        }

        // ======================================================
        // HITUNG SALDO KUMULATIF
        // ======================================================
        $akun->buku_besar = collect($bukuBesar)->sortBy('tanggal')->values();
        $akun->buku_besar_total = ['debit' => $totalDebit, 'kredit' => $totalKredit];
        $akun->saldo_kumulatif = $akun->saldo_awal + ($totalDebit - $totalKredit);
    }

    return $akunTransaksi;
}

}
