<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunRelasiTransaksi extends Model
{
    protected $table = 'akun_relasi_transaksi';
    protected $primaryKey = 'id_relasi';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_akun',
        'id_akun_berkaitan',
        'debit',
        'kredit',
        'kode_transaksi',
        'tanggal_transaksi',
    ];

    public function akunBerkaitan()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_akun_berkaitan', 'id_jenisAkunTransaksi');
    }
    public function transaksi()
    {
        return $this->belongsTo(\App\Models\Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
