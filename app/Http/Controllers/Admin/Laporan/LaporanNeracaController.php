<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisAkunTransaksi;
use App\Models\AkunRelasiTransaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanNeracaController extends Controller
{
    protected $akunOrder = [
        1,3,4,5,2,6,7,8,9,11,12,13,26,28,29,30,27,32,37,34,31,36,35,33,38,
        56,57,58,59,60,61,62,63,66,64,65,68,67,69,71,70,75,89,90,82,84,80,
        79,78,77,83,81,76,85,86,87,88,105,106,91,92,94,95,98,99,100,97,102,
        104,96
    ];

    protected $forceToBeban = [96, 104];

    protected $forceAktivaLancar = [
        13,26,28,29,30,27,32,37,34,31,36,35,33,38,
        56,57,58,59,60,61,62
    ];

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $tanggal = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $akuns = JenisAkunTransaksi::whereIn('id_jenisAkunTransaksi', $this->akunOrder)
            ->get()
            ->keyBy('id_jenisAkunTransaksi');

        $laba_bersih = DB::table('view_laba_rugi_extended')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('laba_bersih');

        $rows = [];

        foreach ($this->akunOrder as $idx => $akunId) {

            if (!isset($akuns[$akunId])) {
                $rows[] = (object)[
                    'id' => $akunId,
                    'kode_aktiva' => null,
                    'nama_AkunTransaksi' => 'N/A',
                    'kelompok' => 'A. Aktiva Lancar', // default
                    'total_debit_display' => 0,
                    'total_kredit_display' => 0,
                    'order' => $idx,
                ];
                continue;
            }

            $akun = $akuns[$akunId];

            if ((int)$akunId === 96) {
                $rows[] = (object)[
                    'id' => $akunId,
                    'kode_aktiva' => $akun->kode_aktiva,
                    'nama_AkunTransaksi' => $akun->nama_AkunTransaksi,
                    'kelompok' => 'K. Beban',
                    'total_debit_display' => $laba_bersih < 0 ? abs($laba_bersih) : 0,
                    'total_kredit_display' => $laba_bersih > 0 ? $laba_bersih : 0,
                    'order' => $idx,
                ];
                continue;
            }

            $saldoAwalDebit  = (float)$akun->saldoAwalFiltered($bulan, $tahun)->sum('debit');
            $saldoAwalKredit = (float)$akun->saldoAwalFiltered($bulan, $tahun)->sum('kredit');

            $beforeDebit  = (float)$akun->bukuBesarSebelumnya($bulan, $tahun)->sum('debit');
            $beforeKredit = (float)$akun->bukuBesarSebelumnya($bulan, $tahun)->sum('kredit');

            $periodDebit  = (float)$akun->bukuBesar()->whereDate('tanggal_transaksi', '<=', $tanggal)->sum('debit');
            $periodKredit = (float)$akun->bukuBesar()->whereDate('tanggal_transaksi', '<=', $tanggal)->sum('kredit');

            $totalDebitRaw  = $saldoAwalDebit + $beforeDebit + $periodDebit;
            $totalKreditRaw = $saldoAwalKredit + $beforeKredit + $periodKredit;

            $net = $totalDebitRaw - $totalKreditRaw;

            $type = strtoupper($akun->type_akun ?? '');

            if ($type === 'ACTIVA') {
                $displayDebit = $net >= 0 ? $net : abs($net);
                $displayKredit = 0;
            } elseif ($type === 'PASIVA') {
                $displayDebit = 0;
                $displayKredit = $net >= 0 ? $net : abs($net);
            } else {
                $displayDebit = $net < 0 ? abs($net) : 0;
                $displayKredit = $net > 0 ? $net : 0;
            }

            if ((int)$akunId === 104) {
                $rows[] = (object)[
                    'id' => $akunId,
                    'kode_aktiva' => $akun->kode_aktiva,
                    'nama_AkunTransaksi' => $akun->nama_AkunTransaksi,
                    'kelompok' => 'K. Beban',
                    'total_debit_display' => abs($net),
                    'total_kredit_display' => 0,
                    'order' => $idx,
                ];
                continue;
            }

            $rows[] = (object)[
                'id' => $akunId,
                'kode_aktiva' => $akun->kode_aktiva,
                'nama_AkunTransaksi' => $akun->nama_AkunTransaksi,
                'kelompok' => $this->kelompokFromKode($akun->kode_aktiva, $akunId),
                'total_debit_display' => $displayDebit,
                'total_kredit_display' => $displayKredit,
                'order' => $idx,
            ];
        }

        $collection = collect($rows);
        $neracaGrouped = $collection->groupBy('kelompok');

        return view('admin.laporan.laporan-neraca.laporan-neraca', [
            'neracaGrouped' => $neracaGrouped,
            'tanggal' => $tanggal,
            'judul' => 'LAPORAN NERACA PER ' . strtoupper($tanggal->translatedFormat('d F Y')),
            'totalDebit' => $collection->sum('total_debit_display'),
            'totalKredit' => $collection->sum('total_kredit_display'),
            'laba_bersih' => $laba_bersih,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->index($request)->getData();

        $pdf = Pdf::loadView('admin.laporan.laporan-neraca.pdf', (array)$data)
            ->setPaper('A4', 'portrait');

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $tanggal = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        return $pdf->download('laporan_neraca_' . $tanggal->translatedFormat('d_F_Y') . '.pdf');
    }

    protected function kelompokFromKode($kodeAktiva, $akunId = null)
    {

        if (in_array((int)$akunId, $this->forceAktivaLancar)) {
            return 'A. Aktiva Lancar';
        }

        if (!$kodeAktiva) {
            return 'Z. Lainnya';
        }

        $prefix = strtoupper(substr($kodeAktiva, 0, 1));

        $map = [
            'A' => 'A. Aktiva Lancar',
            'C' => 'C. Aktiva Tetap Berwujud',
            'F' => 'F. Utang',
            'H' => 'H. Utang Jangka Panjang',
            'I' => 'I. Modal',
            'K' => 'K. Beban',
        ];

        return $map[$prefix] ?? 'Z. Lainnya';
    }

    public function apiIndex(Request $request)
{
    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');
    $tanggal = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

    $akuns = JenisAkunTransaksi::whereIn('id_jenisAkunTransaksi', $this->akunOrder)
        ->get()
        ->keyBy('id_jenisAkunTransaksi');

    $laba_bersih = DB::table('view_laba_rugi_extended')
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->sum('laba_bersih');

    $rows = [];

    foreach ($this->akunOrder as $idx => $akunId) {

        if (!isset($akuns[$akunId])) {
            $rows[] = [
                'id' => $akunId,
                'kode_aktiva' => null,
                'nama_AkunTransaksi' => 'N/A',
                'kelompok' => 'A. Aktiva Lancar',
                'total_debit' => 0,
                'total_kredit' => 0,
                'order' => $idx,
            ];
            continue;
        }

        $akun = $akuns[$akunId];

        if ((int)$akunId === 96) {
            $rows[] = [
                'id' => $akunId,
                'kode_aktiva' => $akun->kode_aktiva,
                'nama_AkunTransaksi' => $akun->nama_AkunTransaksi,
                'kelompok' => 'K. Beban',
                'total_debit' => $laba_bersih < 0 ? abs($laba_bersih) : 0,
                'total_kredit' => $laba_bersih > 0 ? $laba_bersih : 0,
                'order' => $idx,
            ];
            continue;
        }

        $saldoAwalDebit  = (float)$akun->saldoAwalFiltered($bulan, $tahun)->sum('debit');
        $saldoAwalKredit = (float)$akun->saldoAwalFiltered($bulan, $tahun)->sum('kredit');

        $beforeDebit  = (float)$akun->bukuBesarSebelumnya($bulan, $tahun)->sum('debit');
        $beforeKredit = (float)$akun->bukuBesarSebelumnya($bulan, $tahun)->sum('kredit');

        $periodDebit  = (float)$akun->bukuBesar()->whereDate('tanggal_transaksi', '<=', $tanggal)->sum('debit');
        $periodKredit = (float)$akun->bukuBesar()->whereDate('tanggal_transaksi', '<=', $tanggal)->sum('kredit');

        $totalDebitRaw  = $saldoAwalDebit + $beforeDebit + $periodDebit;
        $totalKreditRaw = $saldoAwalKredit + $beforeKredit + $periodKredit;

        $net = $totalDebitRaw - $totalKreditRaw;
        $type = strtoupper($akun->type_akun ?? '');

        if ($type === 'ACTIVA') {
            $displayDebit = $net >= 0 ? $net : abs($net);
            $displayKredit = 0;
        } elseif ($type === 'PASIVA') {
            $displayDebit = 0;
            $displayKredit = $net >= 0 ? $net : abs($net);
        } else {
            $displayDebit = $net < 0 ? abs($net) : 0;
            $displayKredit = $net > 0 ? $net : 0;
        }

        if ((int)$akunId === 104) {
            $rows[] = [
                'id' => $akunId,
                'kode_aktiva' => $akun->kode_aktiva,
                'nama_AkunTransaksi' => $akun->nama_AkunTransaksi,
                'kelompok' => 'K. Beban',
                'total_debit' => abs($net),
                'total_kredit' => 0,
                'order' => $idx,
            ];
            continue;
        }

        $rows[] = [
            'id' => $akunId,
            'kode_aktiva' => $akun->kode_aktiva,
            'nama_AkunTransaksi' => $akun->nama_AkunTransaksi,
            'kelompok' => $this->kelompokFromKode($akun->kode_aktiva, $akunId),
            'total_debit' => $displayDebit,
            'total_kredit' => $displayKredit,
            'order' => $idx,
        ];
    }

    $collection = collect($rows);

    return response()->json([
        'status' => true,
        'message' => 'Laporan Neraca',
        'tanggal' => $tanggal->translatedFormat('d F Y'),
        'laba_bersih' => $laba_bersih,
        'total_debit' => $collection->sum('total_debit'),
        'total_kredit' => $collection->sum('total_kredit'),
        'data' => $collection->groupBy('kelompok')->values(),
    ]);
}

}
