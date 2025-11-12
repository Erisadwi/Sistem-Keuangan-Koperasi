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
use App\Http\Controllers\Admin\TransaksiNonKas\TransaksiNonKasController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\MasterData\SaldoAwalNonKasController;
use App\Http\Controllers\Admin\MasterData\SaldoAwalKasController;
use App\Http\Controllers\DashboardControllerAnggota;
use App\Http\Controllers\Admin\Simpanan\SetoranTunaiController;
use App\Http\Controllers\Anggota\ProfileController;
use App\Http\Controllers\Admin\Simpanan\PenarikanTunaiController;
use App\Http\Controllers\Anggota\AjuanPinjamanController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiPengeluaranController;
use App\Http\Controllers\Admin\TransaksiKas\TransaksiTransferController;
use App\Http\Controllers\Admin\Pinjaman\DataPinjamanController;
use App\Http\Controllers\Admin\Pinjaman\PengajuanPinjamanController;
use App\Http\Controllers\Admin\Pinjaman\AngsuranController;
use App\Http\Controllers\Admin\Pinjaman\PinjamanLunasController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Anggota\LaporanSimpananController;
use App\Http\Controllers\Anggota\LaporanPinjamanController;
use App\Http\Controllers\Anggota\LaporanPembayaranController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/nonaktifkan', [LoginController::class, 'deactivateAccount'])->name('nonaktifkan');

Route::middleware(['auth:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth:anggota'])->group(function () {
    Route::get('/anggota/beranda', [DashboardControllerAnggota::class, 'index'])->name('anggota.beranda');

    Route::get('/profil', [ProfileController::class, 'index'])->name('anggota.profil');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('anggota.profil.edit');
    Route::put('/profil/{id}', [ProfileController::class, 'update'])->name('anggota.profil.update');

    Route::get('/pengajuan', [AjuanPinjamanController::class, 'index'])->name('anggota.pengajuan.index');
    Route::get('/pengajuan/create', [AjuanPinjamanController::class, 'create'])->name('anggota.pengajuan.create');
    Route::post('/pengajuan', [AjuanPinjamanController::class, 'store'])->name('anggota.pengajuan.store');
    Route::post('/pengajuan/simulasi', [AjuanPinjamanController::class, 'simulasi'])->name('anggota.pengajuan.simulasi');

});

Route::middleware(['auth:user'])->prefix('admin')->group(function () {

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');
});

