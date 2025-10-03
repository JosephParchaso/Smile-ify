-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2025 at 01:47 AM
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
-- Database: `smile-ify`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_transaction`
--

CREATE TABLE `appointment_transaction` (
  `appointment_transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `dentist_id` int(11) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `notes` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Booked','Completed','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_transaction`
--

INSERT INTO `appointment_transaction` (`appointment_transaction_id`, `user_id`, `branch_id`, `service_id`, `dentist_id`, `appointment_date`, `appointment_time`, `notes`, `date_created`, `status`) VALUES
(1, 10, 3, 5, 4, '2025-07-18', '15:00:00', '', '2025-07-11 22:31:48', 'Completed'),
(2, 11, 3, 8, NULL, '2025-07-18', '12:00:00', '', '2025-07-11 22:36:13', 'Completed'),
(3, 12, 1, 1, 3, '2025-07-18', '09:00:00', '', '2025-07-11 23:10:37', 'Completed'),
(4, 13, 1, 1, 3, '2025-08-07', '13:30:00', '', '2025-07-11 23:49:00', 'Cancelled'),
(5, 14, 1, 1, 3, '2025-07-18', '09:00:00', '', '2025-07-11 23:53:50', 'Completed'),
(6, 15, 1, 5, 3, '2025-07-19', '12:45:00', '', '2025-07-11 23:57:34', 'Cancelled'),
(7, 16, 1, 5, 3, '2025-07-25', '12:00:00', '', '2025-07-12 18:37:17', 'Completed'),
(8, 17, 1, 1, 1, '2025-08-01', '14:15:00', '', '2025-07-12 19:04:48', 'Completed'),
(9, 18, 1, 1, 1, '2025-07-22', '09:00:00', '', '2025-07-12 20:04:53', 'Completed'),
(10, 19, 1, 1, 1, '2025-07-17', '12:45:00', '', '2025-07-12 20:31:49', 'Completed'),
(11, 20, 1, 1, 3, '2025-07-23', '13:30:00', '', '2025-07-12 20:36:12', 'Completed'),
(12, 21, 1, 1, 3, '2025-07-23', '13:30:00', '', '2025-07-12 20:37:27', 'Cancelled'),
(13, 22, 2, 2, 2, '2025-07-29', '14:15:00', '', '2025-07-12 20:43:04', 'Completed'),
(14, 23, 2, 10, NULL, '2025-07-24', '13:30:00', '', '2025-07-12 20:45:13', 'Completed'),
(15, 24, 1, 5, NULL, '2025-07-23', '13:30:00', '', '2025-07-12 21:20:25', 'Completed'),
(16, 25, 2, 10, 3, '2025-07-24', '13:30:00', '', '2025-07-14 10:25:16', 'Completed'),
(17, 26, 1, 5, 3, '2025-07-30', '13:30:00', '', '2025-07-14 10:33:22', 'Completed'),
(18, 27, 2, 10, 3, '2025-07-29', '13:30:00', '', '2025-07-14 11:14:19', 'Completed'),
(19, 28, 1, 3, 3, '2025-07-29', '14:15:00', '', '2025-07-14 11:26:32', 'Completed'),
(20, 29, 1, 1, 1, '2025-07-24', '10:30:00', '', '2025-07-14 15:48:41', 'Completed'),
(21, 30, 2, 8, 3, '2025-07-31', '13:30:00', '', '2025-07-14 16:03:59', 'Completed'),
(22, 28, 2, 10, 3, '2025-07-23', '09:45:00', '', '2025-07-21 18:30:17', 'Completed'),
(23, 28, 1, 2, NULL, '2025-07-31', '15:00:00', '', '2025-07-21 18:42:53', 'Completed'),
(24, 28, 3, 2, NULL, '2025-07-30', '15:00:00', '', '2025-07-21 20:03:40', 'Completed'),
(25, 28, 1, 5, 3, '2025-07-30', '10:30:00', '', '2025-07-21 20:10:59', 'Completed'),
(26, 28, 1, 1, 1, '2025-07-24', '12:00:00', '', '2025-07-21 20:30:32', 'Completed'),
(27, 28, 2, 8, 3, '2025-07-31', '10:30:00', '', '2025-07-24 15:58:38', 'Completed'),
(28, 31, 1, 1, 1, '2025-08-02', '12:45:00', '', '2025-07-31 14:32:30', 'Completed'),
(29, 32, 2, 6, 2, '2025-08-16', '11:15:00', '', '2025-07-31 14:38:20', 'Cancelled'),
(30, 33, 2, 6, 2, '2025-08-16', '11:15:00', '', '2025-07-31 14:38:28', 'Completed'),
(31, 34, 2, 6, 2, '2025-08-01', '10:30:00', '', '2025-07-31 14:54:44', 'Cancelled'),
(32, 35, 3, 1, 1, '2025-08-29', '15:00:00', '', '2025-08-05 20:06:22', 'Completed'),
(33, 36, 2, 8, 3, '2025-08-12', '14:15:00', '', '2025-08-09 17:21:09', 'Cancelled'),
(34, 42, 3, 1, 1, '2025-08-18', '15:00:00', '', '2025-08-12 15:18:53', 'Completed'),
(35, 28, 3, 7, 4, '2025-08-27', '15:00:00', '', '2025-08-19 20:55:36', 'Completed'),
(36, 28, 2, 2, 2, '2025-08-29', '15:00:00', 'sample note', '2025-08-23 18:39:11', 'Completed'),
(37, 45, 1, 1, 3, '2025-09-09', '11:15:00', 'hhff', '2025-09-01 10:51:29', 'Completed'),
(38, 46, 2, 2, 2, '2025-09-05', '09:00:00', 'Need t extract', '2025-09-01 10:54:07', 'Completed'),
(39, 47, 2, 10, 3, '2025-09-04', '15:00:00', '', '2025-09-01 15:43:24', 'Completed'),
(40, 28, 2, 10, 3, '2025-09-12', '10:30:00', '', '2025-09-07 19:43:36', 'Completed'),
(41, 28, 1, 1, 1, '2025-09-11', '10:30:00', '', '2025-09-07 19:44:03', 'Cancelled'),
(42, 28, 1, 5, NULL, '2025-09-12', '09:45:00', '', '2025-09-07 19:47:38', 'Cancelled'),
(43, 53, 1, 1, 1, '2025-10-04', '14:15:00', '', '2025-09-16 19:05:45', 'Booked'),
(44, 54, 1, 1, NULL, '2025-09-19', '09:00:00', '', '2025-09-16 19:22:37', 'Completed'),
(45, 55, 2, 8, 3, '2025-10-02', '12:00:00', '', '2025-09-17 19:45:22', 'Booked'),
(49, 46, 1, 1, 3, '2025-09-19', '11:15:00', '', '2025-09-17 22:30:42', 'Completed'),
(50, 56, 3, 2, NULL, '2025-09-19', '09:45:00', 'mandaue branch', '2025-09-17 22:48:49', 'Completed'),
(51, 56, 3, 8, 3, '2025-09-20', '09:45:00', '', '2025-09-17 23:10:02', 'Cancelled'),
(52, 28, 1, 1, 1, '2025-09-30', '15:00:00', '711', '2025-09-17 23:11:37', 'Completed'),
(54, 28, 1, 2, 3, '2025-09-19', '09:45:00', '', '2025-09-17 23:12:58', 'Cancelled'),
(57, 46, 1, 1, NULL, '2025-09-20', '10:30:00', '', '2025-09-17 23:16:12', 'Cancelled'),
(58, 57, 1, 1, 1, '2025-09-30', '15:00:00', 'same', '2025-09-21 22:05:17', 'Completed'),
(59, 28, 1, 1, 1, '2025-10-18', '09:00:00', '', '2025-09-21 22:06:35', 'Booked'),
(60, 28, 2, 8, NULL, '2025-09-26', '09:45:00', '', '2025-09-21 22:07:12', 'Completed'),
(61, 28, 1, 2, 8, '2025-09-24', '09:00:00', '', '2025-09-22 19:08:19', 'Cancelled'),
(62, 28, 1, 2, 8, '2025-09-24', '09:00:00', '', '2025-09-22 19:15:35', 'Completed'),
(63, 58, 1, 2, 8, '2025-09-24', '09:45:00', '', '2025-09-22 19:59:12', 'Cancelled'),
(64, 28, 1, 4, NULL, '2025-09-24', '15:00:00', '', '2025-09-22 20:43:39', 'Completed'),
(65, 28, 1, 4, NULL, '2025-09-25', '10:30:00', '', '2025-09-22 21:28:30', 'Completed'),
(66, 28, 1, 4, NULL, '2025-09-24', '10:30:00', '', '2025-09-22 21:28:59', 'Completed'),
(67, 59, 1, 4, NULL, '2025-09-24', '11:15:00', '', '2025-09-22 22:01:09', 'Cancelled'),
(68, 59, 1, 1, 1, '2025-09-24', '12:00:00', '', '2025-09-22 22:02:03', 'Completed'),
(69, 59, 1, 2, 8, '2025-09-24', '12:45:00', '', '2025-09-22 22:02:52', 'Completed'),
(70, 28, 1, 1, NULL, '2025-09-24', '14:15:00', '', '2025-09-22 22:03:11', 'Completed'),
(71, 28, 1, 2, 4, '2025-09-24', '13:30:00', '', '2025-09-22 22:03:24', 'Completed'),
(72, 59, 3, 3, 2, '2025-09-25', '09:00:00', '', '2025-09-24 00:03:02', 'Cancelled'),
(73, 60, 1, 2, 1, '2025-09-25', '11:15:00', '', '2025-09-24 07:32:21', 'Cancelled'),
(74, 28, 1, 3, 1, '2025-09-25', '09:45:00', 'Sample note', '2025-09-24 07:37:01', 'Completed'),
(75, 28, 3, 2, 2, '2025-10-31', '09:00:00', '', '2025-10-03 21:22:21', 'Booked'),
(76, 28, 3, 2, 2, '2025-10-31', '09:45:00', '', '2025-10-03 21:42:30', 'Booked'),
(77, 27, 3, 2, 2, '2025-10-31', '10:30:00', '', '2025-10-03 21:43:55', 'Booked'),
(78, 54, 3, 2, 2, '2025-10-31', '11:15:00', '', '2025-10-03 21:44:25', 'Booked'),
(79, 54, 3, 2, 2, '2025-10-31', '12:00:00', '', '2025-10-03 21:46:53', 'Booked');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `map_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `name`, `address`, `phone_number`, `opening_time`, `closing_time`, `status`, `date_created`, `date_updated`, `map_url`) VALUES
(1, 'Babag', 'Babag 2', '9876543210', NULL, NULL, 'Active', '2025-09-22 22:16:53', '2025-10-02 00:08:18', 'https://www.google.com/maps?s=web&rlz=1C1CHBF_enPH1076PH1076&vet=12ahUKEwjuncvMhquCAxXyZWwGHf0oB6AQ5OUKegQIDhAO..i&cs=0&um=1&ie=UTF-8&fb=1&gl=ph&sa=X&geocode=KeXXQbw9mKkzMZ8SM-2MbRRa&daddr=8XW6%2BG37,+42+Zone+Ube,+Mandaue+City,+6014+Cebu'),
(2, 'Pusok', NULL, NULL, NULL, NULL, 'Active', '2025-09-22 22:16:53', '2025-09-22 22:41:26', 'https://www.google.com/maps/dir//Mondejar+Bldg.,+8X97%2B4VH,+M.L.+Quezon+National+Highway,+Lapu-Lapu+City,+6015+Cebu/@10.3178978,123.9235228,13z/data=!3m1!4b1!4m9!4m8!1m1!4e2!1m5!1m1!1s0x33a999daa69f9d7d:0xe953442899b16cf7!2m2!1d123.9647064!2d10.3178364?e'),
(3, 'Mandaue', 'Mandaue', '9123456789', NULL, NULL, 'Active', '2025-09-22 22:16:53', '2025-10-02 00:10:25', 'https://www.google.com/maps/dir//7WHV%2BRP3,+Babang+II+Rd,+Lapu-Lapu+City,+6015+Cebu/@10.2795046,123.8619066,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x33a99a3a552c12d3:0x4f3b0cb463cfb86d!2m2!1d123.9443073!2d10.2795147?entry=ttu'),
(4, 'sample 1', 'sample', '2222222222', '07:18:00', '19:18:00', 'Inactive', '2025-09-22 22:16:53', '2025-10-02 00:10:35', 'https://www.google.com/maps/place/Mactan-Cebu+International+Airport/@10.3153664,123.9858731,4277m/data=!3m1!1e3!4m6!3m5!1s0x33a997613bbd25df:0x8bd061454b8432c1!8m2!3d10.3136169!4d123.9833557!16s%2Fg%2F12322vj76?entry=ttu&g_ep=EgoyMDI1MDkxNy4wIKXMDSoASAFQA'),
(5, 'sample 2', 'sample insert', '1111111111', '07:09:00', '19:09:00', 'Inactive', '2025-09-22 23:09:30', '2025-10-01 23:55:15', ''),
(6, 'Talambann', 'Talamban, Cebu', '4564656664', NULL, NULL, 'Active', '2025-09-24 08:25:59', '2025-09-24 08:26:29', 'https://www.google.com/maps/dir//8XW6%2BG37,+42+Zone+Ube,+Mandaue+City,+6014+Cebu/@10.3557436,123.8524778,22362m/data=!3m1!1e3!4m8!4m7!1m0!1m5!1m1!1s0x33a9983dbc41d7e5:0x5a146d8ced33129f!2m2!1d123.9601141!2d10.3462534?entry=ttu&g_ep=EgoyMDI1MDkyMi4wIKXMDS');

