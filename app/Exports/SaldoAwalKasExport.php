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
        return Transaksi::with(['details.akun', 'data_user'])
            ->where('type_transaksi', 'SAK')
            ->get()
            ->map(function ($item) {

                $detail = $item->details->first(); // saldo awal hanya 1 detail
                $akun = $detail?->akun?->nama_AkunTransaksi ?? '-';
                $saldo = $detail?->debit ?? 0;
                $username = $item->data_user->username ?? '-';

                return [
                    'Tanggal'    => \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y - H:i'),
                    'Akun'       => $akun,
                    'Keterangan' => $item->ket_transaksi ?? '-',
                    'Saldo Awal' => $saldo,
                    'Username'   => $username,
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

        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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

        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getAlignment()->setWrapText(true);

        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
