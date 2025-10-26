-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2025 at 01:02 PM
-- Server version: 8.0.37
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_tsm`
--

-- --------------------------------------------------------

--
-- Table structure for table `agen_ekspedisi`
--

CREATE TABLE `agen_ekspedisi` (
  `id_ekspedisi` varchar(11) NOT NULL,
  `nama_ekspedisi` varchar(255) NOT NULL,
  `id_negara` varchar(11) NOT NULL,
  `id_provinsi` varchar(11) NOT NULL,
  `id_kota` varchar(11) NOT NULL,
  `telepon_ekspedisi` varchar(16) NOT NULL,
  `email_ekspedi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ajuan_pinjaman`
--

CREATE TABLE `ajuan_pinjaman` (
  `id_ajuanPinjaman` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_lamaAngsuran` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jenis_ajuan` enum('PINJAMAN BIASA','PINJAMAN DARURAT','PINJAMAN BARANG') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_ajuan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_ajuan` enum('MENUNGGU KONFIRMASI','DISETUJUI','DITOLAK') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MENUNGGU KONFIRMASI',
  `id_biayaAdministrasi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `ajuan_pinjaman`
--
DELIMITER $$
CREATE TRIGGER `trg_ajuan_set_kode` AFTER INSERT ON `ajuan_pinjaman` FOR EACH ROW BEGIN
  UPDATE ajuan_pinjaman
    SET kode_ajuan = CONCAT('AP', LPAD(NEW.id_ajuanPinjaman, 6, '0'))
  WHERE id_ajuanPinjaman = NEW.id_ajuanPinjaman;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_anggota` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_anggota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_anggota` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_anggota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_anggota` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `departemen` enum('PRODUKSI BOPP','PRODUKSI SLITTING','WH','QA','HRD','GA','PURCHASING','ACCOUNTING','ENGINEERING') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` enum('TNI','PNS','KARYAWAN SWASTA','GURU','BURUH','TANI','PEDAGANG','WIRASWASTA','MENGURUS RUMAH TANGGA','LAINNYA','PENSIUNAN','PENJAHIT') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` enum('KETUA','SEKRETARIS','BENDAHARA','PENGAWAS','KARYAWAN','PERUSAHAAN') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` enum('ISLAM','KATOLIK','PROTESTAN','HINDU','BUDHA','LAINNYA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_perkawinan` enum('BELUM KAWIN','KAWIN','CERAI HIDUP','CERAI MATI','LAINNYA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_registrasi` date NOT NULL DEFAULT (curdate()),
  `tanggal_keluar` date DEFAULT NULL,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_anggota` enum('AKTIF','NON AKTIF') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `anggota`
--
DELIMITER $$
CREATE TRIGGER `after_insert_anggota` AFTER INSERT ON `anggota` FOR EACH ROW begin update anggota set kode_anggota = concat('AG', NEW.id_anggota) where id_anggota = NEW.id_anggota;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bahasa`
--

CREATE TABLE `bahasa` (
  `id_bahasa` varchar(11) NOT NULL,
  `nama_bahasa` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(30) NOT NULL,
  `id_kategori_barang` varchar(11) NOT NULL,
  `id_supplier` varchar(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `id_satuan` varchar(11) NOT NULL,
  `merk_barang` varchar(255) NOT NULL,
  `berat` decimal(11,2) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `retail` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_inventaris`
--

CREATE TABLE `barang_inventaris` (
  `id_barangInventaris` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_barang` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_barang` int NOT NULL DEFAULT '0',
  `keterangan_barang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_inventaris`
--

INSERT INTO `barang_inventaris` (`id_barangInventaris`, `nama_barang`, `type_barang`, `jumlah_barang`, `keterangan_barang`) VALUES
('BRG0001', 'Komputer', 'K300 Corei3', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bayar_angsuran`
--

CREATE TABLE `bayar_angsuran` (
  `id_bayar_angsuran` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `id_pinjaman` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jenisAkunTransaksi_sumber` int UNSIGNED NOT NULL,
  `id_jenisAkunTransaksi_tujuan` int UNSIGNED NOT NULL,
  `id_user` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `angsuran_ke` int UNSIGNED NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `angsuran_pokok` decimal(15,2) DEFAULT NULL,
  `angsuran_per_bulan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status_bayar` enum('LUNAS','BELUM LUNAS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM LUNAS',
  `denda` decimal(15,2) NOT NULL DEFAULT '0.00',
  `bunga_angsuran` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `bayar_angsuran`
--
DELIMITER $$
CREATE TRIGGER `trg_bayar_kode` AFTER INSERT ON `bayar_angsuran` FOR EACH ROW BEGIN
  UPDATE `bayar_angsuran`
     SET `kode_bayar` = CONCAT('BYR', LPAD(NEW.`id_bayar`, 6, '0'))
   WHERE `id_bayar` = NEW.`id_bayar`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_administrasi`
--

CREATE TABLE `biaya_administrasi` (
  `id_biayaAdministrasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_pinjaman_bunga` enum('A: Persen Bunga dikali angsuran bln','B: Persen Bunga dikali total pinjaman') COLLATE utf8mb4_unicode_ci NOT NULL,
  `suku_bunga_pinjaman` decimal(5,2) NOT NULL,
  `biaya_administrasi` decimal(15,2) NOT NULL DEFAULT '0.00',
  `biaya_denda` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tempo_tanggal_pembayaran` int NOT NULL,
  `iuran_wajib` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dana_cadangan` decimal(5,2) NOT NULL DEFAULT '0.00',
  `jasa_usaha` decimal(5,2) NOT NULL DEFAULT '0.00',
  `jasa_anggota` decimal(5,2) NOT NULL DEFAULT '0.00',
  `jasa_modal_anggota` decimal(5,2) NOT NULL DEFAULT '0.00',
  `dana_pengurus` decimal(5,2) NOT NULL DEFAULT '0.00',
  `dana_karyawan` decimal(5,2) NOT NULL DEFAULT '0.00',
  `dana_pendidikan` decimal(5,2) NOT NULL DEFAULT '0.00',
  `dana_sosial` decimal(5,2) NOT NULL DEFAULT '0.00',
  `pajak_pph` decimal(5,2) NOT NULL DEFAULT '0.00',
  `id_lamaAngsuran` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail_pembelian` varchar(11) NOT NULL,
  `id_pembelian` varchar(11) NOT NULL,
  `id_barang` varchar(30) NOT NULL,
  `sub_total` int NOT NULL,
  `kuantitas` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` varchar(11) NOT NULL,
  `id_penjualan` varchar(11) NOT NULL,
  `id_barang` varchar(30) NOT NULL,
  `kuantitas` int NOT NULL,
  `sub_total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detailTransaksi` int UNSIGNED NOT NULL,
  `id_jenisAkunTransaksi` int UNSIGNED NOT NULL,
  `id_transaksi` int UNSIGNED NOT NULL,
  `kredit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `debit` decimal(15,2) NOT NULL DEFAULT '0.00'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` varchar(11) NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
('J01', 'Manager', '2025-10-15 18:51:47', '2025-10-15 18:51:47'),
('J02', 'Kasir', '2025-10-15 18:51:47', '2025-10-15 18:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_akun_transaksi`
--

CREATE TABLE `jenis_akun_transaksi` (
  `id_jenisAkunTransaksi` int UNSIGNED NOT NULL,
  `nama_AkunTransaksi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_akun` enum('ACTIVA','PASIVA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemasukan` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengeluaran` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `penarikan` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_akun` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nonkas` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `simpanan` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinjaman` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `angsuran` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `labarugi` enum('PENDAPATAN','BIAYA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_aktiva` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_akun_transaksi`
--

INSERT INTO `jenis_akun_transaksi` (`id_jenisAkunTransaksi`, `nama_AkunTransaksi`, `type_akun`, `pemasukan`, `pengeluaran`, `penarikan`, `transfer`, `status_akun`, `nonkas`, `simpanan`, `pinjaman`, `angsuran`, `labarugi`, `kode_aktiva`) VALUES
(1, 'Kas Besar', 'PASIVA', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'BIAYA', 'A1.02');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_simpanan`
--

CREATE TABLE `jenis_simpanan` (
  `id_jenis_simpanan` int UNSIGNED NOT NULL,
  `jenis_simpanan` varchar(20) NOT NULL,
  `jumlah_simpanan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tampil_simpanan` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_simpanan`
--

INSERT INTO `jenis_simpanan` (`id_jenis_simpanan`, `jenis_simpanan`, `jumlah_simpanan`, `tampil_simpanan`) VALUES
(2, 'Simpanan Wajib', '50000.00', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori` varchar(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pelanggan`
--

CREATE TABLE `kategori_pelanggan` (
  `id_kategori_pelanggan` varchar(11) NOT NULL,
  `nama_kategori_pelanggan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `koperasi`
--

CREATE TABLE `koperasi` (
  `nama_koperasi` varchar(255) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `alamat_koperasi` varchar(255) NOT NULL,
  `telepon_koperasi` varchar(255) NOT NULL,
  `email_koperasi` varchar(255) NOT NULL,
  `fax_koperasi` varchar(255) NOT NULL,
  `kode_pos` varchar(11) NOT NULL,
  `website` varchar(255) NOT NULL,
  `logo_koperasi` blob,
  `nama_pimpinan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` varchar(11) NOT NULL,
  `nama_kota` varchar(255) NOT NULL,
  `id_negara` varchar(11) NOT NULL,
  `id_provinsi` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lama_angsuran`
--

CREATE TABLE `lama_angsuran` (
  `id_lamaAngsuran` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lama_angsuran` int NOT NULL,
  `status_angsuran` enum('Y','T') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lama_angsuran`
--

INSERT INTO `lama_angsuran` (`id_lamaAngsuran`, `lama_angsuran`, `status_angsuran`) VALUES
('LMA0001', 2, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_10_02_063837_create_cache_table', 1),
(2, '2025_10_02_063848_create_sessions_table', 1),
(3, '2025_10_02_063855_create_jobs_table', 1),
(4, '2025_10_06_061341_create_kategori_barang_table', 1),
(5, '2025_10_06_061343_create_bahasa_table', 1),
(6, '2025_10_06_061344_create_satuan_table', 1),
(7, '2025_10_06_061345_create_negara_table', 1),
(8, '2025_10_06_061346_create_provinsi_table', 1),
(9, '2025_10_06_061347_create_kota_table', 1),
(10, '2025_10_06_061348_create_agen_ekspedisi_table', 1),
(11, '2025_10_15_041303_create_supplier_table', 1),
(12, '2025_10_15_041453_create_kategori_pelanggan_table', 1),
(13, '2025_10_15_041545_create_pelanggan_table', 1),
(14, '2025_10_15_041626_create_barang_table', 1),
(15, '2025_10_15_061720_create_koperasi_table', 1),
(16, '2025_10_15_064432_create_penjualan_table', 1),
(17, '2025_10_15_064503_create_detail_penjualan_table', 1),
(18, '2025_10_15_064514_create_pengiriman_table', 1),
(19, '2025_10_16_013441_create_pendidikan_table', 1),
(20, '2025_10_16_013507_create_jabatan_table', 1),
(21, '2025_10_16_013521_create_role_table', 1),
(22, '2025_10_16_013600_create_users_table', 1),
(23, '2025_10_16_013906_create_pembelian_table', 1),
(24, '2025_10_16_014000_create_detail_pembelian_table', 1),
(25, '2025_10_25_195702_remove_kode_anggota_from_anggota_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `negara`
--

CREATE TABLE `negara` (
  `id_negara` varchar(11) NOT NULL,
  `nama_negara` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `nomor_telepon` varchar(16) DEFAULT NULL,
  `tipe_pelanggan` varchar(255) NOT NULL,
  `kategori_pelanggan` varchar(11) NOT NULL,
  `email_pelanggan` varchar(255) DEFAULT NULL,
  `id_negara` varchar(11) NOT NULL,
  `id_provinsi` varchar(11) NOT NULL,
  `id_kota` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` varchar(11) NOT NULL,
  `nomor_po` varchar(30) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `tanggal_kirim` date DEFAULT NULL,
  `tanggal_terima` timestamp NULL DEFAULT NULL,
  `id_supplier` varchar(11) NOT NULL,
  `id_user` varchar(11) NOT NULL,
  `jenis_pembayaran` varchar(255) NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int NOT NULL,
  `tingkat_pendidikan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` (`id_pendidikan`, `tingkat_pendidikan`, `created_at`, `updated_at`) VALUES
(1, 'SMA', NULL, NULL),
(2, 'D3', NULL, NULL),
(3, 'S1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` varchar(11) NOT NULL,
  `id_agen_ekspedisi` varchar(11) NOT NULL,
  `id_penjualan` varchar(11) NOT NULL,
  `nomor_resi` varchar(255) NOT NULL,
  `biaya_pengiriman` int NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL,
  `diskon_biaya_kirim` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_berat_bruto` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` varchar(11) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `tanggal_penjualan` time NOT NULL,
  `diskon_penjualan` int NOT NULL,
  `total_harga_penjualan` int NOT NULL,
  `jenis_pembayaran` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id_pinjaman` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ajuanPinjaman` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_anggota` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_jenisAkunTransaksi_tujuan` int UNSIGNED NOT NULL,
  `id_jenisAkunTransaksi_sumber` int UNSIGNED NOT NULL,
  `id_lamaAngsuran` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pinjaman` date NOT NULL,
  `bunga_pinjaman` decimal(5,2) DEFAULT NULL,
  `jumlah_pinjaman` decimal(15,2) NOT NULL,
  `total_tagihan` decimal(15,2) DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_lunas` enum('BELUM LUNAS','LUNAS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM LUNAS',
  `biaya_admin` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` varchar(11) NOT NULL,
  `nama_provinsi` varchar(255) NOT NULL,
  `id_negara` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` varchar(255) NOT NULL,
  `nama_role` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`, `keterangan`, `created_at`, `updated_at`) VALUES
('R01', 'Admin Master', 'Akses penuh ke semua fitur sistem', '2025-10-15 18:51:47', '2025-10-15 18:51:47'),
('R02', 'Kasir', 'Akses untuk transaksi penjualan', '2025-10-15 18:51:47', '2025-10-15 18:51:47'),
('R03', 'Karyawan', 'Akses untuk input dan laporan', '2025-10-15 18:51:47', '2025-10-15 18:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` varchar(11) NOT NULL,
  `nama_satuan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `id_simpanan` int UNSIGNED NOT NULL,
  `id_user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_anggota` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_jenis_simpanan` int UNSIGNED NOT NULL,
  `id_jenisAkunTransaksi_tujuan` int UNSIGNED NOT NULL,
  `id_jenisAkunTransaksi_sumber` int UNSIGNED NOT NULL,
  `jumlah_simpanan` decimal(15,2) NOT NULL,
  `type_simpanan` enum('TRK','TRD') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_simpanan` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_transaksi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_setoran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `simpanan`
--
DELIMITER $$
CREATE TRIGGER `trg_simpanan_kode` AFTER INSERT ON `simpanan` FOR EACH ROW BEGIN
  UPDATE simpanan
     SET kode_simpanan = CONCAT(NEW.type_simpanan, LPAD(NEW.id_simpanan, 6, '0'))
   WHERE id_simpanan = NEW.id_simpanan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` varchar(11) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_negara` varchar(11) NOT NULL,
  `id_provinsi` varchar(11) NOT NULL,
  `id_kota` varchar(11) NOT NULL,
  `telepon_supplier` varchar(16) NOT NULL,
  `email_supplier` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int UNSIGNED NOT NULL,
  `id_jenisAkunTransaksi_sumber` int UNSIGNED NOT NULL,
  `id_jenisAkunTransaksi_tujuan` int UNSIGNED NOT NULL,
  `id_user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type_transaksi` enum('TKD','TKK','TRF','TNK','SAK','SANK') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_transaksi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_transaksi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jumlah_transaksi` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` varchar(50) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat_user` varchar(255) DEFAULT NULL,
  `telepon` varchar(16) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_user` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `id_role` varchar(10) DEFAULT NULL,
  `id_jabatan` varchar(11) DEFAULT NULL,
  `id_pendidikan` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `alamat_user`, `telepon`, `username`, `password`, `foto_user`, `jenis_kelamin`, `status`, `tanggal_masuk`, `tanggal_keluar`, `id_role`, `id_jabatan`, `id_pendidikan`, `created_at`, `updated_at`) VALUES
('USR001', 'Admin Utama', 'Jl. Mawar No. 1', '081234567890', 'admin', '$2y$12$lw0YrqInLwxXK8hT3Lgl0OjhIIDwobTma2CNUwEAH5vBstVJ2Yjgu', NULL, 'L', 'aktif', '2024-01-01', NULL, 'R01', 'J01', 3, '2025-10-15 18:51:48', '2025-10-15 18:51:48');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_data_angsuran`
-- (See below for the actual view)
--
CREATE TABLE `view_data_angsuran` (
`id_pinjaman` varchar(20)
,`kode_transaksi` varchar(21)
,`tanggal_pinjaman` date
,`username_anggota` varchar(50)
,`nama_anggota` varchar(100)
,`jumlah_pinjaman` decimal(15,2)
,`lama_angsuran` int
,`angsuran_pokok` decimal(19,6)
,`bunga_angsuran` decimal(28,12)
,`biaya_admin` decimal(15,2)
,`angsuran_per_bulan` decimal(30,12)
);

-- --------------------------------------------------------

--
-- Structure for view `view_data_angsuran`
--
DROP TABLE IF EXISTS `view_data_angsuran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_data_angsuran`  AS SELECT `p`.`id_pinjaman` AS `id_pinjaman`, concat('T',`p`.`id_pinjaman`) AS `kode_transaksi`, `p`.`tanggal_pinjaman` AS `tanggal_pinjaman`, `a`.`username_anggota` AS `username_anggota`, `a`.`nama_anggota` AS `nama_anggota`, `p`.`jumlah_pinjaman` AS `jumlah_pinjaman`, `la`.`lama_angsuran` AS `lama_angsuran`, (`p`.`jumlah_pinjaman` / `la`.`lama_angsuran`) AS `angsuran_pokok`, ((`p`.`jumlah_pinjaman` * (`p`.`bunga_pinjaman` / 100)) / `la`.`lama_angsuran`) AS `bunga_angsuran`, `p`.`biaya_admin` AS `biaya_admin`, (((`p`.`jumlah_pinjaman` / `la`.`lama_angsuran`) + ((`p`.`jumlah_pinjaman` * (`p`.`bunga_pinjaman` / 100)) / `la`.`lama_angsuran`)) + `p`.`biaya_admin`) AS `angsuran_per_bulan` FROM ((`pinjaman` `p` join `anggota` `a` on((`a`.`id_anggota` = `p`.`id_anggota`))) join `lama_angsuran` `la` on((`la`.`id_lamaAngsuran` = `p`.`id_lamaAngsuran`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agen_ekspedisi`
--
ALTER TABLE `agen_ekspedisi`
  ADD PRIMARY KEY (`id_ekspedisi`),
  ADD KEY `agen_ekspedisi_id_negara_foreign` (`id_negara`),
  ADD KEY `agen_ekspedisi_id_provinsi_foreign` (`id_provinsi`),
  ADD KEY `agen_ekspedisi_id_kota_foreign` (`id_kota`);

--
-- Indexes for table `ajuan_pinjaman`
--
ALTER TABLE `ajuan_pinjaman`
  ADD PRIMARY KEY (`id_ajuanPinjaman`),
  ADD KEY `idx_lama` (`id_lamaAngsuran`),
  ADD KEY `idx_status` (`status_ajuan`),
  ADD KEY `fk_ajuan_anggota` (`id_anggota`),
  ADD KEY `fk_ajuan_adm` (`id_biayaAdministrasi`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `uq_username_anggota` (`username_anggota`);

--
-- Indexes for table `bahasa`
--
ALTER TABLE `bahasa`
  ADD PRIMARY KEY (`id_bahasa`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `barang_id_kategori_barang_foreign` (`id_kategori_barang`),
  ADD KEY `barang_id_supplier_foreign` (`id_supplier`),
  ADD KEY `barang_id_satuan_foreign` (`id_satuan`);

--
-- Indexes for table `barang_inventaris`
--
ALTER TABLE `barang_inventaris`
  ADD PRIMARY KEY (`id_barangInventaris`);

--
-- Indexes for table `bayar_angsuran`
--
ALTER TABLE `bayar_angsuran`
  ADD PRIMARY KEY (`id_bayar_angsuran`),
  ADD KEY `idx_tanggal_bayar` (`tanggal_bayar`),
  ADD KEY `fk_bayar_akun_sumber` (`id_jenisAkunTransaksi_sumber`),
  ADD KEY `fk_bayar_akun_tujuan` (`id_jenisAkunTransaksi_tujuan`),
  ADD KEY `fk_bayar_pinjaman` (`id_pinjaman`),
  ADD KEY `fk_bayar_user` (`id_user`);

--
-- Indexes for table `biaya_administrasi`
--
ALTER TABLE `biaya_administrasi`
  ADD PRIMARY KEY (`id_biayaAdministrasi`),
  ADD KEY `fk_adm_lamaAngsuran` (`id_lamaAngsuran`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail_pembelian`),
  ADD KEY `detail_pembelian_id_pembelian_foreign` (`id_pembelian`),
  ADD KEY `detail_pembelian_id_barang_foreign` (`id_barang`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`),
  ADD KEY `detail_penjualan_id_penjualan_foreign` (`id_penjualan`),
  ADD KEY `detail_penjualan_id_barang_foreign` (`id_barang`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detailTransaksi`),
  ADD KEY `idx_transaksi` (`id_transaksi`),
  ADD KEY `idx_akun` (`id_jenisAkunTransaksi`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `jenis_akun_transaksi`
--
ALTER TABLE `jenis_akun_transaksi`
  ADD PRIMARY KEY (`id_jenisAkunTransaksi`),
  ADD UNIQUE KEY `uq_nama_AkunTransaksi` (`nama_AkunTransaksi`);

--
-- Indexes for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  ADD PRIMARY KEY (`id_jenis_simpanan`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kategori_pelanggan`
--
ALTER TABLE `kategori_pelanggan`
  ADD PRIMARY KEY (`id_kategori_pelanggan`);

--
-- Indexes for table `koperasi`
--
ALTER TABLE `koperasi`
  ADD PRIMARY KEY (`nama_koperasi`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`),
  ADD KEY `kota_id_negara_foreign` (`id_negara`),
  ADD KEY `kota_id_provinsi_foreign` (`id_provinsi`);

--
-- Indexes for table `lama_angsuran`
--
ALTER TABLE `lama_angsuran`
  ADD PRIMARY KEY (`id_lamaAngsuran`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `negara`
--
ALTER TABLE `negara`
  ADD PRIMARY KEY (`id_negara`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `pelanggan_kategori_pelanggan_foreign` (`kategori_pelanggan`),
  ADD KEY `pelanggan_id_negara_foreign` (`id_negara`),
  ADD KEY `pelanggan_id_provinsi_foreign` (`id_provinsi`),
  ADD KEY `pelanggan_id_kota_foreign` (`id_kota`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `pembelian_id_supplier_foreign` (`id_supplier`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD UNIQUE KEY `pengiriman_nomor_resi_unique` (`nomor_resi`),
  ADD KEY `pengiriman_id_agen_ekspedisi_foreign` (`id_agen_ekspedisi`),
  ADD KEY `pengiriman_id_penjualan_foreign` (`id_penjualan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `penjualan_id_pelanggan_foreign` (`id_pelanggan`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id_pinjaman`),
  ADD KEY `idx_sumber` (`id_jenisAkunTransaksi_sumber`),
  ADD KEY `idx_tujuan` (`id_jenisAkunTransaksi_tujuan`),
  ADD KEY `fk_pinj_user` (`id_user`),
  ADD KEY `fk_pinj_anggota` (`id_anggota`),
  ADD KEY `fk_pinj_ajuan` (`id_ajuanPinjaman`),
  ADD KEY `idx_lama` (`id_lamaAngsuran`) USING BTREE;

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`),
  ADD KEY `provinsi_id_negara_foreign` (`id_negara`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `role_nama_role_unique` (`nama_role`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD PRIMARY KEY (`id_simpanan`),
  ADD KEY `idx_jenis_simpanan` (`id_jenis_simpanan`),
  ADD KEY `idx_sumber` (`id_jenisAkunTransaksi_sumber`),
  ADD KEY `idx_tujuan` (`id_jenisAkunTransaksi_tujuan`),
  ADD KEY `idx_tanggal` (`tanggal_transaksi`),
  ADD KEY `fk_simp_anggota` (`id_anggota`),
  ADD KEY `fk_simp_user` (`id_user`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`),
  ADD KEY `supplier_id_negara_foreign` (`id_negara`),
  ADD KEY `supplier_id_provinsi_foreign` (`id_provinsi`),
  ADD KEY `supplier_id_kota_foreign` (`id_kota`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `uq_kode_transaksi` (`kode_transaksi`),
  ADD KEY `idx_tanggal` (`tanggal_transaksi`),
  ADD KEY `idx_sumber` (`id_jenisAkunTransaksi_sumber`),
  ADD KEY `idx_tujuan` (`id_jenisAkunTransaksi_tujuan`),
  ADD KEY `fk_transaksi_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_id_role_foreign` (`id_role`),
  ADD KEY `users_id_jabatan_foreign` (`id_jabatan`),
  ADD KEY `users_id_pendidikan_foreign` (`id_pendidikan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detailTransaksi` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_akun_transaksi`
--
ALTER TABLE `jenis_akun_transaksi`
  MODIFY `id_jenisAkunTransaksi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis_simpanan`
--
ALTER TABLE `jenis_simpanan`
  MODIFY `id_jenis_simpanan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `simpanan`
--
ALTER TABLE `simpanan`
  MODIFY `id_simpanan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agen_ekspedisi`
--
ALTER TABLE `agen_ekspedisi`
  ADD CONSTRAINT `agen_ekspedisi_id_kota_foreign` FOREIGN KEY (`id_kota`) REFERENCES `kota` (`id_kota`) ON DELETE CASCADE,
  ADD CONSTRAINT `agen_ekspedisi_id_negara_foreign` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id_negara`) ON DELETE CASCADE,
  ADD CONSTRAINT `agen_ekspedisi_id_provinsi_foreign` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE;

--
-- Constraints for table `ajuan_pinjaman`
--
ALTER TABLE `ajuan_pinjaman`
  ADD CONSTRAINT `fk_ajuan_adm` FOREIGN KEY (`id_biayaAdministrasi`) REFERENCES `biaya_administrasi` (`id_biayaAdministrasi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ajuan_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ajuan_lama` FOREIGN KEY (`id_lamaAngsuran`) REFERENCES `lama_angsuran` (`id_lamaAngsuran`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_id_kategori_barang_foreign` FOREIGN KEY (`id_kategori_barang`) REFERENCES `kategori_barang` (`id_kategori`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_id_satuan_foreign` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_id_supplier_foreign` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE;

--
-- Constraints for table `bayar_angsuran`
--
ALTER TABLE `bayar_angsuran`
  ADD CONSTRAINT `fk_bayar_akun_sumber` FOREIGN KEY (`id_jenisAkunTransaksi_sumber`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bayar_akun_tujuan` FOREIGN KEY (`id_jenisAkunTransaksi_tujuan`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bayar_pinjaman` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id_pinjaman`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bayar_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `biaya_administrasi`
--
ALTER TABLE `biaya_administrasi`
  ADD CONSTRAINT `fk_adm_lamaAngsuran` FOREIGN KEY (`id_lamaAngsuran`) REFERENCES `lama_angsuran` (`id_lamaAngsuran`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `detail_pembelian_id_pembelian_foreign` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`);

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_penjualan_id_penjualan_foreign` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `fk_detail_akun` FOREIGN KEY (`id_jenisAkunTransaksi`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kota`
--
ALTER TABLE `kota`
  ADD CONSTRAINT `kota_id_negara_foreign` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id_negara`) ON DELETE CASCADE,
  ADD CONSTRAINT `kota_id_provinsi_foreign` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE;

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_id_kota_foreign` FOREIGN KEY (`id_kota`) REFERENCES `kota` (`id_kota`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggan_id_negara_foreign` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id_negara`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggan_id_provinsi_foreign` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggan_kategori_pelanggan_foreign` FOREIGN KEY (`kategori_pelanggan`) REFERENCES `kategori_pelanggan` (`id_kategori_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_id_supplier_foreign` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`);

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_id_agen_ekspedisi_foreign` FOREIGN KEY (`id_agen_ekspedisi`) REFERENCES `agen_ekspedisi` (`id_ekspedisi`),
  ADD CONSTRAINT `pengiriman_id_penjualan_foreign` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_id_pelanggan_foreign` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `fk_pinj_ajuan` FOREIGN KEY (`id_ajuanPinjaman`) REFERENCES `ajuan_pinjaman` (`id_ajuanPinjaman`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pinj_akun_sumber` FOREIGN KEY (`id_jenisAkunTransaksi_sumber`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pinj_akun_tujuan` FOREIGN KEY (`id_jenisAkunTransaksi_tujuan`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pinj_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pinj_lama` FOREIGN KEY (`id_lamaAngsuran`) REFERENCES `lama_angsuran` (`id_lamaAngsuran`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pinj_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD CONSTRAINT `provinsi_id_negara_foreign` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id_negara`) ON DELETE CASCADE;

--
-- Constraints for table `simpanan`
--
ALTER TABLE `simpanan`
  ADD CONSTRAINT `fk_simp_akun_sumber` FOREIGN KEY (`id_jenisAkunTransaksi_sumber`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_simp_akun_tujuan` FOREIGN KEY (`id_jenisAkunTransaksi_tujuan`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_simp_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_simp_jenis` FOREIGN KEY (`id_jenis_simpanan`) REFERENCES `jenis_simpanan` (`id_jenis_simpanan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_simp_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `supplier_id_kota_foreign` FOREIGN KEY (`id_kota`) REFERENCES `kota` (`id_kota`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_id_negara_foreign` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id_negara`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_id_provinsi_foreign` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_sumber` FOREIGN KEY (`id_jenisAkunTransaksi_sumber`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_tujuan` FOREIGN KEY (`id_jenisAkunTransaksi_tujuan`) REFERENCES `jenis_akun_transaksi` (`id_jenisAkunTransaksi`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_id_pendidikan_foreign` FOREIGN KEY (`id_pendidikan`) REFERENCES `pendidikan` (`id_pendidikan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
