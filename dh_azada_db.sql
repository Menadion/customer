-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2026 at 03:52 PM
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
-- Database: `dh_azada_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments_tbl`
--

CREATE TABLE `appointments_tbl` (
  `appt_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `appt_date` date NOT NULL,
  `appt_time` time NOT NULL,
  `appt_status` enum('waiting for approval','approved','rejected','cancelled','completed') NOT NULL DEFAULT 'waiting for approval',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_tbl`
--

CREATE TABLE `customer_tbl` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `status` enum('pending','active','inactive') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_tbl`
--

INSERT INTO `customer_tbl` (`customer_id`, `email`, `password_hash`, `fname`, `mname`, `lname`, `birthday`, `profile_image`, `vehicle_type`, `mobile_number`, `verification_token`, `created_at`, `last_login`, `status`) VALUES
(4, 'ricardoabatantonio@gmail.com', '$2y$10$Fcl0u3xY/bc0.5M5Hvh2iuD164Wv22zNecc.RtsyHRMcgC6vxoLpi', 'Ricardo', 'Abat', 'Antonio', '2006-07-05', '../uploads/profile/customer_4_1775011163.png', NULL, '09167798281', NULL, '2026-04-01 10:34:14', '2026-04-01 10:34:31', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments_tbl`
--
ALTER TABLE `appointments_tbl`
  ADD PRIMARY KEY (`appt_id`),
  ADD KEY `fk_appointments_customer` (`customer_id`);

--
-- Indexes for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments_tbl`
--
ALTER TABLE `appointments_tbl`
  MODIFY `appt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments_tbl`
--
ALTER TABLE `appointments_tbl`
  ADD CONSTRAINT `fk_appointments_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer_tbl` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
