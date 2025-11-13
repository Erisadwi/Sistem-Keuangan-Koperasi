<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewTotalSaldoKas extends Model
{
    protected $table = 'view_total_saldo_kas';
    protected $primaryKey = 'id_akun';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_akun',
        'nama_kas',
        'total_saldo',
    ];
}
