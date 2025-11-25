<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisAkunTransaksi;

class LaporanNeracaSaldoController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $periode = "$tahun-$bulan";

        // mapping sub judul
        $subJudulMap = [
            'A'   => 'A. Aktiva Lancar',
            'B'   => 'A. Aktiva Lancar',
            'C'   => 'C. Aktiva Tetap Berwujud',
            'F'   => 'F. Utang',
            'H'   => 'H. Utang Jangka Panjang',
            'I'   => 'I. Modal',
            'J'   => 'J. Pendapatan',
            'K'   => 'K. Beban',
            'TRF' => 'K. Beban',
        ];

        // AMBIL AKUN + TOTAL SALDO BERDASARKAN TRANSAKSI TERKAIT
        $akun = JenisAkunTransaksi::with([
            'bukuBesarTotal' => function ($q) use ($periode) {
                $q->whereHas('transaksi', function ($t) use ($periode) {
                    $t->whereRaw("DATE_FORMAT(tanggal_transaksi, '%Y-%m') = ?", [$periode]);
                });
            }
        ])
            ->orderBy('kode_aktiva')
            ->get();

        $neracaKelompok = [];

        foreach ($akun as $a) {

            // ambil sub judul dari kode_aktiva
            $prefix = $a->kode_aktiva;
            if (!isset($subJudulMap[$prefix])) {
                $prefix = substr($prefix, 0, 1);
            }
            $kategori = $subJudulMap[$prefix] ?? 'Lainnya';

            // hitung saldo bulan itu
            $totalDebit  = $a->bukuBesarTotal->sum('debit');
            $totalKredit = $a->bukuBesarTotal->sum('kredit');

            if ($a->type_akun === "ACTIVA") {
                $saldo  = $totalDebit - $totalKredit;
                $debet  = $saldo;
                $kredit = 0;
            } else {
                $saldo  = $totalKredit - $totalDebit;
                $debet  = 0;
                $kredit = $saldo;
            }

            $neracaKelompok[$kategori][] = [
                'kode'   => $a->kode_aktiva,
                'nama'   => $a->nama_AkunTransaksi,
                'debet'  => $debet,
                'kredit' => $kredit
            ];
        }

        return view('admin.laporan.laporan-neraca-saldo', [
            'neracaKelompok' => $neracaKelompok,
            'periode'        => $periode
        ]);
    }
}
