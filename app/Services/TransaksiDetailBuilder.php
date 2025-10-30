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
            // bersihkan detail lama
            $trx->details()->delete();

            $rules = config("transaksi.{$trx->type_transaksi}") ?? config('transaksi.default');
            $full  = abs((float) $trx->jumlah_transaksi);

            foreach ($rules as $row) {
                // pilih akun: 'tujuan' atau 'sumber'
                $akunId = $row['akun'] === 'tujuan'
                    ? $trx->id_jenisAkunTransaksi_tujuan
                    : $trx->id_jenisAkunTransaksi_sumber;

                if (!$akunId || $full <= 0) continue;

                // sisi D/K
                $side = $row['side'];
                if ((float)$trx->jumlah_transaksi < 0) {
                    // kalau amount negatif, tukar sisi agar makna akuntansi tetap benar
                    $side = $side === 'D' ? 'K' : 'D';
                }

                DetailTransaksi::create([
                    'id_transaksi'          => $trx->id_transaksi,
                    'id_jenisAkunTransaksi' => $akunId,
                    'debit'                 => $side === 'D' ? $full : 0,
                    'kredit'                => $side === 'K' ? $full : 0,
                ]);
            }

            // (opsional) validasi balance
            // $sumD = $trx->details()->sum('debit');
            // $sumK = $trx->details()->sum('kredit');
            // if ($sumD !== $sumK) throw new \RuntimeException('Jurnal tidak seimbang');
        });
    }
}
