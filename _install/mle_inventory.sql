-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 07:40 AM
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
(10, 'Mouse', 'hp', '2025-03-12 18:45:20'),
(11, 'Laptop', 'Lenovo', '2025-03-24 10:17:45'),
(12, 'Laptop', 'hp', '2025-03-24 10:18:04'),
(13, 'Smart Phone', 'Samsung A33', '2025-03-24 10:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `created_at`, `parent_id`) VALUES
(11, 'MLE - D', '2025-03-26 08:36:02', NULL),
(12, 'Field Monitoring', '2025-03-26 08:38:24', 11),
(13, 'Data Analysis & Learning', '2025-03-26 08:39:01', 11),
(14, 'Quality Analysis & Control', '2025-03-26 08:39:36', 12),
(15, 'Field Monitoring(field)', '2025-03-26 08:40:27', 12),
(16, 'Information Systems', '2025-03-26 08:40:41', 13),
(17, 'Data Analysis', '2025-03-26 08:41:32', 13),
(18, 'Data Learning', '2025-03-26 08:41:42', 13),
(19, 'Data Management', '2025-03-26 08:42:11', 13),
(20, 'EV-AC', '2025-03-26 08:43:54', NULL);

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
(16, 1, 'Samsung A52', '3ewr4r', '0987uj', '2025-03-17', 90.00, '2025-05-09', '2025-03-17 10:49:34'),
(17, 13, 'Samsung A33', '432wed', 'ea-199', '2025-03-04', 40.00, '2025-04-26', '2025-03-24 10:18:54'),
(18, 13, 'Samsung A33', 'u7y6t5', 'ui787', '2025-03-10', 99.00, '2025-05-10', '2025-03-24 10:19:25'),
(19, 11, 'Lenovo', '9876tg', '7yhhy6', '2025-03-24', 145.00, '2025-06-12', '2025-03-24 10:19:54'),
(20, 11, 'Lenovo', '54rg5y6t', 'ea-1100', '2025-03-10', 78.00, '2025-05-30', '2025-03-24 10:20:27');

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
(52, 'florence@test.com', 'florence@test.com', '9 4', 'sn100', 'tag-001', 'quality', 'acknowledged', '2025-03-24 07:36:36', '2025-03-24 07:44:17', '2025-03-23', 8, 'Amagoro Hub'),
(53, 'rama@test.com', 'rama@test.com', '2 3', '4t5rfr5', 'tg-003', 'rhyttahkogi', 'acknowledged', '2025-03-24 09:24:33', '2025-03-24 09:27:04', '2025-03-24', 11, 'Awendo Field Office'),
(54, 'admin@test.com', 'admin@test.com', '2 4', 'qw23wese3', 'ea-1992', 'rama', 'acknowledged', '2025-03-24 09:25:25', '2025-03-24 09:26:56', '2025-03-10', 13, 'Amagoro Hub'),
(55, 'sharon@gmail.com', 'sharon@gmail.com', '2 6', '1q234', '1q2ws', 'rama', 'acknowledged', '2025-03-24 09:26:34', '2025-03-24 09:28:15', '2025-03-23', 15, 'Amagoro Hub'),
(56, 'rama@test.com', 'rama@test.com', '2 3', '4t5rfr5', 'tg-003', 'miss', 'acknowledged', '2025-03-24 09:38:13', '2025-03-24 09:38:21', '2025-03-24', 11, 'Busia Field Office'),
(57, 'miss@test.com', 'miss@test.com', '2 2', 'qwedfr987', 'ea-1991', 'rhyttahkogi', 'acknowledged', '2025-03-24 09:39:04', '2025-03-24 09:39:12', '2025-03-24', 12, 'Busia Field Office'),
(58, 'rhyttahkogi@gmail.com', 'rhyttahkogi@gmail.com', '2 1', '4t5rfr5', 'tg-003', 'rhyttahkogi', 'acknowledged', '2025-03-24 10:15:34', '2025-03-24 10:15:46', '2025-03-24', 11, 'Amagoro Hub'),
(59, 'miss@test.com', 'miss@test.com', '2 2', '10928', 'tag-002', 'rhyttahkogi', 'acknowledged', '2025-03-24 10:29:10', '2025-03-24 10:29:18', '2025-03-24', 9, 'Busia Field Office'),
(60, 'rama@test.com', 'rama@test.com', '2 3', '234ede4', 'ea-111', 'miss', 'acknowledged', '2025-03-24 10:30:00', '2025-03-24 10:31:48', '2025-03-23', 14, 'Busia Field Office'),
(61, 'admin@test.com', 'admin@test.com', '2 4', '432wed', 'ea-199', 'rama', 'acknowledged', '2025-03-24 10:35:00', '2025-03-24 10:35:05', '2025-03-24', 17, 'Busia Field Office'),
(62, 'sharon@gmail.com', 'sharon@gmail.com', '2 6', '3ewr4r', '0987uj', 'rama', 'acknowledged', '2025-03-24 10:35:23', '2025-03-24 10:39:49', '2025-03-24', 16, 'Awendo Field Office'),
(63, 'quality@test.com', 'quality@test.com', '14 3', '54rg5y6t', 'ea-1100', 'faridah', 'pending', '2025-03-26 09:45:36', '2025-03-26 09:45:36', '2025-03-26', 20, 'Busia Field Office');

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
(61, 53, '2025-03-24', 2, 'rama@test.com', 'approved', 'functional', NULL, '2025-03-24 12:37:30', NULL, '2025-03-24 09:37:06', '2025-03-24 09:37:30'),
(62, 54, '2025-03-24', 2, 'admin@test.com', 'approved', 'functional', NULL, '2025-03-24 12:56:19', NULL, '2025-03-24 09:53:33', '2025-03-24 09:56:19'),
(63, 57, '2025-03-24', 2, 'miss@test.com', 'approved', 'functional', NULL, '2025-03-24 12:56:22', NULL, '2025-03-24 09:53:48', '2025-03-24 09:56:22'),
(64, 56, '2025-03-24', 2, 'rama@test.com', 'approved', 'functional', NULL, '2025-03-24 12:56:25', NULL, '2025-03-24 09:54:54', '2025-03-24 09:56:25'),
(65, 55, '2025-03-24', 2, 'sharon@gmail.com', 'approved', 'functional', NULL, '2025-03-24 12:56:28', NULL, '2025-03-24 09:55:52', '2025-03-24 09:56:28'),
(66, 61, '2025-03-26', 2, 'admin@test.com', 'pending', 'functional', NULL, NULL, NULL, '2025-03-26 10:55:56', '2025-03-26 10:55:56');

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
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `hierarchy_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position_name`, `hierarchy_level`) VALUES
(1, 'Associate Director', 1),
(2, 'Manager', 2),
(3, 'Associate Manager', 3),
(4, 'Associate', 5),
(5, 'M&E Field Officer', 6),
(6, 'Intern', 6),
(7, 'Senior Associate', 4);

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
(1, 'admin@test.com', '$2y$10$A/rGSd51afa7/5.lakeWP.AIH0noBnLfryKuaUtIZdLYkA0uKw2AS', 'super_admin', '16', '4', '2025-03-12 13:13:02', '2025-03-26 08:43:24'),
(2, 'tech@test.com', '$2y$10$fMqQh24UHICP3P2Hml2lYefr0S/zjhBASBsyMDNDe8H8epVnNAxEW', 'admin', '20', '3', '2025-03-12 13:13:02', '2025-03-26 08:44:21'),
(3, 'quality@test.com', '$2y$10$bjdKnAVWUoPB6iPEe0Y3hOQqChAqYOo4fYKLNMJj.ajfAXT83fouu', 'admin', '14', '3', '2025-03-12 13:13:02', '2025-03-26 08:44:31'),
(4, 'monitor@test.com', '$2y$10$6n7ACWUT3EH41BYGnrVfGOIV5Wh3y4KARcOfoDkkpklTrU4Qty89u', 'admin', '19', '2', '2025-03-12 13:13:02', '2025-03-26 08:44:44'),
(7, 'rhyttahkogi@gmail.com', '$2y$10$tvkmbWGv7uU0ogcrHFfy/.S3wuokI7kI0lvXxr6TSwJHkEGsamy6S', 'staff', '11', '1', '2025-03-13 11:15:06', '2025-03-26 08:44:59'),
(8, 'rama@test.com', '$2y$10$rh5L0k54SEiGp0ZNAr2.yuzkpv6OkSzCINZQKOWmsgOFRgLzfvbR6', 'staff', '16', '3', '2025-03-21 06:05:46', '2025-03-26 08:45:06'),
(9, 'florence@test.com', '$2y$10$NlO/hUID7aMWiEKdoD5vYef2cnBX1vVsdwYa1c5cJRCI9DiON3IjO', 'staff', '14', '4', '2025-03-21 08:03:56', '2025-03-26 08:45:14'),
(10, 'john@gmail.com', '$2y$10$XE/YD.iOoFfln2macpFTa.mp6xCcE9V0EZSjURcunM0Xsvu5TvYM.', 'admin', '17', '4', '2025-03-24 07:12:46', '2025-03-26 08:45:25'),
(11, 'sharon@gmail.com', '$2y$10$kZm2HekGk4U/40Ed.wq7buz9v/VQgUisiwqnG2Hv1qtz36UZKA6wq', 'staff', '16', '6', '2025-03-24 09:26:10', '2025-03-26 08:45:49'),
(12, 'miss@test.com', '$2y$10$lr/yCTIF.jyUSFGvneqpxepLUUKsuiUDOt1EKKkG6KOY8bWk2t/fS', 'staff', '13', '2', '2025-03-24 09:34:15', '2025-03-26 08:46:08'),
(13, 'faridah@test.com', '$2y$10$qG8jYkNFzGWt5xKQQhzq7e7EmhxbSXvS4PiZdaDBNOX2rHN8CqL.a', 'staff', '12', '2', '2025-03-26 09:44:24', '2025-03-26 09:44:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

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
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `inventory_returned`
--
ALTER TABLE `inventory_returned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff_login`
--
ALTER TABLE `staff_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
