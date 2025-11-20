<?php

namespace App\Services;

use App\Models\Pinjaman;
use App\Models\Angsuran;

class PinjamanDashboardService
{
    public function getSummary()
    {
        $totalTagihan = Pinjaman::sum('total_tagihan');

        $totalPelunasan = Angsuran::sum('angsuran_per_bulan');

        $sisaTagihan = $totalTagihan - $totalPelunasan;

        return [
            'tagihan'     => $totalTagihan,
            'pelunasan'   => $totalPelunasan,
            'sisa'        => $sisaTagihan,
        ];
    }
}
