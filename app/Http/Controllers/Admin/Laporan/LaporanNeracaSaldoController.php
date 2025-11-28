<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisAkunTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanNeracaSaldoController extends Controller
{
    public function index(Request $request)
    {
        // PILIH TAHUN SAJA
        $tahun = $request->tahun ?? date('Y');

        // RANGE TETAP 01 JAN - 31 DES
        $start = "$tahun-01-01";
        $end   = "$tahun-12-31";

        // Sub Judul
        $subJudulMap = [
            'A'   => 'A. Aktiva Lancar',
            'B'   => 'B. Aktiva Tidak Lancar',
            'C'   => 'C. Aktiva Tetap Berwujud',
            'F'   => 'F. Utang',
            'H'   => 'H. Utang Jangka Panjang',
            'I'   => 'I. Modal',
            'J'   => 'J. Pendapatan',
            'K'   => 'K. Beban',
            'TRF' => 'K. Beban',
        ];

        // Ambil akun + buku besar 1 TAHUN PENUH
        $akun = JenisAkunTransaksi::with([
            'bukuBesarTotal' => function ($q) use ($start, $end) {
                $q->whereHas('transaksi', function ($t) use ($start, $end) {
                    $t->whereBetween('tanggal_transaksi', [$start, $end]);
                });
            }
        ])
        ->orderBy('kode_aktiva')
        ->get();

        $neracaKelompok = [];
        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($akun as $a) {

            // Tentukan kategori
            $prefix = $a->kode_aktiva;
            if (!isset($subJudulMap[$prefix])) {
                $prefix = substr($prefix, 0, 1);
            }
            $kategori = $subJudulMap[$prefix] ?? 'Lainnya';

            // Hitung total
            $totalDebit  = $a->bukuBesarTotal->sum('debit');
            $totalKredit = $a->bukuBesarTotal->sum('kredit');

            // Saldo normal berdasarkan type_akun
            if ($a->type_akun === "ACTIVA" || $a->type_akun === "BEBAN") {
                // Saldo normal DEBIT
                $saldo  = $totalDebit - $totalKredit;
                $debet  = $saldo;
                $kredit = 0;
            } else {
                // Saldo normal KREDIT (PASIVA, MODAL, PENDAPATAN)
                $saldo  = $totalKredit - $totalDebit;
                $debet  = 0;
                $kredit = $saldo;
            }

            // Tambahkan ke total
            $totalDebet  += $debet;
            $totalKredit += $kredit;

            // Masukkan ke kategori masing-masing
            $neracaKelompok[$kategori][] = [
                'kode'   => $a->kode_aktiva,
                'nama'   => $a->nama_AkunTransaksi,
                'debet'  => $debet,
                'kredit' => $kredit,
            ];
        }

        return view('admin.laporan.neraca-saldo.laporan-neraca-saldo', [
            'neracaKelompok' => $neracaKelompok,
            'tahun'          => $tahun,
            'totalDebet'     => $totalDebet,
            'totalKredit'    => $totalKredit,
        ]);
    }

    public function exportPdf(Request $request)
        {
            // AMBIL TAHUN
            $tahun = $request->tahun ?? date('Y');

            // PERIODE TETAP: 1 JAN – 31 DES
            $start = "$tahun-01-01";
            $end   = "$tahun-12-31";

            // Sub Judul
            $subJudulMap = [
                'A'   => 'A. Aktiva Lancar',
                'B'   => 'B. Aktiva Tidak Lancar',
                'C'   => 'C. Aktiva Tetap Berwujud',
                'F'   => 'F. Utang',
                'H'   => 'H. Utang Jangka Panjang',
                'I'   => 'I. Modal',
                'J'   => 'J. Pendapatan',
                'K'   => 'K. Beban',
                'TRF' => 'K. Beban',
            ];

            $akun = JenisAkunTransaksi::with([
                'bukuBesarTotal' => function ($q) use ($start, $end) {
                    $q->whereHas('transaksi', function ($t) use ($start, $end) {
                        $t->whereBetween('tanggal_transaksi', [$start, $end]);
                    });
                }
            ])
            ->orderBy('kode_aktiva')
            ->get();

            $neracaKelompok = [];
            $totalDebet = 0;
            $totalKredit = 0;

            foreach ($akun as $a) {

                // Tentukan kategori group
                $prefix = $a->kode_aktiva;
                if (!isset($subJudulMap[$prefix])) {
                    $prefix = substr($prefix, 0, 1);
                }
                $kategori = $subJudulMap[$prefix] ?? 'Lainnya';

                // Hitung saldo
                $totalDebit  = $a->bukuBesarTotal->sum('debit');
                $totalKredit = $a->bukuBesarTotal->sum('kredit');

                if ($a->type_akun === "ACTIVA" || $a->type_akun === "BEBAN") {
                    // Saldo Normal Debit
                    $saldo  = $totalDebit - $totalKredit;
                    $debet  = $saldo;
                    $kredit = 0;
                } else {
                    // Saldo Normal Kredit
                    $saldo  = $totalKredit - $totalDebit;
                    $debet  = 0;
                    $kredit = $saldo;
                }

                $totalDebet  += $debet;
                $totalKredit += $kredit;

                $neracaKelompok[$kategori][] = [
                    'kode'   => $a->kode_aktiva,
                    'nama'   => $a->nama_AkunTransaksi,
                    'debet'  => $debet,
                    'kredit' => $kredit
                ];
            }

            // Buat PDF
            $pdf = Pdf::loadView('admin.laporan.neraca-saldo.pdf', [
                'neracaKelompok' => $neracaKelompok,
                'tahun'          => $tahun,
                'totalDebet'     => $totalDebet,
                'totalKredit'    => $totalKredit,
            ])->setPaper('A4', 'portrait');

            return $pdf->download("Neraca-Saldo-$tahun.pdf");
        }
}
