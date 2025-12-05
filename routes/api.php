<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MasterData\AnggotaController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiTransferController;
use App\Http\Controllers\Admin\Simpanan\PenarikanTunaiController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/anggota', [AnggotaController::class, 'apiIndex']);
Route::post('/anggota', [AnggotaController::class, 'apiStore']);

Route::get('/transfer', [TransaksiTransferController::class, 'apiIndex']);     
Route::post('/transfer', [TransaksiTransferController::class, 'apiStore']);    
Route::put('/transfer/{id}', [TransaksiTransferController::class, 'apiUpdate']); 
Route::delete('/transfer/{id}', [TransaksiTransferController::class, 'apiDestroy']); 

Route::get('/penarikan-tunai', [PenarikanTunaiController::class, 'apiIndex']);
Route::post('/penarikan-tunai', [PenarikanTunaiController::class, 'apiStore']);
Route::put('/penarikan-tunai/{id}', [PenarikanTunaiController::class, 'apiUpdate']);
Route::delete('/penarikan-tunai/{id}', [PenarikanTunaiController::class, 'apiDestroy']);