Route::prefix('admin/master_data')->group(function () {
    Route::get('jenis-simpanan', [JenisSimpananController::class, 'index'])->name('jenis-simpanan.index');
    Route::get('jenis-simpanan/create', [JenisSimpananController::class, 'create'])->name('jenis-simpanan.create');
    Route::post('jenis-simpanan', [JenisSimpananController::class, 'store'])->name('jenis-simpanan.store');
    Route::get('jenis-simpanan/{id}/edit', [JenisSimpananController::class, 'edit'])->name('jenis-simpanan.edit');
    Route::put('jenis-simpanan/{id}', [JenisSimpananController::class, 'update'])->name('jenis-simpanan.update');
    Route::delete('jenis-simpanan/{id}', [JenisSimpananController::class, 'destroy'])->name('jenis-simpanan.destroy');
    Route::get('jenis-simpanan/export', [JenisSimpananController::class, 'export'])->name('jenis-simpanan.export');

    Route::get('jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang.index');
    Route::get('jenis-barang/create', [JenisBarangController::class, 'create'])->name('jenis-barang.create');
    Route::post('jenis-barang', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
    Route::get('jenis-barang/{id}/edit', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
    Route::put('jenis-barang/{id}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
    Route::delete('jenis-barang/{id}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');
    Route::get('jenis-barang/export', [JenisBarangController::class, 'export'])->name('jenis-barang-inventaris.export');

    Route::get('jenis-akun-transaksi', [JenisAkunTransaksiController::class, 'index'])->name('jenis-akun-transaksi.index');
    Route::get('jenis-akun-transaksi/create', [JenisAkunTransaksiController::class, 'create'])->name('jenis-akun-transaksi.create');
    Route::post('jenis-akun-transaksi', [JenisAkunTransaksiController::class, 'store'])->name('jenis-akun-transaksi.store');
    Route::get('jenis-akun-transaksi/export', [JenisAkunTransaksiController::class, 'export'])->name('jenis-akun-transaksi.export');
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
    Route::get('anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    Route::get('anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    


    Route::get('users', [UserController::class, 'index'])->name('data-user.index');
    Route::get('users/create', [UserController::class, 'create'])->name('data-user.create');
    Route::post('users', [UserController::class, 'store'])->name('data-user.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('data-user.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('data-user.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('data-user.destroy');

    Route::get('/saldo-awal-non-kas', [SaldoAwalNonKasController::class, 'index'])->name('saldo-awal-non-kas.index');
    Route::get('/saldo-awal-non-kas/create', [SaldoAwalNonKasController::class, 'create'])->name('saldo-awal-non-kas.create');
    Route::post('/saldo-awal-non-kas', [SaldoAwalNonKasController::class, 'store'])->name('saldo-awal-non-kas.store');
    Route::get('saldo-awal-non-kas/export', [SaldoAwalNonKasController::class, 'export'])->name('saldo-awal-non-kas.export');
    Route::get('/saldo-awal-non-kas/{id}/edit', [SaldoAwalNonKasController::class, 'edit'])->name('saldo-awal-non-kas.edit');
    Route::put('/saldo-awal-non-kas/{id}', [SaldoAwalNonKasController::class, 'update'])->name('saldo-awal-non-kas.update');

    Route::get('saldo-awal-kas', [SaldoAwalKasController::class, 'index'])->name('saldo-awal-kas.index');
    Route::get('saldo-awal-kas/create', [SaldoAwalKasController::class, 'create'])->name('saldo-awal-kas.create');
    Route::post('saldo-awal-kas', [SaldoAwalKasController::class, 'store'])->name('saldo-awal-kas.store');
    Route::get('saldo-awal-kas/export', [SaldoAwalKasController::class, 'export'])->name('saldo-awal-kas.export');
    Route::get('saldo-awal-kas/{id}/edit', [SaldoAwalKasController::class, 'edit'])->name('saldo-awal-kas.edit');
    Route::put('saldo-awal-kas/{id}', [SaldoAwalKasController::class, 'update'])->name('saldo-awal-kas.update');
});


Route::get('/test-logo', [App\Http\Controllers\Admin\setting\identitasKoperasiController::class, 'testBlob']);

Route::middleware(['auth:user'])->prefix('admin')->group(function () {
    Route::get('transaksi_kas/pemasukan/download', [TransaksiPemasukanController::class, 'download'])->name('transaksi-pemasukan.download');
    Route::resource('transaksi-pemasukan', TransaksiPemasukanController::class)->except(['show']);

    Route::get('transaksi-non-kas/download', [TransaksiNonKasController::class, 'download'])->name('transaksi-non-kas.download');
    Route::resource('transaksi-non-kas', TransaksiNonKasController::class)->except(['show']);

    Route::get('identitas-koperasi/edit', [identitasKoperasiController::class, 'edit'])->name('identitas-koperasi.editSingle');
    Route::put('identitas-koperasi/', [identitasKoperasiController::class, 'update'])->name('identitas-koperasi.updateSingle');
    
    Route::get('identitas/logo/{nama_koperasi}', [IdentitasKoperasiController::class, 'showLogo'])->name('identitas.logo');

    Route::get('suku-bunga/edit', [SukuBungaController::class, 'edit'])->name('suku-bunga.editSingle');
    Route::put('suku-bunga/', [SukuBungaController::class, 'update'])->name('suku-bunga.updateSingle');

    Route::get('pengajuan-pinjaman', [PengajuanPinjamanController::class, 'index'])->name('pengajuan-pinjaman.index');
    Route::get('pengajuan-pinjaman/{id}/disetujui', [PengajuanPinjamanController::class, 'disetujui'])->name('pengajuan-pinjaman.disetujui');
    Route::patch('pengajuan-pinjaman/{id}/tolak', [PengajuanPinjamanController::class, 'tolak'])->name('pengajuan-pinjaman.tolak');
    Route::get('pengajuan-pinjaman/download', [PengajuanPinjamanController::class, 'download'])->name('pengajuan-pinjaman.download');

    Route::get('transaksi_kas/transfer/download', [TransaksiTransferController::class, 'download'])
        ->name('transaksi-transfer.download');
    Route::resource('transaksi-transfer', TransaksiTransferController::class)
        ->except(['show']);

});

Route::middleware(['auth:user'])->prefix('admin')->group(function () {
    Route::get('/setoran-tunai', [SetoranTunaiController::class, 'index'])->name('setoran-tunai.index');
    Route::get('/setoran-tunai/create', [SetoranTunaiController::class, 'create'])->name('setoran-tunai.create');
    Route::post('/setoran-tunai', [SetoranTunaiController::class, 'store'])->name('setoran-tunai.store');
    Route::get('/setoran-tunai/{id}/edit', [SetoranTunaiController::class, 'edit'])->name('setoran-tunai.edit');
    Route::put('/setoran-tunai/{id}', [SetoranTunaiController::class, 'update'])->name('setoran-tunai.update');
    Route::delete('/setoran-tunai/{id}', [SetoranTunaiController::class, 'destroy'])->name('setoran-tunai.destroy');
    Route::get('/setoran-tunai/export-pdf', [SetoranTunaiController::class, 'exportPdf'])->name('setoran-tunai.exportPdf');
    Route::get('/setoran-tunai/{id}/cetak', [SetoranTunaiController::class, 'cetak'])->name('setoran-tunai.cetak');
});

Route::middleware(['auth:user'])->prefix('admin')->group(function () {
    Route::get('/penarikan-tunai', [PenarikanTunaiController::class, 'index'])->name('penarikan-tunai.index');
    Route::get('/penarikan-tunai/create', [PenarikanTunaiController::class, 'create'])->name('penarikan-tunai.create');
    Route::post('penarikan-tunai', [PenarikanTunaiController::class, 'store'])->name('penarikan-tunai.store');
    Route::get('/penarikan-tunai/{id}/edit', [PenarikanTunaiController::class, 'edit'])->name('penarikan-tunai.edit');
    Route::put('/penarikan-tunai/{id}', [PenarikanTunaiController::class, 'update'])->name('penarikan-tunai.update');
    Route::delete('/penarikan-tunai/{id}', [PenarikanTunaiController::class, 'destroy'])->name('penarikan-tunai.destroy');
    Route::get('/penarikan-tunai/export-pdf', [PenarikanTunaiController::class, 'exportPdf'])->name('penarikan-tunai.exportPdf');
    Route::get('/penarikan-tunai/{id}/cetak', [PenarikanTunaiController::class, 'cetak'])->name('penarikan-tunai.cetak');
});

Route::middleware(['auth:user'])->prefix('admin')->group(function () {
    Route::get('/pinjaman', [DataPinjamanController::class, 'index'])->name('pinjaman.index');
    Route::get('/pinjaman/create', [DataPinjamanController::class, 'create'])->name('pinjaman.create');
    Route::post('/pinjaman', [DataPinjamanController::class, 'store'])->name('pinjaman.store');
    Route::get('/pinjaman/{id}', [DataPinjamanController::class, 'show'])->name('pinjaman.show');
    Route::get('/pinjaman/{id}/edit', [DataPinjamanController::class, 'edit'])->name('pinjaman.edit');
    Route::put('/pinjaman/{id}', [DataPinjamanController::class, 'update'])->name('pinjaman.update');
    Route::delete('/pinjaman/{id}', [DataPinjamanController::class, 'destroy'])->name('pinjaman.destroy');
    Route::get('pinjaman/cetak-nota/{id}', [DataPinjamanController::class, 'cetakNota'])->name('pinjaman.cetak-nota');
});


Route::middleware(['auth:user'])->prefix('admin')->group(function () {
    Route::resource('pengeluaran', TransaksiPengeluaranController::class)->except(['show']);
    Route::get('/pengeluaran/export-pdf', [TransaksiPengeluaranController::class, 'exportPdf'])
        ->name('pengeluaran.export-pdf');
});

Route::middleware(['auth:user'])->prefix('admin')->group(function () {
    Route::get('/angsuran', [AngsuranController::class, 'index'])->name('angsuran.index');
    Route::get('/angsuran/bayar/{id_pinjaman}', [AngsuranController::class, 'bayar'])->name('bayar.angsuran');
    Route::get('/angsuran/tambah/{id_pinjaman}', [AngsuranController::class, 'create'])->name('angsuran.create');
    Route::post('/angsuran/tambah/{id_pinjaman}', [AngsuranController::class, 'store'])->name('angsuran.store');
    Route::get('/angsuran/edit/{id_bayar_angsuran}', [AngsuranController::class, 'edit'])->name('angsuran.edit');
    Route::put('/angsuran/update/{id_bayar_angsuran}', [AngsuranController::class, 'update'])->name('angsuran.update');
    Route::delete('/angsuran/delete/{id_bayar_angsuran}', [AngsuranController::class, 'destroy'])->name('angsuran.destroy');
    Route::get('/export/pdf', [AngsuranController::class, 'exportPdf'])->name('angsuran.export.pdf');
    Route::get('/cetak/{id_bayar_angsuran}', [AngsuranController::class, 'cetak'])->name('angsuran.cetak');
    Route::get('/admin/angsuran/{id_pinjaman}', [AngsuranController::class, 'show'])->name('angsuran.show');
});

Route::middleware(['auth:user'])->prefix('admin')->group(function () {
    Route::get('/pinjaman-lunas', [PinjamanLunasController::class, 'index'])->name('pinjaman-lunas.index');
    Route::get('/pinjaman-lunas/{kode_transaksi}/detail', [PinjamanLunasController::class, 'detail'])->name('detail.pelunasan');
    Route::get('/pinjaman-lunas/cetak/{id_bayar_angsuran}', [PinjamanLunasController::class, 'cetakNota'])->name('detail.pinjaman.cetak');
});

Route::middleware(['auth:anggota'])->group(function () {
    Route::get('/laporan-simpanan', [LaporanSimpananController::class, 'index'])->name('anggota.laporan.simpanan');
    Route::get('/laporan-pinjaman', [LaporanPinjamanController::class, 'index'])->name('anggota.laporan.pinjaman');
    Route::get('/laporan-pembayaran', [LaporanPembayaranController::class, 'index'])->name('anggota.laporan.pembayaran');
});


//Route::get('/', function () {
//    return view('welcome');
//});



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/anggota/profil/editProfil', function () {
    return view('anggota.profil.editProfil');
})->name('anggota.profil.editProfil');

Route::get('/anggota/lap-SHU', function () {
    return view('anggota.lap-SHU');
})->name('anggota.lap-SHU');


Route::get('/anggota/test', function () {
    return view('anggota.test');
})->name('anggota.test');

Route::get('/admin/laporan/laporan-saldo-kas', function () {
    return view('admin.laporan.laporan-saldo-kas');
})->name('admin.laporan.laporan-saldo-kas');

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

Route::get('/admin/pinjaman/data-pengajuan', function () {
    return view('admin.pinjaman.data-pengajuan');
})->name('admin.pinjaman.data-pengajuan');

Route::get('/anggota/notifikasi', function () {
    return view('anggota.notifikasi');
})->name('anggota.notifikasi');

Route::get('/anggota/profil/profilAnggota', function () {
    return view('anggota.profil.profilAnggota');
})->name('anggota.profil.profilAnggota');

Route::get('/admin/pinjaman/edit-bayar-angsuran', function () {
    return view('admin.pinjaman.edit-bayar-angsuran');
})->name('admin.pinjaman.edit-bayar-angsuran');

Route::get('/admin/laporan/laporan-laba-rugi', function () {
    return view('admin.laporan.laporan-laba-rugi');
})->name('admin.laporan.laporan-laba-rugi');

Route::get('/admin/profil/beranda-profil', function () {
    return view('admin.profil.beranda-profil');
})->name('admin.profil.beranda-profil');

Route::get('/admin/laporan/laporan-neraca', function () {
    return view('admin.laporan.laporan-neraca');
})->name('admin.laporan.laporan-neraca');

Route::get('/admin/laporan/laporan-kas-simpanan', function () {
    return view('admin.laporan.laporan-kas-simpanan');
})->name('admin.laporan.laporan-kas-simpanan');

Route::get('/admin/laporan/laporan-kas-pinjaman', function () {
    return view('admin.laporan.laporan-kas-pinjaman');
})->name('admin.laporan.laporan-kas-pinjaman');

Route::get('/admin/profil/edit-profil', function () {
    return view('admin.profil.edit-profil');
})->name('admin.profil.edit-edit-profil');


Route::get('/admin/pinjaman/detail-peminjaman', function () {
    return view('admin.pinjaman.detail-peminjaman');
})->name('admin.pinjaman.detail-peminjaman');

Route::get('/anggota/data-pengajuan-coba', function () {
    return view('anggota.data-pengajuan-coba');
})->name('anggota.data-pengajuan-coba');

