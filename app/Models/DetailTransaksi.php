<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_jenisAkunTransaksi',
        'debit',
        'kredit',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

        public function akun()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi', 'id_jenisAkunTransaksi');
    }

        protected static function booted()
    {
        static::saved(function ($detail) {
            $detail->transaksi?->updateTotals();
        });

        static::deleted(function ($detail) {
            $detail->transaksi?->updateTotals();
        });
    }
}
