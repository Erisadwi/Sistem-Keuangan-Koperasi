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

Route::get('/admin/pinjaman/data-pengajuan', function () {
    return view('admin.pinjaman.data-pengajuan');
})->name('admin.pinjaman.data-pengajuan');

Route::get('/admin/transaksi_kas/pemasukan', function () {
    return view('admin.transaksi_kas.pemasukan');
})->name('admin.transaksi_kas.pemasukan');

Route::get('/admin/master_data/jenis-akun-transaksi', function () {
    return view('admin.master_data.jenis-akun-transaksi');
})->name('admin.master_data.jenis-akun-transaksi');

Route::get('/admin/master_data/tambah-data-jenis-akun-transaksi', function () {
    return view('admin.master_data.tambah-data-jenis-akun-transaksi');
})->name('admin.master_data.tambah-data-jenis-akun-transaksi');

Route::get('/admin/master_data/edit-data-jenis-akun-transaksi', function () {
    return view('admin.master_data.edit-data-jenis-akun-transaksi');
})->name('admin.master_data.edit-data-jenis-akun-transaksi');

Route::get('/admin/master_data/data-anggota', function () {
    return view('admin.master_data.data-anggota');
})->name('admin.master_data.data-anggota');

Route::get('/admin/master_data/tambah-data-anggota', function () {
    return view('admin.master_data.tambah-data-anggota');
})->name('admin.master_data.tambah-data-anggota');

Route::get('/admin/master_data/edit-data-anggota', function () {
    return view('admin.master_data.edit-data-anggota');
})->name('admin.master_data.edit-data-anggota');

Route::get('/anggota/notifikasi', function () {
    return view('anggota.notifikasi');
})->name('anggota.notifikasi');

Route::get('/anggota/profil/profilAnggota', function () {
    return view('anggota.profil.profilAnggota');
})->name('anggota.profil.profilAnggota');

Route::get('/admin/transaksi_kas/pengeluaran', function () {
    return view('admin.transaksi_kas.pengeluaran');
})->name('admin.transaksi_kas.pengeluaran');

Route::get('/admin/transaksi_kas/tambah-pengeluaran', function () {
    return view('admin.transaksi_kas.tambah-pengeluaran');
})->name('admin.transaksi_kas.tambah-pengeluaran');

Route::get('/admin/transaksi_kas/edit-pengeluaran', function () {
    return view('admin.transaksi_kas.edit-pengeluaran');
})->name('admin.transaksi_kas.edit-pengeluaran');

Route::get('/admin/transaksi_non_kas/transaksi', function () {
    return view('admin.transaksi_non_kas.transaksi');
})->name('admin.transaksi_non_kas.transaksi');

Route::get('/admin/pinjaman/tambah-bayar-angsuran', function () {
    return view('admin.pinjaman.tambah-bayar-angsuran');
})->name('admin.pinjaman.tambah-bayar-angsuran');

Route::get('/admin/pinjaman/edit-bayar-angsuran', function () {
    return view('admin.pinjaman.edit-bayar-angsuran');
})->name('admin.pinjaman.edit-bayar-angsuran');

Route::get('/admin/laporan/laporan-laba-rugi', function () {
    return view('admin.laporan.laporan-laba-rugi');
})->name('admin.laporan.laporan-laba-rugi');

Route::get('/admin/profil/beranda-profil', function () {
    return view('admin.profil.beranda-profil');
})->name('admin.profil.beranda-profil');

Route::get('/admin/transaksi_kas/tambah-transfer', function () {
    return view('admin.transaksi_kas.tambah-transfer');
})->name('admin.transaksi_kas.tambah-transfer');

Route::get('/admin/transaksi_kas/transfer', function () {
    return view('admin.transaksi_kas.transfer');
})->name('admin.transaksi_kas.transfer');

Route::get('/admin/transaksi_kas/edit-transfer', function () {
    return view('admin.transaksi_kas.edit-transfer');
})->name('admin.transaksi_kas.edit-transfer');

