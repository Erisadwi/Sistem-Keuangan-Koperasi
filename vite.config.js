import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/app2.css',
                'resources/css/app3.css',
                'resources/css/app4.css',
                'resources/css/app-add.css',
                'resources/css/app-add2.css',
                'resources/css/app-add3.css',
                'resources/css/app-add4.css',
                'resources/css/coba-app.css',
                'resources/css/laporan-admin3.css',
                'resources/css/style-login.css',
                'resources/css/style-profilAnggota.css',
                'resources/css/style-tambahPengajuan.css',
                'resources/css/style-berandaProfil.css',
                'resources/css/styleBeranda.css',
                'resources/css/style-editProfil.css',
                'resources/css/style-laporanBukuBesar.css',
                'resources/css/style-laporanJatuhTempo.css',
                'resources/css/style-laporanNeraca.css',
                'resources/css/style-laporanNeracaSaldo.css',
                'resources/css/style-laporanPembayaran.css',
                'resources/css/style-laporanPinjaman.css',
                'resources/css/style-laporanSimpanan.css',
                'resources/css/laporan.css',
                'resources/js/app.js',
                'resources/js/toolbar.js',
                'resources/js/laporan.js',
                'resources/css/components/nav-top.css',
                'resources/css/components/pagination.css',
                'resources/css/components/section.css',
                'resources/css/components/tabel.css',
            ],
            refresh: true,
        }),
    ],
});
