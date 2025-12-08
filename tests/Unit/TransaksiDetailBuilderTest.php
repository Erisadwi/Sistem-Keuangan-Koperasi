<?php

namespace Tests\Unit;

use App\Models\Transaksi;
use App\Services\TransaksiDetailBuilder;
use Tests\TestCase;

class TransaksiDetailBuilderTest extends TestCase
{
    /** @test */
    public function it_builds_details_correctly_for_positive_amount()
    {
        config()->set('transaksi.test', [
            ['akun' => 'tujuan', 'side' => 'D'],
            ['akun' => 'sumber', 'side' => 'K'],
        ]);

        $trx = new Transaksi();
        $trx->id_transaksi = 1;
        $trx->jumlah_transaksi = 10000;
        $trx->id_jenisAkunTransaksi_tujuan = 10;
        $trx->id_jenisAkunTransaksi_sumber = 20;
        $trx->type_transaksi = 'test';

        $builder = new TransaksiDetailBuilder();
        $result = $builder->buildInline($trx);

        $this->assertEquals(10, $result[0]['id_jenisAkunTransaksi']);
        $this->assertEquals(10000, $result[0]['debit']);
        $this->assertEquals(0, $result[0]['kredit']);

        $this->assertEquals(20, $result[1]['id_jenisAkunTransaksi']);
        $this->assertEquals(0, $result[1]['debit']);
        $this->assertEquals(10000, $result[1]['kredit']);
    }

    /** @test */
    public function it_reverses_for_negative_amount()
    {
        config()->set('transaksi.test', [
            ['akun' => 'tujuan', 'side' => 'D'],
            ['akun' => 'sumber', 'side' => 'K'],
        ]);

        $trx = new Transaksi();
        $trx->id_transaksi = 1;
        $trx->jumlah_transaksi = -5000;
        $trx->id_jenisAkunTransaksi_tujuan = 10;
        $trx->id_jenisAkunTransaksi_sumber = 20;
        $trx->type_transaksi = 'test';

        $builder = new TransaksiDetailBuilder();
        $result = $builder->buildInline($trx);

        $this->assertEquals(10, $result[0]['id_jenisAkunTransaksi']);
        $this->assertEquals(0, $result[0]['debit']);
        $this->assertEquals(5000, $result[0]['kredit']);
    }

    /** @test */
    public function it_skips_null_account()
    {
        config()->set('transaksi.test', [
            ['akun' => 'tujuan', 'side' => 'D'],
            ['akun' => 'sumber', 'side' => 'K'],
        ]);

        $trx = new Transaksi();
        $trx->id_transaksi = 1;
        $trx->jumlah_transaksi = 5000;
        $trx->id_jenisAkunTransaksi_tujuan = null;
        $trx->id_jenisAkunTransaksi_sumber = 20;
        $trx->type_transaksi = 'test';

        $builder = new TransaksiDetailBuilder();
        $result = $builder->buildInline($trx);

        $this->assertCount(1, $result);
        $this->assertEquals(20, $result[0]['id_jenisAkunTransaksi']);
    }
}
