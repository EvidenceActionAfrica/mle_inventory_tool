-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 01:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mle_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `description`, `created_at`) VALUES
(1, 'Smart Phone', 'Samsung A52', '2025-03-12 17:37:56'),
(3, 'Mouse', 'Ligo', '2025-03-12 18:34:20'),
(5, 'Printer', 'Laser Printers', '2025-03-12 18:34:53'),
(9, 'Laptop', 'Macbook', '2025-03-12 18:45:08'),
(10, 'Mouse', 'hp', '2025-03-12 18:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `tag_number` varchar(255) DEFAULT NULL,
  `acquisition_date` date DEFAULT NULL,
  `acquisition_cost` decimal(10,2) DEFAULT NULL,
  `warranty_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `category_id`, `description`, `serial_number`, `tag_number`, `acquisition_date`, `acquisition_cost`, `warranty_date`, `created_at`) VALUES
(8, 10, 'hp', 'sn100', 'tag-001', '2025-03-05', 20.00, '2025-03-08', '2025-03-17 10:46:05'),
(9, 10, 'hp', '10928', 'tag-002', '2025-03-12', 18.00, '2025-04-11', '2025-03-17 10:46:34'),
(11, 9, 'Macbook', '4t5rfr5', 'tg-003', '2025-03-03', 100.00, '2025-04-24', '2025-03-17 10:47:09'),
(12, 9, 'Macbook', 'qwedfr987', 'ea-1991', '2025-03-12', 134.00, '2025-04-26', '2025-03-17 10:47:40'),
(13, 5, 'Laser Printers', 'qw23wese3', 'ea-1992', '2025-03-05', 456.00, '2025-04-10', '2025-03-17 10:48:18'),
(14, 5, 'Laser Printers', '234ede4', 'ea-111', '2025-03-14', 123.00, '2025-05-01', '2025-03-17 10:48:39'),
(15, 1, 'Samsung A52', '1q234', '1q2ws', '2025-03-14', 125.00, '2025-04-30', '2025-03-17 10:49:10'),
(16, 1, 'Samsung A52', '3ewr4r', '0987uj', '2025-03-17', 90.00, '2025-05-09', '2025-03-17 10:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assignment`
--

CREATE TABLE `inventory_assignment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `tag_number` varchar(255) NOT NULL,
  `managed_by` varchar(255) NOT NULL,
  `acknowledgment_status` enum('pending','acknowledged') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_assigned` date DEFAULT curdate(),
  `item` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT 'Amagoro Hub'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory_assignment`
--

INSERT INTO `inventory_assignment` (`id`, `name`, `email`, `role`, `serial_number`, `tag_number`, `managed_by`, `acknowledgment_status`, `created_at`, `updated_at`, `date_assigned`, `item`, `location`) VALUES
(37, 'admin@test.com', 'admin@test.com', 'IS Manager', '10928', 'tag-002', 'monitor', 'acknowledged', '2025-03-19 15:59:09', '2025-03-19 15:59:14', '2025-03-18', 9, 'Kuria Hub'),
(38, 'admin@test.com', 'admin@test.com', 'IS Manager', '1q234', '1q2ws', 'monitor', 'acknowledged', '2025-03-19 15:59:09', '2025-03-19 15:59:15', '2025-03-18', 15, 'Kuria Hub'),
(39, 'admin@test.com', 'admin@test.com', 'IS Manager', 'sn100', 'tag-001', 'monitor', 'acknowledged', '2025-03-20 04:57:19', '2025-03-20 04:57:24', '2025-03-20', 8, 'Amagoro Hub'),
(40, 'admin@test.com', 'admin@test.com', 'IS Manager', '4t5rfr5', 'tg-003', 'monitor', 'acknowledged', '2025-03-20 05:23:27', '2025-03-20 05:25:22', '2025-03-20', 11, 'Amagoro Hub'),
(43, 'admin@test.com', 'admin@test.com', 'IS Manager', '10928', 'tag-002', 'rhyttahkogi', 'pending', '2025-03-20 06:38:54', '2025-03-20 06:38:54', '2025-03-11', 9, 'Amagoro Hub'),
(44, 'staff@test.com', 'staff@test.com', 'MLE Associate IS', '3ewr4r', '0987uj', 'tech', 'acknowledged', '2025-03-20 12:42:30', '2025-03-20 12:42:38', '2025-03-19', 16, 'Kuria Hub');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_returned`
--

CREATE TABLE `inventory_returned` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `returned_by` varchar(255) NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `item_state` enum('functional','damaged','lost') DEFAULT 'functional',
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `repair_status` enum('Repairable','Unrepairable') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory_returned`
--

INSERT INTO `inventory_returned` (`id`, `assignment_id`, `return_date`, `receiver_id`, `returned_by`, `status`, `item_state`, `approved_by`, `approved_date`, `repair_status`, `created_at`, `updated_at`) VALUES
(49, 37, '2025-03-19', 2, 'admin@test.com', 'approved', 'damaged', NULL, '2025-03-19 19:00:18', 'Repairable', '2025-03-19 15:59:38', '2025-03-19 16:00:25'),
(50, 38, '2025-03-19', 2, 'admin@test.com', 'approved', 'damaged', NULL, '2025-03-19 19:00:32', 'Unrepairable', '2025-03-19 15:59:38', '2025-03-19 16:00:37'),
(52, 39, '2025-03-20', 2, 'admin@test.com', 'approved', 'lost', NULL, '2025-03-20 12:11:00', NULL, '2025-03-20 09:10:47', '2025-03-20 09:11:00'),
(53, 44, '2025-03-20', 2, 'staff@test.com', 'approved', 'functional', NULL, '2025-03-20 15:42:56', NULL, '2025-03-20 12:42:47', '2025-03-20 12:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`, `created_at`) VALUES
(2, 'Busia', '2025-03-13 09:07:55'),
(3, 'Chavakali', '2025-03-13 09:07:55'),
(4, 'Matunda', '2025-03-13 09:07:55'),
(5, 'Ugunja', '2025-03-13 09:07:55'),
(6, 'Nairobi', '2025-03-13 09:07:55'),
(12, 'Awendo', '2025-03-13 09:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` int(11) NOT NULL,
  `office_name` varchar(255) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `office_name`, `location_id`, `created_at`) VALUES
