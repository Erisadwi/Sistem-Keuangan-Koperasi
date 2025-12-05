<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MasterData\AnggotaController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiTransferController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// API Anggota
Route::get('/anggota', [AnggotaController::class, 'apiIndex']);
Route::post('/anggota/store', [AnggotaController::class, 'apiStore']);

Route::get('/transfer', [TransaksiTransferController::class, 'apiIndex']);     
Route::post('/transfer', [TransaksiTransferController::class, 'apiStore']);    
Route::put('/transfer/{id}', [TransaksiTransferController::class, 'apiUpdate']); 
Route::delete('/transfer/{id}', [TransaksiTransferController::class, 'apiDestroy']); 

