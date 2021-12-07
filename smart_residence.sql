-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2021 at 10:24 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_residence`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_rt`
--

CREATE TABLE `admin_rt` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_rt` bigint(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_rt`
--

INSERT INTO `admin_rt` (`id`, `id_rt`, `id_user`, `nik`, `no_hp`, `alamat`, `jabatan`, `created_at`, `updated_at`) VALUES
(1, 1, 8, '12312312312', '0812121212', 'Panam', 'Ketua', '2021-11-24 09:53:46', '2021-11-24 09:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id` bigint(20) NOT NULL,
  `id_rt` bigint(20) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `isi` text NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id`, `id_rt`, `judul`, `isi`, `keterangan`, `tanggal`, `gambar`, `created_at`, `updated_at`) VALUES
(9, 1, 'test', 'isi\nansnx', 'test', '2021-12-01', '/upload-file/informasi/1638375198-ejoH54WXmJbCQbKGmvI2fjtcKRUQr2oT0G.jpg', '2021-12-01 16:13:18', '2021-12-01 16:13:18'),
(10, 1, 'test 2', 'gshnvn', 'hfhf', '2021-12-02', '/upload-file/informasi/1638419218-A1DojxEQY65yb8MEcsRcbS0qlpEv5YD1uB.jpg', '2021-12-02 04:26:58', '2021-12-02 04:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `kab_kota`
--

CREATE TABLE `kab_kota` (
  `id` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kab_kota`
--

INSERT INTO `kab_kota` (`id`, `id_provinsi`, `nama`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pekanbaru', '2021-08-22 10:19:49', '2021-08-22 10:19:49'),
(3, 4, 'Bukittinggi', '2021-08-23 17:55:55', '2021-08-23 17:55:55');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `id_kabkota` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `id_kabkota`, `nama`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tampan', '2021-08-23 10:17:44', '2021-08-23 10:17:44'),
(12, 1, 'Marpoyan', '2021-08-24 10:08:38', '2021-08-24 10:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` bigint(20) NOT NULL,
  `id_rt` bigint(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `status` enum('Selesai','Belum Terlaksana','Batal') NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `id_rt`, `nama`, `tgl_mulai`, `tgl_selesai`, `lokasi`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(35, 1, 'Test 1', '2021-12-07', '2021-12-16', 'Masjid', 'Belum Terlaksana', '-', '2021-12-06 23:17:35', '2021-12-06 23:17:35'),
(36, 1, 'Test 2', '2021-12-01', '2021-12-31', '-', 'Belum Terlaksana', '-', '2021-12-06 23:21:14', '2021-12-06 23:21:14'),
(39, 1, 'Test 3', '2021-12-07', '2021-12-30', '-', 'Belum Terlaksana', '-', '2021-12-06 23:27:46', '2021-12-06 23:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_anggota`
--

CREATE TABLE `kegiatan_anggota` (
  `id` bigint(20) NOT NULL,
  `id_kegiatan` bigint(20) NOT NULL,
  `status` enum('Panitia','Peserta') NOT NULL,
  `maksimal_anggota` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kegiatan_anggota`
--

INSERT INTO `kegiatan_anggota` (`id`, `id_kegiatan`, `status`, `maksimal_anggota`, `created_at`, `updated_at`) VALUES
(29, 35, 'Panitia', NULL, '2021-12-06 23:17:35', '2021-12-06 23:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_detail_anggota`
--

CREATE TABLE `kegiatan_detail_anggota` (
  `id` bigint(20) NOT NULL,
  `id_kegiatan_anggota` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nama_didaftarkan` varchar(50) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kegiatan_detail_anggota`
--

INSERT INTO `kegiatan_detail_anggota` (`id`, `id_kegiatan_anggota`, `id_user`, `nama_didaftarkan`, `keterangan`, `created_at`, `updated_at`) VALUES
(14, 29, 10, NULL, 'ketua', '2021-12-06 23:17:35', '2021-12-06 23:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_detail_iuran`
--

CREATE TABLE `kegiatan_detail_iuran` (
  `id` bigint(20) NOT NULL,
  `id_iuran` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `uang` int(11) DEFAULT NULL,
  `tgl_pembayaran` date DEFAULT NULL,
  `status` enum('Belum Bayar','Menunggu Validasi','Sudah Bayar') NOT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kegiatan_detail_iuran`
--

INSERT INTO `kegiatan_detail_iuran` (`id`, `id_iuran`, `id_user`, `uang`, `tgl_pembayaran`, `status`, `gambar`, `keterangan`, `created_at`, `updated_at`) VALUES
(13, 16, 10, NULL, NULL, 'Belum Bayar', NULL, NULL, '2021-12-06 23:21:14', '2021-12-06 23:21:14'),
(15, 19, 10, NULL, NULL, 'Belum Bayar', NULL, NULL, '2021-12-06 23:27:46', '2021-12-06 23:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_iuran`
--

CREATE TABLE `kegiatan_iuran` (
  `id` bigint(20) NOT NULL,
  `id_kegiatan` bigint(20) NOT NULL,
  `status` enum('Wajib','Tidak Wajib') NOT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tgl_terakhir_pembayaran` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kegiatan_iuran`
--

INSERT INTO `kegiatan_iuran` (`id`, `id_kegiatan`, `status`, `nominal`, `tgl_terakhir_pembayaran`, `created_at`, `updated_at`) VALUES
(16, 36, 'Wajib', 50000, '2021-12-20', '2021-12-06 23:21:14', '2021-12-06 23:21:14'),
(19, 39, 'Wajib', 40000, '2021-12-23', '2021-12-06 23:27:46', '2021-12-06 23:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` int(11) NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id`, `id_kecamatan`, `nama`, `created_at`, `updated_at`) VALUES
(2, 1, 'Simpang Baru', '2021-08-23 18:25:54', '2021-08-23 18:25:54'),
(6, 1, 'Tabek Gadang', '2021-08-24 10:12:22', '2021-08-24 10:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_07_27_050118_table_warga', 1),
(2, '2021_07_27_053822_table_warga', 2),
(3, '2021_07_27_054504_table_rt', 3),
(4, '2021_07_27_064009_table_admin_rt', 4),
(5, '2021_08_03_090247_create_users_table', 5),
(6, '2021_08_03_091721_table_users', 6),
(7, '2021_08_03_091807_create_table_warga', 6),
(8, '2021_08_03_092508_create_table_admin_rt', 6),
(9, '2021_08_11_045007_create_table_user', 7);

-- --------------------------------------------------------

--
-- Table structure for table `pelaporan`
--

CREATE TABLE `pelaporan` (
  `id` bigint(20) NOT NULL,
  `id_rt` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_diproses` date DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `status` enum('Belum Diproses','Diproses','Selesai') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelaporan`
--

INSERT INTO `pelaporan` (`id`, `id_rt`, `id_user`, `judul`, `isi`, `keterangan`, `tgl_diproses`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 10, 'test', 'qwe', 'jdb', NULL, '/upload-file/pelaporan/1638603239-pQg9y1un8LPVaeKSao7yTeeN5u82DQXusB.jpg', 'Belum Diproses', '2021-12-04 07:33:59', '2021-12-04 07:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Riau', '2021-08-22 08:21:22', '2021-08-22 09:10:43'),
(4, 'Sumatera Barat', '2021-08-22 10:57:15', '2021-08-22 10:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `rt`
--

CREATE TABLE `rt` (
  `id` int(11) NOT NULL,
  `id_rw` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rt`
--

INSERT INTO `rt` (`id`, `id_rw`, `nama`, `created_at`, `updated_at`) VALUES
(1, 2, '01', '2021-08-24 10:19:54', '2021-08-24 10:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `rw`
--

CREATE TABLE `rw` (
  `id` int(11) NOT NULL,
  `id_kelurahan` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rw`
--

INSERT INTO `rw` (`id`, `id_kelurahan`, `nama`, `created_at`, `updated_at`) VALUES
(2, 2, '01', '2021-08-24 09:17:06', '2021-08-24 09:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` bigint(20) NOT NULL,
  `id_rt` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `jenis` enum('Surat Pengantar','Surat Keterangan') NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `id_rt`, `id_user`, `jenis`, `keterangan`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 'Surat Pengantar', 'asdc', '2021-12-07', '2021-12-06 21:47:33', '2021-12-06 21:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Administrator','RT','Warga') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fadllil Azhiimi', 'fadllilazhiimi841@gmail.com', '$2y$10$Ug0sVAZyDSgsBweAr6Z4H.95qSmlYEMOJJ4fRCjfvUrn2j1oyNamC', 'Administrator', NULL, '2021-08-10 23:40:56', '2021-08-24 15:16:49'),
(8, 'Vina Azizah', 'vinaazizah@gmail.com', '$2y$10$UbuksUenrsB65w2uX0JvJui0JS/zwivOCXsv7Z9wlcY0RWtyytFRe', 'RT', 'Aktif', '2021-08-31 09:26:59', '2021-08-31 09:26:59'),
(10, 'Dinal', 'dinal@gmail.com', '$2y$10$1YGhI6jTfFLx/PpJk/Prv.OEJlOpOke7j92CYZ/7zRbMsuuew9Bvi', 'Warga', 'Aktif', '2021-09-02 11:11:54', '2021-09-17 10:05:23'),
(14, 'Andra', 'andra@gmail.com', '$2y$10$c6gZ7O7rVx3.TFUv2AHrbuJOkuAMBG.axnietqUgqOvDK1h7byOBa', 'Warga', 'Tidak Aktif', '2021-11-28 16:13:53', '2021-12-06 22:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_rt` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jml_anggota_keluarga` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kk` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id`, `id_rt`, `id_user`, `nik`, `alamat`, `no_hp`, `jml_anggota_keluarga`, `no_kk`, `created_at`, `updated_at`) VALUES
(1, 1, 10, '123123123', 'Panam', '081239', '2', '32423434', '2021-09-02 11:11:54', '2021-12-03 06:50:34'),
(5, 1, 14, NULL, NULL, NULL, NULL, NULL, '2021-11-28 16:13:53', '2021-11-28 16:13:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_rt`
--
ALTER TABLE `admin_rt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kab_kota`
--
ALTER TABLE `kab_kota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan_anggota`
--
ALTER TABLE `kegiatan_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan_detail_anggota`
--
ALTER TABLE `kegiatan_detail_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan_detail_iuran`
--
ALTER TABLE `kegiatan_detail_iuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan_iuran`
--
ALTER TABLE `kegiatan_iuran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelaporan`
--
ALTER TABLE `pelaporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt`
--
ALTER TABLE `rt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rw`
--
ALTER TABLE `rw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warga_nik_unique` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_rt`
--
ALTER TABLE `admin_rt`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kab_kota`
--
ALTER TABLE `kab_kota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `kegiatan_anggota`
--
ALTER TABLE `kegiatan_anggota`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `kegiatan_detail_anggota`
--
ALTER TABLE `kegiatan_detail_anggota`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kegiatan_detail_iuran`
--
ALTER TABLE `kegiatan_detail_iuran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kegiatan_iuran`
--
ALTER TABLE `kegiatan_iuran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rt`
--
ALTER TABLE `rt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rw`
--
ALTER TABLE `rw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
