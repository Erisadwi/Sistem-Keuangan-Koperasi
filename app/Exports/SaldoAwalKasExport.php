<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaldoAwalKasExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Transaksi::where('type_transaksi', 'SAK')
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal'    => \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y - H:i'),
                    'Akun'       => $item->type_transaksi ?? '-',
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

        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E6F2FF'],
            ],
        ]);

        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
