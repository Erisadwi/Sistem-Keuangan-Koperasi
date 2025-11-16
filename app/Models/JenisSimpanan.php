<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Simpanan;

class JenisSimpanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_simpanan';
    protected $primaryKey = 'id_jenis_simpanan';
    public $incrementing = true; // Karena PK-nya int unsigned
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'jenis_simpanan',
        'jumlah_simpanan',
        'id_jenisAkunTransaksi',
        'tampil_simpanan',
    ];
    
    public function akunSimpanan()
    {
        return $this->belongsTo(JenisAkunTransaksi::class, 'id_jenisAkunTransaksi', 'id_jenisAkunTransaksi');
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'id_jenis_simpanan', 'id_jenis_simpanan');
    }
}
