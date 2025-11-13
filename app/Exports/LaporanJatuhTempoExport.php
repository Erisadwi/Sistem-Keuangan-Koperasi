<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanJatuhTempoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return DB::table('view_data_angsuran as v')
            ->leftJoin('bayar_angsuran as b', 'v.id_pinjaman', '=', 'b.id_pinjaman')
            ->select(
                DB::raw('v.kode_transaksi as kode_pinjam'),
                DB::raw("CONCAT(v.username_anggota, ' - ', v.nama_anggota) as nama_anggota"),
                DB::raw('v.tanggal_pinjaman as tanggal_pinjam'),
                DB::raw('v.tanggal_jatuh_tempo as tanggal_tempo'),
                DB::raw('v.lama_angsuran as lama_pinjam'),
                DB::raw('COALESCE(v.total_tagihan, 0) as total_tagihan'),
                DB::raw('COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0) as total_dibayar'),
                DB::raw('(COALESCE(v.total_tagihan, 0) - COALESCE(SUM(b.angsuran_per_bulan + b.denda), 0)) as sisa_tagihan')
            )
            ->whereMonth('v.tanggal_jatuh_tempo', $this->bulan)
            ->whereYear('v.tanggal_jatuh_tempo', $this->tahun)
            ->where(function ($q) {
                $q->where('v.status_lunas', 'BELUM LUNAS')
                  ->orWhereNull('v.status_lunas');
            })
            ->groupBy(
                'v.id_pinjaman',
                'v.kode_transaksi',
                'v.username_anggota',
                'v.nama_anggota',
                'v.tanggal_pinjaman',
                'v.tanggal_jatuh_tempo',
                'v.lama_angsuran',
                'v.total_tagihan',
                'v.status_lunas'
            )
            ->orderBy('v.tanggal_jatuh_tempo', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Pinjam',
            'Nama Anggota',
            'Tanggal Pinjam',
            'Tanggal Jatuh Tempo',
            'Lama Pinjam',
            'Total Tagihan',
            'Total Dibayar',
            'Sisa Tagihan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
    $highestColumn = $sheet->getHighestColumn();
    $highestRow = $sheet->getHighestRow();

    $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000']
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'E6F2FF'],
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ]);

    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ]);
    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
          ->getAlignment()->setWrapText(true);

    return [];
    }

}
