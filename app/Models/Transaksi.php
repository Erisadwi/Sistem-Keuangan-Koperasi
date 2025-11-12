<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'type_transaksi',
        'kode_transaksi',
        'ket_transaksi',
        'tanggal_transaksi',
        'total_debit',         // hasil perhitungan otomatis
        'total_kredit',        // hasil perhitungan otomatis
    ];

    // 🔹 Relasi ke user pembuat transaksi
    public function data_user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // 🔹 Relasi ke detail transaksi (1 transaksi punya banyak detail)
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    // 🔹 Helper: update total debit/kredit otomatis
    public function updateTotals()
    {
        $this->total_debit = $this->details()->sum('debit');
        $this->total_kredit = $this->details()->sum('kredit');
        $this->save();
    }
}
