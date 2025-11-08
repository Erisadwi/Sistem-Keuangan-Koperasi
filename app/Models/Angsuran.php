<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;
    protected $table = 'bayar_angsuran';
    protected $primaryKey = 'id_bayar_angsuran';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_bayar_angsuran',
        'id_user',
        'angsuran_ke',
        'tanggal_bayar',
        'tanggal_jatuh_tempo',
        'angsuran_pokok',
        'angsuran_per_bulan',
        'status_bayar',
        'denda',
        'bunga_angsuran',
        'id_pinjaman',
        'id_jenisAkunTransaksi_sumber',
        'id_jenisAkunTransaksi_tujuan',
        'keterangan'
    ];

    public $timestamps = false;

public static function generateId()
{
    $prefix = 'TBY';
    $last = self::where('id_bayar_angsuran', 'like', $prefix.'%')
        ->orderBy('id_bayar_angsuran', 'desc')
        ->first();

    $number = $last ? (int) substr($last->id_bayar_angsuran, strlen($prefix)) + 1 : 1;
    return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
}

        public function data_user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id_user');
    }
        public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman', 'id_pinjaman');
    }
        public function sumber()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_sumber', 'id_jenisAkunTransaksi');
    }

    public function tujuan()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_tujuan', 'id_jenisAkunTransaksi');
    }
}