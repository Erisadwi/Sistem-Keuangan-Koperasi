<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\JenisAkunTransaksi;

class TransaksiPemasukanTest extends TestCase
{
    protected $user;
    protected $akunKas;
    protected $akunSumber;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil user yang sudah ada
        $this->user = User::first();
        $this->assertNotNull($this->user, "User tidak ditemukan di database.");

        // Ambil akun kas dan akun sumber yang sudah ada
        $this->akunKas = JenisAkunTransaksi::where('is_kas', 1)->first();
        $this->assertNotNull($this->akunKas, "Akun kas tidak ditemukan di database.");

        $this->akunSumber = JenisAkunTransaksi::where('is_kas', 0)->first();
        $this->assertNotNull($this->akunSumber, "Akun sumber tidak ditemukan di database.");

        // Supaya tidak redirect ke /login
        $this->actingAs($this->user, 'user');
    }

    /** @test */
    public function test_store_transaksi_pemasukan()
    {
        $payload = [
            'tanggal_transaksi' => '2025-01-01',
            'ket_transaksi' => 'Pemasukan Test',
            'id_akun_tujuan' => $this->akunKas->id_jenisAkunTransaksi,
            'sumber' => [
                [
                    'id_jenisAkunTransaksi' => $this->akunSumber->id_jenisAkunTransaksi,
                    'jumlah' => 10000
                ]
            ]
        ];

        $response = $this->post(route('transaksi-pemasukan.store'), $payload);

        $response->assertRedirect(route('transaksi-pemasukan.index'));

        // Ambil transaksi terakhir
        $transaksi = Transaksi::latest('id_transaksi')->first();

        $this->assertNotNull($transaksi, "Transaksi tidak tersimpan di database.");
        $this->assertEquals('Pemasukan Test', $transaksi->ket_transaksi);
        $this->assertEquals(10000, $transaksi->total_debit);
        $this->assertEquals(10000, $transaksi->total_kredit);

        // Cek detail
        $this->assertDatabaseHas('detail_transaksi', [
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $this->akunSumber->id_jenisAkunTransaksi,
            'kredit' => 10000
        ]);

        $this->assertDatabaseHas('detail_transaksi', [
            'id_transaksi' => $transaksi->id_transaksi,
            'id_jenisAkunTransaksi' => $this->akunKas->id_jenisAkunTransaksi,
            'debit' => 10000
        ]);

        // Update kode_transaksi setelah insert
        $transaksi->kode_transaksi = $transaksi->type_transaksi . $transaksi->id_transaksi;
        $transaksi->save();

        $this->assertStringStartsWith($transaksi->type_transaksi, $transaksi->kode_transaksi);
    }

 /** @test */
public function test_update_transaksi_pemasukan()
{

    $kode_transaksi = 'TKD' . now()->timestamp;

    $transaksi = Transaksi::create([
        'type_transaksi' => 'TKD',
        'id_user' => $this->user->id_user,
        'total_debit' => 5000,
        'total_kredit' => 5000,
        'kode_transaksi' => $kode_transaksi,
    ]);

    // Buat detail transaksi awal
    DetailTransaksi::create([
        'id_transaksi' => (string)$transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunSumber->id_jenisAkunTransaksi,
        'kredit' => 5000,
        'debit' => 0
    ]);

    DetailTransaksi::create([
        'id_transaksi' => (string)$transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunKas->id_jenisAkunTransaksi,
        'debit' => 5000,
        'kredit' => 0
    ]);

    // Payload update
    $payload = [
        'tanggal_transaksi' => '2025-02-01',
        'ket_transaksi' => 'Updated',
        'id_akun_tujuan' => $this->akunKas->id_jenisAkunTransaksi,
        'sumber' => [
            [
                'id_jenisAkunTransaksi' => $this->akunSumber->id_jenisAkunTransaksi,
                'jumlah' => 20000
            ]
        ]
    ];

    // Lakukan update
    $response = $this->put(route('transaksi-pemasukan.update', (string)$transaksi->id_transaksi), $payload);
    $response->assertRedirect(route('transaksi-pemasukan.index'));

    // Cek database transaksi
    $this->assertDatabaseHas('transaksi', [
        'id_transaksi' => (string)$transaksi->id_transaksi,
        'total_debit' => 20000,
        'total_kredit' => 20000,
        'ket_transaksi' => 'Updated'
    ]);

    // Cek database detail transaksi
    $this->assertDatabaseHas('detail_transaksi', [
        'id_transaksi' => (string)$transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunSumber->id_jenisAkunTransaksi,
        'kredit' => 20000,
        'debit' => 0
    ]);

    $this->assertDatabaseHas('detail_transaksi', [
        'id_transaksi' => (string)$transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunKas->id_jenisAkunTransaksi,
        'debit' => 20000,
        'kredit' => 0
    ]);

    // Cek akun_relasi_transaksi juga
    $this->assertDatabaseHas('akun_relasi_transaksi', [
        'id_transaksi' => (string)$transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunSumber->id_jenisAkunTransaksi
    ]);

    $this->assertDatabaseHas('akun_relasi_transaksi', [
        'id_transaksi' => (string)$transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunKas->id_jenisAkunTransaksi
    ]);
}


/** @test */
public function test_delete_transaksi_pemasukan()
{
    // Buat kode transaksi langsung
    $kode_transaksi = 'TKD' . now()->timestamp;

    // Buat transaksi baru dengan kode_transaksi
    $transaksi = Transaksi::create([
        'type_transaksi' => 'TKD',
        'id_user' => $this->user->id_user,
        'total_debit' => 5000,
        'total_kredit' => 5000,
        'kode_transaksi' => $kode_transaksi, // ✅ penting supaya tidak error
    ]);

    // Buat detail transaksi awal
    DetailTransaksi::create([
        'id_transaksi' => $transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunSumber->id_jenisAkunTransaksi,
        'kredit' => 5000
    ]);

    DetailTransaksi::create([
        'id_transaksi' => $transaksi->id_transaksi,
        'id_jenisAkunTransaksi' => $this->akunKas->id_jenisAkunTransaksi,
        'debit' => 5000
    ]);

    // Delete transaksi
    $response = $this->delete(route('transaksi-pemasukan.destroy', $transaksi->id_transaksi));
    $response->assertRedirect(route('transaksi-pemasukan.index'));

    // Pastikan transaksi hilang
    $this->assertDatabaseMissing('transaksi', [
        'id_transaksi' => $transaksi->id_transaksi
    ]);

    // Pastikan detail transaksi juga hilang
    $this->assertDatabaseMissing('detail_transaksi', [
        'id_transaksi' => $transaksi->id_transaksi
    ]);
}
}