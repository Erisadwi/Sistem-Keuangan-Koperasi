<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
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
        'id_role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function username()
    {
        return 'username';
    }
}
