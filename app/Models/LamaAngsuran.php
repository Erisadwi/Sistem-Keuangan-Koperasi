<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LamaAngsuran extends Model
{
    use HasFactory;
    protected $table = 'lama_angsuran';
    protected $primaryKey = 'id_lamaAngsuran';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_lamaAngsuran',
        'lama_angsuran',
        'status_angsuran',
    ];

    public $timestamps = false;

public static function generateId()
{
    $prefix = 'LMA';
    $last = self::where('id_lamaAngsuran', 'like', $prefix.'%')
        ->orderBy('id_lamaAngsuran', 'desc')
        ->first();

    $number = $last ? (int) substr($last->id_barangInventaris, strlen($prefix)) + 1 : 1;
    return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
}
}
