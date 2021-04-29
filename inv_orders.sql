-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2021 at 07:49 PM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(123) NOT NULL,
  `role_id` int(1) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `user_name`, `password`, `role_id`, `status`) VALUES
(1, 'Admin', 'admin', '123', 1, 1);

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
(1, 'test-1', 3, '1', 'test', 222, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'test-2', 1, '2', 'test', 1504, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'test-3', 2, '3', 'test', 1749, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'test-4', 1, '4', 'test', 971, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'test-5', 2, '5', 'test', 1865, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'test-6', 1, '6', 'test', 1692, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'test-7', 3, '7', 'test', 374, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'test-8', 3, '8', 'test', 1474, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'test-9', 1, '9', 'test', 1027, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'test-10', 2, '10', 'test', 260, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'test-11', 1, '11', 'test', 417, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'test-12', 2, '12', 'test', 683, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'test-13', 3, '13', 'test', 779, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'test-14', 1, '14', 'test', 1451, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'test-15', 1, '15', 'test', 1599, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'test-16', 1, '16', 'test', 385, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'test-17', 1, '17', 'test', 1610, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'test-18', 3, '18', 'test', 1266, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'test-19', 1, '19', 'test', 1247, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'test-20', 1, '20', 'test', 486, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'test-21', 2, '21', 'test', 649, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'test-22', 3, '22', 'test', 1401, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'test-23', 2, '23', 'test', 617, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'test-24', 2, '24', 'test', 1924, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'test-25', 3, '25', 'test', 1943, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'test-26', 2, '26', 'test', 1041, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'test-27', 2, '27', 'test', 1404, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'test-28', 3, '28', 'test', 722, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'test-29', 1, '29', 'test', 1480, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'test-30', 2, '30', 'test', 231, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'test-31', 1, '31', 'test', 1375, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'test-32', 1, '32', 'test', 797, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'test-33', 3, '33', 'test', 375, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'test-34', 3, '34', 'test', 1745, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'test-35', 1, '35', 'test', 1233, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'test-36', 3, '36', 'test', 421, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'test-37', 2, '37', 'test', 1731, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'test-38', 2, '38', 'test', 310, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'test-39', 1, '39', 'test', 835, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'test-40', 2, '40', 'test', 647, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'test-41', 2, '41', 'test', 1861, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'test-42', 1, '42', 'test', 584, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'test-43', 3, '43', 'test', 732, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'test-44', 2, '44', 'test', 1122, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'test-45', 1, '45', 'test', 1154, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'test-46', 2, '46', 'test', 842, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'test-47', 2, '47', 'test', 1320, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'test-48', 3, '48', 'test', 556, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'test-49', 1, '49', 'test', 1559, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'test-50', 2, '50', 'test', 1640, '0', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL);

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
(2, 'User', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=active,2=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `name`, `password`, `role_id`, `status`) VALUES
(1, 'amin', 'Al Amin Prodhan', '123', 2, 1),
(2, 'rimon', 'Rimon', '123', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
