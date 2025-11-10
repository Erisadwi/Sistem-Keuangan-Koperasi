<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';
    protected $primaryKey = 'id_pinjaman';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pinjaman',
        'id_ajuanPinjaman',
        'id_user',
        'id_anggota',
        'id_jenisAkunTransaksi_tujuan',
        'id_jenisAkunTransaksi_sumber',
        'id_lamaAngsuran',
        'tanggal_pinjaman',
        'bunga_pinjaman',
        'jumlah_pinjaman',
        'total_tagihan',
        'keterangan',
        'status_lunas',
        'biaya_admin',
    ];

    protected $casts = [
    'tanggal_pinjaman' => 'date',
];

    public static function generateId()
    {
    $prefix = 'PJ';
    $last = self::where('id_pinjaman', 'like', $prefix.'%')
        ->orderBy('id_pinjaman', 'desc')
        ->first();

    $number = $last ? (int) substr($last->id_pinjaman, strlen($prefix)) + 1 : 1;
    return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
    protected $with = ['ajuanPinjaman','user', 'anggota', 'lamaAngsuran', 'tujuan', 'sumber'];

    public function ajuanPinjaman()
    {
        return $this->belongsTo(AjuanPinjaman::class, 'id_ajuanPinjaman', 'id_ajuanPinjaman');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function lamaAngsuran()
    {
        return $this->belongsTo(LamaAngsuran::class, 'id_lamaAngsuran', 'id_lamaAngsuran');
    }

    public function Angsuran()
    {
        return $this->belongsTo(Angsuran::class, 'id_bayar_angsuran', 'id_bayar_angsuran');
    }

    public function tujuan()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_tujuan', 'id_jenisAkunTransaksi');
    }

    public function sumber()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_sumber', 'id_jenisAkunTransaksi');
    }

    public function angsuran()
    {
    return $this->hasMany(\App\Models\Angsuran::class, 'id_pinjaman', 'id_pinjaman');
    }

}
