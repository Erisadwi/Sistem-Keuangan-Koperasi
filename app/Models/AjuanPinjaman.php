<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjuanPinjaman extends Model
{
    use HasFactory;
    protected $table = 'ajuan_pinjaman';
    protected $primaryKey = 'id_ajuanPinjaman';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ajuanPinjaman',
        'id_anggota',
        'tanggal_pengajuan',
        'tanggal_update',
        'jenis_ajuan',
        'jumlah_ajuan',
        'keterangan',
        'status_ajuan',
        'id_lamaAngsuran',
        'id_biayaAdministrasi'
    ];

    public $timestamps = false;

public static function generateId()
{
    $prefix = 'AJP';
    $last = self::where('id_ajuanPinjaman', 'like', $prefix.'%')
        ->orderBy('id_ajuanPinjaman', 'desc')
        ->first();

    $number = $last ? (int) substr($last->id_ajuanPinjaman, strlen($prefix)) + 1 : 1;
    return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
}

public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

public function lama_angsuran()
    {
        return $this->belongsTo(LamaAngsuran::class, 'id_lamaAngsuran', 'id_lamaAngsuran');
    }

public function biaya_administrasi()
    {
        return $this->belongsTo(sukuBunga::class, 'id_biayaAdminitrasi', 'id_biayaAdminitrasi');
    }
}
