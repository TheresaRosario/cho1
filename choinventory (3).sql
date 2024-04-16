-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 03:56 AM
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
-- Database: `choinventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`) VALUES
(1, 'test', 'test1');

-- --------------------------------------------------------

--
-- Table structure for table `archived_medicines`
--

CREATE TABLE `archived_medicines` (
  `archive_id` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Item_Name` varchar(255) DEFAULT NULL,
  `Batch_Number` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `QTY` int(11) DEFAULT NULL,
  `Manufacturing_Date` date DEFAULT NULL,
  `Expiration_Date` date DEFAULT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_medicines`
--

INSERT INTO `archived_medicines` (`archive_id`, `Date`, `Item_Name`, `Batch_Number`, `Description`, `QTY`, `Manufacturing_Date`, `Expiration_Date`, `archived_at`) VALUES
(103, '2024-04-25', 'asd', 'asd', '34', 34, '2024-04-10', '2024-04-17', '2024-04-11 06:15:21'),
(104, '2024-04-25', 'asd', 'asd', '34', 34, '2024-04-10', '2024-04-17', '2024-04-11 06:48:47'),
(105, '2024-04-18', 'asd', '234', 'asd', 1, '2024-04-18', '2024-04-24', '2024-04-11 08:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `archived_supply`
--

CREATE TABLE `archived_supply` (
  `supply_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `manufacturing_date` date NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `issued_to` varchar(255) DEFAULT NULL,
  `medicine_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `action` text DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `action`, `date_time`) VALUES
(89, 'admin report generation', '2024-04-12 11:21:11');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Item_Name` varchar(255) NOT NULL,
  `batch_number` varchar(255) NOT NULL,
  `QTY` int(11) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Manufacturing_Date` date DEFAULT NULL,
  `Expiration_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `Date`, `Item_Name`, `batch_number`, `QTY`, `Description`, `Manufacturing_Date`, `Expiration_Date`) VALUES
(22, '2024-04-16', 'x', 'asd', 23, 'cv', '2024-04-10', '2024-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `supply_id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Item_Name` varchar(50) NOT NULL,
  `Branch_Number` int(30) NOT NULL,
  `Lot_Number` int(30) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `QTY` int(10) NOT NULL,
  `Mfg_Date` date NOT NULL,
  `Exp_Date` date NOT NULL,
  `Issued_To` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `supply_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `batch_number` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date_manufactured` varchar(255) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `issued_to` varchar(100) DEFAULT NULL,
  `medicine_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`supply_id`, `date`, `item_name`, `batch_number`, `description`, `qty`, `date_manufactured`, `expiration_date`, `issued_to`, `medicine_id`) VALUES
(11, '2024-04-11', 'asd', 'asd', 'asd', 2, '2024-04-09', '2024-04-24', 'sd', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archived_medicines`
--
ALTER TABLE `archived_medicines`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `archived_supply`
--
ALTER TABLE `archived_supply`
  ADD PRIMARY KEY (`supply_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`supply_id`);

--
-- Indexes for table `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`supply_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `archived_medicines`
--
ALTER TABLE `archived_medicines`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `archived_supply`
--
ALTER TABLE `archived_supply`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supply`
--
ALTER TABLE `supply`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `supply`
--
ALTER TABLE `supply`
  ADD CONSTRAINT `supply_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`medicine_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
