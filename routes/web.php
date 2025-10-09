<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('login');
});

Route::get('/anggota/beranda', function () {
    return view('anggota.beranda');
})->name('anggota.beranda');
