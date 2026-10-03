-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2026 at 10:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dress_rental_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin|127.0.0.1', 'i:2;', 1790151271),
('laravel-cache-admin|127.0.0.1:timer', 'i:1790151271;', 1790151271),
('laravel-cache-arthittya23|127.0.0.1', 'i:1;', 1789122483),
('laravel-cache-arthittya23|127.0.0.1:timer', 'i:1789122483;', 1789122483),
('laravel-cache-ayayee|127.0.0.1', 'i:1;', 1790154971),
('laravel-cache-ayayee|127.0.0.1:timer', 'i:1790154971;', 1790154971),
('laravel-cache-ayayee22|127.0.0.1', 'i:1;', 1790162374),
('laravel-cache-ayayee22|127.0.0.1:timer', 'i:1790162374;', 1790162374),
('laravel-cache-yeyee22|127.0.0.1', 'i:1;', 1790162391),
('laravel-cache-yeyee22|127.0.0.1:timer', 'i:1790162391;', 1790162391);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dresses`
--

CREATE TABLE `dresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price_per_day` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dresses`
--

INSERT INTO `dresses` (`id`, `code`, `name`, `size`, `type`, `price_per_day`, `status`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'DR001', 'Brown Muse Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 60.00, 'available', 'dresses/p65M05DG1V2hq8VRRsw1iCcAGUPvLMrO6WMh2FFy.jpg', 'เซ็ตเสื้อเกาะอกสีน้ำตาลและกางเกงขาสั้น ดีไซน์วินเทจ 2 ชิ้น', '2026-09-09 21:55:38', '2026-09-23 04:15:08'),
(2, 'DR002', 'Ivory Lace Dress', 'ไซซ์ S/M', 'ชุดเดรส', 99.00, 'available', 'dresses/SHmSrQLDRLLJd19McEO2vsj0EODi9E6sBYF3asds.jpg', 'เดรสลูกไม้เปิดไหล่ ทรงยาวเข้ารูป ดีไซน์หวานหรู 1 ชิ้น', '2026-09-09 21:55:38', '2026-09-23 01:42:57'),
(3, 'DR003', 'Unigam Cream Dress', 'ไซซ์ S/M', 'ชุดเดรส', 50.00, 'available', 'dresses/rwcV09ELIH1cd86sKffRma229cJNaERk4QK0FfsA.jpg', 'เดรสแขนกุดสีครีม ดีไซน์เรียบหวานแต่งระบายชายกระโปรง \r\n1 ชิ้น', '2026-09-09 21:55:38', '2026-09-23 01:45:34'),
(4, 'DR004', 'Lemon Cream Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 60.00, 'available', 'dresses/G6vKvkllzCsXk4xyYxWa37CCHAkzbQim9m2PqTbY.jpg', 'เซ็ตเสื้อสายเดี่ยวและกระโปรงสั้นสีครีม ดีไซน์หวานละมุน \r\n2 ชิ้น', '2026-09-09 21:55:38', '2026-09-23 01:50:16'),
(5, 'DR005', 'Black Lace Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 69.00, 'available', 'dresses/XvKtQUpQz005mKUQWeUBIqbKiaswheuibcZoECCN.jpg', 'เซ็ตเสื้อเกาะอกแต่งลูกไม้และกระโปรงสั้นระบาย ดีไซน์เท่เซ็กซี่ \r\n3 ชิ้น', '2026-09-09 21:55:38', '2026-09-23 01:54:00'),
(6, 'DR006', 'Mari White Dress', 'ไซซ์ S/M', 'ชุดเดรส', 99.00, 'rented', 'dresses/Aflk19BLYVU31T5QPQhM6mQDQSC4ZUSSX3xSQYJ1.jpg', 'เดรสสายเดี่ยวคอคล้อง ดีไซน์เรียบหรู เนื้อผ้าลายดอก 1 ชิ้น', '2026-09-09 21:55:39', '2026-09-23 05:33:49'),
(7, 'DR007', 'Black Sea Set', 'ไซซ์: S/M', 'ชุดเซ็ต', 60.00, 'available', 'dresses/EKyxTdhHBQlo2a4CxiUerwgNg66DJZWpBa0ogHPC.jpg', 'เซ็ตเสื้อเกาะอกและกระโปรงสั้น \r\nผ้าลูกไม้สีดำ 2 ชิ้น', '2026-09-09 21:55:39', '2026-09-23 04:15:38'),
(10, 'DR009', 'Blue Y2K Darling Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 60.00, 'available', 'dresses/Nu4CfS3er1JQrfDRd16PbB6OfJSvHA5prC8TuTwc.jpg', 'เสื้อเกาะอกสีฟ้าพาสเทลจับจีบผูกด้านหน้า แมตช์กระโปรงพลีทสีดำ 2 ชิ้น', '2026-09-11 02:15:40', '2026-09-23 01:52:49'),
(11, 'DR008', 'Brown Vintage Muse', 'ไซซ์ M', 'ชุดเซ็ต', 60.00, 'available', 'dresses/5t654IVs8PyTxkn1RY03kU6pHVTrkPSQuw9mMRMj.jpg', 'เสื้อคลุมซีทรูแขนพองสีขาว แมตช์เสื้อสายเดี่ยวสีน้ำตาลและกางเกงขาสั้น 4 ชิ้น', '2026-09-11 02:46:15', '2026-09-23 01:52:40'),
(12, 'DR010', 'White Wrap Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 69.00, 'available', 'dresses/BbEOE4UYI0VjdvTMcVp7o3CY4lv6gdvedhbgUOq1.jpg', 'เซ็ตเสื้อสายเดี่ยวดีไซน์พันรอบเอวและกางเกงยีนส์ขากว้าง \r\n2 ชิ้น', '2026-09-23 01:59:34', '2026-09-23 01:59:53'),
(13, 'DR011', 'Floral Bikini Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 50.00, 'available', 'dresses/HAca3OsGC9uZBRix9N0cO6Rvxyu8i6EL4CWacEzx.jpg', 'เซ็ตบิกินี่ลายดอกพร้อมกระโปรงสั้น ดีไซน์หวานสไตล์ซัมเมอร์\r\n3 ชิ้น', '2026-09-23 02:01:49', '2026-09-23 02:01:49'),
(14, 'DR012', 'Brown Vintage Dress', 'ไซซ์ S/M', 'ชุดเดรส', 60.00, 'available', 'dresses/PRsC2u5tqr1A2BjSLYU8PqVwOHZ3rgJdve43h4sN.jpg', 'เดรสสีน้ำตาลทรงคอร์เซ็ต กระโปรงระบาย ดีไซน์วินเทจหวาน ๆ', '2026-09-23 02:26:10', '2026-09-23 02:26:10'),
(15, 'DR013', 'White Stripe Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 60.00, 'available', 'dresses/qZYMnTREnwpL1wUTvMM6EXB66wXGXAomA5gUltTy.jpg', 'เซ็ตเสื้อเกาะอกและกางเกงขายาวลายทางสีขาว ดีไซน์เรียบมินิมอล 2 ชิ้น', '2026-09-23 03:55:51', '2026-09-23 03:55:51'),
(16, 'DR014', 'Street Black Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 65.00, 'available', 'dresses/aR7ONoZ9o5KTZHl7IMLXuya8AEfjdWlWcGnQ70a0.jpg', 'เซ็ตเสื้อกล้ามและกางเกงคาร์โก้ขากว้าง ดีไซน์สตรีทเท่ ๆ\r\n3 ชิิ้น', '2026-09-23 04:00:01', '2026-09-23 04:00:01'),
(17, 'DR015', 'White Lace Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 60.00, 'available', 'dresses/Ii1FcE8AS7hwfCqjkmg66thUTleKBHXNV851rAL2.jpg', 'เซ็ตเสื้อลูกไม้แขนยาวและกระโปรงสั้น ดีไซน์หวานเซ็กซี่\r\n2 ชิ้น', '2026-09-23 04:02:07', '2026-09-23 04:02:07'),
(18, 'DR016', 'Pink Lace Set', 'ไซซ์ S/M', 'ชุดเซ็ต', 60.00, 'booked', 'dresses/EYHif2VehLOmtp4A8MaR2CrGs5nSgq6EeHUzQgfy.jpg', 'เซ็ตเสื้อลูกไม้สายเดี่ยวและกระโปรงสั้นลายลูกไม้ ดีไซน์หวานละมุน \r\n2 ชิ้น', '2026-09-23 04:08:45', '2026-09-23 04:13:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_09_121141_add_role_to_users_table', 2),
(5, '2026_09_09_131923_add_role_to_users_table', 3),
(6, '2026_09_09_132747_add_username_to_users_table', 4),
(7, '2026_09_10_100000_create_dresses_table', 5),
(8, '2026_09_10_100100_create_rentals_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dress_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `rental_days` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price_per_day` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `return_condition` varchar(255) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `dress_id`, `start_date`, `end_date`, `rental_days`, `price_per_day`, `total_price`, `status`, `rejection_reason`, `return_condition`, `return_note`, `approved_at`, `returned_at`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2026-09-16', '2026-09-18', 3, 550.00, 1650.00, 'returned', NULL, 'สภาพปกติ', NULL, '2026-09-11 01:14:30', '2026-09-11 01:19:03', '2026-09-11 01:14:20', '2026-09-11 01:19:03'),
(2, 1, 3, '2026-09-13', '2026-09-14', 2, 520.00, 1040.00, 'returned', NULL, 'สภาพปกติ', NULL, '2026-09-11 01:57:58', '2026-09-11 03:30:08', '2026-09-11 01:57:23', '2026-09-11 03:30:08'),
(3, 4, 1, '2026-09-13', '2026-09-14', 2, 550.00, 1100.00, 'rejected', 'ไม่ผ่านการอนุมัติ', NULL, NULL, NULL, NULL, '2026-09-11 02:08:42', '2026-09-11 02:21:47'),
(4, 1, 2, '2026-09-18', '2026-09-19', 2, 490.00, 980.00, 'rejected', 'ชุดไม่ว่าง', NULL, NULL, NULL, NULL, '2026-09-11 02:28:49', '2026-09-11 02:29:07'),
(5, 1, 10, '2026-09-14', '2026-09-15', 2, 150.00, 300.00, 'pending', NULL, NULL, NULL, NULL, NULL, '2026-09-11 02:34:55', '2026-09-11 02:34:55'),
(6, 1, 18, '2026-09-24', '2026-09-24', 1, 60.00, 60.00, 'approved', NULL, NULL, NULL, '2026-09-23 04:13:16', NULL, '2026-09-23 04:12:03', '2026-09-23 04:13:16'),
(7, 1, 6, '2026-09-23', '2026-09-24', 1, 99.00, 99.00, 'renting', NULL, NULL, NULL, '2026-09-23 05:33:42', NULL, '2026-09-23 05:33:05', '2026-09-23 05:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zACkPCBxBf6sUx6rQgpLhDo2ux25pdOX0OWTvGq9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', 'eyJfdG9rZW4iOiJmUE9rb1ZhZk43U08yOHVDdDVSR2VoNnBrS3pQVnM3T2ZaMHk0Ynl3IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2N1c3RvbWVyXC9ob21lIiwicm91dGUiOiJjdXN0b21lci5ob21lIn0sInVybCI6eyJpbnRlbmRlZCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvcmVudGFscyJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1790167523);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'customer',
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'รพีพร ยางนอก', 'yayee22', 'customer', NULL, NULL, '$2y$12$X5jZRSgbL3X8eR63Swo9d.eU6vfn4T9EASCUvzsSEVORsIVqZGMXy', '4LRTFzrAHyEyVQ3ouPT3FweQ0Q3MuHrBMwGSWoXQxphvu20ZeW3DpA3t0o4C', '2026-09-09 06:48:21', '2026-09-09 06:48:21'),
(2, 'วิมลสิริ เงินพลับพลา', 'admin', 'admin', NULL, NULL, '$2y$12$MOgLA/0EHjqS9RxMLR1/PeIfMqQ6D..TiEVG2v.w/mlJBYDkrXj72', NULL, '2026-09-09 07:40:44', '2026-09-23 02:36:15'),
(3, 'จารุวรรณ เขื่อนงูเหลือม', 'owner', 'owner', NULL, NULL, '$2y$12$Sr.k5DzORsPiMPV/pSTt9upQLJT2AUpAXrFZWflohJvrobP2GLgsG', NULL, '2026-09-09 07:40:44', '2026-09-23 02:45:28'),
(4, 'อาทิตยา ศรียาลัย', 'Arthittaya23', 'customer', NULL, NULL, '$2y$12$KUgaibAaCCxtIsdSxiX/HucTwrFLnjw/F5Ak17BJlDxZNqDTdMhDi', NULL, '2026-09-10 05:50:33', '2026-09-10 05:50:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `dresses`
--
ALTER TABLE `dresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dresses_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rentals_user_id_foreign` (`user_id`),
  ADD KEY `rentals_dress_id_foreign` (`dress_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dresses`
--
ALTER TABLE `dresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_dress_id_foreign` FOREIGN KEY (`dress_id`) REFERENCES `dresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rentals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- WANWAN: payment fields, preserving existing rental data
ALTER TABLE `rentals`
 ADD COLUMN `slip_path` varchar(255) NULL,
 ADD COLUMN `slip_hash` varchar(64) NULL,
 ADD COLUMN `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
 ADD COLUMN `payment_message` varchar(255) NULL,
 ADD COLUMN `payment_reference` varchar(255) NULL,
 ADD COLUMN `paid_at` timestamp NULL,
 ADD UNIQUE KEY `rentals_slip_hash_unique` (`slip_hash`),
 ADD UNIQUE KEY `rentals_payment_reference_unique` (`payment_reference`);
INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_10_02_215547_add_payment_fields_to_rentals_table', 7);
