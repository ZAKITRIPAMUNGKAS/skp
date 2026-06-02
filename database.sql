-- MySQL Dump of ARQAM Database Schema
-- Generated from Laravel Migrations

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------
-- Table structure for users
-- ---------------------------------------------------------
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','panitia','peserta') NOT NULL DEFAULT 'peserta',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for password_reset_tokens
-- ---------------------------------------------------------
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for sessions
-- ---------------------------------------------------------
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for cache
-- ---------------------------------------------------------
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for cache_locks
-- ---------------------------------------------------------
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for jobs
-- ---------------------------------------------------------
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for job_batches
-- ---------------------------------------------------------
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for failed_jobs
-- ---------------------------------------------------------
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for peserta
-- ---------------------------------------------------------
CREATE TABLE `peserta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nama_lengkap` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peserta_user_id_index` (`user_id`),
  CONSTRAINT `peserta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for events
-- ---------------------------------------------------------
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint unsigned DEFAULT NULL,
  `nama_event` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `status` enum('persiapan','berlangsung','selesai') NOT NULL DEFAULT 'persiapan',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_created_by_index` (`created_by`),
  CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for event_sesi
-- ---------------------------------------------------------
CREATE TABLE `event_sesi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `nama_sesi` varchar(255) NOT NULL,
  `urutan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at?` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_sesi_event_id_index` (`event_id`),
  CONSTRAINT `event_sesi_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for event_peserta
-- ---------------------------------------------------------
CREATE TABLE `event_peserta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_peserta_qr_code_unique` (`qr_code`),
  KEY `event_peserta_event_id_index` (`event_id`),
  KEY `event_peserta_peserta_id_index` (`peserta_id`),
  CONSTRAINT `event_peserta_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_peserta_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for event_panitia
-- ---------------------------------------------------------
CREATE TABLE `event_panitia` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `akses` enum('owner','viewer') NOT NULL DEFAULT 'owner',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_panitia_event_id_foreign` (`event_id`),
  KEY `event_panitia_user_id_foreign` (`user_id`),
  CONSTRAINT `event_panitia_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_panitia_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for soal
-- ---------------------------------------------------------
CREATE TABLE `soal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `tipe` enum('pretest','posttest') NOT NULL,
  `teks_soal` text NOT NULL,
  `urutan` int NOT NULL,
  `created_at?` timestamp NULL DEFAULT NULL,
  `updated_at?` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `soal_event_id_index` (`event_id`),
  CONSTRAINT `soal_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for pilihan_jawaban
-- ---------------------------------------------------------
CREATE TABLE `pilihan_jawaban` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `soal_id` bigint unsigned NOT NULL,
  `huruf` enum('A','B','C','D') NOT NULL,
  `teks_pilihan` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pilihan_jawaban_soal_id_index` (`soal_id`),
  CONSTRAINT `pilihan_jawaban_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for sesi_tes
-- ---------------------------------------------------------
CREATE TABLE `sesi_tes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `tipe` enum('pretest','posttest') NOT NULL,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `durasi_menit` int DEFAULT NULL,
  `status` enum('belum_buka','aktif','tutup') NOT NULL DEFAULT 'belum_buka',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sesi_tes_event_id_index` (`event_id`),
  CONSTRAINT `sesi_tes_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for jawaban_peserta
-- ---------------------------------------------------------
CREATE TABLE `jawaban_peserta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `soal_id` bigint unsigned NOT NULL,
  `pilihan_id` bigint unsigned NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jawaban_peserta_event_id_index` (`event_id`),
  KEY `jawaban_peserta_peserta_id_index` (`peserta_id`),
  KEY `jawaban_peserta_soal_id_index` (`soal_id`),
  KEY `jawaban_peserta_pilihan_id_index` (`pilihan_id`),
  CONSTRAINT `jawaban_peserta_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_peserta_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_peserta_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_peserta_pilihan_id_foreign` FOREIGN KEY (`pilihan_id`) REFERENCES `pilihan_jawaban` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for absensi
