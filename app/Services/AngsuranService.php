<?php
namespace App\Services;

use App\Models\ViewDataAngsuran;
use App\Models\Angsuran;

class AngsuranService
{
    public function getDataBayar($id)
    {
        $pinjaman = ViewDataAngsuran::where('id', $id)->firstOrFail();
        $payments = Angsuran::where('id_pinjaman', $id)->get();

        return compact('pinjaman', 'payments');
    }
}
