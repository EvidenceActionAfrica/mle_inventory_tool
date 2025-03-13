--
-- Database: `mle_inventory`

-- --------------------------------------------------------

-- Table structure for table `staff_login`
--

CREATE TABLE `staff_login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT 'mle2025',
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
(1, 'admin@test.com', 'mle2025', 'super_admin', 'IS', 'Manager', '2025-03-12 13:13:02', '2025-03-12 13:13:02'),
(2, 'tech@test.com', 'mle2025', 'admin', 'IT', 'Senior Manager', '2025-03-12 13:13:02', '2025-03-12 13:13:02'),
(3, 'quality@test.com', 'mle2025', 'admin', 'QA/QC', 'Associate Manager', '2025-03-12 13:13:02', '2025-03-12 13:13:02'),
(4, 'monitor@test.com', 'mle2025', 'admin', 'MLE', 'Director', '2025-03-12 13:13:02', '2025-03-12 13:13:02'),
(5, 'staff@test.com', 'mle2025', 'staff', 'MLE', 'Associate IS', '2025-03-12 13:13:02', '2025-03-12 13:13:02');

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
(2, 'Laptop', 'Lenovo', '2025-03-12 17:37:56');

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
(1, 1, 'Samsung A52', 'SN12345', 'TAG001', '2025-03-10', 350.00, '2026-03-10', '2025-03-13 04:18:02'),
(2, 3, 'Ligo Mouse', 'SN67890', 'TAG002', '2025-03-11', 20.00, '2026-03-11', '2025-03-13 04:18:02'),
(3, 5, 'Laser Printer', 'SN11223', 'TAG003', '2025-03-11', 500.00, '2026-03-11', '2025-03-13 04:18:02'),
(4, 9, 'Macbook Pro', 'SN44556', 'TAG004', '2025-03-12', 1500.00, '2027-03-12', '2025-03-13 04:18:02'),
(5, 10, 'Ligo Mouse', 'SN77889', 'TAG005', '2025-03-12', 25.00, '2026-03-12', '2025-03-13 04:18:02');
