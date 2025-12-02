<?php

namespace App\Http\Controllers\Admin\Laporan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanNeracaSaldoController extends Controller
{
    
    private function buildData(Request $request)
    {
       $tahun = $request->start_date
            ? date('Y', strtotime($request->start_date))
            : ($request->input('tahun') ?? date('Y'));

       $dataBukuBesar = app(LaporanBukuBesarController::class)->index(new Request([
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'tahun'      => $tahun,     
        ]));

        $akunTransaksi = $dataBukuBesar->getData()['akunTransaksi'];

        $subJudulOrder = [
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

        $neracaKelompok = [];
        $subTotals = [];
        $totalDebet = 0;
        $totalKredit = 0;

        foreach ($akunTransaksi as $akun) {

            $kode = $akun->kode_aktiva ?? '';
            $prefix = array_key_exists($kode, $subJudulOrder) ? $kode : substr($kode, 0, 1);
            $kategori = $subJudulOrder[$prefix] ?? null;

            $net = (float) ($akun->saldo_kumulatif ?? 0);

            if ($net > 0) {
                $debet = $net;
                $kredit = 0;
            } elseif ($net < 0) {
                $debet = 0;
                $kredit = abs($net);
            } else {
                $debet = 0;
                $kredit = 0;
            }

            if (!isset($neracaKelompok[$kategori])) {
                $neracaKelompok[$kategori] = [];
                $subTotals[$kategori] = ['debet' => 0, 'kredit' => 0];
            }

            $neracaKelompok[$kategori][] = [
                'kode' => $kode,
                'nama' => $akun->nama_AkunTransaksi,
                'debet' => $debet,
                'kredit' => $kredit,
            ];

            $subTotals[$kategori]['debet'] += $debet;
            $subTotals[$kategori]['kredit'] += $kredit;

            $totalDebet += $debet;
            $totalKredit += $kredit;
        }
        
        $orderedGroups = [];
        foreach ($subJudulOrder as $key => $label) {
            if (isset($neracaKelompok[$label])) {
                $orderedGroups[$label] = $neracaKelompok[$label];
            }
        }

        foreach ($orderedGroups as $judul => &$items) {
            usort($items, function ($a, $b) {
                return $a['kode'] <=> $b['kode'];
            });
        }
        unset($items); 

        return [
            'tahun' => $tahun,
            'neracaKelompok' => $orderedGroups,
            'subTotals' => $subTotals,
            'totalDebet' => $totalDebet,
            'totalKredit' => $totalKredit,
            'imbalance' => round($totalDebet - $totalKredit, 2), 
        ];


    }

    public function index(Request $request)
    {
        $data = $this->buildData($request);

        return view('admin.laporan.neraca-saldo.laporan-neraca-saldo', $data);
    }

    public function exportPdf(Request $request)
{
    $data = $this->buildData($request);

    $pdf = Pdf::loadView('admin.laporan.neraca-saldo.pdf', $data)
        ->setPaper('A4', 'portrait');

    return $pdf->download("Neraca-Saldo-{$data['tahun']}.pdf"); 
}
}