-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 07:14 PM
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
-- Database: `samastha_caravan`
--

-- --------------------------------------------------------

--
-- Table structure for table `caravans`
--

CREATE TABLE `caravans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `vehicle_number` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `driver_phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caravan_locations`
--

CREATE TABLE `caravan_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caravan_id` bigint(20) UNSIGNED NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `speed` decimal(8,2) DEFAULT NULL,
  `heading` decimal(5,2) DEFAULT NULL,
  `tracked_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `latitude`, `longitude`, `address`, `city`, `state`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Thiruvananthapuram', 'Capital city of Kerala', 8.52410000, 76.93660000, 'MG Road', 'Thiruvananthapuram', 'Kerala', 1, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(2, 'Kollam', 'Port city in Kerala', 8.89320000, 76.61410000, 'Kollam Beach', 'Kollam', 'Kerala', 2, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(3, 'Alappuzha', 'Venice of the East', 9.49810000, 76.33880000, 'Alappuzha Beach', 'Alappuzha', 'Kerala', 3, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(4, 'Kottayam', 'Land of Letters, Lakes and Latex', 9.59160000, 76.52220000, 'Kottayam Town', 'Kottayam', 'Kerala', 4, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(5, 'Kochi', 'Queen of Arabian Sea', 9.93120000, 76.26730000, 'Marine Drive', 'Kochi', 'Kerala', 5, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(6, 'Thrissur', 'Cultural Capital of Kerala', 10.52760000, 76.21440000, 'Round South', 'Thrissur', 'Kerala', 6, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(7, 'Palakkad', 'Gateway to Kerala', 10.78670000, 76.65480000, 'Palakkad Fort', 'Palakkad', 'Kerala', 7, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(8, 'Malappuram', 'City of Hills', 11.05090000, 76.07110000, 'Malappuram Town', 'Malappuram', 'Kerala', 8, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(9, 'Kozhikode', 'City of Spices', 11.25880000, 75.78040000, 'Beach Road', 'Kozhikode', 'Kerala', 9, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(10, 'Kannur', 'Crown of Kerala', 11.87450000, 75.37040000, 'Payyambalam Beach', 'Kannur', 'Kerala', 10, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(11, 'Kasaragod', 'Land of Gods', 12.49960000, 74.98690000, 'Kasaragod Town', 'Kasaragod', 'Kerala', 11, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(12, 'Idukki', 'Spice Garden of Kerala', 9.84970000, 76.97200000, 'Idukki Town', 'Idukki', 'Kerala', 12, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35'),
(13, 'Wayanad', 'Green Paradise', 11.68540000, 76.13200000, 'Kalpetta', 'Wayanad', 'Kerala', 13, 1, '2025-12-17 17:58:35', '2025-12-17 17:58:35');

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_01_000001_create_caravans_table', 1),
(3, '2024_01_01_000002_create_caravan_locations_table', 1),
(4, '2024_01_01_000000_create_users_table', 2),
(5, '2024_01_01_000003_create_destinations_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$WR.X7WwQL0B82SUcXvoCqeEv.8Rwme01UJY9rA2iBc6kF8Afkn3QO', 1, NULL, '2025-12-17 17:51:50', '2025-12-17 17:51:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caravans`
--
ALTER TABLE `caravans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `caravans_vehicle_number_unique` (`vehicle_number`);

--
-- Indexes for table `caravan_locations`
--
ALTER TABLE `caravan_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caravan_locations_caravan_id_index` (`caravan_id`),
  ADD KEY `caravan_locations_tracked_at_index` (`tracked_at`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caravans`
--
ALTER TABLE `caravans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caravan_locations`
--
ALTER TABLE `caravan_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `caravan_locations`
--
ALTER TABLE `caravan_locations`
  ADD CONSTRAINT `caravan_locations_caravan_id_foreign` FOREIGN KEY (`caravan_id`) REFERENCES `caravans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
