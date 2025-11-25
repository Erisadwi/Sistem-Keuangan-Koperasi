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
        'is_kas',
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

    public function bukuBesar()
    {
        return $this->hasMany(\App\Models\AkunRelasiTransaksi::class, 'id_akun', 'id_jenisAkunTransaksi')
            ->with('transaksi');
    }
    public function bukuBesarTotal()
    {
        return $this->hasMany(\App\Models\AkunRelasiTransaksi::class, 'id_akun', 'id_jenisAkunTransaksi')
            ->with('transaksi');
    }

    public function saldoAwalFiltered()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_jenisAkunTransaksi', 'id_jenisAkunTransaksi')
            ->whereHas('transaksi'); // filter dilakukan di controller
    }

    // JenisAkunTransaksi.php
    public function saldoAwal()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_jenisAkunTransaksi')
            ->whereHas('transaksi', function ($q) {
                $q->whereIn('type_transaksi', ['SAK', 'SANK']); // Kas + Non Kas
            });
    }
}
