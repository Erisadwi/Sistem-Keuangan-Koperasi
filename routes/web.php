<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('anggota.login');
});

Route::get('/anggota/beranda', function () {
    return view('anggota.beranda');
})->name('anggota.beranda');

Route::get('/anggota/laporan-simpanan', function () {
    return view('anggota.laporan-simpanan');
})->name('anggota.laporan-simpanan');
Route::get('/anggota/profil/editProfil', function () {
    return view('anggota.profil.editProfil');
})->name('anggota.profil.editProfil');

Route::get('/anggota/lap-SHU', function () {
    return view('anggota.lap-SHU');
})->name('anggota.lap-SHU');

Route::get('/anggota/dataPengajuan', function () {
    return view('anggota.dataPengajuan');
})->name('anggota.dataPengajuan');
