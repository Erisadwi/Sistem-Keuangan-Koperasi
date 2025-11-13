<?php

namespace App\Exports;

use App\Models\JenisAkunTransaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JenisAkunTransaksiExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return JenisAkunTransaksi::select(
            'kode_aktiva',
            'nama_AkunTransaksi',
            'type_akun',
            'pemasukan',
            'penarikan',
            'transfer',
            'pengeluaran',
            'status_akun',
            'labarugi',
            'nonkas',
            'simpanan',
            'pinjaman',
            'angsuran',
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Aktiva',
            'Jenis Transaksi',
            'Akun',
            'Pemasukan',
            'Penarikan',
            'Transfer',
            'Pengeluaran',
            'Aktif',
            'Laba Rugi',
            'Non Kas',
            'Simpanan',
            'Pinjaman',
            'Angsuran',
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

    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ]);

    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->getAlignment()->setWrapText(true);

    return [];  
    }


}
