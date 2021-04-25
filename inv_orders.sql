-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2021 at 06:00 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inv_orders`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory_categories`
--

CREATE TABLE `inventory_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `root_id` int(11) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_page` int(11) DEFAULT '0',
  `ware_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT '1' COMMENT 'active = 1 and inactive = 2',
  `category_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_categories`
--

INSERT INTO `inventory_categories` (`id`, `root_id`, `category_name`, `category_code`, `short_name`, `home_page`, `ware_id`, `status`, `category_image`, `created_at`, `updated_at`) VALUES
(1, 0, 'Fruits & Vegetables', '1234', NULL, 0, 0, 1, NULL, NULL, NULL),
(3, 0, 'Meat & Fish', '1234', NULL, 0, 0, 1, NULL, NULL, NULL),
(4, 0, 'Snacks', '1234', NULL, 0, 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(255) DEFAULT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` int(20) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1=active,2=incative',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_settings`
--

CREATE TABLE `role_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active,2=inactive',
  `trash` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=not trash,1=trash',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_settings`
--

INSERT INTO `role_settings` (`id`, `role_name`, `status`, `trash`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, 0, NULL, NULL),
(2, 'Manager', 1, 0, NULL, NULL),
(3, 'Developer', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ware_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=active,2=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `ware_id`, `role_id`, `status`) VALUES
(104, 'admin', 'Admin', NULL, NULL, '123', NULL, NULL, NULL, 0, 1, 1),
(124, 'tasnim', 'Tasnim', NULL, NULL, '123', NULL, NULL, NULL, 0, 3, 1),
(125, 'rimon', 'Rimon', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(127, 'mizan', 'Mizan', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(128, 'nasir', 'Nasir', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(129, 'waleed', 'Waleed', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(130, 'maruf', 'Maruf', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(131, 'arman', 'Arman', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(132, 'sayem', 'Sayem', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(133, 'sudipto', 'Sudipto', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(134, 'ismail', 'Ismail', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(135, 'sahid', 'Sahid', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(136, 'amin', 'Amin', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(138, 'nasif', 'Nasif', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(139, 'rejaur', 'Rejaur', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1),
(140, 'tuser', 'Tuser', NULL, NULL, '$2y$10$gbtgMJkEqsjjD4RqFqgdnODmShGOxHjfuopbUwFdHOaHuGbRCaFxG', NULL, NULL, NULL, 0, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `role_settings`
--
ALTER TABLE `role_settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_settings`
--
ALTER TABLE `role_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