Route::get('/admin/laporan/laporan-neraca', function () {
    return view('admin.laporan.laporan-neraca');
})->name('admin.laporan.laporan-neraca');

Route::get('/admin/laporan/laporan-kas-simpanan', function () {
    return view('admin.laporan.laporan-kas-simpanan');
})->name('admin.laporan.laporan-kas-simpanan');

Route::get('/admin/laporan/laporan-kas-pinjaman', function () {
    return view('admin.laporan.laporan-kas-pinjaman');
})->name('admin.laporan.laporan-kas-pinjaman');

Route::get('/admin/master_data/saldo-awal-non-kas', function () {
    return view('admin.master_data.saldo-awal-non-kas');
})->name('admin.master_data.saldo-awal-non-kas');

Route::get('/admin/master_data/tambah-data-saldo-awal-non-kas', function () {
    return view('admin.master_data.tambah-data-saldo-awal-non-kas');
})->name('admin.master_data.tambah-data-saldo-awal-non-kas');

Route::get('/admin/master_data/edit-data-saldo-awal-non-kas', function () {
    return view('admin.master_data.edit-data-saldo-awal-non-kas');
})->name('admin.master_data.edit-data-saldo-awal-non-kas');

Route::get('/admin/master_data/lama-angsuran', function () {
    return view('admin.master_data.lama-angsuran');
})->name('admin.master_data.lama-angsuran');

Route::get('/admin/master_data/tambah-data-lama-angsuran', function () {
    return view('admin.master_data.tambah-data-lama-angsuran');
})->name('admin.master_data.tambah-data-lama-angsuran');

Route::get('/admin/master_data/edit-data-lama-angsuran', function () {
    return view('admin.master_data.edit-data-lama-angsuran');
})->name('admin.master_data.edit-data-lama-angsuran');

Route::get('/admin/master_data/data-pengguna', function () {
    return view('admin.master_data.data-pengguna');
})->name('admin.master_data.data-pengguna');

Route::get('/admin/master_data/tambah-data-pengguna', function () {
    return view('admin.master_data.tambah-data-pengguna');
})->name('admin.master_data.tambah-data-pengguna');

Route::get('/admin/master_data/edit-data-pengguna', function () {
    return view('admin.master_data.edit-data-pengguna');
})->name('admin.master_data.edit-data-pengguna');

Route::get('/admin/simpanan/setoran-tunai', function () {
    return view('admin.simpanan.setoran-tunai');
})->name('admin.simpanan.setoran-tunai');

Route::get('/admin/simpanan/tambah-setoran-tunai', function () {
    return view('admin.simpanan.tambah-setoran-tunai');
})->name('admin.simpanan.tambah-setoran-tunai');

Route::get('/admin/simpanan/edit-setoran-tunai', function () {
    return view('admin.simpanan.edit-setoran-tunai');
})->name('admin.simpanan.edit-setoran-tunai');

Route::get('/admin/pinjaman/angsuran', function () {
    return view('admin.pinjaman.angsuran');
})->name('admin.pinjaman.angsuran');

Route::get('/admin/pinjaman/pinjaman-lunas', function () {
    return view('admin.pinjaman.pinjaman-lunas');
})->name('admin.pinjaman.pinjaman-lunas');

Route::get('/admin/simpanan/penarikan-tunai', function () {
    return view('admin.simpanan.penarikan-tunai');
})->name('admin.simpanan.penarikan-tunai');

Route::get('/admin/simpanan/tambah-penarikan-tunai', function () {
    return view('admin.simpanan.tambah-penarikan-tunai');
})->name('admin.simpanan.tambah-penarikan-tunai');

Route::get('/admin/simpanan/edit-penarikan-tunai', function () {
    return view('admin.simpanan.edit-penarikan-tunai');
})->name('admin.simpanan.edit-penarikan-tunai');