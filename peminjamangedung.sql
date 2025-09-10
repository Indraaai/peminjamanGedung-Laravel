-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 26 Jul 2025 pada 16.29
-- Versi server: 8.0.30
-- Versi PHP: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjamangedung`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('peminjaman-gedung-cache-admin@freshmart.com|127.0.0.1', 'i:1;', 1753432027),
('peminjaman-gedung-cache-admin@freshmart.com|127.0.0.1:timer', 'i:1753432027;', 1753432027),
('peminjaman-gedung-cache-admin@gmail.ac.id|127.0.0.1', 'i:1;', 1753461152),
('peminjaman-gedung-cache-admin@gmail.ac.id|127.0.0.1:timer', 'i:1753461152;', 1753461152),
('peminjaman-gedung-cache-admin@unimal.ac.id|127.0.0.1', 'i:1;', 1753461117),
('peminjaman-gedung-cache-admin@unimal.ac.id|127.0.0.1:timer', 'i:1753461117;', 1753461117),
('peminjaman-gedung-cache-mahasiswa@email.com|127.0.0.1', 'i:1;', 1753432297),
('peminjaman-gedung-cache-mahasiswa@email.com|127.0.0.1:timer', 'i:1753432297;', 1753432297),
('peminjaman-gedung-cache-mahasiswa@unimal.ac.id|127.0.0.1', 'i:2;', 1753460840),
('peminjaman-gedung-cache-mahasiswa@unimal.ac.id|127.0.0.1:timer', 'i:1753460840;', 1753460840);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gedungs`
--