-- ---------------------------------------------------------
CREATE TABLE `absensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `sesi_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `waktu_scan` timestamp NULL DEFAULT NULL,
  `scanned_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `absensi_event_id_index` (`event_id`),
  KEY `absensi_sesi_id_index` (`sesi_id`),
  KEY `absensi_peserta_id_index` (`peserta_id`),
  KEY `absensi_scanned_by_index` (`scanned_by`),
  CONSTRAINT `absensi_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_scanned_by_foreign` FOREIGN KEY (`scanned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `event_sesi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for afektif_sub_aspek
-- ---------------------------------------------------------
CREATE TABLE `afektif_sub_aspek` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `nama_sub_aspek` varchar(255) NOT NULL,
  `sesi_id` bigint unsigned DEFAULT NULL,
  `urutan` int NOT NULL,
  `status` enum('belum_buka','aktif','tutup') NOT NULL DEFAULT 'belum_buka',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `afektif_sub_aspek_event_id_index` (`event_id`),
  KEY `afektif_sub_aspek_sesi_id_index` (`sesi_id`),
  CONSTRAINT `afektif_sub_aspek_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `afektif_sub_aspek_sesi_id_foreign` FOREIGN KEY (`sesi_id`) REFERENCES `event_sesi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for afektif_butir
-- ---------------------------------------------------------
CREATE TABLE `afektif_butir` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sub_aspek_id` bigint unsigned NOT NULL,
  `teks_pernyataan` text NOT NULL,
  `is_positif` tinyint(1) NOT NULL DEFAULT '1',
  `urutan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `afektif_butir_sub_aspek_id_index` (`sub_aspek_id`),
  CONSTRAINT `afektif_butir_sub_aspek_id_foreign` FOREIGN KEY (`sub_aspek_id`) REFERENCES `afektif_sub_aspek` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for afektif_jawaban
-- ---------------------------------------------------------
CREATE TABLE `afektif_jawaban` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `sub_aspek_id` bigint unsigned NOT NULL,
  `butir_id` bigint unsigned NOT NULL,
  `jawaban` enum('SS','S','TS','STS') NOT NULL,
  `skor` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `afektif_jawaban_event_id_index` (`event_id`),
  KEY `afektif_jawaban_peserta_id_index` (`peserta_id`),
  KEY `afektif_jawaban_sub_aspek_id_index` (`sub_aspek_id`),
  KEY `afektif_jawaban_butir_id_index` (`butir_id`),
  CONSTRAINT `afektif_jawaban_butir_id_foreign` FOREIGN KEY (`butir_id`) REFERENCES `afektif_butir` (`id`) ON DELETE CASCADE,
  CONSTRAINT `afektif_jawaban_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `afektif_jawaban_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE,
  CONSTRAINT `afektif_jawaban_sub_aspek_id_foreign` FOREIGN KEY (`sub_aspek_id`) REFERENCES `afektif_sub_aspek` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for psikomotor_template
-- ---------------------------------------------------------
CREATE TABLE `psikomotor_template` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `jenis` enum('outbound','ibadah') NOT NULL,
  `nama_aspek` varchar(255) NOT NULL,
  `skor_maks` int NOT NULL DEFAULT '4',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `psikomotor_template_event_id_index` (`event_id`),
  CONSTRAINT `psikomotor_template_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for psikomotor_nilai
-- ---------------------------------------------------------
CREATE TABLE `psikomotor_nilai` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `template_id` bigint unsigned NOT NULL,
  `skor` int NOT NULL,
  `dinilai_oleh` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `psikomotor_nilai_event_id_index` (`event_id`),
  KEY `psikomotor_nilai_peserta_id_index` (`peserta_id`),
  KEY `psikomotor_nilai_template_id_index` (`template_id`),
  KEY `psikomotor_nilai_dinilai_oleh_index` (`dinilai_oleh`),
  CONSTRAINT `psikomotor_nilai_dinilai_oleh_foreign` FOREIGN KEY (`dinilai_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `psikomotor_nilai_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `psikomotor_nilai_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE,
  CONSTRAINT `psikomotor_nilai_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `psikomotor_template` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for angket_item
-- ---------------------------------------------------------
CREATE TABLE `angket_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `kategori` enum('A','B','C','D','E','F','G','H','I') NOT NULL,
  `teks_item` text NOT NULL,
  `urutan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `angket_item_event_id_index` (`event_id`),
  CONSTRAINT `angket_item_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for angket_jawaban
-- ---------------------------------------------------------
CREATE TABLE `angket_jawaban` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `jawaban` enum('A','B','C','D') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `angket_jawaban_event_id_index` (`event_id`),
  KEY `angket_jawaban_peserta_id_index` (`peserta_id`),
  KEY `angket_jawaban_item_id_index` (`item_id`),
  CONSTRAINT `angket_jawaban_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `angket_jawaban_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `angket_item` (`id`) ON DELETE CASCADE,
  CONSTRAINT `angket_jawaban_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for angket_komentar
-- ---------------------------------------------------------
CREATE TABLE `angket_komentar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `angket_komentar_event_id_index` (`event_id`),
  KEY `angket_komentar_peserta_id_index` (`peserta_id`),
  CONSTRAINT `angket_komentar_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `angket_komentar_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for ahp_bobot
-- ---------------------------------------------------------
CREATE TABLE `ahp_bobot` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `matriks` json NOT NULL,
  `bobot_c1` decimal(8,6) NOT NULL,
  `bobot_c2` decimal(8,6) NOT NULL,
  `bobot_c3` decimal(8,6) NOT NULL,
  `bobot_c4` decimal(8,6) NOT NULL,
  `bobot_c5` decimal(8,6) NOT NULL,
  `cr_value` decimal(8,6) NOT NULL,
  `is_consistent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ahp_bobot_event_id_index` (`event_id`),
  CONSTRAINT `ahp_bobot_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for penilaian_akhir
-- ---------------------------------------------------------
CREATE TABLE `penilaian_akhir` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint unsigned NOT NULL,
  `peserta_id` bigint unsigned NOT NULL,
  `nilai_pretest` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_posttest` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_afektif` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_psikomotor` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_kehadiran` decimal(5,2) NOT NULL DEFAULT '0.00',
  `skor_saw` decimal(8,6) NOT NULL DEFAULT '0.000000',
  `ranking` int DEFAULT NULL,
  `predikat` enum('Amat Baik','Baik','Cukup','Kurang') DEFAULT NULL,
  `status_kelulusan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_akhir_event_id_index` (`event_id`),
  KEY `penilaian_akhir_peserta_id_index` (`peserta_id`),
  CONSTRAINT `penilaian_akhir_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_akhir_peserta_id_foreign` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for activity_logs
-- ---------------------------------------------------------
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `description` text,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------
-- Table structure for system_settings
-- ---------------------------------------------------------
CREATE TABLE `system_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
