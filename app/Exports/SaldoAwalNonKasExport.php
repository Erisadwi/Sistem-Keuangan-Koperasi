<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SaldoAwalNonKasExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Transaksi::where('type_transaksi', 'SANK')
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal'    => \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y - H:i'),
                    'Akun'       => $item->tujuan->nama_AkunTransaksi ?? '-',
                    'Keterangan' => $item->ket_transaksi ?? '-',
                    'Saldo Awal' => $item->jumlah_transaksi,
                    'Username'   => $item->username ?? '-', 
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Akun',
            'Keterangan',
            'Saldo Awal',
            'Username',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Style header (baris 1)
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
