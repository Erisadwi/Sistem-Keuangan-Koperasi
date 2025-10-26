<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_anggota',
        'username_anggota',
        'password_anggota',
        'nama_anggota',
        'jenis_kelamin',
        'alamat_anggota',
        'kota_anggota',
        'tempat_lahir',
        'tanggal_lahir',
        'departemen',
        'pekerjaan',
        'jabatan',
        'agama',
        'status_perkawinan',
        'tanggal_registrasi',
        'tanggal_keluar',
        'no_telepon',
        'status_anggota',
        'foto',
    ];

    public $timestamps = false;

public static function generateId()
{
    $prefix = 'AG';
    $last = self::where('id_anggota', 'like', $prefix.'%')
        ->orderBy('id_anggota', 'desc')
        ->first();

    $number = $last ? (int) substr($last->id_anggota, strlen($prefix)) + 1 : 1;
    return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
}
}
