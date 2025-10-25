<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sukuBunga extends Model
{
    use HasFactory;
    protected $table = 'biaya_administrasi';
    protected $primaryKey = 'id_biayaAdministrasi';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_biayaAdministrasi',
        'tipe_pinjaman_bunga',
        'suku_bunga_pinjaman',
        'biaya_administrasi',
        'biaya_denda',
        'tempo_tanggal_pembayaran',
        'iuran_wajib',
        'dana_cadangan',
        'jasa_usaha',
        'jasa_anggota',
        'jasa_modal_anggota',
        'dana_pengurus',
        'dana_karyawan',
        'dana_pendidikan',
        'dana_sosial',
        'pajak_pph',
    ];

    public $timestamps = false;

    public static function generateId()
        {
        $prefix = 'ADM';

        $last = self::where('id_biayaAdministrasi', 'like', $prefix . '%')
            ->orderBy('id_biayaAdministrasi', 'desc')
            ->first();

        if ($last) {
            $lastNumberPart = substr($last->id_biayaAdministrasi, strlen($prefix));

            $nextNumber = (int) $lastNumberPart + 1;
        } else {
            $nextNumber = 1;
        }

        $nextNumberPadded = str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return $prefix . $nextNumberPadded; 
        }
}
