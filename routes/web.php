<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\MasterData\JenisBarangController;
use App\Http\Controllers\Admin\MasterData\JenisSimpananController;
use App\Http\Controllers\Admin\setting\SukuBungaController;
use App\Http\Controllers\Admin\setting\identitasKoperasiController;
use App\Models\identitasKoperasi;

Route::prefix('admin/master_data')->group(function () {
    Route::get('jenis-simpanan', [JenisSimpananController::class, 'index'])->name('jenis-simpanan.index');
    Route::get('jenis-simpanan/create', [JenisSimpananController::class, 'create'])->name('jenis-simpanan.create');
    Route::post('jenis-simpanan', [JenisSimpananController::class, 'store'])->name('jenis-simpanan.store');
    Route::get('jenis-simpanan/{id}/edit', [JenisSimpananController::class, 'edit'])->name('jenis-simpanan.edit');
    Route::put('jenis-simpanan/{id}', [JenisSimpananController::class, 'update'])->name('jenis-simpanan.update');
    Route::delete('jenis-simpanan/{id}', [JenisSimpananController::class, 'destroy'])->name('jenis-simpanan.destroy');

    Route::get('jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang.index');
    Route::get('jenis-barang/create', [JenisBarangController::class, 'create'])->name('jenis-barang.create');
    Route::post('jenis-barang', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
    Route::get('jenis-barang/{id}/edit', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
    Route::put('jenis-barang/{id}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
    Route::delete('jenis-barang/{id}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');
});

Route::prefix('admin/setting')->group(function () {
    Route::get('identitas-koperasi/edit', [identitasKoperasiController::class, 'edit'])->name('identitas-koperasi.edit');
    Route::put('identitas-koperasi/update', [identitasKoperasiController::class, 'update'])->name('identitas-koperasi.update');

    Route::get('suku-bunga/edit', [SukuBungaController::class, 'edit'])->name('suku-bunga.editSingle');
    Route::put('suku-bunga/', [SukuBungaController::class, 'update'])->name('suku-bunga.updateSingle');
});

//Route::get('/', function () {
//    return view('welcome');
//});



Route::get('/', function () {
    return view('login');
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

Route::get('/admin/laporan/laporan-jatuh-tempo', function () {
    return view('admin.laporan.laporan-jatuh-tempo');
})->name('admin.laporan.laporan-jatuh-tempo');

Route::get('/admin/laporan/laporan-buku-besar', function () {
    return view('admin.laporan.laporan-buku-besar');
})->name('admin.laporan.laporan-buku-besar');

Route::get('/admin/laporan/laporan-neraca-saldo', function () {
    return view('admin.laporan.laporan-neraca-saldo');
})->name('admin.laporan.laporan-neraca-saldo');

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

Route::get('/admin/pinjaman/detail-pelunasan', function () {
    return view('admin.pinjaman.detail-pelunasan');
})->name('admin.pinjaman.detail-pelunasan');

Route::get('/admin/simpanan/penarikan-tunai', function () {
    return view('admin.simpanan.penarikan-tunai');
})->name('admin.simpanan.penarikan-tunai');

Route::get('/admin/simpanan/tambah-penarikan-tunai', function () {
    return view('admin.simpanan.tambah-penarikan-tunai');
})->name('admin.simpanan.tambah-penarikan-tunai');

Route::get('/admin/simpanan/edit-penarikan-tunai', function () {
    return view('admin.simpanan.edit-penarikan-tunai');
})->name('admin.simpanan.edit-penarikan-tunai');

Route::get('/admin/beranda', function () {
    return view('admin.beranda');
})->name('admin.beranda');

Route::get('/admin/pinjaman/data-pinjaman', function () {
    return view('admin.pinjaman.data-pinjaman');
})->name('admin.pinjaman.data-pinjaman');

Route::get('/admin/pinjaman/tambah-data-pinjaman', function () {
    return view('admin.pinjaman.tambah-data-pinjaman');
})->name('admin.pinjaman.tambah-data-pinjaman');

Route::get('/admin/pinjaman/edit-data-pinjaman', function () {
    return view('admin.pinjaman.edit-data-pinjaman');
})->name('admin.pinjaman.edit-data-pinjaman');

Route::get('/admin/profil/edit-profil', function () {
    return view('admin.profil.edit-profil');
})->name('admin.profil.edit-edit-profil');

Route::get('/admin/pinjaman/bayar-angsuran', function () {
    return view('admin.pinjaman.bayar-angsuran');
})->name('admin.pinjaman.bayar-angsuran');

Route::get('/admin/pinjaman/detail-peminjaman', function () {
    return view('admin.pinjaman.detail-peminjaman');
})->name('admin.pinjaman.detail-peminjaman');

Route::get('/anggota/tambah-data-pengajuan', function () {
    return view('anggota.tambah-data-pengajuan');
})->name('anggota.tambah-data-pengajuan');

Route::get('/anggota/data-pengajuan-coba', function () {
    return view('anggota.data-pengajuan-coba');
})->name('anggota.data-pengajuan-coba');
