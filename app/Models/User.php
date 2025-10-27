<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false; // karena bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'nama_lengkap',
        'alamat_user',
        'telepon',
        'username',
        'password',
        'foto_user',
        'jenis_kelamin',
        'status',
        'tanggal_masuk',
        'tanggal_keluar',
        'id_role',       // foreign key ke tabel role
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Relasi ke tabel Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

}