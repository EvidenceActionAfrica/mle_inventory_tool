-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 08:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.32

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
(13, 'Smart Phone', 'Samsung A33', '2025-03-24 10:18:15'),
(14, 'Smart Phone', 'Samsung Note 10', '2025-04-02 12:47:16'),
(15, 'Mouse', 'Logi', '2025-04-09 05:12:23'),
(16, 'Smart Phone', 'Tecno Camon 40', '2025-04-25 06:39:33'),
(17, 'Smart Phone', 'Tecno Spark 20', '2025-04-25 06:40:01'),
(18, 'Mouse', 'Dell MS116', '2025-04-25 06:42:00'),
(19, 'Mouse', 'Logitech M510', '2025-04-25 06:42:29'),
(20, 'Laptop', 'Hp Chromebook', '2025-04-25 06:43:25'),
(21, 'Laptop', 'Dell', '2025-04-25 06:43:44'),
(22, 'Laptop', 'Acer', '2025-04-25 06:43:51'),
(23, 'Laptop', 'Apple Macbook', '2025-04-25 06:44:10'),
(24, 'Monitor', 'Dell E2016hv', '2025-04-25 06:45:13'),
(25, 'Monitor', 'Hp Compaq', '2025-04-25 06:45:37'),
(26, 'Monitor', 'Asus ROG', '2025-04-25 06:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `confirmation_log`
--

CREATE TABLE `confirmation_log` (
  `id` int(11) NOT NULL,
  `inventory_assignment_id` int(11) NOT NULL,
  `confirmation_date` datetime NOT NULL,
  `confirmed_by` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `confirmation_log`
--

INSERT INTO `confirmation_log` (`id`, `inventory_assignment_id`, `confirmation_date`, `confirmed_by`, `status`) VALUES
(2, 67, '2025-04-23 14:13:46', 'admin@test.com', 'confirmed'),
(3, 65, '2025-04-23 14:15:29', 'admin@test.com', 'confirmed'),
(5, 67, '2025-04-23 14:15:32', 'admin@test.com', 'confirmed'),
(6, 65, '2025-04-23 14:26:23', 'admin@test.com', 'confirmed'),
(8, 67, '2025-04-23 14:26:27', 'admin@test.com', 'confirmed'),
(9, 58, '2025-04-23 14:38:00', 'rhyttahkogi@gmail.com', 'confirmed'),
(10, 73, '2025-04-25 11:50:00', 'johnmark@test.com', 'confirmed'),
(11, 73, '2025-04-25 11:52:00', 'johnmark@test.com', 'confirmed'),
(12, 65, '2025-04-29 08:11:00', 'admin@test.com', 'confirmed'),
(14, 67, '2025-04-29 08:11:00', 'admin@test.com', 'confirmed');

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
(20, 'EV-AC', '2025-03-26 08:43:54', NULL),
(22, 'Information Technology', '2025-04-25 06:32:31', 20);

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
(14, 5, 'Laser Printers', '234ede4', 'ea-111', '2025-03-14', 123.00, '2025-05-01', '2025-03-17 10:48:39'),
(15, 1, 'Samsung A52', '1q234', '1q2ws', '2025-03-14', 125.00, '2025-04-30', '2025-03-17 10:49:10'),
(16, 1, 'Samsung A52', '3ewr4r', '0987uj', '2025-03-17', 90.00, '2025-05-09', '2025-03-17 10:49:34'),
(17, 13, 'Samsung A33', '432wed', 'ea-199', '2025-03-04', 40.00, '2025-04-26', '2025-03-24 10:18:54'),
(18, 13, 'Samsung A33', 'u7y6t5', 'ui787', '2025-03-10', 99.00, '2025-05-10', '2025-03-24 10:19:25'),
(19, 11, 'Lenovo', '9876tg', '7yhhy6', '2025-03-24', 145.00, '2025-06-12', '2025-03-24 10:19:54'),
(20, 11, 'Lenovo', '54rg5y6t', 'ea-1100', '2025-03-10', 78.00, '2025-05-30', '2025-03-24 10:20:27'),
(21, 15, 'Logi', '9uje98', 'ea-00011', '2025-04-08', 20.00, '2028-04-08', '2025-04-09 05:46:23'),
(22, 15, 'Logi', '6te6g3', 'ea-200', '2025-04-15', 300.00, '2025-05-10', '2025-04-17 06:34:39'),
(23, 26, 'Asus ROG', '71083', 'ea-k011', '2025-04-01', 123.00, '2028-10-25', '2025-04-25 06:47:51'),
(24, 25, 'Hp Compaq', '4e3w2q', 'ea-k102', '2025-04-01', 45.00, '2025-05-30', '2025-04-25 06:48:17'),
(25, 24, 'Dell E2016hv', '5trftre4', 'ea-12k9', '2025-04-01', 306.00, '2025-05-23', '2025-04-25 06:48:48'),
(26, 23, 'Apple Macbook', 'hr5ffc', 'ea-k293', '2025-03-18', 890.00, '2031-10-21', '2025-04-25 06:49:30'),
(27, 17, 'Tecno Spark 20', '6hy7j', 'ea-k1222', '2025-04-01', 30.00, '2028-10-26', '2025-04-25 08:43:46'),
(28, 26, 'Asus ROG', 'w8ujdyu', '6789-ea', '2025-04-01', 100.00, '2031-10-14', '2025-04-29 06:57:11'),
(29, 17, 'Tecno Spark 20', 'nb900', '', '2025-04-24', 33.00, '2025-05-10', '2025-04-30 07:53:10'),
(30, 21, 'Dell', 'iuytrtyu', 'ea-1784', '2025-05-01', 78378.00, '2025-06-07', '2025-05-02 06:28:12');

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
  `reconfirm_enabled` tinyint(1) DEFAULT 0,
  `confirmed` tinyint(1) DEFAULT 0,
  `confirmation_date` datetime DEFAULT NULL,
  `reconfirmation_session_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory_assignment`
--

INSERT INTO `inventory_assignment` (`id`, `name`, `email`, `role`, `serial_number`, `tag_number`, `managed_by`, `acknowledgment_status`, `created_at`, `updated_at`, `date_assigned`, `item`, `reconfirm_enabled`, `confirmed`, `confirmation_date`, `reconfirmation_session_id`) VALUES
(52, 'florence@test.com', 'florence@test.com', '9 4', 'sn100', 'tag-001', 'quality', 'acknowledged', '2025-03-24 07:36:36', '2025-05-02 05:56:01', '2025-03-23', 8, 0, 0, NULL, 1),
(53, 'rama@test.com', 'rama@test.com', '2 3', '4t5rfr5', 'tg-003', 'rhyttahkogi', 'acknowledged', '2025-03-24 09:24:33', '2025-05-02 05:56:01', '2025-03-24', 11, 0, 0, NULL, 1),
(54, 'admin@test.com', 'admin@test.com', '2 4', 'qw23wese3', 'ea-1992', 'rama', 'acknowledged', '2025-03-24 09:25:25', '2025-05-02 05:56:01', '2025-03-10', 13, 0, 0, NULL, 1),
(55, 'sharon@gmail.com', 'sharon@gmail.com', '2 6', '1q234', '1q2ws', 'rama', 'acknowledged', '2025-03-24 09:26:34', '2025-05-02 05:56:01', '2025-03-23', 15, 0, 0, NULL, 1),
(56, 'rama@test.com', 'rama@test.com', '2 3', '4t5rfr5', 'tg-003', 'miss', 'acknowledged', '2025-03-24 09:38:13', '2025-05-02 05:56:01', '2025-03-24', 11, 0, 0, NULL, 1),
(57, 'miss@test.com', 'miss@test.com', '2 2', 'qwedfr987', 'ea-1991', 'rhyttahkogi', 'acknowledged', '2025-03-24 09:39:04', '2025-05-02 05:56:01', '2025-03-24', 12, 0, 0, NULL, 1),
(58, 'rhyttahkogi@gmail.com', 'rhyttahkogi@gmail.com', '2 1', '4t5rfr5', 'tg-003', 'rhyttahkogi', 'acknowledged', '2025-03-24 10:15:34', '2025-05-02 05:56:01', '2025-03-24', 11, 0, 0, NULL, 1),
(59, 'miss@test.com', 'miss@test.com', '2 2', '10928', 'tag-002', 'rhyttahkogi', 'acknowledged', '2025-03-24 10:29:10', '2025-05-02 05:56:01', '2025-03-24', 9, 0, 0, NULL, 1),
(60, 'rama@test.com', 'rama@test.com', '2 3', '234ede4', 'ea-111', 'miss', 'acknowledged', '2025-03-24 10:30:00', '2025-05-02 05:56:01', '2025-03-23', 14, 0, 0, NULL, 1),
(61, 'admin@test.com', 'admin@test.com', '2 4', '432wed', 'ea-199', 'rama', 'acknowledged', '2025-03-24 10:35:00', '2025-05-02 05:56:01', '2025-03-24', 17, 0, 0, NULL, 1),
(62, 'sharon@gmail.com', 'sharon@gmail.com', '2 6', '3ewr4r', '0987uj', 'rama', 'acknowledged', '2025-03-24 10:35:23', '2025-05-02 05:56:01', '2025-03-24', 16, 0, 0, NULL, 1),
(65, 'admin@test.com', 'admin@test.com', '16 4', '9uje98', 'ea-00011', 'rama', 'acknowledged', '2025-04-09 05:51:09', '2025-05-02 05:56:01', '2025-04-09', 21, 0, 1, '2025-04-29 08:11:33', 13),
(67, 'admin@test.com', 'admin@test.com', '16 4', '9876tg', '7yhhy6', 'rama', 'acknowledged', '2025-04-16 09:52:31', '2025-05-02 05:56:01', '2025-04-16', 19, 0, 1, '2025-04-29 08:11:35', 13),
(68, 'admin@test.com', 'admin@test.com', '16 4', '6te6g3', 'ea-200', 'rama', 'acknowledged', '2025-04-17 06:35:05', '2025-05-02 05:56:01', '2025-04-17', 22, 0, 0, NULL, 1),
(71, 'rita@test.com', 'rita@test.com', '16 4', '6hy7j', 'ea-k1222', 'rama', 'acknowledged', '2025-04-25 08:44:34', '2025-05-02 05:56:01', '2025-04-25', 27, 0, 0, NULL, 1),
(72, 'rita@test.com', 'rita@test.com', '16 4', '4e3w2q', 'ea-k102', 'rama', 'acknowledged', '2025-04-25 08:44:34', '2025-05-02 05:56:01', '2025-04-25', 24, 0, 0, NULL, 1),
(73, 'johnmark@test.com', 'johnmark@test.com', '22 4', '6te6g3', 'ea-200', 'maria', 'acknowledged', '2025-04-25 08:49:47', '2025-05-02 05:56:01', '2025-04-25', 22, 0, 1, '2025-04-25 11:52:22', 13),
(74, 'admin@test.com', 'admin@test.com', '16 4', 'w8ujdyu', '6789-ea', 'rama', 'acknowledged', '2025-04-29 07:55:53', '2025-04-30 08:45:50', '2025-04-29', 28, 0, 0, NULL, NULL),
(75, 'admin@test.com', 'admin@test.com', '16 4', 'hr5ffc', 'ea-k293', 'rama', 'acknowledged', '2025-04-29 12:29:02', '2025-04-30 08:45:51', '2025-04-29', 26, 0, 0, NULL, NULL);

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
  `status` enum('pending','approved','disapproved') NOT NULL DEFAULT 'pending',
  `item_state` enum('functional','damaged','lost','disapproved') NOT NULL DEFAULT 'functional',
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `repair_status` enum('Repairable','Unrepairable') DEFAULT NULL,
  `disapproval_comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory_returned`
--

INSERT INTO `inventory_returned` (`id`, `assignment_id`, `return_date`, `receiver_id`, `returned_by`, `status`, `item_state`, `approved_by`, `approved_date`, `repair_status`, `disapproval_comment`, `created_at`, `updated_at`) VALUES
(61, 53, '2025-03-24', 2, 'rama@test.com', 'approved', 'functional', NULL, '2025-03-24 12:37:30', NULL, NULL, '2025-03-24 09:37:06', '2025-03-24 09:37:30'),
(62, 54, '2025-03-24', 2, 'admin@test.com', 'approved', 'functional', NULL, '2025-03-24 12:56:19', 'Repairable', NULL, '2025-03-24 09:53:33', '2025-04-25 08:18:09'),
(63, 57, '2025-03-24', 2, 'miss@test.com', 'approved', 'functional', NULL, '2025-03-24 12:56:22', NULL, NULL, '2025-03-24 09:53:48', '2025-03-24 09:56:22'),
(64, 56, '2025-03-24', 2, 'rama@test.com', 'approved', 'functional', NULL, '2025-03-24 12:56:25', NULL, NULL, '2025-03-24 09:54:54', '2025-03-24 09:56:25'),
(65, 55, '2025-03-24', 2, 'sharon@gmail.com', 'approved', 'functional', NULL, '2025-03-24 12:56:28', NULL, NULL, '2025-03-24 09:55:52', '2025-03-24 09:56:28'),
(66, 61, '2025-03-26', 2, 'admin@test.com', 'approved', 'lost', NULL, '2025-04-09 08:52:55', NULL, NULL, '2025-03-26 10:55:56', '2025-04-09 05:52:55'),
(68, 61, '2025-04-09', 2, 'admin@test.com', 'approved', 'functional', NULL, '2025-04-09 08:52:37', NULL, NULL, '2025-04-09 05:51:54', '2025-04-09 05:52:37'),
(86, 68, '2025-04-17', 2, 'admin@test.com', 'approved', 'damaged', NULL, '2025-04-17 09:35:58', 'Repairable', NULL, '2025-04-17 06:35:43', '2025-04-17 06:36:04'),
(90, 60, '2025-04-25', 18, 'rama@test.com', 'approved', 'functional', NULL, '2025-04-25 10:10:20', NULL, NULL, '2025-04-25 07:10:05', '2025-04-25 07:10:20'),
(91, 71, '2025-04-25', 18, 'rita@test.com', 'approved', 'functional', NULL, '2025-04-25 11:47:03', NULL, NULL, '2025-04-25 08:46:28', '2025-04-25 08:47:03'),
(92, 72, '2025-04-25', 18, 'rita@test.com', 'approved', 'lost', NULL, '2025-04-25 11:47:12', NULL, NULL, '2025-04-25 08:46:28', '2025-04-25 08:47:12'),
(93, 73, '2025-04-28', 18, 'johnmark@test.com', 'pending', 'functional', NULL, NULL, NULL, NULL, '2025-04-28 15:50:12', '2025-04-28 15:50:12'),
(95, 65, '2025-04-28', 2, 'admin@test.com', 'disapproved', 'disapproved', NULL, '2025-04-28 20:22:27', 'Unrepairable', 'I did not receive the item as indicated by the user', '2025-04-28 17:12:23', '2025-04-30 08:36:04'),
(98, 65, '2025-04-29', 2, 'admin@test.com', 'disapproved', 'disapproved', NULL, '2025-04-29 15:31:06', 'Unrepairable', 'Didnt receive', '2025-04-29 12:30:22', '2025-04-30 08:36:04'),
(100, 65, '2025-04-30', 2, 'admin@test.com', 'approved', 'damaged', NULL, '2025-04-30 11:34:02', 'Unrepairable', NULL, '2025-04-30 08:33:49', '2025-04-30 08:36:04'),
(101, 67, '2025-04-30', 2, 'admin@test.com', 'approved', 'damaged', NULL, '2025-04-30 11:58:19', 'Unrepairable', NULL, '2025-04-30 08:46:04', '2025-04-30 08:58:25'),
(102, 75, '2025-05-02', 2, 'admin@test.com', 'pending', 'functional', NULL, NULL, NULL, NULL, '2025-05-02 05:56:59', '2025-05-02 05:56:59');

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
(4, 'Busia Field Office', 3, '2025-03-13 10:08:13'),
(7, 'Wagai Hub', 5, '2025-04-09 05:45:33'),
(8, 'Nairobi', 6, '2025-04-25 06:30:00');

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
-- Table structure for table `reconfirmation_sessions`
--

CREATE TABLE `reconfirmation_sessions` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `initiated_by` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT current_timestamp(),
  `active` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reconfirmation_sessions`
--

INSERT INTO `reconfirmation_sessions` (`id`, `year`, `month`, `initiated_by`, `start_date`, `active`) VALUES
(1, 2025, 4, 'admin@test.com', '2025-04-22 00:00:00', 0),
(2, 2025, 4, 'admin@test.com', '2025-04-22 00:00:00', 0),
(3, 2025, 4, 'admin@test.com', '2025-04-22 00:00:00', 0),
(4, 2025, 4, 'admin@test.com', '2025-04-22 00:00:00', 0),
(5, 2025, 4, 'admin@test.com', '2025-04-23 00:00:00', 0),
(6, 2025, 4, 'admin@test.com', '2025-04-23 00:00:00', 0),
(7, 2025, 4, 'admin@test.com', '2025-04-23 00:00:00', 0),
(8, 2025, 4, 'admin@test.com', '2025-04-23 00:00:00', 0),
(9, 2025, 4, 'admin@test.com', '2025-04-23 00:00:00', 0),
(10, 2025, 4, 'admin@test.com', '2025-04-25 00:00:00', 0),
(11, 2025, 4, 'johnmark@test.com', '2025-04-25 00:00:00', 0),
(12, 2025, 4, 'johnmark@test.com', '2025-04-25 00:00:00', 0),
(13, 2025, 4, 'johnmark@test.com', '2025-04-25 00:00:00', 0);

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
  `dutystation` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff_login`
--

INSERT INTO `staff_login` (`id`, `email`, `password`, `role`, `department`, `position`, `dutystation`, `created_at`, `updated_at`) VALUES
(1, 'admin@test.com', '$2y$10$A/rGSd51afa7/5.lakeWP.AIH0noBnLfryKuaUtIZdLYkA0uKw2AS', 'super_admin', '16', '4', '2', '2025-03-12 13:13:02', '2025-04-16 08:40:20'),
(2, 'tech@test.com', '$2y$10$fMqQh24UHICP3P2Hml2lYefr0S/zjhBASBsyMDNDe8H8epVnNAxEW', 'admin', '20', '3', '1', '2025-03-12 13:13:02', '2025-04-16 08:40:28'),
(3, 'quality@test.com', '$2y$10$bjdKnAVWUoPB6iPEe0Y3hOQqChAqYOo4fYKLNMJj.ajfAXT83fouu', 'admin', '14', '3', '4', '2025-03-12 13:13:02', '2025-04-16 08:40:33'),
(4, 'monitor@test.com', '$2y$10$6n7ACWUT3EH41BYGnrVfGOIV5Wh3y4KARcOfoDkkpklTrU4Qty89u', 'admin', '19', '2', '3', '2025-03-12 13:13:02', '2025-04-16 08:40:38'),
(7, 'rhyttahkogi@gmail.com', '$2y$10$tvkmbWGv7uU0ogcrHFfy/.S3wuokI7kI0lvXxr6TSwJHkEGsamy6S', 'staff', '11', '1', '3', '2025-03-13 11:15:06', '2025-04-16 08:40:43'),
(8, 'rama@test.com', '$2y$10$rh5L0k54SEiGp0ZNAr2.yuzkpv6OkSzCINZQKOWmsgOFRgLzfvbR6', 'staff', '16', '3', '2', '2025-03-21 06:05:46', '2025-04-16 08:40:49'),
(9, 'florence@test.com', '$2y$10$NlO/hUID7aMWiEKdoD5vYef2cnBX1vVsdwYa1c5cJRCI9DiON3IjO', 'staff', '14', '4', '7', '2025-03-21 08:03:56', '2025-04-16 08:40:54'),
(10, 'john@gmail.com', '$2y$10$XE/YD.iOoFfln2macpFTa.mp6xCcE9V0EZSjURcunM0Xsvu5TvYM.', 'admin', '17', '4', '7', '2025-03-24 07:12:46', '2025-04-16 08:41:00'),
(11, 'sharon@gmail.com', '$2y$10$kZm2HekGk4U/40Ed.wq7buz9v/VQgUisiwqnG2Hv1qtz36UZKA6wq', 'staff', '16', '6', '4', '2025-03-24 09:26:10', '2025-04-16 08:41:06'),
(12, 'miss@test.com', '$2y$10$lr/yCTIF.jyUSFGvneqpxepLUUKsuiUDOt1EKKkG6KOY8bWk2t/fS', 'staff', '13', '2', '4', '2025-03-24 09:34:15', '2025-04-16 08:41:12'),
(13, 'faridah@test.com', '$2y$10$qG8jYkNFzGWt5xKQQhzq7e7EmhxbSXvS4PiZdaDBNOX2rHN8CqL.a', 'admin', '12', '2', '1', '2025-03-26 09:44:24', '2025-04-16 08:40:07'),
(17, 'maria@test.com', '$2y$10$mtwY2jFiOCAHUo6vjr5h7ui/n0a9VX1gny8c2QMs0MNgxqfRdHMJK', 'staff', '22', '2', '8', '2025-04-25 06:31:36', '2025-04-25 06:33:00'),
(18, 'johnmark@test.com', '$2y$10$pZyu3xzOVXfn6LDuH8/Skuvfm9RTpmdaU6ViPwn3B0ivwzQU2/fDu', 'admin', '22', '4', '8', '2025-04-25 06:34:02', '2025-04-25 07:02:01'),
(19, 'ferdnand@test.com', '$2y$10$3Ryo2FcOv11HhbuGTKNWMOVZsauESiK05E51LGyMNRuY61DHTajcu', 'staff', '13', '2', '8', '2025-04-25 06:36:20', '2025-04-25 06:36:20'),
(20, 'rita@test.com', '$2y$10$PUSMRGgbj9wNK2unLoLNCu9PEruEwLD4UMmsXf0X8e/EtVBBV6NFW', 'staff', '16', '4', '8', '2025-04-25 06:37:25', '2025-04-25 06:37:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `confirmation_log`
--
ALTER TABLE `confirmation_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_assignment_id` (`inventory_assignment_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `reconfirmation_session_id` (`reconfirmation_session_id`);

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
-- Indexes for table `reconfirmation_sessions`
--
ALTER TABLE `reconfirmation_sessions`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `confirmation_log`
--
ALTER TABLE `confirmation_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `inventory_returned`
--
ALTER TABLE `inventory_returned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reconfirmation_sessions`
--
ALTER TABLE `reconfirmation_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `staff_login`
--
ALTER TABLE `staff_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `confirmation_log`
--
ALTER TABLE `confirmation_log`
  ADD CONSTRAINT `confirmation_log_ibfk_1` FOREIGN KEY (`inventory_assignment_id`) REFERENCES `inventory_assignment` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  ADD CONSTRAINT `inventory_assignment_ibfk_1` FOREIGN KEY (`reconfirmation_session_id`) REFERENCES `reconfirmation_sessions` (`id`);

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
