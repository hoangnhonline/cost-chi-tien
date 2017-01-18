-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2017 at 11:51 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gameduaxe_t_ceaa`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Miền Đông\n', '', '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(2, 'Miền Tây\r\n', '', '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(3, 'Miền Trung', '', '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(4, 'Hồ Chí Minh', '', '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(5, 'Duyên Hải Nam Trung Bộ và Tây Nguyên', '', '2017-01-17 00:00:00', '2017-01-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_no` varchar(100) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `bill_no` varchar(50) NOT NULL,
  `date_export` date NOT NULL,
  `product_cost` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `pay` int(11) NOT NULL DEFAULT '0',
  `owed` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `customer_id`, `bill_no`, `date_export`, `product_cost`, `tax`, `total_cost`, `pay`, `owed`, `created_at`, `updated_at`) VALUES
(1, 4, '0987654322', '2017-01-19', 120000, 12000, 132000, 0, 132000, '2017-01-19 05:43:20', '2017-01-19 05:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `bill_detail`
--

CREATE TABLE `bill_detail` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `unit` tinyint(1) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cost`
--

CREATE TABLE `cost` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `detail` text NOT NULL,
  `staff_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `date_use` date NOT NULL,
  `total_cost` int(11) NOT NULL,
  `sct` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1 nha may 2 van phong',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `tax_code` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `display_order` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'Phòng kế toán', 1, 1, '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(2, 'Phòng kinh doanh', 1, 2, '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(3, 'Phòng kế hoạch và điều vận\r\n', 2, 1, '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(4, 'Phòng Lab\r\n', 2, 1, '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(5, 'Phòng bảo trì - công nghệ sản xuất', 2, 3, '2017-01-17 00:00:00', '2017-01-17 00:00:00'),
(6, 'Phòng HSE', 2, 4, '2017-01-17 00:00:00', '2017-01-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE `pay` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `pay_date` date NOT NULL,
  `bill_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `tax_no` varchar(100) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `staff_code` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL COMMENT '3 super 2 giam doc 1 staff 0 customer',
  `type` tinyint(1) NOT NULL COMMENT '1 : staff 2 : customer',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `company_name`, `address`, `phone`, `tax_no`, `department_id`, `area_id`, `staff_code`, `email`, `password`, `role`, `type`, `status`, `remember_token`, `created_at`, `updated_at`, `last_login`) VALUES
(1, 'Tiên Hồ', NULL, NULL, NULL, NULL, 1, 0, 9999, 'tien.ho@apsaigonpetro.com.vn', '$2y$10$/vF4N2AKvZub7jnhWpTaWeBoejGkbad5DOx9IRfBTvKqWkzgPuTX6', 3, 1, 1, 'mqC01P4OKEJkSDd7DYF1EaYzlfgR527D0tyM3A5Giups6KueCRjNFVQV44Ij', '2017-01-14 00:00:00', '2017-01-17 17:26:51', '2017-01-14 00:00:00'),
(4, 'A Hoang', 'Cty ABC', NULL, '0917492306', '09876543', 0, 1, 0, 'hoangnhonline@gmail.com', '$2y$10$Ce8M2c3XTSMCvI9JPo6.3ONWzUH0WNcgUYds3rP5/kam.aZe1RG5.', 0, 2, 1, '', '2017-01-19 05:35:26', '2017-01-19 05:35:26', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_name` (`bank_name`),
  ADD KEY `account_name` (`account_name`),
  ADD KEY `account_no` (`account_no`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_no` (`bill_no`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `bill_no_2` (`bill_no`),
  ADD KEY `date_export` (`date_export`);

--
-- Indexes for table `bill_detail`
--
ALTER TABLE `bill_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `cost`
--
ALTER TABLE `cost`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_use` (`date_use`),
  ADD KEY `sct` (`sct`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `type` (`type`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `phone` (`phone`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `staff_code` (`staff_code`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bill_detail`
--
ALTER TABLE `bill_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cost`
--
ALTER TABLE `cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pay`
--
ALTER TABLE `pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
