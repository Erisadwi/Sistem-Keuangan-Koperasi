<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MasterData\AnggotaController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// API Anggota
Route::get('/anggota', [AnggotaController::class, 'apiIndex']);
Route::post('/anggota/store', [AnggotaController::class, 'apiStore']);
