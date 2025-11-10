<?php

namespace App\Exports;

use App\Models\JenisBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class JenisBarangInventarisExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return JenisBarang::select('nama_barang', 'type_barang', 'jumlah_barang', 'keterangan_barang')
            ->get()
            ->map(function ($item) {
                return [
                    $item->nama_barang ?? '-',
                    $item->type_barang ?? '-',
                    $item->jumlah_barang ?? '-',
                    $item->keterangan_barang ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Type',
            'Jumlah',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E6F2FF'],
            ],
        ]);

        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}

