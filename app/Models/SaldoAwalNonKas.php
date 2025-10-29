<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoAwalNonKas extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; 
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_jenisAkunTransaksi_tujuan',
        'id_user',
        'type_transaksi',
        'kode_transaksi',
        'ket_transaksi',
        'tanggal_transaksi',
        'jumlah_transaksi',
    ];

    protected static function booted()
    {
        static::addGlobalScope('saldoAwalNonKas', function ($query) {
            $query->where('type_transaksi', 'SANK');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function akunTujuan()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi_tujuan');
    }

}
