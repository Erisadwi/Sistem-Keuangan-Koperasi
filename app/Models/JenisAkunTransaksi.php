<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAkunTransaksi extends Model
{
    use HasFactory;
    protected $table = 'jenis_akun_transaksi';
    protected $primaryKey = 'id_jenisAkunTransaksi';


    protected $fillable = [
        'kode_aktiva',
        'nama_AkunTransaksi',
        'type_akun',
        'pemasukan',
        'pengeluaran',
        'penarikan',
        'transfer',
        'status_akun',
        'nonkas',
        'simpanan',
        'pinjaman',
        'angsuran',
        'labarugi',
    ];

    public $timestamps = false;
    public function simpananSumber()
    {
        return $this->hasMany(Simpanan::class, 'id_jenisAkunTransaksi_sumber', 'id_jenisAkunTransaksi');
    }

    public function simpananTujuan()
    {
        return $this->hasMany(Simpanan::class, 'id_jenisAkunTransaksi_tujuan', 'id_jenisAkunTransaksi');
    }
}
