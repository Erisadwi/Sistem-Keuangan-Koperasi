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

Route::get('/anggota/profil/editProfil', function () {
    return view('anggota.profil.editProfil');
})->name('anggota.profil.editProfil');

Route::get('/anggota/lap-SHU', function () {
    return view('anggota.lap-SHU');
})->name('anggota.lap-SHU');

Route::get('/anggota/data-pengajuan', function () {
    return view('anggota.data-pengajuan');
})->name('anggota.data-pengajuan');