-- --------------------------------------------------------

--
-- Table structure for table `branch_promo`
--

CREATE TABLE `branch_promo` (
  `branch_promo_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_promo`
--

INSERT INTO `branch_promo` (`branch_promo_id`, `branch_id`, `promo_id`, `status`, `start_date`, `end_date`, `date_created`, `date_updated`) VALUES
(1, 1, 1, 'Active', NULL, NULL, '2025-09-21 06:48:42', '2025-10-04 07:08:12'),
(2, 1, 2, 'Active', NULL, NULL, '2025-09-21 06:54:12', '2025-10-04 07:06:41'),
(3, 1, 3, 'Active', '2025-10-01', '2025-10-27', '2025-09-21 07:11:00', '2025-10-02 06:15:45'),
(4, 1, 4, 'Active', '2025-09-13', '2025-10-03', '2025-09-21 07:19:41', '2025-10-02 06:18:16'),
(5, 1, 5, 'Active', NULL, NULL, '2025-09-24 08:30:01', '2025-10-02 06:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `branch_service`
--

CREATE TABLE `branch_service` (
  `branch_services_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_service`
--

INSERT INTO `branch_service` (`branch_services_id`, `branch_id`, `service_id`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 1, 'Active', '2025-09-21 05:51:14', '2025-10-04 06:57:01'),
(2, 1, 2, 'Active', '2025-09-21 05:51:14', '2025-10-04 06:59:02'),
(3, 1, 3, 'Active', '2025-09-21 05:51:14', '2025-10-04 06:59:13'),
(4, 1, 4, 'Active', '2025-09-21 05:51:14', '2025-10-04 06:59:21'),
(5, 1, 5, 'Active', '2025-09-21 05:51:14', '2025-10-04 06:59:30'),
(6, 2, 6, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(7, 2, 7, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(8, 2, 8, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(9, 2, 9, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(10, 2, 10, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(11, 3, 1, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(12, 3, 2, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(13, 3, 3, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(14, 3, 4, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(15, 3, 5, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(16, 3, 6, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(17, 3, 7, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(18, 3, 8, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(19, 3, 9, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(20, 3, 10, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14'),
(21, 2, 2, 'Active', '2025-09-21 05:51:14', '2025-09-21 05:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `branch_supply`
--

CREATE TABLE `branch_supply` (
  `branch_supplies_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `supply_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `reorder_level` int(11) DEFAULT 0,
  `expiration_date` date DEFAULT NULL,
  `status` enum('Available','Unavailable') DEFAULT 'Available',
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_supply`
--

INSERT INTO `branch_supply` (`branch_supplies_id`, `branch_id`, `supply_id`, `quantity`, `reorder_level`, `expiration_date`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 1, 11, 12, '2025-10-31', '', '2025-09-21 05:51:59', '2025-10-04 06:39:49'),
(2, 3, 2, 5, 10, NULL, 'Available', '2025-09-21 06:05:54', '2025-09-21 06:05:54');

-- --------------------------------------------------------

--
-- Table structure for table `dental_prescription`
--

CREATE TABLE `dental_prescription` (
  `prescription_id` int(11) NOT NULL,
  `appointment_transaction_id` int(11) NOT NULL,
  `drug` varchar(255) NOT NULL,
  `route` varchar(50) DEFAULT NULL,
  `frequency` varchar(50) DEFAULT NULL,
  `dosage` varchar(50) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `quantity` varchar(50) NOT NULL,
  `instructions` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_prescription`
--

INSERT INTO `dental_prescription` (`prescription_id`, `appointment_transaction_id`, `drug`, `route`, `frequency`, `dosage`, `duration`, `quantity`, `instructions`, `date_created`) VALUES
(1, 21, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '21', 'Take after meals', '2025-08-23 18:54:01'),
(2, 21, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '3 days', '3', 'For pain, take only when needed', '2025-08-23 18:54:01'),
(3, 22, 'Ibuprofen', 'Oral', '2x/day', '400mg', '5 days', '22', 'Take after meals', '2025-08-23 18:54:01'),
(4, 23, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', '23', 'Do not swallow', '2025-08-23 18:54:01'),
(5, 24, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '24', 'Take after meals', '2025-08-23 18:54:01'),
(6, 24, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', '24', 'For pain and fever', '2025-08-23 18:54:01'),
(7, 25, 'Clindamycin', 'Oral', '3x/day', '300mg', '7 days', '25', 'Use if allergic to penicillin', '2025-08-23 18:54:01'),
(8, 27, 'Sodium Fluoride Gel', 'Topical', '1x/day', 'Thin layer', '14 days', '27', 'Apply at night before bed', '2025-08-23 18:54:01'),
(9, 28, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '28', 'Take after meals', '2025-08-23 18:54:01'),
(10, 28, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '5 days', '28', 'Take only when needed', '2025-08-23 18:54:01'),
(11, 28, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', '28', 'Alternate with Mefenamic Acid if severe pain', '2025-08-23 18:54:01'),
(12, 24, 'Ibuprofen', 'Oral', '3x/day', '400mg', '5 days', '24', 'Take after meals for pain and inflammation', '2025-09-07 19:57:34'),
(13, 24, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '5 days', '24', 'Take only when needed for severe pain', '2025-09-07 19:57:34'),
(14, 24, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', '24', 'Rinse for 30 seconds, do not swallow', '2025-09-07 19:57:34'),
(15, 24, 'Prednisone', 'Oral', '1x/day', '10mg', '3 days', '24', 'Take in the morning to reduce swelling', '2025-09-07 19:57:34'),
(16, 24, 'Metronidazole', 'Oral', '3x/day', '500mg', '7 days', '24', 'Take after meals, avoid alcohol', '2025-09-07 19:57:34'),
(17, 61, '1', '1', '1', '1', '1', '', '1', '2025-09-24 01:11:28'),
(18, 61, '2', '2', '2', '2', '2', '', '2', '2025-09-24 01:12:26'),
(19, 52, '5', NULL, '5', '5', '5', '', '5', '2025-09-26 15:51:54'),
(20, 52, '6', NULL, '6', '6', '6', '', '6', '2025-09-26 16:11:04'),
(21, 52, '7', NULL, '7', '7', '7', '', '7', '2025-09-26 16:16:02'),
(22, 52, '8', NULL, '8', '8', '8', '', '8', '2025-09-26 16:16:26'),
(23, 52, '9', NULL, '9', '9', '9', '9', '9', '2025-09-26 22:59:30'),
(24, 52, '10', NULL, '10', '10', '10', '10', '10', '2025-09-26 22:59:39'),
(25, 24, 'Ibuprofen', 'Oral', '3x/day', '400mg', '5 days', '15', 'Take after meals for pain relief', '2025-09-26 23:46:41'),
(26, 24, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '21', 'Take after meals, complete the course', '2025-09-26 23:46:41'),
(27, 24, 'Mefenamic Acid', 'Oral', '2x/day', '500mg', '3 days', '6', 'Take only when needed for pain', '2025-09-26 23:46:41'),
(28, 24, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', '14', 'Rinse for 30 seconds, do not swallow', '2025-09-26 23:46:41'),
(29, 24, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', '15', 'Take for pain and fever', '2025-09-26 23:46:41');

-- --------------------------------------------------------

--
-- Table structure for table `dental_transaction`
--

CREATE TABLE `dental_transaction` (
  `dental_transaction_id` int(11) NOT NULL,
  `appointment_transaction_id` int(11) NOT NULL,
  `dentist_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `is_swelling` enum('Yes','No') DEFAULT 'No',
  `is_sensitive` enum('Yes','No') DEFAULT 'No',
  `is_bleeding` enum('Yes','No') DEFAULT 'No',
  `notes` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `prescription_downloaded` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_transaction`
--

INSERT INTO `dental_transaction` (`dental_transaction_id`, `appointment_transaction_id`, `dentist_id`, `amount_paid`, `is_swelling`, `is_sensitive`, `is_bleeding`, `notes`, `date_created`, `prescription_downloaded`) VALUES
(1, 21, 3, 1500.00, 'Yes', 'No', 'No', 'Tooth #12 extraction, mild swelling.', '2025-08-23 19:37:15', 0),
(2, 22, 3, 2000.00, 'No', 'Yes', 'No', 'Tooth filling, slight sensitivity.', '2025-08-23 19:37:15', 1),
(3, 23, 1, 1200.00, 'No', 'No', 'No', 'Routine cleaning, no complications.', '2025-08-23 19:37:15', 1),
(4, 24, 4, 1800.00, 'Yes', 'No', 'Yes', 'Wisdom tooth removal, moderate bleeding.', '2025-08-23 19:37:15', 1),
(5, 25, 3, 2500.00, 'No', 'No', 'No', 'Root canal treatment, stable condition.', '2025-08-23 19:37:15', 0),
(8, 28, 1, 3000.00, 'Yes', 'Yes', 'Yes', 'Complex surgical extraction with swelling & bleeding.', '2025-08-23 19:37:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dental_vital`
--

CREATE TABLE `dental_vital` (
  `vitals_id` int(11) NOT NULL,
  `appointment_transaction_id` int(11) NOT NULL,
  `body_temp` decimal(4,1) DEFAULT NULL,
  `pulse_rate` int(11) DEFAULT NULL,
  `respiratory_rate` int(11) DEFAULT NULL,
  `blood_pressure` varchar(10) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_vital`
--

INSERT INTO `dental_vital` (`vitals_id`, `appointment_transaction_id`, `body_temp`, `pulse_rate`, `respiratory_rate`, `blood_pressure`, `height`, `weight`, `date_created`) VALUES
(1, 21, 36.7, 72, 18, '120/80', 168.00, 65.00, '2025-08-23 18:53:50'),
(2, 22, 37.2, 80, 20, '130/85', 175.00, 70.00, '2025-08-23 18:53:50'),
(3, 23, 36.5, 70, 19, '115/75', 160.00, 55.00, '2025-08-23 18:53:50'),
(4, 24, 37.0, 76, 18, '118/78', 165.00, 60.00, '2025-08-23 18:53:50'),
(5, 25, 36.8, 74, 17, '122/82', 172.00, 68.00, '2025-08-23 18:53:50'),
(6, 26, 37.1, 82, 21, '135/90', 178.00, 80.00, '2025-08-23 18:53:50'),
(7, 27, 36.6, 68, 16, '110/70', 158.00, 50.00, '2025-08-23 18:53:50'),
(8, 28, 37.3, 85, 22, '140/95', 182.00, 85.00, '2025-08-23 18:53:50'),
(10, 61, 25.0, 25, 25, '25', 25.00, 25.00, '2025-09-24 00:50:19'),
(11, 61, 25.0, 25, 25, '25', 25.00, 25.00, '2025-09-24 00:53:07'),
(12, 61, 1.0, 1, 1, '1', 1.00, 1.00, '2025-09-24 00:54:46'),
(13, 61, 2.0, 2, 2, '2', 2.00, 2.00, '2025-09-24 00:55:32'),
(14, 61, 3.0, 3, 3, '3', 3.00, 3.00, '2025-09-24 01:10:03'),
(15, 61, 4.0, 4, 4, '4', 4.00, 4.00, '2025-09-24 01:12:49'),
(16, 52, 5.0, 5, 5, '5', 5.00, 5.00, '2025-09-26 15:52:13'),
(17, 52, 6.0, 6, 6, '6', 6.00, 6.00, '2025-09-26 16:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `dentist`
--

CREATE TABLE `dentist` (
  `dentist_id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `date_started` date NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `signature_image` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentist`
--

INSERT INTO `dentist` (`dentist_id`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `email`, `contact_number`, `license_number`, `date_started`, `status`, `signature_image`, `date_created`, `date_updated`) VALUES
(1, 'Ulanday', 'Mansanitass', 'Precious', 'Female', '2025-01-02', 'precious@gmail.com', '9789321654', 'LIC-100111', '2025-10-31', 'Active', '68be0b0fa22c2_pretot.png', '2025-07-11 19:40:26', NULL),
(2, 'Chan', 'Marie', 'Kyla', 'Female', '2025-08-29', 'kyla.marie@gmail.com', '2112321321', 'LIC-1002', '2023-02-10', 'Active', '68be0b1e6d278_chiku.png', '2025-07-11 19:40:26', NULL),
(3, 'Summers', '', 'Daze', 'Female', '2025-09-09', 'daze@gmail.com', '0912345680', 'LIC-1003', '2023-03-05', 'Active', '68be0b26e6fc2_daze.png', '2025-07-11 19:40:26', NULL),
(4, 'San Jose', '', 'Solene', 'Female', '2025-09-12', 'solene@gmail.com', '0912345681', 'LIC-1004', '2023-04-01', 'Active', '68be0b34297fb_sol.png', '2025-07-11 19:40:26', NULL),
(5, 'San Jose', 'Codm', 'Yel', 'Female', '2025-09-04', 'yel@gmail.com', '9123456789', 'LIC-100322', '2023-05-20', 'Active', '68be0b3d5870b_yel.png', '2025-08-30 00:24:25', NULL),
(6, 'Achas', '', 'Gab', 'Male', '2025-08-02', 'achas@gmail.com', '7864515665', '123123', '0000-00-00', 'Active', NULL, '2025-08-30 12:07:53', NULL),
(7, 'Menano', '', 'Andy', 'Male', '2025-08-29', 'adny@gmail.com', '8756465486', '123321', '2025-09-25', 'Active', NULL, '2025-08-30 12:17:41', NULL),
(8, 'asd', 'sad', 'asdas', 'Female', '2025-09-08', 'sample@gmail.com', '1241421241', '1221211', '2025-09-25', 'Active', '68be08a6d924a_gary-vaynerchuk-signature-0.png', '2025-09-07 22:35:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dentist_branch`
--

CREATE TABLE `dentist_branch` (
  `dentist_branch_id` int(11) NOT NULL,
  `dentist_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentist_branch`
--

INSERT INTO `dentist_branch` (`dentist_branch_id`, `dentist_id`, `branch_id`) VALUES
(7, 5, 2),
(18, 4, 1),
(19, 4, 3),
(28, 2, 3),
(29, 2, 2),
(35, 7, 3),
(78, 6, 2),
(84, 3, 2),
(85, 8, 1),
(86, 1, 1),
(87, 1, 2),
(88, 1, 3),
(89, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `dentist_service`
--

CREATE TABLE `dentist_service` (
  `dentist_services_id` int(11) NOT NULL,
  `dentist_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentist_service`
--

INSERT INTO `dentist_service` (`dentist_services_id`, `dentist_id`, `service_id`) VALUES
(2, 2, 2),
(3, 2, 3),
(4, 2, 6),
(19, 3, 1),
(24, 4, 2),
(25, 4, 5),
(26, 4, 7),
(27, 8, 2),
(31, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 27, 'Your appointment on 2025-07-29 at 13:30 was successfully booked!', 0, '2025-07-14 11:14:19'),
(2, 28, 'Welcome to Smile-ify! Your account was successfully created.', 1, '2025-07-14 11:26:32'),
(3, 28, 'Your appointment on 2025-07-29 at 14:15 was successfully booked!', 1, '2025-07-14 11:26:32'),
(5, 2, 'sample - admin', 1, '2025-07-14 15:33:49'),
(6, 1, 'sample - owner', 1, '2025-07-14 15:33:49'),
(7, 1, 'sample - owner', 1, '2025-07-14 15:33:49'),
(8, 1, 'sample - owner', 1, '2025-07-14 15:33:49'),
(9, 2, 'sample - admin', 1, '2025-07-14 15:33:49'),
(10, 2, 'sample - admin', 1, '2025-07-14 15:35:36'),
(11, 2, 'sample - admin', 1, '2025-07-14 15:35:36'),
(12, 29, 'Welcome to Smile-ify! Your account was successfully created.', 1, '2025-07-14 15:48:42'),
(13, 29, 'Your appointment on 2025-07-24 at 10:30 was successfully booked!', 1, '2025-07-14 15:48:42'),
(14, 30, 'Welcome to Smile-ify! Your account was successfully created.', 1, '2025-07-14 16:03:59'),
(15, 30, 'Your appointment on 2025-07-31 at 13:30 was successfully booked!', 1, '2025-07-14 16:03:59'),
(16, 28, 'Your appointment on 2025-07-23 at 09:45 was successfully booked!', 1, '2025-07-21 18:30:17'),
(17, 28, 'Your appointment on 2025-07-31 at 15:00 was successfully booked!', 1, '2025-07-21 18:42:53'),
(18, 28, 'Your appointment on 2025-07-30 at 15:00 was successfully booked!', 1, '2025-07-21 20:03:40'),
(19, 28, 'Your appointment on 2025-07-30 at 10:30 was successfully booked!', 1, '2025-07-21 20:10:59'),
(20, 28, 'Your appointment on 2025-07-24 at 12:00 was successfully booked!', 1, '2025-07-21 20:30:32'),
(21, 28, 'Your appointment on 2025-07-31 at 10:30 was successfully booked!', 1, '2025-07-24 15:58:38'),
(22, 31, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-07-31 14:32:30'),
(23, 31, 'Your appointment on 2025-08-02 at 12:45 was successfully booked!', 0, '2025-07-31 14:32:30'),
(24, 32, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-07-31 14:38:20'),
(25, 32, 'Your appointment on 2025-08-16 at 11:15 was successfully booked!', 0, '2025-07-31 14:38:20'),
(26, 33, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-07-31 14:38:28'),
(27, 33, 'Your appointment on 2025-08-16 at 11:15 was successfully booked!', 0, '2025-07-31 14:38:28'),
(28, 34, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-07-31 14:54:44'),
(29, 34, 'Your appointment on 2025-08-01 at 10:30 was successfully booked!', 0, '2025-07-31 14:54:44'),
(30, 35, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-08-05 20:06:22'),
(31, 35, 'Your appointment on 2025-08-29 at 15:00 was successfully booked!', 0, '2025-08-05 20:06:23'),
(32, 36, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-08-09 17:21:09'),
(33, 36, 'Your appointment on 2025-08-12 at 14:15 was successfully booked!', 0, '2025-08-09 17:21:09'),
(34, 30, 'Your password was successfully reset on August 9, 2025, 8:46 pm. If this wasn’t you, please contact support immediately.', 1, '2025-08-09 18:46:24'),
(35, 30, 'Your password was successfully reset on August 10, 2025, 2:52 am. If this wasn’t you, please contact support immediately.', 1, '2025-08-09 18:52:02'),
(36, 30, 'Your appointment on 2025-08-15 at 10:00 was successfully booked.', 1, '2025-08-09 19:22:26'),
(37, 30, 'Reminder: Your dental cleaning is tomorrow at 14:30.', 1, '2025-08-09 19:22:26'),
(38, 30, 'Your profile has been updated successfully.', 1, '2025-08-09 19:22:26'),
(39, 30, 'Special Offer: 20% off whitening treatment this month!', 1, '2025-08-09 19:22:26'),
(40, 30, 'We received your payment for your last visit.', 1, '2025-08-09 19:22:26'),
(41, 30, 'New message from Dr. Smith regarding your last appointment.', 1, '2025-08-09 19:22:26'),
(42, 30, 'Your appointment on 2025-08-20 at 09:00 is confirmed.', 1, '2025-08-09 19:22:26'),
(43, 30, 'Lab results are now available in your account.', 1, '2025-08-09 19:22:26'),
(44, 30, 'Your subscription plan has been renewed successfully.', 1, '2025-08-09 19:22:26'),
(45, 30, 'Important: Our clinic hours have changed starting next week.', 1, '2025-08-09 19:22:26'),
(46, 1, 'sample index', 1, '2025-08-09 20:34:25'),
(47, 1, 'sample index', 1, '2025-08-09 20:34:25'),
(48, 42, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-08-12 15:18:53'),
(49, 42, 'Your appointment on 2025-08-18 at 15:00 was successfully booked!', 0, '2025-08-12 15:18:53'),
(50, 28, 'Your appointment on 2025-08-27 at 15:00 was successfully booked!', 1, '2025-08-19 20:55:36'),
(51, 28, 'Your password was changed successfully on August 21, 2025, 6:13 am. If this wasn’t you, please contact support immediately.', 1, '2025-08-20 22:13:56'),
(52, 28, 'Your password was changed successfully on August 21, 2025, 6:18 am. If this wasn’t you, please contact support immediately.', 1, '2025-08-20 22:18:11'),
(53, 28, 'Your password was changed successfully on August 21, 2025, 6:20 am. If this wasn’t you, please contact support immediately.', 1, '2025-08-20 22:20:58'),
(54, 28, 'Your password was changed successfully on August 21, 2025, 6:22 am. If this wasn’t you, please contact support immediately.', 1, '2025-08-20 22:22:40'),
(55, 1, 'Your password was changed successfully on August 21, 2025, 6:44 am. If this wasn’t you, please contact support immediately.', 1, '2025-08-20 22:44:20'),
(56, 28, 'Your password was successfully reset on August 23, 2025, 11:09 pm. If this wasn’t you, please contact support immediately.', 1, '2025-08-23 15:09:45'),
(57, 28, 'Your appointment on 2025-08-29 at 15:00 was successfully booked!', 1, '2025-08-23 18:39:11'),
(58, 45, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-09-01 10:51:29'),
(59, 45, 'Your appointment on 2025-09-09 at 11:15 was successfully booked!', 0, '2025-09-01 10:51:29'),
(60, 46, 'Welcome to Smile-ify! Your account was successfully created.', 1, '2025-09-01 10:54:07'),
(61, 46, 'Your appointment on 2025-09-05 at 09:00 was successfully booked!', 1, '2025-09-01 10:54:07'),
(62, 46, 'Your password was changed successfully on September 1, 2025, 6:57 pm. If this wasn’t you, please contact support immediately.', 0, '2025-09-01 10:57:48'),
(63, 47, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-09-01 15:43:24'),
(64, 47, 'Your appointment on 2025-09-04 at 15:00 was successfully booked!', 0, '2025-09-01 15:43:24'),
(65, 47, 'Your password was changed successfully on September 1, 2025, 11:48 pm. If this wasn’t you, please contact support immediately.', 0, '2025-09-01 15:48:43'),
(66, 28, 'Your appointment on 2025-09-12 at 10:30 was successfully booked!', 1, '2025-09-07 19:43:36'),
(67, 28, 'Your appointment on 2025-09-11 at 10:30 was successfully booked!', 1, '2025-09-07 19:44:03'),
(68, 28, 'Your appointment on 2025-09-12 at 09:45 was successfully booked!', 1, '2025-09-07 19:47:38'),
(69, 2, 'Your password was successfully reset on September 8, 2025, 6:12 am. If this wasn’t you, please contact support immediately.', 1, '2025-09-07 22:12:42'),
(70, 2, 'Your password was successfully reset on September 13, 2025, 3:37 am. If this wasn’t you, please contact support immediately.', 1, '2025-09-12 19:37:06'),
(71, 2, 'Your password was changed successfully on September 13, 2025, 4:00 am. If this wasn’t you, please contact support immediately.', 1, '2025-09-12 20:00:18'),
(72, 53, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-09-16 19:05:45'),
(73, 53, 'Your appointment on 2025-10-04 at 14:15 was successfully booked!', 0, '2025-09-16 19:05:45'),
(74, 54, 'Welcome to Smile-ify! Your account was created. Username: Tan_P | Password: tan9464%', 0, '2025-09-16 19:22:37'),
(75, 54, 'Your appointment on 2025-09-19 at 09:00 was successfully booked!', 0, '2025-09-16 19:22:37'),
(76, 55, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-09-17 19:45:22'),
(77, 55, 'Your appointment on 2025-10-02 at 12:00 was successfully booked!', 0, '2025-09-17 19:45:22'),
(78, 46, 'Your appointment on 2025-09-19 at 11:15 was successfully booked!', 0, '2025-09-17 22:30:42'),
(79, 56, 'Welcome to Smile-ify! Your account was created.', 0, '2025-09-17 22:48:49'),
(80, 56, 'Your appointment on 2025-09-19 at 09:45 was successfully booked!', 0, '2025-09-17 22:48:49'),
(81, 56, 'Your appointment on 2025-09-20 at 09:45 was successfully booked!', 0, '2025-09-17 23:10:02'),
(82, 28, 'Your appointment on 2025-09-30 at 15:00 was successfully booked!', 1, '2025-09-17 23:11:37'),
(83, 28, 'Your appointment on 2025-09-19 at 09:45 was successfully booked!', 1, '2025-09-17 23:12:58'),
(84, 46, 'Your appointment on 2025-09-20 at 10:30 was successfully booked!', 0, '2025-09-17 23:16:12'),
(85, 57, 'Welcome to Smile-ify! Your account was created.', 0, '2025-09-21 22:05:17'),
(86, 57, 'Your appointment on 2025-09-30 at 15:00 was successfully booked!', 0, '2025-09-21 22:05:17'),
(87, 28, 'Your appointment on 2025-10-18 at 09:00 was successfully booked!', 1, '2025-09-21 22:06:36'),
(88, 28, 'Your appointment on 2025-09-26 at 09:45 was successfully booked!', 1, '2025-09-21 22:07:12'),
(89, 28, 'Your appointment on 2025-09-24 at 09:00 was successfully booked!', 1, '2025-09-22 19:08:19'),
(90, 28, 'Your appointment on 2025-09-24 at 09:00 was successfully booked!', 1, '2025-09-22 19:15:35'),
(91, 58, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-09-22 19:59:12'),
(92, 58, 'Your appointment on 2025-09-24 at 09:45 was successfully booked!', 0, '2025-09-22 19:59:12'),
(93, 28, 'Your appointment on 2025-09-24 at 15:00 was successfully booked!', 1, '2025-09-22 20:43:39'),
(94, 28, 'Your appointment on 2025-09-25 at 10:30 was successfully booked!', 1, '2025-09-22 21:28:30'),
(95, 28, 'Your appointment on 2025-09-24 at 10:30 was successfully booked!', 1, '2025-09-22 21:28:59'),
(96, 59, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-09-22 22:01:09'),
(97, 59, 'Your appointment on 2025-09-24 at 11:15 was successfully booked!', 0, '2025-09-22 22:01:09'),
(98, 59, 'Your appointment on 2025-09-24 at 12:00 was successfully booked!', 0, '2025-09-22 22:02:03'),
(99, 59, 'Your appointment on 2025-09-24 at 12:45 was successfully booked!', 0, '2025-09-22 22:02:52'),
(100, 28, 'Your appointment on 2025-09-24 at 14:15 was successfully booked!', 1, '2025-09-22 22:03:11'),
(101, 28, 'Your appointment on 2025-09-24 at 13:30 was successfully booked!', 1, '2025-09-22 22:03:24'),
(102, 59, 'Your appointment on 2025-09-25 at 09:00 was successfully booked!', 0, '2025-09-24 00:03:02'),
(103, 60, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-09-24 07:32:21'),
(104, 60, 'Your appointment on 2025-09-25 at 11:15 was successfully booked!', 0, '2025-09-24 07:32:21'),
(105, 28, 'Your appointment on 2025-09-25 at 09:45 was successfully booked!', 1, '2025-09-24 07:37:01'),
(106, 28, 'Your password was successfully reset on September 24, 2025, 4:10 pm. If this wasn’t you, please contact support immediately.', 1, '2025-09-24 08:10:56'),
(107, 28, 'Your password was changed successfully on September 26, 2025, 10:49 pm. If this wasn’t you, please contact clinic immediately.', 0, '2025-09-26 14:49:45'),
(108, 28, 'Your password was changed successfully on September 26, 2025, 11:27 pm. If this wasn’t you, please contact clinic immediately.', 0, '2025-09-26 15:27:12'),
(109, 28, 'Your appointment on 2025-10-31 at 09:00 was successfully booked!', 0, '2025-10-03 21:22:21'),
(110, 28, 'Your password was changed successfully on October 4, 2025, 5:30 am. If this wasn’t you, please contact clinic immediately.', 0, '2025-10-03 21:30:15'),
(111, 28, 'Your appointment on 2025-10-31 at 09:45 was successfully booked!', 0, '2025-10-03 21:42:30'),
(112, 27, 'Your appointment on 2025-10-31 at 10:30 was successfully booked!', 0, '2025-10-03 21:43:55'),
(113, 54, 'Your appointment on 2025-10-31 at 11:15 was successfully booked!', 0, '2025-10-03 21:44:25'),
(114, 54, 'Your appointment on 2025-10-31 at 12:00 was successfully booked!', 0, '2025-10-03 21:46:53'),
(115, 2, 'Your password was changed successfully on October 4, 2025, 6:03 am. If this wasn’t you, please contact clinic immediately.', 0, '2025-10-03 22:03:33'),
(116, 1, 'Your password was changed successfully on October 4, 2025, 6:10 am. If this wasn’t you, please contact clinic immediately.', 0, '2025-10-03 22:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `promo_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `name`, `image_path`, `description`, `discount_type`, `discount_value`) VALUES
(1, 'openinggg', '/images/promos/promo_1.jpg', 'openinggg', 'fixed', 500.00),
(2, 'Grand Openingg', '/images/promos/promo_2.jpg', 'Grand Openinggg', 'fixed', 45.00),
(3, 'joseph', '/images/promos/promo_3.jpg', 'jj', 'percentage', 80.00),
(4, 'sample', '/images/promos/promo_4.jpg', 'qwerrt', 'fixed', 123.00),
(5, 'Senior', '/images/promos/promo_5.jpeg', '60 above', 'percentage', 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `name`, `price`) VALUES
(1, 'Consultation', 300),
(2, 'Tooth Extraction', 5000),
(3, 'Dental Filling', 3000),
(4, 'Root Canal Treatment', 10000),
(5, 'Dental Crown Placement', 500),
(6, 'Orthodontic Braces', 0),
(7, 'Teeth Whitening', 0),
(8, 'Complete Denture', 0),
(9, 'Partial Denture', 0),
(10, 'Dental Implant', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `supply_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`supply_id`, `name`, `description`, `category`, `unit`) VALUES
(1, 'mask', 'mask', 'mask', 'ppe4e'),
(2, 'knife', 'talinis', 'tools', 'taya');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('owner','admin','patient') NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `date_started` date DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL,
  `force_logout` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `email`, `contact_number`, `address`, `role`, `branch_id`, `date_started`, `status`, `date_created`, `date_updated`, `force_logout`) VALUES
(1, 'owner01', '$2y$10$ghSNQ.rsGM1HnSDeQviA7uwSkcOw8sLWHjmOg7glYSCLwS7UXaUKi', 'Owner', 'Dummy', 'Sample', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9998887777', 'decaasdadadaaaa', 'owner', NULL, NULL, 'Active', '2025-06-14 10:39:32', '2025-10-04 06:10:31', 0),
(2, 'admin01', '$2y$10$WPhHqvinl9NbARAkJMZh6eZWAXGJQ/HuP4a7ZX5cuCTK3FieEJuCS', 'Potot', 'Travero', 'Rixx', 'Female', '2000-04-05', '18102727@usc.edu.ph', '9950217941', 'San Miguel, Cordovaaa', 'admin', 1, '2025-09-30', 'Active', '2025-06-14 10:39:32', '2025-10-04 06:19:44', 0),
(3, 'patient01', '$2a$12$RJZbVUZ3JDsUjDB5eFTyiuACuCvxFJyrQI4cE9u8fQ2ChJf/.Srdq', 'Patient', 'Dummy', 'Sample', 'Male', '0000-00-00', '', '9123456789', NULL, 'patient', NULL, NULL, 'Inactive', '2025-06-14 10:39:32', NULL, 0),
(8, 'ParchasoJ', '$2y$10$9fqT9Gco1CtAKVKu6bSDgeh9SFZbg/bb8GJR5OJrrVIJycPZgqxWC', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', '9055626239', 'josephparc', NULL, 'owner', NULL, NULL, 'Inactive', '2025-07-11 22:27:56', NULL, 0),
(9, 'ParchasoJJ', '$2y$10$W.BXzGapcq9J/oxpk1RHYeaYMxBCz0fSTp8YiRh41YSUebQ12Hjhy', 'Parchaso', 'Joseph', 'Jhon', 'Male', '0000-00-00', '9055626239', 'josephparc', NULL, 'owner', NULL, NULL, 'Inactive', '2025-07-11 22:30:07', NULL, 0),
(10, 'ParchasoJo', '$2y$10$7TtiXyp5duA0k9e0t7nmX.BfdQgpQkYwzUVT8tiCFDY166aCIZFoG', 'Parchaso', '', 'Joseph', 'Male', '0000-00-00', '9055626239', 'josephparc', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 22:31:48', NULL, 0),
(11, 'PototR', '$2y$10$2LodhIAZ8iTEc7e5U8ciM.ERBdKf5t2XTv1enJGrQyxJC501X7DG.', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', '9950217941', 'josephparc', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 22:36:13', NULL, 0),
(12, 'ParchasoJh', '$2y$10$V9IluHOclcF/fELFexGVPOwsPpXLMCpVz6X5tA53PNxqjGUN39XHq', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:10:37', NULL, 0),
(13, 'asdasdaa', '$2y$10$xx/z0aCzxsgWfhbTyNeT2ewgqLJDF0eA4MIG2KJAh48nLldnoT7mu', 'asdasda', 'dasdads', 'asdasdas', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '3543535353', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:49:00', NULL, 0),
(14, 'ParchasoJn', '$2y$10$n0Wn8ENlBKZSmFAc8XIo6.8MBB9.vBHC9jj20HU4E4aBg3QzLnJGa', 'Parchaso', 'espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:53:50', NULL, 0),
(15, 'pototrr', '$2y$10$81epq2ks0nZntMd5BJtQZeTQgwcM1olJw54tWvY3BCS2.WMKgVy6q', 'potot', 'travs', 'rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '3242424243', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:57:34', NULL, 0),
(16, 'PototRi', '$2y$10$upl6ZnCyMKiiML1SFtOANefWYuh0EKOdUDdNDm/i8b/2nExYEXuea', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '9055626339', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 18:37:17', NULL, 0),
(17, 'PototRx', '$2y$10$/z0.LVx2xEaDvFVmYKUx9Ou3r8cYEg8Iv0aO6lSArBdZbX2e4XJ9m', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 19:04:48', NULL, 0),
(18, 'parchr', '$2y$10$rBXard1PzWqKnXOsGVbowu8pT1dv11gHFELYhn2UjusTOkR39ZxVS', 'parch', 'potot', 'rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '3243242343', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:04:53', NULL, 0),
(19, 'achasg', '$2y$10$pdkklvpmZcbw451FCvkKt.JI14X7dXVExlkqd4e7hAyzunu1KkRjC', 'achas', 'gab', 'gab', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '2423543265', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:31:49', NULL, 0),
(20, 'rixp', '$2y$10$qBN90ZhgnNkJMH23cBT6uOHqAmlXeUTkkJgaQ.myzXnRwATFWEvma', 'rix', '', 'potot', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '2342412421', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:36:12', NULL, 0),
(21, 'rixpp', '$2y$10$nvqUzj8gqqY16SHHkt4NQeVQVeU8CQbOaw6u0hhliacSetzJQU6v2', 'rix', '', 'potot', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '2342412421', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:37:27', NULL, 0),
(22, 'parchj', '$2y$10$sQwUuUFOgllhhPugQds8k.zXlAGrVCiCuTvbcfiCyBBnp4dd8/e3a', 'parch', 'rix', 'jj', 'Female', '0000-00-00', '18100807@usc.edu.ph', '2346676887', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:43:04', NULL, 0),
(23, 'pretotd', '$2y$10$fTfrKDDNlUlfmfVRvYF.xOfaEyRWPo51Ux8aqHtLpDgBlxbWVjxSy', 'pretot', 'chiku', 'daze', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '3214325666', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:45:13', NULL, 0),
(24, '23dfsfs', '$2y$10$jRDx4wuzWruwA6NDUnGnn.XRyS0qYxK16q.20kDMphYGnVcDNlZKK', '23dfsf', 's', 'sdfsfd', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '4326789879', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 21:20:25', NULL, 0),
(25, 'AchasGG', '$2y$10$csrxQ1iwxHEcfkhQHKf3se586DUSZSK.WhXgNKB39m9js/HfPwuYK', 'Achas', '', 'Gab', 'Male', '0000-00-00', '18100807@usc.edu.ph', '0922626262', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 10:25:16', NULL, 0),
(26, 'DazeP', '$2y$10$du.PYFR4vnJv9ecdNWDox.UUDcjoC0cTUAvtnsnSG.tXwdqn5vLKO', 'Daze', '', 'Pretot', 'Male', '0000-00-00', 'parchasoresidence@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 10:33:22', NULL, 0),
(27, 'ChikuY', '$2y$10$h7C7FiWzWuf7oS0hUaav/OZwJX4rYOExaPk3NJu3O39mmsutOsUvm', 'Chiku', 'Wix', 'Yel', 'Female', '0000-00-00', 'parchasoresidence@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 11:14:19', '2025-10-04 05:51:10', 0),
(28, 'Josephp', '$2y$10$zHpdy.9BdsVQZpCU9Jzgg.ULyXzGmQKOSfgj5TwNV5le40z7ln8Si', 'Joseph', '', 'parch', 'Male', '1999-08-17', 'josephparchaso@gmail.com', '9055626237', 'Block 22, Lot 6, Deca 4 Bankal Lapu Lapu City Cebu', 'patient', 1, NULL, 'Active', '2025-07-14 11:26:32', '2025-10-04 05:30:15', 0),
(29, 'pototj', '$2y$10$9Swzre20c9pLQ8ejMr1ySufYwaARXiCYpp8sUXyb5CP1oI7xNjtC2', 'potot', '', 'jj', 'Male', '0000-00-00', '18102727@usc.edu.ph', '9527194102', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 15:48:41', NULL, 0),
(30, 'pret', '$2y$10$z7r/dpwWQ2m.RZK8EcwJGu2MkUM3tRY2EgG/7OyfSubN.bmXm2yTW', 'pre', '', 'tot', 'Male', '0000-00-00', '18102727@usc.edu.ph', '9205251545', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 16:03:59', NULL, 0),
(31, 'Parchaso_J', '$2y$10$14IUZVVauGdjCe04vSuVTechUS8.EYYzOO5yZ0Li6Lq/IUhGx0.Ny', 'Parchaso', 'Espana', 'Jhon', 'Female', '0000-00-00', '18100807@usc.edu.ph', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:32:30', NULL, 0),
(32, 'Parchaso_J1', '$2y$10$jhV55n5K2zZw.hoG40uBw.OceefQ5Q8VftYGFBJND/AdBnP7FmhkS', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:38:20', NULL, 0),
(33, 'Parchaso_J2', '$2y$10$9RhohMzQ7GCr2dSgX02sROUqqX9BhlYPQbvFzTte0bR7nms04U562', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:38:28', NULL, 0),
(34, 'parchaso_J', '$2y$10$AzXcLMHhefFKyQJfG3lteu/2wKCjJzmhRM4ncT6oSQzhIfEvci9ca', 'parchaso', 'espana', 'jhon', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:54:44', NULL, 0),
(35, 'Parchhh_J', '$2y$10$BLbxRzDFxMO/QnMcVMpT/OO7r5CYpuSanK4TIMTrLAv6kq7qMy.IG', 'Parchhh', '', 'jj', 'Female', '0000-00-00', '18100807@usc.edu.ph', '6515616165', NULL, 'patient', NULL, NULL, 'Inactive', '2025-08-05 20:06:22', NULL, 0),
(36, 'asdasd_A', '$2y$10$bMsAKLtfJ1e00emYMAaNWuFrD00n/n5St9zCFqmlbLvlHKoKNOXfS', 'asdasd', '', 'asdads', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '2525325425', NULL, 'patient', NULL, NULL, 'Inactive', '2025-08-09 17:21:09', '2025-10-04 05:52:35', 0),
(37, 'admin_b1_01', '$2a$12$hBbDjdgIHA7jTYk63MoYCevpRg.Wyl.Q9AlF1k22Adu5ZTZ2scPhm', 'Wonderland', 'In', 'Alice', 'Female', '2020-03-25', 'alice.b1@example.com', '9789456231', 'Cebu', 'admin', 3, '2023-02-11', 'Active', '2025-08-11 18:06:49', '2025-10-04 06:26:06', 1),
(38, 'admin_b1_02', '$2a$12$q3izbTzuli5uTm1twK/4YuDY3QSDbWej0pkWVyGsSMRpXVhbrbVRO', 'Admin', 'B1', 'Bob', 'Male', '0000-00-00', 'bob.b1@example.com', '0911111111', NULL, 'admin', 1, '2023-12-05', 'Active', '2025-08-11 18:06:49', NULL, 0),
(39, 'admin_b2_01', '$2a$12$zoGuJuLYhOVs6B828pgDe.lrvUEwXroV1zUzbmxgfwZgCSLi39mHa', 'Admin', 'B2', 'Charlie', 'Male', '2025-09-25', 'charlie.b2@example.com', '0922222222', 'null', 'admin', 2, '2025-09-12', 'Inactive', '2025-08-11 18:06:49', NULL, 1),
(40, 'admin_b2_02', '$2a$12$KL9XSfdZh75UuYWljehw0.zNyPK/arJmS7mEzFMvNuK1sBKqLBTLC', 'Admin', 'B2', 'Diana', 'Female', '0000-00-00', 'diana.b2@example.com', '0922222222', NULL, 'admin', 2, '2024-02-20', 'Active', '2025-08-11 18:06:49', NULL, 0),
(41, 'admin_b3_01', '$2a$12$hNePRteKgF2EC1nNHkhQP..14KMwMN66/t3YzL4.GGbLNPXhS7ksa', 'Admin', 'B33', 'Evan', 'Male', '2025-09-25', 'evan.b3@example.com', '0933333333', 'null', 'admin', 3, '2025-02-20', 'Active', '2025-08-11 18:06:49', '2025-10-04 06:31:24', 1),
(42, 'Parchaso_J3', '$2y$10$7nbX35783pFvgW4/mdIuzuSaFhONUt6S5Gw/Aabgd2akXGwfmzwa2', 'Parchaso', 'Espana', 'JJ', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-08-12 15:18:53', NULL, 0),
(43, NULL, '$2y$10$aCLfK7EOsfLFyCYFsCDZzO03iVxSaxZ7D9grAp7C1GMnDs2t.YSYi', 'Potot', 'Travero', 'Thamara', 'Female', '2013-09-25', 'maya@gmail.com', '5465464654', 'asdsad', 'admin', 1, '2025-09-25', 'Inactive', '2025-08-30 11:40:50', NULL, 0),
(44, 'potot_a', '$2y$10$f5shlmN2IMzn1yz/VacRLOjezOmSdU7xPB7kizyd70K0nvpk7e8AK', 'Potot', 'Travero', 'Anna', 'Female', '2025-07-27', 'ana@gmail.com', '1231324654', '0', 'admin', 3, '2025-09-29', 'Inactive', '2025-08-30 11:47:27', NULL, 0),
(45, 'ttvt_K', '$2y$10$avex/XQe4/bbLQTfGq4vsOeLiFV.SANzStRzaEgpZHUr5kLUuJ1Bq', 'ttvt', 'k', 'kggjkj', 'Female', '2025-09-02', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-09-01 10:51:29', NULL, 0),
(46, 'Achas_J', '$2y$10$YuOFDFrnJFYnE65JjXFChu.WQxRa2okENHtFER9xJPwLN1LM29l1y', 'Achas', 'Pallasigue', 'Joshua Gabriel', 'Male', '1999-04-27', 'gabbyachas99@gmail.com', '9260860681', 'P-1 Base Camp, Maramag, Bukidnon', 'patient', NULL, NULL, 'Active', '2025-09-01 10:54:07', NULL, 0),
(47, 'Parchaso_J4', '$2y$10$Durf8pKbOk2BG6IioMFST.63gUDR4PRITB5mJbdJrOvg6MfdfZRCK', 'Parchaso', 'Espana', 'Jhon', 'Female', '1999-08-17', '18100807@usc.edu.ph', '9055626239', NULL, 'patient', NULL, NULL, 'Inactive', '2025-09-01 15:43:24', NULL, 0),
(48, 'Achas_G', '$2y$10$qF68ie3yW6UnvQyTV74O7.zN7PotiUXW0huXAGuMQ5FY4SDxkqXgK', 'Achas', '', 'Gab', 'Male', '2025-09-11', 'josephparchaso@gmail.com', '9055626239', 'deca', 'admin', 3, '2025-09-09', 'Active', '2025-09-07 21:54:27', NULL, 0),
(49, 'asd_A', '$2y$10$mWpr.dorheR9kWYUjq71n.DYPE98YkIwheXxDpRFejM88d6GLslRq', 'asd', 'asd', 'asd', 'Female', '2025-09-04', 'josephparchasooo@gmail.com', '8481198919', '0', 'admin', 3, '2025-09-24', 'Inactive', '2025-09-07 21:56:18', NULL, 0),
(50, 'parch_J', '$2y$10$Pnho0/H8Abi2ZzJcSapU8.5YBJJKsLidoJAr1uCfibTzM9MHLZx82', 'parch', '', 'jj', 'Female', '2025-09-04', '21313@gmail.com', '1232141242', '0', 'admin', 3, '2025-09-10', 'Active', '2025-09-07 22:00:07', NULL, 0),
(51, 'adny_A', '$2y$10$7KPScD0EP86YwVfwAxj7tu50e5rO1dDFfSm1SmjYg1dL66SUDS3QC', 'adny', '', 'adsa', 'Female', '2025-09-09', 'j@gmail.com', '1324412414', '0', 'admin', 1, '2025-09-24', 'Inactive', '2025-09-07 22:03:04', NULL, 0),
(52, 'potot_R', '$2y$10$mnp55PKAKO0Yawgeg2FWqeE4ejo9aK2RCto5E2EtfWHSY6IqNKwjK', 'potot', '', 'rix', 'Male', '2025-09-02', 'asd@gmail.com', '1243141414', 'deca', 'admin', 1, '2025-09-24', 'Active', '2025-09-07 22:05:06', NULL, 0),
(53, 'bakol_K', NULL, 'bakol', '', 'kolad', 'Male', '2025-09-16', 'kolado@yahoo.com', '3454353453', NULL, 'patient', 1, NULL, 'Active', '2025-09-16 19:05:45', NULL, 0),
(54, 'Tan_P', '$2y$10$TZkHD748QzNkgjjvZNpUzOHXTunwayEU9J38.Net11EtuWWWd9lY6', 'Tan', '', 'Pilep', 'Male', '2025-09-11', 'josephparchaso@gmail.com', '1231313131', NULL, 'patient', 1, NULL, 'Active', '2025-09-16 19:22:37', '2025-10-04 05:46:53', 0),
(55, 'sample_S', '$2y$10$DUoVBSk0sV7WTwlLBWmCTu443Nb4FEOe0kwHt0dMfzRJgTlVoBf8O', 'sample', '', 'sample', 'Male', '2025-09-11', 'josephparchaso@gmail.com', '1242141414', NULL, 'patient', 2, NULL, 'Inactive', '2025-09-17 19:45:22', NULL, 0),
(56, 'Baloy_P', '$2y$10$otDsje.SDYSmiPOSxDfL4OpsQrpLXttB.YPiU7CEBmpuC99J5GsMe', 'Baloy', '', 'Parkley', 'Female', '2025-09-20', '18100807@usc.edu.ph', '2114142141', NULL, 'patient', 3, NULL, 'Inactive', '2025-09-17 22:48:49', NULL, 0),
(57, 'baloy_B', '$2y$10$48Dxhg4z5kXu7q92qHbMpOqVneCyNkz5Q97epVC0h6yWy.kG8TSG2', 'baloy', '', 'bal', 'Male', '2025-09-24', 'josephparchaso@gmail.com', '1243124214', NULL, 'patient', 1, NULL, 'Inactive', '2025-09-21 22:05:17', NULL, 0),
(58, 'sampol_T', '$2y$10$xQ1hKR5T9gbf3p7QaHxEYeucqrF6WY.bRISoAGpUt2E7cIVzxsPu2', 'sampol', '', 'time', 'Female', '2025-09-24', 'josephparchaso@gmail.com', '1241241421', NULL, 'patient', 1, NULL, 'Inactive', '2025-09-22 19:59:12', NULL, 0),
(59, 'tanggol_C', '$2y$10$N4I./LHIANvKF6TQHpHjmu6Zqw95L6L5ZOC3gdGKd7Q.NgpTWohB2', 'tanggol', '', 'coco', 'Male', '2025-09-17', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', 1, NULL, 'Inactive', '2025-09-22 22:01:09', '2025-10-04 05:52:03', 0),
(60, 'Potot_R', '$2y$10$nA2OkSxEr5YigHd7z1dyme/5S1fKnqylLBfjyZDU6J0bAsINMlDSK', 'Potot', 'Travero', 'Rixielie', 'Female', '2000-05-01', 'theartp1@gmail.com', '9950217794', NULL, 'patient', 1, NULL, 'Active', '2025-09-24 07:32:21', NULL, 0),
(61, 'Achas_G1', '$2y$10$2UgaJgb8A5u2GVZxd6t2L.rzDbiHr/hOCYAa7cMBUYLailvn4DLO2', 'Achas', '', 'Gab', 'Male', '2025-09-11', 'theartp1@gmail.com', '9995565656', 'Talamban, Cebu', 'admin', 6, '2025-09-25', 'Active', '2025-09-24 08:29:54', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_transaction`
--
ALTER TABLE `appointment_transaction`
  ADD PRIMARY KEY (`appointment_transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `dentist_id` (`dentist_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `branch_promo`
--
ALTER TABLE `branch_promo`
  ADD PRIMARY KEY (`branch_promo_id`),
  ADD KEY `promo_id` (`promo_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `branch_service`
--
ALTER TABLE `branch_service`
  ADD PRIMARY KEY (`branch_services_id`),
  ADD KEY `fk_branch` (`branch_id`),
  ADD KEY `fk_service` (`service_id`);

--
-- Indexes for table `branch_supply`
--
ALTER TABLE `branch_supply`
  ADD PRIMARY KEY (`branch_supplies_id`),
  ADD KEY `supply_id` (`supply_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `dental_prescription`
--
ALTER TABLE `dental_prescription`
  ADD PRIMARY KEY (`prescription_id`),
  ADD KEY `appointment_transaction_id` (`appointment_transaction_id`);

--
-- Indexes for table `dental_transaction`
--
ALTER TABLE `dental_transaction`
  ADD PRIMARY KEY (`dental_transaction_id`),
  ADD KEY `appointment_transaction_id` (`appointment_transaction_id`),
  ADD KEY `dentist_id` (`dentist_id`);

--
-- Indexes for table `dental_vital`
--
ALTER TABLE `dental_vital`
  ADD PRIMARY KEY (`vitals_id`),
  ADD KEY `appointment_transaction_id` (`appointment_transaction_id`);

--
-- Indexes for table `dentist`
--
ALTER TABLE `dentist`
  ADD PRIMARY KEY (`dentist_id`);

--
-- Indexes for table `dentist_branch`
--
ALTER TABLE `dentist_branch`
  ADD PRIMARY KEY (`dentist_branch_id`),
  ADD KEY `dentist_id` (`dentist_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `dentist_service`
--
ALTER TABLE `dentist_service`
  ADD PRIMARY KEY (`dentist_services_id`),
  ADD KEY `dentist_id` (`dentist_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`supply_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `index_username_unique` (`username`),
  ADD KEY `fk_users_branch` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_transaction`
--
ALTER TABLE `appointment_transaction`
  MODIFY `appointment_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `branch_promo`
--
ALTER TABLE `branch_promo`
  MODIFY `branch_promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branch_service`
--
ALTER TABLE `branch_service`
  MODIFY `branch_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `branch_supply`
--
ALTER TABLE `branch_supply`
  MODIFY `branch_supplies_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dental_prescription`
--
ALTER TABLE `dental_prescription`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `dental_transaction`
--
ALTER TABLE `dental_transaction`
  MODIFY `dental_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dental_vital`
--
ALTER TABLE `dental_vital`
  MODIFY `vitals_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `dentist`
--
ALTER TABLE `dentist`
  MODIFY `dentist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dentist_branch`
--
ALTER TABLE `dentist_branch`
  MODIFY `dentist_branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `dentist_service`
--
ALTER TABLE `dentist_service`
  MODIFY `dentist_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `supply`
--
ALTER TABLE `supply`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_transaction`
--
ALTER TABLE `appointment_transaction`
  ADD CONSTRAINT `appointment_transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `appointment_transaction_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `appointment_transaction_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`),
  ADD CONSTRAINT `appointment_transaction_ibfk_4` FOREIGN KEY (`dentist_id`) REFERENCES `dentist` (`dentist_id`);

--
-- Constraints for table `branch_promo`
--
ALTER TABLE `branch_promo`
  ADD CONSTRAINT `branch_promo_ibfk_1` FOREIGN KEY (`promo_id`) REFERENCES `promo` (`promo_id`),
  ADD CONSTRAINT `branch_promo_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `branch_service`
--
ALTER TABLE `branch_service`
  ADD CONSTRAINT `fk_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `branch_supply`
--
ALTER TABLE `branch_supply`
  ADD CONSTRAINT `branch_supply_ibfk_1` FOREIGN KEY (`supply_id`) REFERENCES `supply` (`supply_id`),
  ADD CONSTRAINT `branch_supply_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `dental_prescription`
--
ALTER TABLE `dental_prescription`
  ADD CONSTRAINT `dental_prescription_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`);

--
-- Constraints for table `dental_transaction`
--
ALTER TABLE `dental_transaction`
  ADD CONSTRAINT `dental_transaction_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`),
  ADD CONSTRAINT `dental_transaction_ibfk_2` FOREIGN KEY (`dentist_id`) REFERENCES `dentist` (`dentist_id`);

--
-- Constraints for table `dental_vital`
--
ALTER TABLE `dental_vital`
  ADD CONSTRAINT `dental_vital_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`);

--
-- Constraints for table `dentist_branch`
--
ALTER TABLE `dentist_branch`
  ADD CONSTRAINT `dentist_branch_ibfk_1` FOREIGN KEY (`dentist_id`) REFERENCES `dentist` (`dentist_id`),
  ADD CONSTRAINT `dentist_branch_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `dentist_service`
--
ALTER TABLE `dentist_service`
  ADD CONSTRAINT `dentist_service_ibfk_1` FOREIGN KEY (`dentist_id`) REFERENCES `dentist` (`dentist_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dentist_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
