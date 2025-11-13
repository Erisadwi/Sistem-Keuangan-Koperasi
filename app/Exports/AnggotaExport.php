<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AnggotaExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Anggota::select(
            'id_anggota',
            'username_anggota',
            'nama_anggota',
            'jenis_kelamin',
            'alamat_anggota',
            'kota_anggota',
            'jabatan',
            'tanggal_registrasi',
            'tanggal_keluar',
            'status_anggota'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID Anggota',
            'Username',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Alamat',
            'Kota',
            'Jabatan',
            'Tanggal Registrasi',
            'Tanggal Keluar',
            'Keanggotaan'
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
