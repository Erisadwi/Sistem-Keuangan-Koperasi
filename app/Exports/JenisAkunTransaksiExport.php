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

    $sheet->getStyle("A1:{$highestColumn}500")->getAlignment()->setWrapText(true);

    return [];
    }

}
