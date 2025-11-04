<?php

namespace App\Exports;

use App\Models\JenisAkunTransaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JenisAkunTransaksiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return JenisAkunTransaksi::select(
            'kode_aktiva',
            'nama_AkunTransaksi',
            'type_akun',
            'pemasukan',
            'pengeluaran',
            'penarikan',
            'transfer',
            'status_akun',
            'nonkas',
            'simpanan',
            'pinjaman',
            'angsuran',
            'labarugi'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Aktiva',
            'Nama Akun',
            'Tipe Akun',
            'Pemasukan',
            'Pengeluaran',
            'Penarikan',
            'Transfer',
            'Status Akun',
            'Non Kas',
            'Simpanan',
            'Pinjaman',
            'Angsuran',
            'Laba/Rugi'
        ];
    }
}
