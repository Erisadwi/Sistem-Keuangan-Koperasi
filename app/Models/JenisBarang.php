<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;
    protected $table = 'barang_inventaris';
    protected $primaryKey = 'id_barangInventaris';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_barangInventaris',
        'nama_barang',
        'type_barang',
        'jumlah_barang',
        'keterangan_barang',
    ];

    public $timestamps = false;

public static function generateId()
{
    $prefix = 'BRG';
    $last = self::where('id_barangInventaris', 'like', $prefix.'%')
        ->orderBy('id_barangInventaris', 'desc')
        ->first();

    $number = $last ? (int) substr($last->id_barangInventaris, strlen($prefix)) + 1 : 1;
    return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
}
}
