<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MasterData\AnggotaController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/anggota', [AnggotaController::class, 'apiIndex']);
Route::post('/anggota', [AnggotaController::class, 'apiStore']);

