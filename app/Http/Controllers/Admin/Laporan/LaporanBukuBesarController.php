<?php

namespace App\Http\Controllers\Admin\Laporan;

use Illuminate\Http\Request;
use App\Models\JenisAkunTransaksi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanBukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int)$request->input('bulan', date('m'));
        $tahun = (int)$request->input('tahun', date('Y'));
        $periode = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT);

        $akunTransaksi = JenisAkunTransaksi::with([
            'saldoAwal',
            'bukuBesar' => function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal_transaksi', $bulan)
                  ->whereYear('tanggal_transaksi', $tahun)
                  ->whereDoesntHave('transaksi', function ($t) {
                      $t->whereIn('kode_transaksi', ['SAK', 'SANK']);
                  })
                  ->orderBy('tanggal_transaksi', 'asc')
                  ->orderBy('id_relasi', 'asc'); 
            },
            'bukuBesarTotal'
        ])
        ->orderBy('id_jenisAkunTransaksi')
        ->get();

        $danaCadangan = DB::table('view_shu')
            ->where('tahun', $tahun - 1)
            ->value('total_dana_cadangan') ?? 0;

        foreach ($akunTransaksi as $akun) {

            if ($akun->id_jenisAkunTransaksi == 97) {
                $saldoAwalSAK = $akun->saldoAwal->sum('debit')
                                - $akun->saldoAwal->sum('kredit');
            } elseif ($akun->is_kas == 1) {
                $saldoAwalSAK = $akun->saldoAwal->sum('debit');
            } else {
                $saldoAwalSAK = $akun->saldoAwal->sum('kredit');
            }

            $bulanSaldoAwal = $akun->saldoAwal
                ->sortBy('tanggal_transaksi')
                ->first()
                ? (int)substr($akun->saldoAwal->first()->tanggal_transaksi, 5, 2)
                : null;

            $saldoSebelumnya = $akun->bukuBesarTotal
                ->filter(function ($trans) use ($periode) {
                    return isset($trans->tanggal_transaksi)
                        && substr($trans->tanggal_transaksi, 0, 7) < $periode;
                })
                ->sum(function ($t) {
                    return $t->debit - $t->kredit;
                });

            if ($akun->id_jenisAkunTransaksi == 97) {

                $akun->saldo_awal_tampil = 
                    $saldoAwalSAK 
                    + $saldoSebelumnya 
                    + $danaCadangan;

            } else {

                if ($bulan == $bulanSaldoAwal) {
                    $akun->saldo_awal_tampil = $saldoAwalSAK;
                } else {
                    $akun->saldo_awal_tampil = $saldoAwalSAK + $saldoSebelumnya;
                }
            }

            $saldoBulanIni = $akun->bukuBesar->sum(function ($t) {
                return $t->debit - $t->kredit;
            });


            $akun->saldo_kumulatif = 
                $akun->saldo_awal_tampil 
                + $saldoBulanIni;

            $akun->total_debet_bulan = $akun->bukuBesar->sum('debit');
            $akun->total_kredit_bulan = $akun->bukuBesar->sum('kredit');
        }

        return view('admin.laporan.buku-besar.laporan-buku-besar', compact(
            'akunTransaksi', 'periode', 'bulan', 'tahun'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = (int)$request->input('bulan', date('m'));
        $tahun = (int)$request->input('tahun', date('Y'));
        $periode = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT);

        $request->merge(['bulan' => $bulan, 'tahun' => $tahun]);
        $data = $this->index($request);

        $pdf = Pdf::loadView('admin.laporan.buku-besar.pdf', [
            'akunTransaksi' => $data->getData()['akunTransaksi'],
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-buku-besar.pdf');
    }
}
