-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2026 at 04:30 PM
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
-- Database: `dh_azada`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments_tbl`
--

CREATE TABLE `appointments_tbl` (
  `appt_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `appt_date` date DEFAULT NULL,
  `appt_time` time DEFAULT NULL,
  `appt_status` enum('pending','completed','cancelled') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_tbl`
--

CREATE TABLE `customer_tbl` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_tbl`
--

INSERT INTO `customer_tbl` (`customer_id`, `email`, `password_hash`, `fname`, `mname`, `lname`, `birthday`, `vehicle_type`, `mobile_number`, `created_at`, `last_login`, `status`, `profile_image`) VALUES
(1, '123@gmail.com', '$2y$10$W1N4WrAlr/W3Swsnye3rwO4e4GcrlMVkeznxREg.sa9gsxqf/yNnK', '1', '1', '1', '2026-04-02', NULL, '123', NULL, '2026-04-02 22:21:15', 'active', '../uploads/profile/customer_4_1775011163.png');

-- --------------------------------------------------------

--
-- Table structure for table `employee_tbl`
--

CREATE TABLE `employee_tbl` (
  `employee_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `uRole_name` varchar(20) DEFAULT NULL,
  `uRole_desc` varchar(20) DEFAULT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `mname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_tbl`
--

INSERT INTO `employee_tbl` (`employee_id`, `email`, `password_hash`, `uRole_name`, `uRole_desc`, `fname`, `mname`, `lname`, `birthday`, `created_at`, `status`, `last_login`) VALUES
(1, 'admin@gmail.com', 'admin123', 'admin', 'admin', 'admin', 'admin', 'admin', '1999-01-01', '2026-03-22 21:52:56', 'active', '2026-03-22 21:52:56'),
(2, 'cashier@gmail.com', 'cashier123', 'cashier', 'cashier', 'cashier', 'cashier', 'cashier', '2000-01-01', '2026-03-28 12:33:11', 'active', '2026-03-28 12:33:11'),
(3, 'controller@gmail.com', 'cont123', 'cont', 'cont', 'cont', 'cont', 'cont', '2003-01-01', '2026-03-28 12:34:49', 'active', '2026-03-28 12:34:49'),
(4, 'owner@gmail.com', 'owner123', 'owner', 'store owner', 'Owner', 'Main', 'User', '1995-01-01', '2026-04-02 17:03:02', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE `product_tbl` (
  `product_id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `critical_lvl` int(11) DEFAULT NULL,
  `status` enum('available','unavailable') DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tbl`
--

INSERT INTO `product_tbl` (`product_id`, `item_name`, `brand`, `size`, `price`, `critical_lvl`, `status`, `image_url`, `created_at`, `category`) VALUES
(1, 'ENKEI RPF1', 'ENKEI', '15\" X 6\" ET35', 10000.00, 3, '', 'assets/enkei.png', '2026-04-02 16:27:25', 'rim'),
(2, 'BBS LM', 'BBS', '18\" X 8\" ET40', 25000.00, 2, '', 'assets/bbs.png', '2026-04-02 16:27:25', 'rim'),
(3, 'VOLK TE37', 'VOLK RACING', '17\" X 7.5\" ET35', 30000.00, 2, '', 'assets/volk(donotuse).png', '2026-04-02 16:27:25', 'rim'),
(4, 'MOTOLITE ENDURO NS40', 'MOTOLITE ENDURO', 'NS40', 5250.00, 3, 'available', 'assets/motolite.png', '2026-04-02 16:48:33', 'battery'),
(5, 'AMARON HI-LIFE 2SM', 'AMARON HI-LIFE', '2SM', 4800.00, 3, 'available', 'assets/amaron.png', '2026-04-02 16:48:33', 'battery'),
(6, 'MOTOLITE GOLD DIN44', 'MOTOLITE GOLD', 'DIN44', 6100.00, 2, 'available', 'assets/motolite.png', '2026-04-02 16:48:33', 'battery'),
(7, 'NANKANG NS2 175/65R14', 'NANKANG', '175/65R14', 1700.00, 3, 'available', 'assets/nankang2.png', '2026-04-02 16:58:26', 'tire'),
(8, 'GOODYEAR ASSURANCE 185/60R15', 'GOODYEAR', '185/60R15', 3200.00, 2, 'available', 'assets/goodyear.png', '2026-04-02 16:58:26', 'tire'),
(9, 'YOKOHAMA ADVAN DB 195/55R16', 'YOKOHAMA', '195/55R16', 4500.00, 2, 'available', 'assets/yokohama.png', '2026-04-02 16:58:26', 'tire');

-- --------------------------------------------------------

--
-- Table structure for table `service_tbl`
--

CREATE TABLE `service_tbl` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_tbl`
--

INSERT INTO `service_tbl` (`service_id`, `service_name`, `service_type`, `price`, `created_at`, `status`) VALUES
(2, 'Wheel Alignment', 'Repair', 200.00, NULL, 'active'),
(3, 'Camber Correction', 'Repair', 360.00, NULL, 'active'),
(4, 'Tire Change (SUV)', 'Installation', 200.00, NULL, 'active'),
(5, 'Tire Change (Van)', 'Installation', 225.00, NULL, 'active'),
(6, 'Battery Replacement', 'Installation', 800.00, NULL, 'active'),
(7, 'Wheel Balancing', 'Maintenance', 75.00, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `stockbatch_tbl`
--

CREATE TABLE `stockbatch_tbl` (
  `batch_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stockbatch_tbl`
--

INSERT INTO `stockbatch_tbl` (`batch_id`, `product_id`, `quantity`, `received_date`, `expiration_date`, `supplier`, `created_at`) VALUES
(1, 1, 5, '2026-04-02', NULL, NULL, '2026-04-02 16:52:27'),
(2, 1, 3, '2026-04-02', NULL, NULL, '2026-04-02 16:52:27'),
(3, 2, 10, '2026-04-02', NULL, NULL, '2026-04-02 16:52:27'),
(4, 3, 2, '2026-04-02', NULL, NULL, '2026-04-02 16:52:27'),
(5, 4, 5, '2026-04-02', NULL, NULL, '2026-04-02 16:56:19'),
(6, 5, 3, '2026-04-02', NULL, NULL, '2026-04-02 16:56:19'),
(7, 6, 7, '2026-04-02', NULL, NULL, '2026-04-02 16:56:19'),
(8, 7, 10, '2026-04-02', NULL, NULL, '2026-04-02 16:58:48'),
(9, 7, 5, '2026-04-02', NULL, NULL, '2026-04-02 16:58:48'),
(10, 8, 8, '2026-04-02', NULL, NULL, '2026-04-02 16:58:48'),
(11, 9, 12, '2026-04-02', NULL, NULL, '2026-04-02 16:58:48');

-- --------------------------------------------------------

--
-- Table structure for table `stock_logs_tbl`
--

CREATE TABLE `stock_logs_tbl` (
  `log_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `performed_by` int(11) DEFAULT NULL,
  `quantity_change` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items_tbl`
--

CREATE TABLE `transaction_items_tbl` (
  `item_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `item_type` enum('product','service') DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price_at_sale` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_tbl`
--

CREATE TABLE `transaction_tbl` (
  `transaction_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `appt_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('cash','card','gcash') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments_tbl`
--
ALTER TABLE `appointments_tbl`
  ADD PRIMARY KEY (`appt_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `service_tbl`
--
ALTER TABLE `service_tbl`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `stockbatch_tbl`
--
ALTER TABLE `stockbatch_tbl`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_logs_tbl`
--
ALTER TABLE `stock_logs_tbl`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `performed_by` (`performed_by`);

--
-- Indexes for table `transaction_items_tbl`
--
ALTER TABLE `transaction_items_tbl`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `app_id` (`appt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_tbl`
--
ALTER TABLE `product_tbl`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service_tbl`
--
ALTER TABLE `service_tbl`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stockbatch_tbl`
--
ALTER TABLE `stockbatch_tbl`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stock_logs_tbl`
--
ALTER TABLE `stock_logs_tbl`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_items_tbl`
--
ALTER TABLE `transaction_items_tbl`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments_tbl`
--
ALTER TABLE `appointments_tbl`
  ADD CONSTRAINT `appointments_tbl_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_tbl` (`customer_id`),
  ADD CONSTRAINT `appointments_tbl_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service_tbl` (`service_id`),
  ADD CONSTRAINT `appointments_tbl_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`);

--
-- Constraints for table `stockbatch_tbl`
--
ALTER TABLE `stockbatch_tbl`
  ADD CONSTRAINT `stockbatch_tbl_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`product_id`);

--
-- Constraints for table `stock_logs_tbl`
--
ALTER TABLE `stock_logs_tbl`
  ADD CONSTRAINT `stock_logs_tbl_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `stockbatch_tbl` (`batch_id`),
  ADD CONSTRAINT `stock_logs_tbl_ibfk_2` FOREIGN KEY (`performed_by`) REFERENCES `employee_tbl` (`employee_id`);

--
-- Constraints for table `transaction_items_tbl`
--
ALTER TABLE `transaction_items_tbl`
  ADD CONSTRAINT `transaction_items_tbl_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction_tbl` (`transaction_id`),
  ADD CONSTRAINT `transaction_items_tbl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`product_id`),
  ADD CONSTRAINT `transaction_items_tbl_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service_tbl` (`service_id`);

--
-- Constraints for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD CONSTRAINT `transaction_tbl_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_tbl` (`employee_id`),
  ADD CONSTRAINT `transaction_tbl_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_tbl` (`customer_id`),
  ADD CONSTRAINT `transaction_tbl_ibfk_3` FOREIGN KEY (`appt_id`) REFERENCES `appointments_tbl` (`appt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
