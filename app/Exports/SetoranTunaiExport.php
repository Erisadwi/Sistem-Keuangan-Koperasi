<?php

namespace App\Exports;

use App\Models\Simpanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class SetoranTunaiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Simpanan::with(['anggota', 'jenisSimpanan', 'user'])
            ->where('type_simpanan', 'TRD')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Tanggal Transaksi',
            'ID Anggota',
            'Nama Anggota',
            'Jenis Simpanan',
            'Jumlah',
            'User'
        ];
    }

    public function map($simpanan): array
    {
        static $no = 1;

        return [
            $no++,
            $simpanan->kode_simpanan,
            $simpanan->tanggal_transaksi
                ? Carbon::parse($simpanan->tanggal_transaksi)->format('d-m-Y H:i')
                : '-',
            optional($simpanan->anggota)->id_anggota,
            optional($simpanan->anggota)->nama_anggota,
            optional($simpanan->jenisSimpanan)->jenis_simpanan,
            number_format($simpanan->jumlah_simpanan, 0, ',', '.'),
            optional($simpanan->data_user)->nama_lengkap,
        ];
    }
}
