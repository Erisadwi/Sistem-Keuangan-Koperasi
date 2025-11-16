<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanan';
    protected $primaryKey = 'id_simpanan';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_anggota',
        'id_jenis_simpanan',

        'id_jenisAkunTransaksi_tujuan',
        'id_jenisAkunTransaksi_sumber',

        'jumlah_simpanan',
        'type_simpanan',
        'kode_simpanan',
        'tanggal_transaksi',
        'keterangan',
        'bukti_setoran',
    ];

    protected $with = ['user', 'anggota', 'jenisSimpanan', 'tujuan', 'sumber'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function jenisSimpanan()
    {
        return $this->belongsTo(JenisSimpanan::class, 'id_jenis_simpanan', 'id_jenis_simpanan');
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
