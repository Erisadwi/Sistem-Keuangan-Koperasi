<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanSHUAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $preset = $request->get('preset', 'this_year');
        $start  = $request->get('start_date');
        $end    = $request->get('end_date');

        $tahunIni  = date('Y');
        $tahunLalu = $tahunIni - 1;

        $idAnggota = Auth::user()->id_anggota;

        $shu = DB::table('view_shu')->first() ?? (object)[
            'shu_jasa_usaha' => 0,
            'shu_jasa_modal_anggota' => 0
        ];

        $total_shu_jasa_usaha = $shu->shu_jasa_usaha;
        $total_shu_jasa_modal = $shu->shu_jasa_modal_anggota;

        $query = DB::table('view_shu_per_anggota')
            ->where('id_anggota', $idAnggota);

        if ($preset === 'this_year') {

            $query->where('tahun', $tahunIni);
            $periodeText = "Periode: 1 Januari $tahunIni - 31 Desember $tahunIni";

        } elseif ($preset === 'last_year') {

            $query->where('tahun', $tahunLalu);
            $periodeText = "Periode: 1 Januari $tahunLalu - 31 Desember $tahunLalu";

        } elseif ($preset === 'custom' && $start && $end) {

            $tahunCustom = date('Y', strtotime($start));
            $query->where('tahun', $tahunCustom);

            $periodeText = "Periode: "
                         . date('d/m/Y', strtotime($start))
                         . " - "
                         . date('d/m/Y', strtotime($end));
        }

        $data = $query->first();

        if (!$data) {
            $data = (object)[
                'id_anggota' => $idAnggota,
                'bunga_anggota' => 0,
                'total_bunga' => 0,
                'simpanan_anggota' => 0,
                'total_simpanan' => 0,
                'shu_jasa_usaha' => 0,
                'shu_jasa_modal' => 0,
                'total_shu' => 0,
                'tahun' => null
            ];
        }

        return view('anggota.laporan-SHU', [
            'anggota' => $data,
            'periodeText' => $periodeText,
            'total_shu_jasa_usaha' => $total_shu_jasa_usaha,
            'total_shu_jasa_modal' => $total_shu_jasa_modal,
            'shu' => $shu,
            'preset' => $preset,
            'start'  => $start,
            'end'    => $end,
        ]);
    }
}
