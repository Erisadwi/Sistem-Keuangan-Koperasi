<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSimpanan extends Model
{
    use HasFactory;
    protected $table = 'jenis_simpanan';
    protected $primaryKey = 'id_jenis_simpanan';


    protected $fillable = [
        'jenis_simpanan',
        'jumlah_simpanan',
        'tampil_simpanan',
    ];

    public $timestamps = false;
}
