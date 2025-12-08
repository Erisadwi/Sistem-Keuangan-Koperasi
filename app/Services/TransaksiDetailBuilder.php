<?php
namespace App\Services;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiDetailBuilder
{
    public function rebuildDetails(Transaksi $trx): void
    {
        DB::transaction(function () use ($trx) {

            $trx->details()->delete();

            $rules = config("transaksi.{$trx->type_transaksi}") ?? config('transaksi.default');
            $full  = abs((float) $trx->jumlah_transaksi);

            foreach ($rules as $row) {

                $akunId = $row['akun'] === 'tujuan'
                    ? $trx->id_jenisAkunTransaksi_tujuan
                    : $trx->id_jenisAkunTransaksi_sumber;

                if (!$akunId || $full <= 0) continue;

                $side = $row['side'];
                if ((float)$trx->jumlah_transaksi < 0) {

                    $side = $side === 'D' ? 'K' : 'D';
                }

                DetailTransaksi::create([
                    'id_transaksi'          => $trx->id_transaksi,
                    'id_jenisAkunTransaksi' => $akunId,
                    'debit'                 => $side === 'D' ? $full : 0,
                    'kredit'                => $side === 'K' ? $full : 0,
                ]);
            }
        });
    }

    public function buildInline(Transaksi $trx): array
{
    $rules = config("transaksi.{$trx->type_transaksi}") ?? config('transaksi.default');
    $full  = abs((float) $trx->jumlah_transaksi);

    $details = [];

    foreach ($rules as $row) {

        $akunId = $row['akun'] === 'tujuan'
            ? $trx->id_jenisAkunTransaksi_tujuan
            : $trx->id_jenisAkunTransaksi_sumber;

        if (!$akunId || $full <= 0) continue;

        $side = $row['side'];

        if ((float)$trx->jumlah_transaksi < 0) {
            $side = $side === 'D' ? 'K' : 'D';
        }

        $details[] = [
            'id_transaksi'          => $trx->id_transaksi,
            'id_jenisAkunTransaksi' => $akunId,
            'debit'                 => $side === 'D' ? $full : 0,
            'kredit'                => $side === 'K' ? $full : 0,
        ];
    }

    return $details;
}

}
