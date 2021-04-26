-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2021 at 09:03 PM
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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `qty` float NOT NULL DEFAULT '0',
  `price` float NOT NULL,
  `order_status` int(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_id`, `product_id`, `qty`, `price`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 124, 1619462069124, 15, 4, 120, 1, '2021-04-26 20:34:29', NULL),
(2, 124, 1619462083124, 14, 6, 118, 1, '2021-04-26 20:34:43', NULL),
(3, 124, 1619462101124, 16, 2, 30, 1, '2021-04-26 20:35:01', NULL),
(4, 124, 1619462417124, 14, 10, 118, 1, '2021-04-26 20:40:17', NULL),
(5, 124, 1619462703124, 15, 5, 120, 1, '2021-04-26 20:45:03', NULL),
(6, 124, 1619462758124, 15, 5, 120, 1, '2021-04-26 20:45:58', NULL),
(7, 124, 1619462775124, 17, 3, 200, 1, '2021-04-26 20:46:15', NULL),
(8, 124, 1619462831124, 15, 2, 120, 1, '2021-04-26 20:47:11', NULL),
(9, 124, 1619462914124, 18, 5, 459, 1, '2021-04-26 20:48:34', NULL),
(10, 124, 1619462956124, 16, 2, 30, 1, '2021-04-26 20:49:16', NULL),
(11, 124, 1619462975124, 15, 2, 120, 1, '2021-04-26 20:49:35', NULL),
(12, 124, 1619463015124, 15, 2, 120, 1, '2021-04-26 20:50:15', NULL),
(13, 124, 1619463039124, 15, 1, 120, 1, '2021-04-26 20:50:39', NULL),
(14, 124, 1619463095124, 16, 1, 30, 1, '2021-04-26 20:51:35', NULL),
(15, 124, 1619463146124, 16, 1, 30, 3, '2021-04-26 20:52:26', NULL),
(16, 124, 1619463182124, 16, 1, 30, 1, '2021-04-26 20:53:02', NULL),
(17, 124, 1619463215124, 15, 2, 120, 4, '2021-04-26 20:53:35', NULL),
(18, 124, 1619463234124, 15, 1, 120, 1, '2021-04-26 20:53:54', NULL),
(19, 125, 1251619463386, 15, 2, 120, 3, '2021-04-26 20:56:26', NULL),
(20, 124, 1241619463717, 19, 4, 498, 1, '2021-04-26 21:01:57', NULL),
(21, 124, 1241619464267, 16, 4, 30, 2, '2021-04-26 21:11:07', NULL),
(22, 124, 1241619465704, 15, 3, 120, 4, '2021-04-26 21:35:04', NULL),
(23, 124, 1241619465764, 15, 2, 120, 3, '2021-04-26 21:36:04', NULL),
(24, 124, 1241619473738, 17, 3, 200, 4, '2021-04-26 23:48:58', NULL),
(25, 125, 1251619477876, 14, 3, 118, 3, '2021-04-27 00:57:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_status_details`
--

CREATE TABLE `order_status_details` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `sort_id` int(11) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1=active,2=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_status_details`
--

INSERT INTO `order_status_details` (`id`, `name`, `sort_id`, `status`) VALUES
(1, 'Pending', 1, 1),
(2, 'Processing', 2, 1),
(3, 'Shipped', 3, 1),
(4, 'Delivered', 4, 1);

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
  `trash` int(1) NOT NULL DEFAULT '1' COMMENT '1=not trash,2=trash',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `sku`, `description`, `price`, `image`, `status`, `trash`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(7, 'sfafa', 3, '123456', 'erqr', 665, '1619353114.png', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'test', 3, '1234', 'test', 300, '1619356087.png', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'aadfa', 3, '54', 'test', 48, '1619356157.png', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'aadfa', 3, '567657', '5675', 56755, '1619356956.png', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'gsdfgs', 1, '12345', 'asfsa', 555, '1619357089.png', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '567657', 4, '5676576', '567657', 54, '1619358943.png', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'dfadfsaf', 1, '123', 'sfadf', 653, '1619359236.png', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Malta (Special Offer)', 1, '1', 'Malta, a variety of orange, is a popular citrus fruit cultivated in hot climate. The fruit is rich in mineral salts', 118, '1619359668.png', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Banana Sagor', 3, '4', 'test', 200, '1619359810.png', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Green Coconut', 4, '5', 'Green coconut or young coconut is a very popular fruit all over the world. Green coconut produces more water than the brown or mature coconut. It is a complete food rich in calories, vitamins, and minerals. One whole green coconut contains roughly 140 calories, 28 grams of carbohydrates, 2 grams fiber, 3 grams fat, and 2 grams of protein. Coconut water is a very refreshing drink to beat tropical summer thirst. It is also a very good source of B-complex vitamins. These vitamins are essential in the sense that body requires them from external sources to replenish. Coconut water contains a very good amount of potassium. Coconut’s water reduce the risk of heart disease, boost your daily energy.', 459, '1619371625.png', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Cherry Pineapple', 3, '2', 'Malta, a variety of orange, is a popular citrus fruit cultivated in hot climate. The fruit is rich in mineral salts and other ingredients of nutritive value such as iron, lime, phosphorus, and vital minerals. Malta is loaded with vitamin C and vitamin B complex.', 120, '1619359711.png', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Watermelon', 4, '3', 'It has a rough-surfaced orange ringed with a segment of around 9.67 centimetres and a sweet-tasting juice content of around 33.7 per cent. The fruit is often used to make processed juice, jam, jelly and marmalade.', 30, '1619359759.png', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Guava Thai', 1, '6', 'Guava is a tropical fruit rich in high-profile nutrients. Thai guavas are generally the size of a softball with apple green skin that can range from bumpy to smooth. The flesh is white with pale yellow seeds and tends to be drier than the pink type of guavas. ', 498, '1619372592.png', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL);

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
(124, 'tasnim', 'Tasnim', NULL, NULL, '123', NULL, NULL, NULL, 0, 2, 1),
(125, 'rimon', 'Rimon', NULL, NULL, '123', NULL, NULL, NULL, 0, 2, 1),
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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status_details`
--
ALTER TABLE `order_status_details`
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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