(1, 'Amagoro Hub', 2, '2025-03-13 10:08:13'),
(2, 'Awendo Field Office', 12, '2025-03-13 10:08:13'),
(3, 'Kuria Hub', 12, '2025-03-13 10:08:13'),
(4, 'Busia Field Office', 3, '2025-03-13 10:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `staff_login`
--

CREATE TABLE `staff_login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '$2y$10$[your_generated_hash_here]',
  `role` enum('super_admin','admin','staff') NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff_login`
--

INSERT INTO `staff_login` (`id`, `email`, `password`, `role`, `department`, `position`, `created_at`, `updated_at`) VALUES
(1, 'admin@test.com', '$2y$10$A/rGSd51afa7/5.lakeWP.AIH0noBnLfryKuaUtIZdLYkA0uKw2AS', 'super_admin', 'IS', 'Manager', '2025-03-12 13:13:02', '2025-03-14 09:52:04'),
(2, 'tech@test.com', '$2y$10$fMqQh24UHICP3P2Hml2lYefr0S/zjhBASBsyMDNDe8H8epVnNAxEW', 'admin', 'IT', 'Senior Manager', '2025-03-12 13:13:02', '2025-03-14 11:40:37'),
(3, 'quality@test.com', '$2y$10$eYftVMN2IY4MSIsOaEBD4uYFcwhAkeyjIdkDxBE3CuO7IZwwuVeyS', 'admin', 'QA/QC', 'Associate Manager', '2025-03-12 13:13:02', '2025-03-18 11:40:56'),
(4, 'monitor@test.com', '$2y$10$6n7ACWUT3EH41BYGnrVfGOIV5Wh3y4KARcOfoDkkpklTrU4Qty89u', 'admin', 'MLE', 'Director', '2025-03-12 13:13:02', '2025-03-18 11:41:58'),
(5, 'staff@test.com', '$2y$10$BpgfrYEf/vQzte42df1VAuL5Tq9syy6uwKrCz0IzhpLhMyzGTlsGq', 'staff', 'MLE', 'Associate IS', '2025-03-12 13:13:02', '2025-03-18 11:42:57'),
(7, 'rhyttahkogi@gmail.com', '$2y$10$r/H.vLc1QG5XgRdOqZ4VHewhcUjs9Z9NIHPYmBRV7Oz9sKLFM325C', 'staff', 'MLE-D', 'Associate IS', '2025-03-13 11:15:06', '2025-03-13 11:15:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD UNIQUE KEY `tag_number` (`tag_number`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_returned`
--
ALTER TABLE `inventory_returned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `location_name` (`location_name`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `staff_login`
--
ALTER TABLE `staff_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `inventory_returned`
--
ALTER TABLE `inventory_returned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff_login`
--
ALTER TABLE `staff_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_returned`
--
ALTER TABLE `inventory_returned`
  ADD CONSTRAINT `inventory_returned_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `inventory_assignment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_returned_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `staff_login` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_returned_ibfk_4` FOREIGN KEY (`approved_by`) REFERENCES `staff_login` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `offices`
--
ALTER TABLE `offices`
  ADD CONSTRAINT `offices_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
