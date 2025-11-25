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

        public function downloadPDF(Request $request)
    {
        $preset = $request->get('preset', 'this_year');
        $start  = $request->get('start_date');
        $end    = $request->get('end_date');

        $tahunIni  = date('Y');
        $tahunLalu = $tahunIni - 1;

        $shu = DB::table('view_shu')->first();

        $total_shu_jasa_usaha = $shu->shu_jasa_usaha ?? 0;
        $total_shu_jasa_modal = $shu->shu_jasa_modal_anggota ?? 0;

        $query = DB::table('anggota as a')
            ->leftJoin('view_shu_per_anggota as v', 'a.id_anggota', '=', 'v.id_anggota')
            ->select(
                'a.id_anggota',
                'a.nama_anggota',
                'a.alamat_anggota',
                'a.no_telepon',
                'v.bunga_anggota',
                'v.total_bunga',
                'v.simpanan_anggota',
                'v.total_simpanan',
                'v.shu_jasa_usaha',
                'v.shu_jasa_modal',
                'v.total_shu',
                'v.tahun'
            );


      if ($preset === 'this_year') {

        $query->where(function($q) use ($tahunIni) {
            $q->where('v.tahun', $tahunIni)
            ->orWhereNull('v.tahun');
        });

        $periodeText = "Periode: 1 Januari $tahunIni - 31 Desember $tahunIni";

        } elseif ($preset === 'last_year') {

            $query->where(function($q) use ($tahunLalu) {
                $q->where('v.tahun', $tahunLalu)
                ->orWhereNull('v.tahun');
            });

            $periodeText = "Periode: 1 Januari $tahunLalu - 31 Desember $tahunLalu";

        } elseif ($preset === 'custom' && $start && $end) {

            $tahunCustom = date('Y', strtotime($start));

            $query->where(function($q) use ($tahunCustom) {
                $q->where('v.tahun', $tahunCustom)
                ->orWhereNull('v.tahun');
            });

            $periodeText = "Periode: ".date('d/m/Y', strtotime($start)).
                        " - ".date('d/m/Y', strtotime($end));
        }

        $anggota = $query->get();


        $pdf = Pdf::loadView('admin.laporan.SHU.pdf', [
            'anggota' => $anggota,
            'periodeText' => $periodeText,
            'total_shu_jasa_usaha' => $total_shu_jasa_usaha,
            'total_shu_jasa_modal' => $total_shu_jasa_modal
        ])->setPaper('A4', 'landscape');

        $fileName = 'Laporan_SHU_Anggota_' . date('Ymd_His') . '.pdf';

        return $pdf->stream($fileName);
    }
}
