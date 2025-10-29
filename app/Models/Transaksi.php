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
}
