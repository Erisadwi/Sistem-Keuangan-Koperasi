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

Route::get('/anggota/data-pengajuan', function () {
    return view('anggota.data-pengajuan');
})->name('anggota.data-pengajuan');

Route::get('/anggota/test', function () {
    return view('anggota.test');
})->name('anggota.test');

Route::get('/admin/laporan/laporan-saldo-kas', function () {
    return view('admin.laporan.laporan-saldo-kas');
})->name('admin.laporan.laporan-saldo-kas');

Route::get('/anggota/laporan-pinjaman', function () {
    return view('anggota.laporan-pinjaman');
})->name('anggota.laporan-pinjaman');

Route::get('/anggota/laporan-pembayaran', function () {
    return view('anggota.laporan-pembayaran');
})->name('anggota.laporan-pembayaran');

Route::get('/admin/laporan/laporan-SHU', function () {
    return view('admin.laporan.laporan-SHU');
})->name('admin.laporan.laporan-SHU');

Route::get('/admin/master_data/jenis-simpanan', function () {
    return view('admin.master_data.jenis-simpanan');
})->name('admin.master_data.jenis-simpanan');

Route::get('/admin/master_data/data-barang', function () {
    return view('admin.master_data.data-barang');
})->name('admin.master_data.data-barang');

Route::get('/admin/setting/identitas-koperasi', function () {
    return view('admin.setting.identitas-koperasi');
})->name('admin.setting.identitas-koperasi');

Route::get('/admin/laporan/laporan-jatuh-tempo', function () {
    return view('admin.laporan.laporan-jatuh-tempo');
})->name('admin.laporan.laporan-jatuh-tempo');

Route::get('/admin/laporan/laporan-buku-besar', function () {
    return view('admin.laporan.laporan-buku-besar');
})->name('admin.laporan.laporan-buku-besar');

Route::get('/admin/laporan/laporan-neraca-saldo', function () {
    return view('admin.laporan.laporan-neraca-saldo');
})->name('admin.laporan.laporan-neraca-saldo');

Route::get('/admin/setting/suku-bunga', function () {
    return view('admin.setting.suku-bunga'); 
})->name('admin.setting.suku-bunga');

Route::get('/admin/transaksi_non_kas/tambah-transaksi', function () {
    return view('admin.transaksi_non_kas.tambah-transaksi');
})->name('admin.transaksi_non_kas.tambah-transaksi');

Route::get('/admin/transaksi_non_kas/edit-transaksi', function () {
    return view('admin.transaksi_non_kas.edit-transaksi');
})->name('admin.transaksi_non_kas.edit-transaksi');

Route::get('/admin/transaksi_kas/tambah-pemasukan', function () {
    return view('admin.transaksi_kas.tambah-pemasukan');
})->name('admin.transaksi_kas.tambah-pemasukan');

Route::get('/admin/transaksi_kas/edit-pemasukan', function () {
    return view('admin.transaksi_kas.edit-pemasukan');
})->name('admin.transaksi_kas.edit-pemasukan');

Route::get('/admin/master_data/tambah-data-barang', function () {
    return view('admin.master_data.tambah-data-barang');
})->name('admin.master_data.tambah-data-barang');

Route::get('/admin/master_data/edit-data-barang', function () {
    return view('admin.master_data.edit-data-barang');
})->name('admin.master_data.edit-data-barang');

Route::get('/admin/master_data/tambah-jenis-simpanan', function () {
    return view('admin.master_data.tambah-jenis-simpanan');
})->name('admin.master_data.tambah-jenis-simpanan');

Route::get('/admin/master_data/edit-jenis-simpanan', function () {
    return view('admin.master_data.edit-jenis-simpanan');
})->name('admin.master_data.edit-jenis-simpanan');

Route::get('/admin/master_data/saldo-awal-kas', function () {
    return view('admin.master_data.saldo-awal-kas');
})->name('admin.master_data.saldo-awal-kas');

Route::get('/admin/master_data/tambah-data-saldo-awal-kas', function () {
    return view('admin.master_data.tambah-data-saldo-awal-kas');
})->name('admin.master_data.tambah-data-saldo-awal-kas');

Route::get('/admin/master_data/edit-data-saldo-awal-kas', function () {
    return view('admin.master_data.edit-data-saldo-awal-kas');
})->name('admin.master_data.edit-data-saldo-awal-kas');
