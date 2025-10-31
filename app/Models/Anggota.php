<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

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

    protected $hidden = [
        'password_anggota',
    ];

    public function getAuthPassword()
    {
        return $this->password_anggota;
    }

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
