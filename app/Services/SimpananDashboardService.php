<?php

namespace App\Services;

use App\Models\Simpanan;

class SimpananDashboardService
{
    /**
     * Mengambil summary simpanan untuk dashboard
     */
    public function getSummary()
    {
        $totalSetoran = Simpanan::where('type_simpanan', 'TRD')
            ->sum('jumlah_simpanan');

        $totalPenarikan = Simpanan::where('type_simpanan', 'TRK')
            ->sum('jumlah_simpanan');

        $jumlahSimpanan = $totalSetoran - $totalPenarikan;

        return (object) [
            'setoran' => $totalSetoran,
            'penarikan' => $totalPenarikan,
            'jumlah' => $jumlahSimpanan,
        ];
    }
}
