<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class UsersExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return User::with('role')
            ->select(
                'id_user',
                'nama_lengkap',
                'username',
                'telepon',
                'jenis_kelamin',
                'status',
                'tanggal_masuk',
                'tanggal_keluar',
                'id_role'
            )
            ->get()
            ->map(function ($user) {
                return [
                    $user->id_user ?? '-',
                    $user->nama_lengkap ?? '-',
                    $user->username ?? '-',
                    $user->telepon ?? '-',
                    $user->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                    ucfirst($user->status ?? '-'),
                    $user->tanggal_masuk ? date('d-m-Y', strtotime($user->tanggal_masuk)) : '-',
                    $user->tanggal_keluar ? date('d-m-Y', strtotime($user->tanggal_keluar)) : '-',
                    $user->role->nama_role ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID User',
            'Nama Lengkap',
            'Username',
            'Telepon',
            'Jenis Kelamin',
            'Status',
            'Tanggal Masuk',
            'Tanggal Keluar',
            'Role / Jabatan',
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

        // Border semua sel
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Lebar kolom otomatis
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
