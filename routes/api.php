<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MasterData\AnggotaController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiPengeluaranController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiPemasukanController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiTransferController;
use App\Http\Controllers\Admin\TransaksiNonKas\TransaksiNonKasController;
use App\Http\Controllers\Admin\Simpanan\SetoranTunaiController;
use App\Http\Controllers\Admin\Pinjaman\AngsuranController;
use App\Http\Controllers\Admin\Pinjaman\PinjamanLunasController;
use App\Http\Controllers\Admin\Laporan\LaporanBukuBesarController;
use App\Http\Controllers\Admin\Laporan\LaporanJatuhTempoController;
use App\Http\Controllers\Admin\Laporan\LaporanNeracaSaldoController;
use App\Http\Controllers\Anggota\LaporanPembayaranController;
use App\Http\Controllers\Anggota\LaporanPinjamanController;
use App\Http\Controllers\Anggota\LaporanSimpananController;
use App\Http\Controllers\Admin\Simpanan\PenarikanTunaiController;
use App\Http\Controllers\Admin\Pinjaman\DataPinjamanController;
use App\Http\Controllers\Admin\Laporan\LaporanNeracaController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// API Anggota
Route::get('/anggota', [AnggotaController::class, 'apiIndex']);
Route::post('/anggota', [AnggotaController::class, 'apiStore']);
Route::put('/anggota/{id}', [AnggotaController::class, 'apiUpdate']);
Route::delete('/anggota/{id}', [AnggotaController::class, 'apiDestroy']);

Route::get('/transfer', [TransaksiTransferController::class, 'apiIndex']);     
Route::post('/transfer', [TransaksiTransferController::class, 'apiStore']);    
Route::put('/transfer/{id}', [TransaksiTransferController::class, 'apiUpdate']); 
Route::delete('/transfer/{id}', [TransaksiTransferController::class, 'apiDestroy']);

Route::get('/pemasukan', [TransaksiPemasukanController::class, 'apiIndex']);
Route::post('/pemasukan', [TransaksiPemasukanController::class, 'apiStore']);
Route::put('/pemasukan/{id}', [TransaksiPemasukanController::class, 'apiUpdate']);
Route::delete('/pemasukan/{id}', [TransaksiPemasukanController::class, 'apiDestroy']);

Route::get('/pengeluaran', [TransaksiPengeluaranController::class, 'apiIndex']);
Route::post('/pengeluaran', [TransaksiPengeluaranController::class, 'apiStore']);
Route::put('/pengeluaran/{id}', [TransaksiPengeluaranController::class, 'apiUpdate']);
Route::delete('/pengeluaran/{id}', [TransaksiPengeluaranController::class, 'apiDestroy']);

Route::get('/nonKas', [TransaksiNonKasController::class, 'apiIndex']);
Route::post('/nonKas', [TransaksiNonKasController::class, 'apiStore']);
Route::put('/nonKas/{id}', [TransaksiNonKasController::class, 'apiUpdate']);
Route::delete('/nonKas/{id}', [TransaksiNonKasController::class, 'apiDestroy']);

Route::get('/setoran', [SetoranTunaiController::class, 'apiIndex']);
Route::post('/setoran', [SetoranTunaiController::class, 'apiStore']);
Route::put('/setoran/{id}', [SetoranTunaiController::class, 'apiUpdate']);
Route::delete('/setoran/{id}', [SetoranTunaiController::class, 'apiDestroy']);
Route::get('/setoran/{id}/nota', [SetoranTunaiController::class, 'apiNota']);

Route::get('/angsuran', [AngsuranController::class, 'apiIndex']);

Route::get('/pinjaman-lunas', [PinjamanLunasController::class, 'apiIndex']);
Route::get('/pinjaman-lunas/{kode_transaksi}', [PinjamanLunasController::class, 'apiDetail']);
Route::get('/pinjaman-lunas/{id_bayar_angsuran}/nota', [PinjamanLunasController::class, 'apiNota']);

Route::get('/buku-besar', [LaporanBukuBesarController::class, 'apiIndex']);

Route::get('/neraca-saldo', [LaporanNeracaSaldoController::class, 'apiIndex']);

Route::get('/jatuh-tempo', [LaporanJatuhTempoController::class, 'apiIndex']);

Route::get('/laporan-pembayaran', [LaporanPembayaranController::class, 'apiIndex']);

Route::get('/laporan-pinjaman', [LaporanPinjamanController::class, 'apiIndex']);

Route::get('/laporan-simpanan', [LaporanSimpananController::class, 'apiIndex']);

Route::get('/penarikan', [PenarikanTunaiController::class, 'apiIndex']);
Route::post('/penarikan', [PenarikanTunaiController::class, 'apiStore']);
Route::put('/penarikan/{id}', [PenarikanTunaiController::class, 'apiUpdate']);
Route::delete('/penarikan/{id}', [PenarikanTunaiController::class, 'apiDestroy']);
Route::get('/penarikan/{id}/nota', [PenarikanTunaiController::class, 'apiNota']);

Route::get('/pinjaman', [DataPinjamanController::class, 'apiIndex']);
Route::post('/pinjaman', [DataPinjamanController::class, 'apiStore']);
Route::get('/pinjaman/{id}', [DataPinjamanController::class, 'apiShow']);
Route::put('/pinjaman/{id}', [DataPinjamanController::class, 'apiUpdate']);
Route::get('/pinjaman/{id}/nota', [DataPinjamanController::class, 'apiNota']);

Route::get('/neraca', [LaporanNeracaController::class, 'apiIndex']);


