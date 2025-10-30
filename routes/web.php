<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\MasterData\UserController;
use App\Http\Controllers\Admin\MasterData\RoleController;
use App\Http\Controllers\Admin\MasterData\JenisBarangController;
use App\Http\Controllers\Admin\MasterData\JenisSimpananController;
use App\Http\Controllers\Admin\MasterData\JenisAkunTransaksiController;
use App\Http\Controllers\Admin\MasterData\LamaAngsuranController;
use App\Http\Controllers\Admin\MasterData\AnggotaController;
use App\Http\Controllers\Admin\setting\SukuBungaController;
use App\Http\Controllers\Admin\setting\identitasKoperasiController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiPemasukanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\MasterData\SaldoAwalKasController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


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

    Route::get('jenis-akun-transaksi', [JenisAkunTransaksiController::class, 'index'])->name('jenis-akun-transaksi.index');
    Route::get('jenis-akun-transaksi/create', [JenisAkunTransaksiController::class, 'create'])->name('jenis-akun-transaksi.create');
    Route::post('jenis-akun-transaksi', [JenisAkunTransaksiController::class, 'store'])->name('jenis-akun-transaksi.store');
    Route::get('jenis-akun-transaksi/{id}/edit', [JenisAkunTransaksiController::class, 'edit'])->name('jenis-akun-transaksi.edit');
    Route::put('jenis-akun-transaksi/{id}', [JenisAkunTransaksiController::class, 'update'])->name('jenis-akun-transaksi.update');

    Route::get('lama-angsuran', [LamaAngsuranController::class, 'index'])->name('lama-angsuran.index');
    Route::get('lama-angsuran/create', [LamaAngsuranController::class, 'create'])->name('lama-angsuran.create');
    Route::post('lama-angsuran', [LamaAngsuranController::class, 'store'])->name('lama-angsuran.store');
    Route::get('lama-angsuran/{id}/edit', [LamaAngsuranController::class, 'edit'])->name('lama-angsuran.edit');
    Route::put('lama-angsuran/{id}', [LamaAngsuranController::class, 'update'])->name('lama-angsuran.update');
    Route::delete('lama-angsuran/{id}', [LamaAngsuranController::class, 'destroy'])->name('lama-angsuran.destroy');

    Route::get('anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    Route::get('users', [UserController::class, 'index'])->name('data-user.index');
    Route::get('users/create', [UserController::class, 'create'])->name('data-user.create');
    Route::post('users', [UserController::class, 'store'])->name('data-user.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('data-user.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('data-user.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('data-user.destroy');

    Route::get('saldo-awal-kas', [SaldoAwalKasController::class, 'index'])->name('saldo-awal-kas.index');
    Route::get('saldo-awal-kas/create', [SaldoAwalKasController::class, 'create'])->name('saldo-awal-kas.create');
    Route::post('saldo-awal-kas', [SaldoAwalKasController::class, 'store'])->name('saldo-awal-kas.store');
    Route::get('saldo-awal-kas/{id}/edit', [SaldoAwalKasController::class, 'edit'])->name('saldo-awal-kas.edit');
    Route::put('saldo-awal-kas/{id}', [SaldoAwalKasController::class, 'update'])->name('saldo-awal-kas.update');


});

Route::prefix('admin/setting')->group(function () {
    Route::get('identitas-koperasi/edit', [identitasKoperasiController::class, 'edit'])->name('identitas-koperasi.editSingle');
    Route::put('identitas-koperasi/', [identitasKoperasiController::class, 'update'])->name('identitas-koperasi.updateSingle');
    
    Route::get('identitas/logo/{nama_koperasi}', [IdentitasKoperasiController::class, 'showLogo'])
    ->name('identitas.logo');

    Route::get('suku-bunga/edit', [SukuBungaController::class, 'edit'])->name('suku-bunga.editSingle');
    Route::put('suku-bunga/', [SukuBungaController::class, 'update'])->name('suku-bunga.updateSingle');
});

Route::get('/test-logo', [App\Http\Controllers\Admin\setting\identitasKoperasiController::class, 'testBlob']);

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('transaksi-pemasukan', TransaksiPemasukanController::class);
});
Route::get('admin/transaksi_kas/pemasukan/download', [TransaksiPemasukanController::class, 'download'])
    ->name('transaksi-pemasukan.download');


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

