<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanSHUUtamaController extends Controller
{
public function index(Request $request)
{
    $preset = $request->get('preset', 'this_year');

    $start  = $request->get('start_date');
    $end    = $request->get('end_date');

    $tahunIni  = date('Y');
    $tahunLalu = $tahunIni - 1;

    $query = DB::table('view_shu');

    if ($preset === 'this_year') {

        $query->where('tahun', $tahunIni);

    } elseif ($preset === 'last_year') {

        $query->where('tahun', $tahunLalu);

    } elseif ($preset === 'custom' && $start && $end) {

        $tahunCustom = date('Y', strtotime($start));
        $query->where('tahun', $tahunCustom);
    }

    $data = $query->first();
    $biayaAdm = DB::table('biaya_administrasi')
    ->first();

    if ($preset === 'this_year') {

        $periodeText = "Periode: 1 Januari " . $tahunIni . " - 31 Desember " . $tahunIni;

    } elseif ($preset === 'last_year') {

        $periodeText = "Periode: 1 Januari " . $tahunLalu . " - 31 Desember " . $tahunLalu;

    } elseif ($preset === 'custom' && $start && $end) {

        $periodeText = "Periode: " 
            . date('d/m/Y', strtotime($start)) .
            " - " . date('d/m/Y', strtotime($end));

    } else {

        $periodeText = "Periode -";
    }


    if (!$data) {
        $data = (object) [
            'tahun' => null,
            'total_pendapatan' => 0,
            'total_biaya' => 0,
            'shu' => 0,
            'total_simpanan' => 0,
            'total_pendapatan_anggota' => 0,
        ];
    }

    return view('admin.laporan.SHU.laporan-SHU', [
        'shu'       => $data,
        'biayaAdm'     => $biayaAdm,
        'preset'    => $preset,
        'start'     => $start,
        'end'       => $end,
        'tahunIni'  => $tahunIni,
        'tahunLalu' => $tahunLalu,
        'periodeText' => $periodeText,
    ]);
}

}
