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