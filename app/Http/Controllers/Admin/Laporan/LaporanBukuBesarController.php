<?php

namespace App\Http\Controllers\Admin\Laporan;

use Illuminate\Http\Request;
use App\Models\JenisAkunTransaksi;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanBukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $periode = "$tahun-$bulan";

        $akunTransaksi = JenisAkunTransaksi::with([
            'saldoAwal' => function ($q) {
                $q->whereHas('transaksi', function ($t) {
                    $t->whereIn('type_transaksi', ['SAK', 'SANK']); // Kas + Non Kas
                });
            },
            'bukuBesar' => function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal_transaksi', $bulan)
                  ->whereYear('tanggal_transaksi', $tahun)
                  ->orderBy('tanggal_transaksi', 'asc');
            },
            'bukuBesarTotal'
        ])
        ->orderBy('id_jenisAkunTransaksi')
        ->get();

        foreach ($akunTransaksi as $akun) {

            // 🔹 SALDO AWAL DARI TRANSAKSI SALDO (SAK & SANK)
            $saldoAwal = $akun->saldoAwal->sum('debit') - $akun->saldoAwal->sum('kredit');

            // 🔹 SALDO BULAN INI
            $saldoBulanIni = $akun->bukuBesar->sum(function ($t) {
                return $t->debit - $t->kredit;
            });

            // 🔹 SALDO SEBELUM PERIODE (BOLEH MINUS)
            $saldoSebelumnya = $akun->bukuBesarTotal
                ->filter(function ($trans) use ($periode) {
                    return isset($trans->tanggal_transaksi)
                        && substr($trans->tanggal_transaksi, 0, 7) < $periode;
                })
                ->sum(function ($t) {
                    return $t->debit - $t->kredit;
                });

            // 🔹 SALDO KUMULATIF AKHIR (INILAH YANG DIPAKAI DI BLADE)
            $akun->saldo_kumulatif = $saldoAwal + $saldoSebelumnya + $saldoBulanIni;
        }

        return view('admin.laporan.buku-besar.laporan-buku-besar', [
            'akunTransaksi' => $akunTransaksi,
            'periode'       => $periode,
            'bulan'         => $bulan,
            'tahun'         => $tahun
        ]);
    }

    public function exportPdf(Request $request)
    {
   
    $bulan = $request->input('bulan', date('m'));
    $tahun = $request->input('tahun', date('Y'));
    $periode = "$tahun-$bulan";

    $akunTransaksi = JenisAkunTransaksi::with([
        'saldoAwal' => function ($q) {
            $q->whereHas('transaksi', function ($t) {
                $t->whereIn('type_transaksi', ['SAK', 'SANK']);
            });
        },
        'bukuBesar' => function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal_transaksi', $bulan)
              ->whereYear('tanggal_transaksi', $tahun)
              ->orderBy('tanggal_transaksi', 'asc');
        },
        'bukuBesarTotal'
    ])
    ->orderBy('id_jenisAkunTransaksi')
    ->get();


    foreach ($akunTransaksi as $akun) {

        $saldoAwal = $akun->saldoAwal->sum('debit') - $akun->saldoAwal->sum('kredit');


        $saldoBulanIni = $akun->bukuBesar->sum(function ($t) {
            return $t->debit - $t->kredit;
        });

 
        $saldoSebelumnya = $akun->bukuBesarTotal
            ->filter(function ($trans) use ($periode) {
                return isset($trans->tanggal_transaksi)
                    && substr($trans->tanggal_transaksi, 0, 7) < $periode;
            })
            ->sum(function ($t) {
                return $t->debit - $t->kredit;
            });

        $akun->saldo_kumulatif = $saldoAwal + $saldoSebelumnya + $saldoBulanIni;
    }

    $pdf = Pdf::loadView('admin.laporan.buku-besar.pdf', [
        'akunTransaksi' => $akunTransaksi,
        'periode'       => $periode,
        'bulan'         => $bulan,
        'tahun'         => $tahun
    ])
    ->setPaper('a4', 'portrait'); 

    return $pdf->download('laporan-buku-besar-'.$periode.'.pdf');
    }

}
