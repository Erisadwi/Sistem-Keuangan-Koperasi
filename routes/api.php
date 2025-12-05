<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MasterData\AnggotaController;
use App\Http\Controllers\Admin\Simpanan\SetoranTunaiController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiPengeluaranController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiTransferController;

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

// API Transaksi kas-pengeluaran
Route::get('/pengeluaran', [TransaksiPengeluaranController::class, 'apiIndex']);
Route::post('/pengeluaran', [TransaksiPengeluaranController::class, 'apiStore']);
Route::put('/pengeluaran/{id}', [TransaksiPengeluaranController::class, 'apiUpdate']);
Route::delete('/pengeluaran/{id}', [TransaksiPengeluaranController::class, 'apiDestroy']);

// API Simpanan-setoran tunai
Route::get('/setoran', [SetoranTunaiController::class, 'apiIndex']);
Route::post('/setoran', [SetoranTunaiController::class, 'apiStore']);
Route::put('/setoran/{id}', [SetoranTunaiController::class, 'apiUpdate']);
Route::delete('/setoran/{id}', [SetoranTunaiController::class, 'apiDestroy']);



