<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'id_jenisAkunTransaksi_sumber',
        'id_jenisAkunTransaksi_tujuan',
        'id_user',
        'type_transaksi',
        'kode_transaksi',
        'ket_transaksi',
        'tanggal_transaksi',
        'jumlah_transaksi',
    ];

        public function sumber()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_sumber', 'id_jenisAkunTransaksi');
    }

    public function tujuan()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_tujuan', 'id_jenisAkunTransaksi');
    }

        public function data_user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id_user');
    }

        public function details()
    {
    return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

}