CREATE TABLE `gedungs` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gedungs`
--

INSERT INTO `gedungs` (`id`, `nama`, `deskripsi`, `lokasi`, `created_at`, `updated_at`) VALUES
(1, 'A3 Informatika', 'gedung kuliah umum A', 'Bukit Indah', '2025-07-23 11:59:11', '2025-07-25 00:46:56'),
(2, 'Gedung Dekanat', 'Gedung Dekanat Universitas Malikussaleh', 'Bukit Indah', '2025-07-25 00:47:40', '2025-07-25 00:47:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_21_061655_create_profil_mahasiswas_table', 2),
(5, '2025_07_21_061656_create_profil_dosens_table', 2),
(6, '2025_07_21_071519_rename_program_studi_to_jurusan_in_profil_mahasiswas_table', 3),
(7, '2025_07_23_181829_create_gedungs_table', 4),
(8, '2025_07_23_181829_create_ruangans_table', 4),
(9, '2025_07_24_152612_create_peminjamans_table', 5),
(10, '2025_07_25_225612_add_indexes_to_peminjamans_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ruangan_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `peminjamans`
--

INSERT INTO `peminjamans` (`id`, `user_id`, `ruangan_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `tujuan`, `dokumen`, `status`, `catatan_admin`, `created_at`, `updated_at`) VALUES
(2, 6, 1, '2025-07-25', '08:15:00', '15:15:00', 'ganteng', 'dokumen/YQEt0PTbdc2zdTmPXjfXFksuEHF9HbXn5m1B9SEA.pdf', 'disetujui', NULL, '2025-07-24 10:11:44', '2025-07-24 10:58:06'),
(3, 6, 1, '2025-07-28', '03:02:00', '06:02:00', 'party', 'dokumen/1t3MMrCi42ihynjiQW9ek6wSwlYtFAQQEZxK8aeG.pdf', 'disetujui', NULL, '2025-07-24 11:03:15', '2025-07-24 11:39:47'),
(4, 5, 1, '2025-07-29', '05:08:00', '06:09:00', 'Seminar', 'dokumen/DIw4gTeB4nFS9ziG4CFjtAH1upyKUPzlVCpvpR4T.pdf', 'disetujui', NULL, '2025-07-24 11:04:36', '2025-07-25 01:29:01'),
(5, 5, 3, '2025-07-25', '08:16:00', '17:18:00', 'hbdshbchsbdj', 'dokumen/BmMTdnKXmqNr3rtZwGMovHNzsP3DTQWXKca8HUaR.pdf', 'disetujui', NULL, '2025-07-25 01:17:06', '2025-07-25 01:28:47'),
(8, 7, 3, '2025-07-30', '09:00:00', '12:00:00', 'Rapat Himpunan', 'dokumen/QfWalY3kvlRRn3oWjP5GhKAElc73yaiOr3LBcFv3.pdf', 'disetujui', 'Silahkan datang ke ruang biro dengan membawa bukti peminjaman', '2025-07-25 16:30:11', '2025-07-25 16:33:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_dosens`
--

CREATE TABLE `profil_dosens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nidn_nip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Departemen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profil_dosens`
--

INSERT INTO `profil_dosens` (`id`, `user_id`, `nidn_nip`, `fakultas`, `Departemen`, `created_at`, `updated_at`) VALUES
(1, 5, '43343425', 'Teknik', 'Teknik', '2025-07-21 00:30:02', '2025-07-21 00:30:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_mahasiswas`
--

CREATE TABLE `profil_mahasiswas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profil_mahasiswas`
--

INSERT INTO `profil_mahasiswas` (`id`, `user_id`, `nim`, `fakultas`, `jurusan`, `created_at`, `updated_at`) VALUES
(1, 6, '22017788', 'Teknik', 'Teknik Informatika', '2025-07-21 00:17:15', '2025-07-21 00:17:15'),
(2, 7, '220170096', 'Teknik', 'Teknik Informatika', '2025-07-25 16:20:49', '2025-07-25 16:20:49'),
(3, 8, '220170103', 'Teknik', 'Teknik Informatika', '2025-07-25 17:17:37', '2025-07-25 17:17:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangans`
--

CREATE TABLE `ruangans` (
  `id` bigint UNSIGNED NOT NULL,
  `gedung_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `fasilitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ruangans`
--

INSERT INTO `ruangans` (`id`, `gedung_id`, `nama`, `kapasitas`, `fasilitas`, `foto`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lab informatika', 35, 'Ac, Proyektor dan Tempat duduk', 'foto-ruangan/9BU4crNUTeO0L3EqjtPqeNGQVbwuSlS8shUNUBCD.jpg', '2025-07-24 01:34:14', '2025-07-24 23:48:58'),
(3, 2, 'Auditorium', 70, 'Ac, Meja, Sound', 'foto-ruangan/JEaWqyGTzcQtWWTkeXVK8VwZShtEBwelpXGJbw4v.jpg', '2025-07-25 00:48:39', '2025-07-25 00:48:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2NYWyJiRi8lgAttUxtM23TsgRxkqXaQg3Ryw4Pin', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSDFNd1B1U1JCU1p6WlE1OEkwQ0tNc0w2SzJjWUtXdVo3RjN3VlYyZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nLXJ1YW5nYW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O30=', 1753465578);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-07-20 23:09:26', '$2y$12$t6RHP7sh4Y89HCOtQgoFMudXvbuUIHktSayFGKtap3axNAROWGfti', 'mahasiswa', 'kbExEtCyKX', '2025-07-20 23:09:26', '2025-07-20 23:09:26'),
(2, 'Admin', 'admin@unimal.ac.id', NULL, '$2y$12$ZskW.qfUq/4GfMjRjyuBCuZ1rSJTta1a3VUDB5nD9CgMnuN5ViECe', 'admin', '2Z6MbQe3VL9bpw4yjoxx2b1E171aN2W2QZSKKPrjuMOSvaCMkTT8UENvLsJz', '2025-07-20 23:09:26', '2025-07-25 17:28:40'),
(5, 'Dosen', 'dosen123@gmail.com', NULL, '$2y$12$o2G2pOy5ixTuZ12tefsVD.uKrwtS9ejmGTplUKEfpUWTtuJTUG7HS', 'dosen', NULL, '2025-07-21 00:00:07', '2025-07-21 00:00:07'),
(6, 'Indra firmansyah', 'mahasiswa@gmail.com', NULL, '$2y$12$n0l3Psj/Z1h0pusLYDzbd.OaW4I4/BBFLyqvr2hJE2wfleD/S0m/u', 'mahasiswa', NULL, '2025-07-21 00:01:14', '2025-07-21 00:01:14'),
(7, 'Hesty Sisya Olivia', 'hesty@unimal.ac.id', NULL, '$2y$12$W4tRMOPvSCLR4tJkSqkk6.hity2s9jJo067vMK3LjrzeAYJbAGEYK', 'mahasiswa', NULL, '2025-07-25 16:17:09', '2025-07-25 16:35:23'),
(8, 'Bayu Winata', 'bayu@gmail.com', NULL, '$2y$12$pqjtSYiciN32DqFOeAsi7Oi7lWiDewKboMX/VBPX/iJvuNajkGnj6', 'mahasiswa', NULL, '2025-07-25 17:17:18', '2025-07-25 17:17:18');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gedungs`
--
ALTER TABLE `gedungs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjamans_conflict_check` (`ruangan_id`,`tanggal`,`status`),
  ADD KEY `peminjamans_date_status` (`tanggal`,`status`),
  ADD KEY `peminjamans_user_status` (`user_id`,`status`),
  ADD KEY `peminjamans_date` (`tanggal`);

--
-- Indeks untuk tabel `profil_dosens`
--
ALTER TABLE `profil_dosens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profil_dosens_nidn_nip_unique` (`nidn_nip`),
  ADD KEY `profil_dosens_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `profil_mahasiswas`
--
ALTER TABLE `profil_mahasiswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profil_mahasiswas_nim_unique` (`nim`),
  ADD KEY `profil_mahasiswas_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `ruangans`
--
ALTER TABLE `ruangans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruangans_gedung_id_foreign` (`gedung_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gedungs`
--
ALTER TABLE `gedungs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `profil_dosens`
--
ALTER TABLE `profil_dosens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `profil_mahasiswas`
--
ALTER TABLE `profil_mahasiswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ruangans`
--
ALTER TABLE `ruangans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profil_dosens`
--
ALTER TABLE `profil_dosens`
  ADD CONSTRAINT `profil_dosens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profil_mahasiswas`
--
ALTER TABLE `profil_mahasiswas`
  ADD CONSTRAINT `profil_mahasiswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruangans`
--
ALTER TABLE `ruangans`
  ADD CONSTRAINT `ruangans_gedung_id_foreign` FOREIGN KEY (`gedung_id`) REFERENCES `gedungs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
