<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';
    protected $primaryKey = 'id_pinjaman';
    public $incrementing = true;
    protected $keyType = 'int';
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

    protected $with = ['ajuanPinjaman','user', 'anggota', 'lamaAngsuran', 'tujuan', 'sumber'];

    public function ajuan_pinjaman()
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

    public function lama_angsuran()
    {
        return $this->belongsTo(LamaAngsuran::class, 'id_lamaAngsuran', 'id_lamaAngsuran');
    }

    public function tujuan()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_tujuan', 'id_jenisAkunTransaksi');
    }

    public function sumber()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_sumber', 'id_jenisAkunTransaksi');
    }

}
