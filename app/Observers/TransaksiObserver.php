<?php
// app/Observers/TransaksiObserver.php
namespace App\Observers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use App\Services\TransaksiDetailBuilder;

class TransaksiObserver
{
    public function created(Transaksi $trx): void
    {
        Log::info('✅ Observer::created terpanggil', ['id' => $trx->id_transaksi]);
        app(TransaksiDetailBuilder::class)->rebuildDetails($trx);
    }

    public function updated(Transaksi $trx): void
    {
        if ($trx->wasChanged([
            'type_transaksi',
            'jumlah_transaksi',
            'id_jenisAkunTransaksi_sumber',
            'id_jenisAkunTransaksi_tujuan',
        ])) {
            Log::info('♻️ Observer::updated terpanggil', ['id' => $trx->id_transaksi]);
            app(TransaksiDetailBuilder::class)->rebuildDetails($trx);
        }
    }
}

