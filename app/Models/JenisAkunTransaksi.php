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
        return $this->hasMany(AkunRelasiTransaksi::class, 'id_akun', 'id_jenisAkunTransaksi')
            ->with('transaksi')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id_relasi', 'asc');
    }

    public function bukuBesarTotal()
    {
        return $this->hasMany(AkunRelasiTransaksi::class, 'id_akun', 'id_jenisAkunTransaksi')
            ->with('transaksi')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id_relasi', 'asc');
    }
   
    // SALDO AWAL dari SAK & SANK
    public function saldoAwal()
    {
        return $this->hasMany(AkunRelasiTransaksi::class, 'id_akun', 'id_jenisAkunTransaksi')
            ->whereHas('transaksi', function ($q) {
                $q->whereIn('kode_transaksi', ['SAK', 'SANK']);
            })
            ->with('transaksi');
    }

    // SALDO AWAL sebelum bulan yang dipilih
    public function saldoAwalFiltered($bulan, $tahun)
    {
        $tanggalAwal = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01";

        return $this->hasMany(AkunRelasiTransaksi::class, 'id_akun', 'id_jenisAkunTransaksi')
            ->whereHas('transaksi', function ($q) use ($tanggalAwal) {
                $q->whereIn('kode_transaksi', ['SAK', 'SANK'])
                ->whereDate('tanggal_transaksi', '<', $tanggalAwal);
            })
            ->with('transaksi');
    }

    // TRANSAKSI SEBELUM BULAN YANG DIPILIH (untuk akumulasi)
    public function bukuBesarSebelumnya($bulan, $tahun)
    {
        $tanggalAwal = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01";

        return $this->hasMany(AkunRelasiTransaksi::class, 'id_akun', 'id_jenisAkunTransaksi')
            ->whereHas('transaksi', function ($q) use ($tanggalAwal) {
                $q->whereDate('tanggal_transaksi', '<', $tanggalAwal)
                ->whereNotIn('kode_transaksi', ['SAK', 'SANK']);
            })
            ->with('transaksi');
    }


}
