-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2025 at 09:20 PM
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
-- Database: `smile-ify`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` enum('General','Closed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `description`, `type`) VALUES
(1, 'Holiday', 'Christmas', 'Closed'),
(2, 'Get 10% Off on Root Canal Treatments!', 'Enjoy a 10% discount on all Root Canal services this October. Book your appointment now!', 'General'),
(3, 'New Dental Branch Now Open!', 'We’re excited to announce that our new branch in Talamban is now open to serve you!', 'General'),
(4, 'Free Dental Check-up for New Patients!', 'All new patients can avail a free dental check-up this month. Walk-ins are welcome!', 'General'),
(5, 'System Maintenance Notice', 'Our online booking system will be under maintenance this weekend. Sorry for the inconvenience!', 'General'),
(6, 'dummy', '', 'General'),
(7, 'Notify Owner', '', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_services`
--

CREATE TABLE `appointment_services` (
  `appointment_services_id` int(11) NOT NULL,
  `appointment_transaction_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_services`
--

INSERT INTO `appointment_services` (`appointment_services_id`, `appointment_transaction_id`, `service_id`, `date_created`) VALUES
(1, 84, 1, '2025-10-09 00:23:20'),
(2, 85, 1, '2025-10-09 00:31:23'),
(3, 86, 10, '2025-10-09 00:37:26'),
(4, 86, 6, '2025-10-09 00:37:26'),
(5, 87, 8, '2025-10-09 01:26:21'),
(6, 88, 7, '2025-10-09 01:44:24'),
(7, 88, 2, '2025-10-09 01:44:24'),
(8, 89, 1, '2025-10-09 02:12:00'),
(9, 89, 2, '2025-10-09 02:12:00'),
(10, 90, 2, '2025-10-10 04:14:11'),
(11, 91, 1, '2025-10-10 04:20:00'),
(12, 91, 2, '2025-10-10 04:20:00'),
(13, 92, 1, '2025-10-10 05:25:06'),
(14, 93, 1, '2025-10-10 09:02:22'),
(15, 93, 2, '2025-10-10 09:02:22'),
(16, 94, 4, '2025-10-11 06:22:19'),
(17, 94, 2, '2025-10-11 06:22:19'),
(18, 95, 1, '2025-10-11 06:31:38'),
(19, 96, 1, '2025-10-14 01:16:14'),
(20, 97, 1, '2025-10-15 00:22:41'),
(21, 97, 2, '2025-10-15 00:22:41'),
(22, 98, 1, '2025-10-15 03:30:57'),
(23, 98, 4, '2025-10-15 03:30:57'),
(24, 99, 1, '2025-10-15 09:06:42'),
(25, 99, 4, '2025-10-15 09:06:42'),
(26, 100, 1, '2025-10-15 09:27:39'),
(27, 100, 4, '2025-10-15 09:27:39'),
(28, 101, 1, '2025-10-15 09:34:49'),
(29, 102, 1, '2025-10-15 22:50:48'),
(30, 103, 3, '2025-10-16 04:28:31'),
(31, 103, 4, '2025-10-16 04:28:31'),
(32, 104, 1, '2025-10-16 04:41:11'),
(33, 105, 1, '2025-10-17 14:50:03'),
(34, 106, 1, '2025-10-18 04:44:06'),
(35, 107, 8, '2025-10-18 06:27:59'),
(36, 107, 1, '2025-10-18 06:27:59'),
(37, 108, 1, '2025-10-18 06:28:19'),
(38, 109, 1, '2025-10-18 06:28:37'),
(39, 110, 1, '2025-10-18 06:29:12'),
(40, 110, 4, '2025-10-18 06:29:12'),
(41, 111, 1, '2025-10-18 06:29:42'),
(42, 112, 1, '2025-10-18 08:09:42'),
(43, 113, 2, '2025-10-19 02:28:24'),
(44, 114, 2, '2025-10-19 03:30:10'),
(45, 115, 2, '2025-10-19 03:30:30'),
(46, 116, 2, '2025-10-19 03:44:16'),
(47, 117, 2, '2025-10-19 03:45:54'),
(48, 118, 2, '2025-10-19 03:49:56'),
(49, 119, 1, '2025-10-19 03:56:34'),
(50, 120, 7, '2025-10-19 03:59:13'),
(51, 121, 1, '2025-10-19 04:10:32'),
(52, 121, 3, '2025-10-19 04:10:32'),
(53, 122, 2, '2025-10-19 04:14:04'),
(54, 123, 2, '2025-10-19 04:22:43'),
(55, 124, 2, '2025-10-19 04:23:02'),
(56, 125, 1, '2025-10-24 14:01:06'),
(57, 125, 3, '2025-10-24 14:01:06'),
(58, 126, 1, '2025-11-01 02:17:14'),
(59, 127, 1, '2025-11-01 02:47:54'),
(60, 127, 2, '2025-11-01 02:47:54'),
(61, 128, 1, '2025-11-01 07:11:28'),
(62, 128, 4, '2025-11-01 07:11:28'),
(63, 129, 7, '2025-11-02 01:16:30'),
(64, 130, 9, '2025-11-02 02:46:49'),
(65, 131, 8, '2025-11-02 03:59:58'),
(66, 132, 9, '2025-11-02 04:29:12'),
(67, 133, 2, '2025-11-02 04:35:15'),
(68, 134, 2, '2025-11-03 05:52:52'),
(69, 135, 2, '2025-11-03 23:38:08'),
(70, 136, 8, '2025-11-04 01:13:45'),
(71, 136, 3, '2025-11-04 01:13:45'),
(72, 136, 6, '2025-11-04 01:13:45'),
(73, 136, 7, '2025-11-04 01:13:45'),
(74, 137, 1, '2025-11-05 01:31:14'),
(75, 137, 2, '2025-11-05 01:31:14'),
(76, 138, 16, '2025-11-05 01:35:52'),
(77, 139, 1, '2025-11-05 01:36:38'),
(78, 139, 3, '2025-11-05 01:36:38'),
(79, 139, 13, '2025-11-05 01:36:38'),
(80, 139, 2, '2025-11-05 01:36:38'),
(81, 140, 5, '2025-11-05 07:11:22'),
(82, 141, 8, '2025-11-05 07:21:12'),
(83, 141, 1, '2025-11-05 07:21:12'),
(84, 141, 5, '2025-11-05 07:21:12'),
(85, 142, 4, '2025-11-05 07:22:48'),
(86, 142, 7, '2025-11-05 07:22:48'),
(87, 142, 2, '2025-11-05 07:22:48'),
(88, 143, 1, '2025-11-06 04:39:32'),
(89, 144, 1, '2025-11-08 03:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_transaction`
--

CREATE TABLE `appointment_transaction` (
  `appointment_transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `dentist_id` int(11) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `notes` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL,
  `status` enum('Booked','Completed','Cancelled') NOT NULL,
  `reminder_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_transaction`
--

INSERT INTO `appointment_transaction` (`appointment_transaction_id`, `user_id`, `branch_id`, `dentist_id`, `appointment_date`, `appointment_time`, `notes`, `date_created`, `date_updated`, `status`, `reminder_sent`) VALUES
(1, 10, 3, 4, '2025-07-18', '15:00:00', '', '2025-07-11 22:31:48', NULL, 'Completed', 0),
(2, 11, 3, NULL, '2025-07-18', '12:00:00', '', '2025-07-11 22:36:13', NULL, 'Completed', 0),
(3, 12, 1, 3, '2025-07-18', '09:00:00', '', '2025-07-11 23:10:37', NULL, 'Completed', 0),
(4, 13, 1, 3, '2025-08-07', '13:30:00', '', '2025-07-11 23:49:00', NULL, 'Cancelled', 0),
(5, 14, 1, 3, '2025-07-18', '09:00:00', '', '2025-07-11 23:53:50', NULL, 'Completed', 0),
(6, 15, 1, 3, '2025-07-19', '12:45:00', '', '2025-07-11 23:57:34', NULL, 'Cancelled', 0),
(7, 16, 1, 3, '2025-07-25', '12:00:00', '', '2025-07-12 18:37:17', NULL, 'Completed', 0),
(8, 17, 1, 1, '2025-08-01', '14:15:00', '', '2025-07-12 19:04:48', NULL, 'Completed', 0),
(9, 18, 1, 1, '2025-07-22', '09:00:00', '', '2025-07-12 20:04:53', NULL, 'Completed', 0),
(10, 19, 1, 1, '2025-07-17', '12:45:00', '', '2025-07-12 20:31:49', NULL, 'Completed', 0),
(11, 20, 1, 3, '2025-07-23', '13:30:00', '', '2025-07-12 20:36:12', NULL, 'Completed', 0),
(12, 21, 1, 3, '2025-07-23', '13:30:00', '', '2025-07-12 20:37:27', NULL, 'Cancelled', 0),
(13, 22, 2, 2, '2025-07-29', '14:15:00', '', '2025-07-12 20:43:04', NULL, 'Completed', 0),
(14, 23, 2, NULL, '2025-07-24', '13:30:00', '', '2025-07-12 20:45:13', NULL, 'Completed', 0),
(15, 24, 1, NULL, '2025-07-23', '13:30:00', '', '2025-07-12 21:20:25', NULL, 'Completed', 0),
(16, 25, 2, 3, '2025-07-24', '13:30:00', '', '2025-07-14 10:25:16', NULL, 'Completed', 0),
(17, 26, 1, 3, '2025-07-30', '13:30:00', '', '2025-07-14 10:33:22', NULL, 'Completed', 0),
(18, 27, 2, 3, '2025-07-29', '13:30:00', '', '2025-07-14 11:14:19', NULL, 'Completed', 0),
(19, 28, 1, 3, '2025-07-29', '14:15:00', '', '2025-07-14 11:26:32', NULL, 'Completed', 0),
(20, 29, 1, 1, '2025-07-24', '10:30:00', '', '2025-07-14 15:48:41', NULL, 'Completed', 0),
(21, 30, 2, 3, '2025-07-31', '13:30:00', '', '2025-07-14 16:03:59', NULL, 'Completed', 0),
(22, 28, 2, 3, '2025-07-23', '09:45:00', '', '2025-07-21 18:30:17', NULL, 'Completed', 0),
(23, 28, 1, NULL, '2025-07-31', '15:00:00', '', '2025-07-21 18:42:53', NULL, 'Completed', 0),
(24, 28, 3, NULL, '2025-07-30', '15:00:00', '', '2025-07-21 20:03:40', NULL, 'Completed', 0),
(25, 28, 1, 3, '2025-07-30', '10:30:00', '', '2025-07-21 20:10:59', NULL, 'Completed', 0),
(26, 28, 1, 1, '2025-07-24', '12:00:00', '', '2025-07-21 20:30:32', NULL, 'Completed', 0),
(27, 28, 2, 3, '2025-07-31', '10:30:00', '', '2025-07-24 15:58:38', NULL, 'Completed', 0),
(28, 31, 1, 1, '2025-08-02', '12:45:00', '', '2025-07-31 14:32:30', NULL, 'Completed', 0),
(29, 32, 2, 2, '2025-08-16', '11:15:00', '', '2025-07-31 14:38:20', NULL, 'Cancelled', 0),
(30, 33, 2, 2, '2025-08-16', '11:15:00', '', '2025-07-31 14:38:28', NULL, 'Completed', 0),
(31, 34, 2, 2, '2025-08-01', '10:30:00', '', '2025-07-31 14:54:44', NULL, 'Cancelled', 0),
(32, 35, 3, 1, '2025-08-29', '15:00:00', '', '2025-08-05 20:06:22', NULL, 'Completed', 0),
(33, 36, 2, 3, '2025-08-12', '14:15:00', '', '2025-08-09 17:21:09', NULL, 'Cancelled', 0),
(34, 42, 3, 1, '2025-08-18', '15:00:00', '', '2025-08-12 15:18:53', NULL, 'Completed', 0),
(35, 28, 3, 4, '2025-08-27', '15:00:00', '', '2025-08-19 20:55:36', NULL, 'Completed', 0),
(36, 28, 2, 2, '2025-08-29', '15:00:00', 'sample note', '2025-08-23 18:39:11', NULL, 'Completed', 0),
(37, 45, 1, 3, '2025-09-09', '11:15:00', 'hhff', '2025-09-01 10:51:29', NULL, 'Completed', 0),
(38, 46, 2, 2, '2025-09-05', '09:00:00', 'Need t extract', '2025-09-01 10:54:07', NULL, 'Completed', 0),
(39, 47, 2, 3, '2025-09-04', '15:00:00', '', '2025-09-01 15:43:24', NULL, 'Completed', 0),
(40, 28, 2, 3, '2025-09-12', '10:30:00', '', '2025-09-07 19:43:36', NULL, 'Completed', 0),
(41, 28, 1, 1, '2025-09-11', '10:30:00', '', '2025-09-07 19:44:03', NULL, 'Cancelled', 0),
(42, 28, 1, NULL, '2025-09-12', '09:45:00', '', '2025-09-07 19:47:38', NULL, 'Cancelled', 0),
(43, 53, 1, 1, '2025-10-04', '14:15:00', '', '2025-09-16 19:05:45', NULL, 'Cancelled', 0),
(44, 54, 1, NULL, '2025-09-19', '09:00:00', '', '2025-09-16 19:22:37', NULL, 'Completed', 0),
(45, 55, 2, 3, '2025-10-02', '12:00:00', '', '2025-09-17 19:45:22', NULL, 'Cancelled', 0),
(49, 46, 1, 3, '2025-09-19', '11:15:00', '', '2025-09-17 22:30:42', NULL, 'Completed', 0),
(50, 56, 3, NULL, '2025-09-19', '09:45:00', 'mandaue branch', '2025-09-17 22:48:49', NULL, 'Completed', 0),
(51, 56, 3, 3, '2025-09-20', '09:45:00', '', '2025-09-17 23:10:02', NULL, 'Cancelled', 0),
(52, 28, 1, 1, '2025-09-30', '15:00:00', '711', '2025-09-17 23:11:37', NULL, 'Completed', 0),
(54, 28, 1, 3, '2025-09-19', '09:45:00', '', '2025-09-17 23:12:58', NULL, 'Cancelled', 0),
(57, 46, 1, NULL, '2025-09-20', '10:30:00', '', '2025-09-17 23:16:12', NULL, 'Cancelled', 0),
(58, 57, 1, 1, '2025-09-30', '15:00:00', 'same', '2025-09-21 22:05:17', NULL, 'Completed', 0),
(59, 28, 1, 1, '2025-10-18', '09:00:00', '', '2025-09-21 22:06:35', '2025-10-14 01:08:56', 'Cancelled', 0),
(60, 28, 2, NULL, '2025-09-26', '09:45:00', '', '2025-09-21 22:07:12', NULL, 'Completed', 0),
(61, 28, 1, 8, '2025-09-24', '09:00:00', '', '2025-09-22 19:08:19', NULL, 'Cancelled', 0),
(62, 28, 1, 8, '2025-09-24', '09:00:00', '', '2025-09-22 19:15:35', NULL, 'Completed', 0),
(63, 58, 1, 8, '2025-09-24', '09:45:00', '', '2025-09-22 19:59:12', NULL, 'Cancelled', 0),
(64, 28, 1, NULL, '2025-09-24', '15:00:00', '', '2025-09-22 20:43:39', NULL, 'Completed', 0),
(65, 28, 1, NULL, '2025-09-25', '10:30:00', '', '2025-09-22 21:28:30', NULL, 'Completed', 0),
(66, 28, 1, NULL, '2025-09-24', '10:30:00', '', '2025-09-22 21:28:59', NULL, 'Completed', 0),
(67, 59, 1, NULL, '2025-09-24', '11:15:00', '', '2025-09-22 22:01:09', NULL, 'Cancelled', 0),
(68, 59, 1, 1, '2025-09-24', '12:00:00', '', '2025-09-22 22:02:03', NULL, 'Completed', 0),
(69, 59, 1, 8, '2025-09-24', '12:45:00', '', '2025-09-22 22:02:52', NULL, 'Completed', 0),
(70, 28, 1, NULL, '2025-09-24', '14:15:00', '', '2025-09-22 22:03:11', NULL, 'Completed', 0),
(71, 28, 1, 4, '2025-09-24', '13:30:00', '', '2025-09-22 22:03:24', NULL, 'Completed', 0),
(72, 59, 3, 2, '2025-09-25', '09:00:00', '', '2025-09-24 00:03:02', NULL, 'Cancelled', 0),
(73, 60, 1, 1, '2025-09-25', '11:15:00', '', '2025-09-24 07:32:21', NULL, 'Cancelled', 0),
(74, 28, 1, 1, '2025-09-25', '09:45:00', 'Sample note', '2025-09-24 07:37:01', NULL, 'Completed', 0),
(75, 28, 3, 2, '2025-10-31', '09:00:00', '', '2025-10-03 21:22:21', NULL, 'Cancelled', 0),
(76, 28, 3, 2, '2025-10-31', '09:45:00', '', '2025-10-03 21:42:30', NULL, 'Cancelled', 0),
(77, 27, 3, 2, '2025-10-31', '10:30:00', '', '2025-10-03 21:43:55', NULL, 'Cancelled', 0),
(78, 54, 3, 2, '2025-10-31', '11:15:00', '', '2025-10-03 21:44:25', NULL, 'Cancelled', 0),
(79, 54, 3, 2, '2025-10-31', '12:00:00', '', '2025-10-03 21:46:53', NULL, 'Cancelled', 0),
(80, 28, 1, 4, '2025-10-08', '09:00:00', '', '2025-10-06 19:50:46', NULL, 'Cancelled', 0),
(81, 62, 1, 4, '2025-10-07', '15:00:00', '', '2025-10-06 20:35:12', NULL, 'Cancelled', 0),
(82, 63, 3, 2, '2025-10-08', '15:00:00', '', '2025-10-06 20:41:29', NULL, 'Cancelled', 0),
(84, 65, 3, 5, '2025-10-14', '09:00:00', 'consult only', '2025-10-08 16:23:20', NULL, 'Cancelled', 0),
(85, 66, 1, 2, '2025-10-14', '09:00:00', 'consult only', '2025-10-08 16:31:23', '2025-10-14 01:04:39', 'Cancelled', 0),
(86, 67, 2, NULL, '2025-10-14', '12:00:00', 'dental implant, ortho 115000', '2025-10-08 16:37:26', NULL, 'Cancelled', 0),
(87, 68, 2, NULL, '2025-10-15', '09:00:00', 'Estimated End Time: 10:30 AM\r\n', '2025-10-08 17:26:21', NULL, 'Cancelled', 0),
(88, 69, 3, 4, '2025-10-10', '10:00:00', 'teeth whiten tooth extract 105 mins, Estimated End Time: 11:45 AM', '2025-10-08 17:44:24', NULL, 'Cancelled', 0),
(89, 70, 3, 5, '2025-10-10', '12:00:00', 'Estimated End Time: 01:00 PM', '2025-10-08 18:12:00', NULL, 'Cancelled', 0),
(90, 28, 3, 3, '2025-10-10', '09:00:00', '', '2025-10-09 20:14:11', NULL, 'Cancelled', 0),
(91, 28, 3, 4, '2025-10-10', '13:30:00', 'consult, tooth extract', '2025-10-09 20:20:00', NULL, 'Cancelled', 0),
(92, 71, 3, 5, '2025-10-10', '15:00:00', 'Estimated End Time: 03:15 PM', '2025-10-09 21:25:06', NULL, 'Cancelled', 0),
(93, 28, 1, 3, '2025-10-20', '09:00:00', '', '2025-10-10 01:02:22', '2025-10-14 01:10:06', 'Cancelled', 0),
(94, 46, 1, 2, '2025-10-20', '10:30:00', '', '2025-10-10 22:22:19', '2025-10-15 01:06:26', 'Cancelled', 0),
(95, 54, 1, 2, '2025-10-20', '13:30:00', '', '2025-10-10 22:31:38', '2025-10-15 03:26:48', 'Cancelled', 0),
(96, 28, 1, NULL, '2025-10-15', '09:00:00', 'available dentist', '2025-10-13 17:16:14', '2025-10-14 01:22:14', 'Cancelled', 0),
(97, 72, 1, 3, '2025-10-22', '09:00:00', '', '2025-10-14 16:22:41', '2025-10-15 01:15:27', 'Cancelled', 0),
(98, 28, 1, 2, '2025-10-22', '09:00:00', '', '2025-10-14 19:30:57', '2025-10-15 08:51:44', 'Completed', 0),
(99, 28, 1, NULL, '2025-10-23', '09:00:00', '', '2025-10-15 01:06:42', '2025-10-15 09:19:36', 'Completed', 0),
(100, 28, 1, 2, '2025-10-23', '09:00:00', '', '2025-10-15 01:27:39', '2025-10-15 09:32:40', 'Completed', 0),
(101, 28, 1, 3, '2025-10-23', '09:00:00', '', '2025-10-15 01:34:49', '2025-10-15 09:36:00', 'Completed', 0),
(102, 28, 1, 3, '2025-10-23', '09:00:00', '', '2025-10-15 14:50:48', '2025-10-15 22:52:55', 'Completed', 0),
(103, 28, 1, 2, '2025-10-23', '09:00:00', '', '2025-10-15 20:28:31', '2025-10-16 04:29:54', 'Completed', 0),
(104, 28, 1, 3, '2025-10-23', '09:00:00', '', '2025-10-15 20:41:11', '2025-10-16 04:43:04', 'Completed', 0),
(105, 28, 1, NULL, '2025-10-27', '09:00:00', '', '2025-10-17 06:50:03', '2025-10-17 15:14:42', 'Completed', 0),
(106, 28, 1, NULL, '2025-10-18', '09:00:00', '', '2025-10-17 20:44:06', NULL, 'Cancelled', 0),
(107, 46, 3, 5, '2025-10-18', '12:00:00', '', '2025-10-17 22:27:59', NULL, 'Cancelled', 1),
(108, 54, 1, 2, '2025-10-18', '10:00:00', '', '2025-10-17 22:28:19', NULL, 'Cancelled', 1),
(109, 69, 1, 3, '2025-10-18', '11:00:00', '', '2025-10-17 22:28:37', NULL, 'Cancelled', 1),
(110, 28, 1, 2, '2025-10-18', '12:00:00', '', '2025-10-17 22:29:12', NULL, 'Cancelled', 1),
(111, 46, 1, 3, '2025-10-18', '15:00:00', '', '2025-10-17 22:29:42', NULL, 'Cancelled', 1),
(112, 28, 1, 1, '2025-10-18', '09:30:00', '', '2025-10-18 00:08:35', NULL, 'Cancelled', 1),
(113, 54, 2, 1, '2025-10-27', '09:00:00', '', '2025-10-18 18:28:24', '2025-10-19 03:14:31', 'Completed', 0),
(114, 28, 1, 3, '2025-10-27', '09:00:00', '', '2025-10-18 19:30:10', '2025-10-19 03:41:45', 'Completed', 0),
(115, 28, 2, 3, '2025-10-27', '09:00:00', '', '2025-10-18 19:30:30', '2025-10-19 03:35:14', 'Completed', 0),
(116, 28, 1, 3, '2025-10-22', '13:00:00', '', '2025-10-18 19:44:16', '2025-10-19 03:44:31', 'Completed', 0),
(117, 28, 1, 2, '2025-10-29', '13:30:00', '', '2025-10-18 19:45:54', '2025-10-19 03:48:34', 'Completed', 0),
(118, 28, 1, 3, '2025-10-25', '13:30:00', '', '2025-10-18 19:49:56', '2025-10-19 03:50:20', 'Completed', 0),
(119, 28, 1, NULL, '2025-10-22', '12:00:00', '', '2025-10-18 19:56:34', '2025-10-19 03:56:58', 'Completed', 0),
(120, 28, 2, 1, '2025-10-29', '11:30:00', '', '2025-10-18 19:59:13', '2025-10-19 04:08:25', 'Completed', 0),
(121, 28, 1, 2, '2025-10-25', '09:00:00', '', '2025-10-18 20:10:32', '2025-10-19 04:12:06', 'Completed', 0),
(122, 28, 2, 3, '2025-10-28', '10:00:00', '', '2025-10-18 20:14:04', '2025-10-19 04:14:31', 'Completed', 0),
(123, 28, 2, 1, '2025-10-24', '11:00:00', '', '2025-10-18 20:22:43', '2025-10-19 04:25:13', 'Completed', 0),
(124, 28, 1, 3, '2025-10-29', '11:30:00', '', '2025-10-18 20:23:02', '2025-10-19 04:25:45', 'Completed', 0),
(125, 73, 3, 4, '2025-10-30', '13:00:00', 'Hello', '2025-10-24 06:01:06', NULL, 'Booked', 0),
(126, 28, 1, NULL, '2025-11-10', '09:00:00', 'sakit ngipon', '2025-10-31 18:17:14', '2025-11-01 02:24:32', 'Completed', 0),
(127, 28, 1, 2, '2025-11-10', '09:00:00', '', '2025-10-31 18:47:54', '2025-11-01 02:49:18', 'Completed', 0),
(128, 28, 1, 2, '2025-11-17', '09:00:00', '', '2025-10-31 23:11:28', '2025-11-01 07:11:54', 'Completed', 0),
(129, 28, 2, 1, '2025-11-10', '09:00:00', '', '2025-11-01 17:16:30', '2025-11-02 01:29:47', 'Completed', 0),
(130, 28, 2, NULL, '2025-11-03', '12:30:00', '', '2025-11-01 18:46:49', '2025-11-02 03:43:25', 'Completed', 0),
(131, 28, 2, 1, '2025-11-24', '09:30:00', '', '2025-11-01 19:59:58', '2025-11-02 05:32:43', 'Completed', 0),
(132, 73, 2, 1, '2025-11-17', '09:30:00', '', '2025-11-01 20:29:12', '2025-11-02 05:57:50', 'Completed', 0),
(133, 54, 2, NULL, '2025-11-17', '11:30:00', '', '2025-11-01 20:35:15', '2025-11-02 06:01:40', 'Completed', 0),
(134, 28, 1, NULL, '2025-11-10', '09:00:00', '', '2025-11-02 21:52:52', '2025-11-03 06:03:25', 'Completed', 0),
(135, 73, 1, NULL, '2025-11-10', '09:00:00', '', '2025-11-03 15:38:08', '2025-11-04 00:21:52', 'Completed', 0),
(136, 73, 1, NULL, '2025-11-04', '09:00:00', '', '2025-11-03 17:13:45', '2025-11-04 01:16:01', 'Completed', 0),
(137, 74, 3, 4, '2025-11-05', '09:00:00', '', '2025-11-04 17:31:14', '2025-11-05 06:07:57', 'Completed', 1),
(138, 28, 3, NULL, '2025-11-05', '10:30:00', '', '2025-11-04 17:35:52', '2025-11-05 07:06:39', 'Completed', 0),
(139, 28, 1, 2, '2025-11-05', '09:00:00', '', '2025-11-04 17:36:38', '2025-11-05 05:49:40', 'Completed', 1),
(140, 28, 1, 2, '2025-11-06', '09:30:00', '', '2025-11-04 23:11:22', '2025-11-05 07:12:08', 'Completed', 0),
(141, 75, 3, 4, '2025-11-06', '14:30:00', '', '2025-11-04 23:21:12', NULL, 'Booked', 1),
(142, 75, 3, 4, '2025-11-06', '14:00:00', '', '2025-11-04 23:22:48', NULL, 'Booked', 1),
(143, 76, 2, 1, '2025-11-06', '09:00:00', '', '2025-11-05 20:39:32', NULL, 'Booked', 0),
(144, 77, 1, 2, '2025-11-10', '09:00:00', '', '2025-11-07 19:03:18', NULL, 'Booked', 0);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `map_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `name`, `address`, `phone_number`, `status`, `date_created`, `date_updated`, `map_url`) VALUES
(1, 'Babag', 'Babag 2, Lapu Lapu City, Cebu', '9876543211', 'Active', '2025-09-23 06:16:53', '2025-10-09 00:29:11', 'https://www.google.com/maps?s=web&rlz=1C1CHBF_enPH1076PH1076&vet=12ahUKEwjuncvMhquCAxXyZWwGHf0oB6AQ5OUKegQIDhAO..i&cs=0&um=1&ie=UTF-8&fb=1&gl=ph&sa=X&geocode=KeXXQbw9mKkzMZ8SM-2MbRRa&daddr=8XW6%2BG37,+42+Zone+Ube,+Mandaue+City,+6014+Cebu'),
(2, 'Pusok', 'Pusok, Lapu Lapu City, Cebu', NULL, 'Active', '2025-09-23 06:16:53', '2025-10-09 00:29:11', 'https://www.google.com/maps/dir//Mondejar+Bldg.,+8X97%2B4VH,+M.L.+Quezon+National+Highway,+Lapu-Lapu+City,+6015+Cebu/@10.3178978,123.9235228,13z/data=!3m1!4b1!4m9!4m8!1m1!4e2!1m5!1m1!1s0x33a999daa69f9d7d:0xe953442899b16cf7!2m2!1d123.9647064!2d10.3178364?e'),
(3, 'Mandaue', 'Mandaue City, Cebu', '9123456789', 'Active', '2025-09-23 06:16:53', '2025-10-09 00:29:11', 'https://www.google.com/maps/dir//7WHV%2BRP3,+Babang+II+Rd,+Lapu-Lapu+City,+6015+Cebu/@10.2795046,123.8619066,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x33a99a3a552c12d3:0x4f3b0cb463cfb86d!2m2!1d123.9443073!2d10.2795147?entry=ttu'),
(6, 'Talamban', 'Talamban, Cebu', '4564656664', 'Active', '2025-09-24 16:25:59', '2025-10-08 09:57:04', 'https://www.google.com/maps/dir//8XW6%2BG37,+42+Zone+Ube,+Mandaue+City,+6014+Cebu/@10.3557436,123.8524778,22362m/data=!3m1!1e3!4m8!4m7!1m0!1m5!1m1!1s0x33a9983dbc41d7e5:0x5a146d8ced33129f!2m2!1d123.9601141!2d10.3462534?entry=ttu&g_ep=EgoyMDI1MDkyMi4wIKXMDS'),
(7, 'Bankal', 'Bankal, Lapu Lapu City, Cebu', '9055626239', 'Active', '2025-10-19 01:50:46', '2025-10-24 16:25:02', 'https://www.google.com/maps/place/Bankal+Barangay+Hall/@10.3078254,123.9873401,1069m/data=!3m2!1e3!4b1!4m6!3m5!1s0x33a99769a6db8655:0x48200cb7cbf4bf82!8m2!3d10.3078254!4d123.989915!16s%2Fg%2F11bwl3ssy7?entry=ttu&g_ep=EgoyMDI1MTAxNC4wIKXMDSoASAFQAw%3D%3D');

-- --------------------------------------------------------

--
-- Table structure for table `branch_announcements`
--

CREATE TABLE `branch_announcements` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_announcements`
--

INSERT INTO `branch_announcements` (`id`, `announcement_id`, `branch_id`, `status`, `start_date`, `end_date`, `date_created`, `date_updated`) VALUES
(1, 1, 1, 'Active', '2025-12-24', '2026-01-02', '2025-10-17 16:33:55', '2025-11-04 01:55:03'),
(2, 6, 1, 'Inactive', NULL, NULL, '2025-10-17 16:42:41', '2025-11-04 21:56:13'),
(3, 7, 1, 'Active', NULL, NULL, '2025-11-04 21:52:25', '2025-11-05 00:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `branch_promo`
--

CREATE TABLE `branch_promo` (
  `branch_promo_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `promo_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_promo`
--

INSERT INTO `branch_promo` (`branch_promo_id`, `branch_id`, `promo_id`, `status`, `start_date`, `end_date`) VALUES
(4, 1, 4, 'Active', '2025-11-05', '2025-11-12'),
(6, 2, 6, 'Active', NULL, NULL),
(7, 1, 7, 'Inactive', NULL, NULL),
(8, 1, 8, 'Inactive', NULL, NULL),
(9, 1, 9, 'Inactive', NULL, NULL),
(10, 1, 5, 'Active', NULL, NULL),
(11, 2, 5, '', NULL, NULL),
(12, 3, 5, '', NULL, NULL),
(13, 6, 5, '', NULL, NULL),
(14, 7, 5, '', NULL, NULL),
(28, 1, 10, '', NULL, NULL),
(29, 2, 10, '', NULL, NULL),
(36, 1, 2, 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch_service`
--

CREATE TABLE `branch_service` (
  `branch_services_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_service`
--

INSERT INTO `branch_service` (`branch_services_id`, `branch_id`, `service_id`, `status`, `date_created`, `date_updated`) VALUES
(24, 1, 13, 'Active', '2025-11-01 02:20:48', '2025-11-01 02:20:48'),
(26, 2, 13, 'Active', '2025-11-02 04:48:39', '2025-11-02 05:03:58'),
(27, 3, 13, 'Active', '2025-11-02 05:12:23', '2025-11-02 05:12:23'),
(28, 6, 13, 'Active', '2025-11-02 05:12:23', '2025-11-02 05:12:23'),
(29, 7, 13, 'Active', '2025-11-02 05:12:23', '2025-11-02 05:12:23'),
(64, 1, 2, 'Active', '2025-11-03 03:37:27', '2025-11-03 03:37:27'),
(65, 2, 2, 'Active', '2025-11-03 03:37:27', '2025-11-03 03:37:27'),
(66, 3, 2, 'Active', '2025-11-03 03:37:27', '2025-11-03 03:37:27'),
(67, 6, 2, 'Active', '2025-11-03 03:37:27', '2025-11-03 03:37:27'),
(68, 7, 2, 'Active', '2025-11-03 03:37:27', '2025-11-03 03:37:27'),
(69, 1, 3, 'Active', '2025-11-03 03:37:31', '2025-11-03 03:37:31'),
(70, 2, 3, 'Active', '2025-11-03 03:37:31', '2025-11-03 03:37:31'),
(71, 3, 3, 'Active', '2025-11-03 03:37:31', '2025-11-03 03:37:31'),
(72, 6, 3, 'Active', '2025-11-03 03:37:31', '2025-11-03 03:37:31'),
(73, 7, 3, 'Active', '2025-11-03 03:37:31', '2025-11-03 03:37:31'),
(74, 1, 4, 'Active', '2025-11-03 03:37:39', '2025-11-03 03:37:39'),
(75, 2, 4, 'Active', '2025-11-03 03:37:39', '2025-11-03 03:37:39'),
(76, 3, 4, 'Active', '2025-11-03 03:37:39', '2025-11-03 03:37:39'),
(77, 6, 4, 'Active', '2025-11-03 03:37:39', '2025-11-03 03:37:39'),
(78, 7, 4, 'Active', '2025-11-03 03:37:39', '2025-11-03 03:37:39'),
(79, 1, 5, 'Active', '2025-11-03 03:37:47', '2025-11-03 03:37:47'),
(80, 2, 5, 'Active', '2025-11-03 03:37:47', '2025-11-03 03:37:47'),
(81, 3, 5, 'Active', '2025-11-03 03:37:47', '2025-11-03 03:37:47'),
(82, 6, 5, 'Active', '2025-11-03 03:37:47', '2025-11-03 03:37:47'),
(83, 7, 5, 'Active', '2025-11-03 03:37:47', '2025-11-03 03:37:47'),
(84, 1, 6, 'Active', '2025-11-03 03:37:55', '2025-11-03 03:37:55'),
(85, 2, 6, 'Active', '2025-11-03 03:37:55', '2025-11-03 03:37:55'),
(86, 3, 6, 'Active', '2025-11-03 03:37:55', '2025-11-03 03:37:55'),
(87, 6, 6, 'Active', '2025-11-03 03:37:55', '2025-11-03 03:37:55'),
(88, 7, 6, 'Active', '2025-11-03 03:37:55', '2025-11-03 03:37:55'),
(89, 1, 7, 'Active', '2025-11-03 03:38:00', '2025-11-03 03:38:00'),
(90, 2, 7, 'Active', '2025-11-03 03:38:00', '2025-11-03 03:38:00'),
(91, 3, 7, 'Active', '2025-11-03 03:38:00', '2025-11-03 03:38:00'),
(92, 6, 7, 'Active', '2025-11-03 03:38:00', '2025-11-03 03:38:00'),
(93, 7, 7, 'Active', '2025-11-03 03:38:00', '2025-11-03 03:38:00'),
(94, 1, 8, 'Active', '2025-11-03 03:38:06', '2025-11-03 03:38:06'),
(95, 2, 8, 'Active', '2025-11-03 03:38:06', '2025-11-03 03:38:06'),
(96, 3, 8, 'Active', '2025-11-03 03:38:06', '2025-11-03 03:38:06'),
(97, 6, 8, 'Active', '2025-11-03 03:38:06', '2025-11-03 03:38:06'),
(98, 7, 8, 'Active', '2025-11-03 03:38:06', '2025-11-03 03:38:06'),
(99, 1, 9, 'Active', '2025-11-03 03:38:14', '2025-11-03 03:38:14'),
(100, 2, 9, 'Active', '2025-11-03 03:38:14', '2025-11-03 03:38:14'),
(101, 3, 9, 'Active', '2025-11-03 03:38:14', '2025-11-03 03:38:14'),
(102, 6, 9, 'Active', '2025-11-03 03:38:14', '2025-11-03 03:38:14'),
(103, 7, 9, 'Active', '2025-11-03 03:38:14', '2025-11-03 03:38:14'),
(104, 1, 10, 'Active', '2025-11-03 03:38:19', '2025-11-03 03:38:19'),
(105, 2, 10, 'Active', '2025-11-03 03:38:19', '2025-11-03 03:38:19'),
(106, 3, 10, 'Active', '2025-11-03 03:38:19', '2025-11-03 03:38:19'),
(107, 6, 10, 'Active', '2025-11-03 03:38:19', '2025-11-03 03:38:19'),
(108, 7, 10, 'Active', '2025-11-03 03:38:19', '2025-11-03 03:38:19'),
(132, 1, 1, 'Active', '2025-11-03 06:29:26', '2025-11-03 06:29:26'),
(133, 2, 1, 'Active', '2025-11-03 06:29:26', '2025-11-03 06:29:26'),
(134, 3, 1, 'Active', '2025-11-03 06:29:26', '2025-11-03 06:29:26'),
(135, 6, 1, 'Active', '2025-11-03 06:29:26', '2025-11-03 06:29:26'),
(136, 1, 16, 'Active', '2025-11-05 00:31:24', '2025-11-05 00:31:24'),
(137, 2, 16, 'Active', '2025-11-05 00:31:24', '2025-11-05 00:31:24'),
(138, 3, 16, 'Active', '2025-11-05 00:31:24', '2025-11-05 00:31:24'),
(139, 6, 16, 'Active', '2025-11-05 00:31:24', '2025-11-05 00:31:24'),
(140, 7, 16, 'Active', '2025-11-05 00:31:24', '2025-11-05 00:31:24');

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
(1, 1, 1, 13, 12, '2025-10-31', 'Available', '2025-09-21 05:51:59', '2025-11-05 05:49:40'),
(2, 3, 2, 5, 10, NULL, 'Available', '2025-09-21 06:05:54', '2025-09-21 06:05:54'),
(3, 1, 3, 455, 10, NULL, 'Available', '2025-10-13 04:59:52', '2025-10-17 15:14:42'),
(8, 1, 6, 20, 10, NULL, 'Available', '2025-10-19 03:55:10', '2025-11-05 05:49:40'),
(9, 2, 7, 996, 200, NULL, 'Available', '2025-10-19 04:04:47', '2025-11-02 06:01:40'),
(10, 2, 5, 90, 5, NULL, 'Available', '2025-11-02 01:29:31', '2025-11-02 01:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `dental_prescription`
--

CREATE TABLE `dental_prescription` (
  `prescription_id` int(11) NOT NULL,
  `appointment_transaction_id` int(11) NOT NULL,
  `admin_user_id` int(11) DEFAULT NULL,
  `drug` varchar(255) NOT NULL,
  `route` varchar(50) DEFAULT NULL,
  `frequency` varchar(50) DEFAULT NULL,
  `dosage` varchar(50) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `quantity` varchar(50) NOT NULL,
  `instructions` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_prescription`
--

INSERT INTO `dental_prescription` (`prescription_id`, `appointment_transaction_id`, `admin_user_id`, `drug`, `route`, `frequency`, `dosage`, `duration`, `quantity`, `instructions`, `date_created`, `date_updated`) VALUES
(1, 21, NULL, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '21', 'Take after meals', '2025-08-23 18:54:01', NULL),
(2, 21, NULL, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '3 days', '3', 'For pain, take only when needed', '2025-08-23 18:54:01', NULL),
(3, 22, NULL, 'Ibuprofen', 'Oral', '2x/day', '400mg', '5 days', '22', 'Take after meals', '2025-08-23 18:54:01', NULL),
(4, 23, NULL, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', '23', 'Do not swallow', '2025-08-23 18:54:01', NULL),
(5, 24, NULL, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '24', 'Take after meals', '2025-08-23 18:54:01', NULL),
(6, 24, NULL, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', '24', 'For pain and fever', '2025-08-23 18:54:01', NULL),
(7, 25, NULL, 'Clindamycin', 'Oral', '3x/day', '300mg', '7 days', '25', 'Use if allergic to penicillin', '2025-08-23 18:54:01', NULL),
(8, 27, NULL, 'Sodium Fluoride Gel', 'Topical', '1x/day', 'Thin layer', '14 days', '27', 'Apply at night before bed', '2025-08-23 18:54:01', NULL),
(9, 28, NULL, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '28', 'Take after meals', '2025-08-23 18:54:01', NULL),
(10, 28, NULL, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '5 days', '28', 'Take only when needed', '2025-08-23 18:54:01', NULL),
(11, 28, NULL, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', '28', 'Alternate with Mefenamic Acid if severe pain', '2025-08-23 18:54:01', NULL),
(12, 24, NULL, 'Ibuprofen', 'Oral', '3x/day', '400mg', '5 days', '24', 'Take after meals for pain and inflammation', '2025-09-07 19:57:34', NULL),
(13, 24, NULL, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '5 days', '24', 'Take only when needed for severe pain', '2025-09-07 19:57:34', NULL),
(14, 24, NULL, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', '24', 'Rinse for 30 seconds, do not swallow', '2025-09-07 19:57:34', NULL),
(15, 24, NULL, 'Prednisone', 'Oral', '1x/day', '10mg', '3 days', '24', 'Take in the morning to reduce swelling', '2025-09-07 19:57:34', NULL),
(16, 24, NULL, 'Metronidazole', 'Oral', '3x/day', '500mg', '7 days', '24', 'Take after meals, avoid alcohol', '2025-09-07 19:57:34', NULL),
(17, 61, NULL, '1', '1', '1', '1', '1', '', '1', '2025-09-24 01:11:28', NULL),
(18, 61, NULL, '2', '2', '2', '2', '2', '', '2', '2025-09-24 01:12:26', NULL),
(19, 52, NULL, '5', NULL, '5', '5', '5', '', '5', '2025-09-26 15:51:54', NULL),
(20, 52, NULL, '6', NULL, '6', '6', '6', '', '6', '2025-09-26 16:11:04', NULL),
(21, 52, NULL, '7', NULL, '7', '7', '7', '', '7', '2025-09-26 16:16:02', NULL),
(22, 52, NULL, '8', NULL, '8', '8', '8', '', '8', '2025-09-26 16:16:26', NULL),
(23, 52, NULL, '9', NULL, '9', '9', '9', '9', '9', '2025-09-26 22:59:30', NULL),
(24, 52, NULL, '10', NULL, '10', '10', '10', '10', '10', '2025-09-26 22:59:39', NULL),
(25, 24, NULL, 'Ibuprofen', 'Oral', '3x/day', '400mg', '5 days', '15', 'Take after meals for pain relief', '2025-09-26 23:46:41', NULL),
(26, 24, NULL, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', '21', 'Take after meals, complete the course', '2025-09-26 23:46:41', NULL),
(27, 24, NULL, 'Mefenamic Acid', 'Oral', '2x/day', '500mg', '3 days', '6', 'Take only when needed for pain', '2025-09-26 23:46:41', NULL),
(28, 24, NULL, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', '14', 'Rinse for 30 seconds, do not swallow', '2025-09-26 23:46:41', NULL),
(29, 24, NULL, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', '15', 'Take for pain and fever', '2025-09-26 23:46:41', NULL),
(30, 80, NULL, 'Paracetamol', NULL, '3x/day', '500mgg', '7 dayss', '21', 'Take after mealssss', '2025-10-07 21:32:57', NULL),
(31, 93, NULL, 'asd', NULL, 'asd', 'asd', 'asd', 'asd', 'asd', '2025-10-12 22:55:22', NULL),
(32, 97, NULL, 'Biogesic', NULL, 'twice a day', '500 mg', '7 days', '14', '', '2025-10-14 16:43:37', NULL),
(33, 98, 2, 'Biogesic', NULL, 'after meal', '50', '7 days', '21', 'after meall', '2025-10-14 19:43:27', '2025-10-15 03:48:15'),
(34, 126, 2, 'Biogesic', NULL, '2x a day', '60', '7 days', '14', 'before breakfast, dinner', '2025-10-31 18:18:55', '2025-11-01 02:18:55'),
(35, 126, 2, 'Centrum', NULL, 'once a day', '120', '3 days', '3', 'after lunch', '2025-10-31 18:19:29', '2025-11-01 02:19:29'),
(36, 129, 39, 'advil', NULL, 'once a day', '60', '1 week', '7', '', '2025-11-01 17:19:01', '2025-11-02 01:19:01');

-- --------------------------------------------------------

--
-- Table structure for table `dental_tips`
--

CREATE TABLE `dental_tips` (
  `tip_id` int(11) NOT NULL,
  `tip_text` varchar(255) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_tips`
--

INSERT INTO `dental_tips` (`tip_id`, `tip_text`, `date_created`) VALUES
(1, '🦷 Brush twice a day — morning and night!', '2025-10-08 00:03:23'),
(2, '😁 Floss daily to keep the spaces clean.', '2025-10-08 00:03:23'),
(3, '🪥 Change your toothbrush every 3 months.', '2025-10-08 00:03:23'),
(4, '🚫 Avoid too much sugar — your teeth will thank you!', '2025-10-08 00:03:23'),
(5, '💧 Drink more water, it helps wash away bacteria.', '2025-10-08 00:03:23'),
(6, '🦷 Visit your dentist every 6 months for a check-up.', '2025-10-08 00:03:23'),
(7, '🍎 Crunch on apples or carrots — nature’s toothbrush!', '2025-10-08 00:03:23'),
(8, '😬 Don’t ignore bleeding gums — it’s a sign to visit us!', '2025-10-08 00:03:23'),
(9, '💤 Brush before bedtime — no sleeping with sugar bugs!', '2025-10-08 00:03:23'),
(10, '💎 A healthy smile is your best accessory!', '2025-10-08 00:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `dental_transaction`
--

CREATE TABLE `dental_transaction` (
  `dental_transaction_id` int(11) NOT NULL,
  `appointment_transaction_id` int(11) NOT NULL,
  `dentist_id` int(11) NOT NULL,
  `admin_user_id` int(11) DEFAULT NULL,
  `promo_id` int(11) DEFAULT NULL,
  `promo_name` varchar(255) DEFAULT NULL,
  `promo_type` enum('percentage','fixed') DEFAULT NULL,
  `promo_value` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('Cash','Cashless') NOT NULL,
  `cashless_receipt` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `medcert_status` enum('None','Requested','Eligible','Issued','Expired') NOT NULL,
  `medcert_receipt` varchar(255) DEFAULT NULL,
  `fitness_status` varchar(255) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `medcert_requested_date` datetime DEFAULT NULL,
  `medcert_request_payment` decimal(10,2) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL,
  `prescription_downloaded` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_transaction`
--

INSERT INTO `dental_transaction` (`dental_transaction_id`, `appointment_transaction_id`, `dentist_id`, `admin_user_id`, `promo_id`, `promo_name`, `promo_type`, `promo_value`, `payment_method`, `cashless_receipt`, `total`, `notes`, `medcert_status`, `medcert_receipt`, `fitness_status`, `diagnosis`, `remarks`, `medcert_requested_date`, `medcert_request_payment`, `date_created`, `date_updated`, `prescription_downloaded`) VALUES
(1, 21, 3, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 1500.00, 'Tooth #12 extraction, mild swelling.', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-08-23 19:37:15', '2025-11-08 04:17:50', 0),
(2, 22, 3, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 2000.00, 'Tooth filling, slight sensitivity.', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-08-23 19:37:15', '2025-11-08 04:17:50', 1),
(3, 23, 1, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 1200.00, 'Routine cleaning, no complications.', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-08-23 19:37:15', '2025-11-08 04:17:50', 1),
(4, 24, 4, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 1800.00, 'Wisdom tooth removal, moderate bleeding.', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-08-23 19:37:15', '2025-11-08 04:17:50', 1),
(5, 25, 3, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 2500.00, 'Root canal treatment, stable condition.', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-08-23 19:37:15', '2025-11-08 04:17:50', 1),
(8, 28, 1, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 3000.00, 'Complex surgical extraction with swelling & bleeding.', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-08-23 19:37:15', '2025-11-08 04:17:50', 0),
(20, 95, 2, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 22:25:33', '2025-11-08 04:17:50', 0),
(21, 95, 2, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 1800.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 22:25:47', '2025-11-08 04:17:50', 0),
(22, 93, 3, NULL, 3, NULL, NULL, NULL, 'Cash', NULL, 300.00, 'from ₱1500.00 into  ₱300.00 90% off', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 22:28:02', '2025-11-08 04:17:50', 0),
(23, 93, 3, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 300.00, 'removed tooth extract', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 22:29:47', '2025-11-08 04:17:50', 0),
(24, 93, 3, NULL, NULL, NULL, NULL, NULL, 'Cash', NULL, 6300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 22:30:18', '2025-11-08 04:17:50', 0),
(25, 93, 2, 2, 2, NULL, NULL, NULL, 'Cash', NULL, 9955.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 22:37:31', '2025-11-08 04:17:50', 0),
(26, 93, 2, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 10000.00, 'tanan', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 22:56:41', '2025-11-08 04:17:50', 0),
(27, 93, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 7500.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 23:24:24', '2025-11-08 04:17:50', 1),
(28, 94, 2, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 8200.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-12 23:40:58', '2025-11-08 04:17:50', 0),
(29, 85, 2, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-13 15:50:04', '2025-11-08 04:17:50', 0),
(30, 59, 2, 2, 2, NULL, NULL, NULL, 'Cash', NULL, 1455.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-13 16:09:46', '2025-11-08 04:17:50', 0),
(31, 97, 2, 2, 3, NULL, NULL, NULL, 'Cash', NULL, 780.00, 'bag ang', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-14 16:58:03', '2025-11-08 04:17:50', 0),
(32, 98, 2, 2, 5, NULL, NULL, NULL, 'Cash', NULL, 225.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-14 19:32:19', '2025-11-08 04:17:50', 1),
(33, 99, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 7300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-15 01:07:35', '2025-11-08 04:17:50', 0),
(34, 100, 2, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-15 01:29:17', '2025-11-08 04:17:50', 1),
(35, 101, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-15 01:34:55', '2025-11-08 04:17:50', 1),
(36, 102, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-15 14:51:07', '2025-11-08 04:17:50', 1),
(37, 103, 2, 2, 2, NULL, NULL, NULL, 'Cash', NULL, 8455.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-15 20:29:36', '2025-11-08 04:17:50', 0),
(38, 104, 2, 2, 3, NULL, NULL, NULL, 'Cash', NULL, 1940.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-15 20:42:01', '2025-11-08 04:17:50', 1),
(39, 105, 3, 2, 2, NULL, NULL, NULL, 'Cashless', NULL, 1455.00, 'Gcash 091234556687', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-17 07:02:46', '2025-11-08 04:17:50', 0),
(40, 113, 1, 39, NULL, NULL, NULL, NULL, 'Cash', NULL, 2400.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 18:29:01', '2025-11-08 04:17:50', 0),
(41, 115, 3, 39, NULL, NULL, NULL, NULL, 'Cash', NULL, 1200.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 19:31:10', '2025-11-08 04:17:50', 0),
(42, 114, 3, 2, NULL, NULL, NULL, NULL, 'Cashless', NULL, 1200.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 19:41:35', '2025-11-08 04:17:50', 0),
(43, 116, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 1200.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 19:44:22', '2025-11-08 04:17:50', 0),
(44, 117, 2, 2, NULL, NULL, NULL, NULL, 'Cashless', NULL, 1200.00, '', 'Expired', '/images/payments/medcert_payments/44_parchaso.png', '44', '44', '44', '2025-11-01 04:10:44', 150.00, '2025-10-18 19:46:03', '2025-11-08 04:17:50', 0),
(45, 118, 3, 2, NULL, NULL, NULL, NULL, 'Cashless', NULL, 1200.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 19:50:02', '2025-11-08 04:17:50', 0),
(46, 119, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 300.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 19:56:50', '2025-11-08 04:17:50', 0),
(47, 120, 1, 39, NULL, NULL, NULL, NULL, 'Cashless', NULL, 1200.00, '', 'Expired', '/images/payments/medcert_payments/47_parchaso.png', NULL, NULL, NULL, '2025-11-01 04:04:40', 0.00, '2025-10-18 20:01:24', '2025-11-08 04:17:50', 0),
(48, 121, 2, 2, NULL, NULL, NULL, NULL, 'Cashless', NULL, 1800.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 20:11:15', '2025-11-08 04:17:50', 0),
(49, 122, 3, 39, NULL, NULL, NULL, NULL, 'Cashless', NULL, 1200.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 20:14:18', '2025-11-08 04:17:50', 0),
(50, 123, 1, 39, NULL, NULL, NULL, NULL, 'Cash', NULL, 1200.00, '', 'Expired', NULL, NULL, NULL, NULL, NULL, 0.00, '2025-10-18 20:23:21', '2025-11-08 04:17:50', 0),
(51, 124, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 1200.00, '', 'Expired', '/images/payments/medcert_payments/51_parchaso.png', NULL, NULL, NULL, '2025-11-01 04:02:56', 0.00, '2025-10-18 20:23:41', '2025-11-08 04:17:50', 0),
(52, 126, 3, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 1850.00, '', 'Expired', NULL, '1-2 Days', 'Sick', 'none', NULL, 0.00, '2025-10-31 18:24:12', '2025-11-08 04:17:50', 1),
(53, 127, 2, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 1700.00, '', 'Expired', '/images/payments/medcert_payments/53_parchaso.jpg', '7 days', 'balig nawng', 'remarks', NULL, 150.00, '2025-10-31 18:49:10', '2025-11-08 04:17:50', 0),
(54, 128, 2, 2, NULL, NULL, NULL, NULL, 'Cash', NULL, 7300.00, '', 'Expired', '/images/payments/medcert_payments/54_parchaso.jpg', '10 days', 'Headache', 'none', '2025-11-01 23:06:31', 150.00, '2025-10-31 23:11:52', '2025-11-08 04:17:50', 0),
(55, 129, 1, 39, NULL, NULL, NULL, NULL, 'Cash', NULL, 6000.00, '', 'Issued', '/images/payments/medcert_payments/55_parchaso.jpg', 'none', 'none', '0', '2025-11-02 02:44:59', 150.00, '2025-11-01 17:19:53', '2025-11-02 02:45:12', 1),
(56, 130, 3, 39, 6, NULL, NULL, NULL, 'Cash', NULL, 7500.00, '', 'Issued', '/images/payments/medcert_payments/56_parchaso.jpg', 'nonr', 'nonr', '0', '2025-11-02 03:44:49', 150.00, '2025-11-01 19:43:17', '2025-11-02 03:45:01', 0),
(57, 131, 1, 39, NULL, NULL, NULL, NULL, 'Cashless', '/images/payments/cashless_payments/57_parchaso.jpg', 15150.00, 'with cert and receipt cashless', 'Issued', NULL, 'with cert and receipt cashless', 'with cert and receipt cashless', 'with cert and receipt cashless', NULL, NULL, '2025-11-01 20:20:37', '2025-11-02 05:37:55', 0),
(58, 132, 1, 39, NULL, NULL, NULL, NULL, 'Cashless', '/images/payments/cashless_payments/58_potot.png', 8000.00, '', 'None', NULL, '', '', '', NULL, NULL, '2025-11-01 20:30:05', '2025-11-02 05:57:50', 0),
(59, 133, 3, 39, 6, NULL, NULL, NULL, 'Cashless', '/images/payments/cashless_payments/59_tan.png', 700.00, '', 'None', NULL, '', '', '', NULL, NULL, '2025-11-01 20:35:33', '2025-11-02 06:01:40', 0),
(65, 134, 3, 2, 5, NULL, NULL, NULL, 'Cashless', '/images/payments/cashless_payments/65_parchaso.png', 900.00, '25 off', 'Issued', '/images/payments/medcert_payments/65_parchaso.jpg', '1-3 days', 'Severe bleeding', 'none', '2025-11-05 05:29:27', 150.00, '2025-11-02 22:02:54', '2025-11-05 05:29:47', 0),
(78, 135, 2, 2, 2, 'new updated promo', 'percentage', 50.00, 'Cashless', '/images/payments/cashless_payments/78_potot.jpg', 3250.00, 'b4', 'None', NULL, '', '', '', NULL, NULL, '2025-11-03 16:20:29', '2025-11-04 00:21:52', 0),
(79, 136, 3, 2, 2, 'before update', 'fixed', 123.00, 'Cashless', '/images/payments/cashless_payments/79_potot.png', 67377.00, '', 'None', NULL, '', '', '', NULL, NULL, '2025-11-03 17:15:51', '2025-11-04 01:16:01', 0),
(80, 139, 2, 2, 4, 'sample with date', 'fixed', 120.00, 'Cashless', '/images/payments/cashless_payments/80_parchaso.png', 2180.00, '', 'Issued', NULL, '1-3 Days', 'Severe Bleeding', 'No activities', NULL, NULL, '2025-11-04 21:49:31', '2025-11-05 05:50:18', 0),
(81, 137, 4, 41, NULL, NULL, NULL, NULL, 'Cash', NULL, 650.00, '', 'Issued', NULL, '3 weeks', 'headache', 'none so far', '2025-11-05 06:47:27', 150.00, '2025-11-04 22:07:51', '2025-11-05 06:49:21', 0),
(82, 138, 5, 41, NULL, NULL, NULL, NULL, 'Cashless', '/images/payments/cashless_payments/82_parchaso.jpg', 800.00, '', 'Issued', '/images/payments/medcert_payments/82_parchaso.png', '1 month', 'diagnostics', 'remarks', '2025-11-05 07:09:26', 150.00, '2025-11-04 23:06:32', '2025-11-05 07:10:14', 0),
(83, 140, 2, 2, 5, 'Senior', 'percentage', 25.00, 'Cashless', '/images/payments/cashless_payments/83_parchaso.jpg', 7500.00, '', 'Issued', '/images/payments/medcert_payments/83_parchaso.png', '1 year', 'none', 'none', '2025-11-05 07:13:04', 150.00, '2025-11-04 23:12:05', '2025-11-05 07:13:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dental_transaction_services`
--

CREATE TABLE `dental_transaction_services` (
  `id` int(11) NOT NULL,
  `dental_transaction_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `service_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_transaction_services`
--

INSERT INTO `dental_transaction_services` (`id`, `dental_transaction_id`, `service_id`, `service_name`, `service_price`, `quantity`) VALUES
(1, 20, 1, NULL, NULL, 1),
(2, 21, 1, NULL, NULL, 1),
(3, 21, 3, NULL, NULL, 1),
(4, 22, 1, NULL, NULL, 1),
(5, 22, 2, NULL, NULL, 1),
(6, 23, 1, NULL, NULL, 1),
(7, 24, 1, NULL, NULL, 1),
(8, 24, 2, NULL, NULL, 5),
(9, 25, 1, NULL, NULL, 1),
(10, 25, 3, NULL, NULL, 1),
(11, 25, 4, NULL, NULL, 1),
(12, 25, 2, NULL, NULL, 1),
(13, 26, 1, NULL, NULL, 1),
(14, 26, 3, NULL, NULL, 1),
(15, 26, 4, NULL, NULL, 1),
(16, 26, 2, NULL, NULL, 1),
(17, 27, 1, NULL, NULL, 5),
(18, 27, 2, NULL, NULL, 5),
(19, 28, 4, NULL, NULL, 1),
(20, 28, 2, NULL, NULL, 1),
(21, 29, 1, NULL, NULL, 1),
(22, 30, 3, NULL, NULL, 1),
(23, 31, 1, NULL, NULL, 1),
(24, 31, 2, NULL, NULL, 3),
(46, 32, 1, NULL, NULL, 1),
(47, 33, 1, NULL, NULL, 1),
(48, 33, 4, NULL, NULL, 1),
(49, 34, 1, NULL, NULL, 1),
(50, 35, 1, NULL, NULL, 1),
(51, 36, 1, NULL, NULL, 1),
(52, 37, 3, NULL, NULL, 1),
(53, 37, 4, NULL, NULL, 1),
(54, 38, 3, NULL, NULL, 1),
(55, 38, 4, NULL, NULL, 1),
(56, 38, 2, NULL, NULL, 1),
(81, 39, 1, NULL, NULL, 1),
(82, 39, 2, NULL, NULL, 1),
(83, 40, 2, NULL, NULL, 2),
(84, 41, 2, NULL, NULL, 1),
(85, 42, 2, NULL, NULL, 1),
(86, 43, 2, NULL, NULL, 1),
(87, 44, 2, NULL, NULL, 1),
(88, 45, 2, NULL, NULL, 1),
(89, 46, 1, NULL, NULL, 1),
(90, 47, 2, NULL, NULL, 1),
(91, 48, 1, NULL, NULL, 1),
(92, 48, 3, NULL, NULL, 1),
(93, 49, 2, NULL, NULL, 1),
(94, 50, 2, NULL, NULL, 1),
(95, 51, 2, NULL, NULL, 1),
(96, 52, 1, NULL, NULL, 1),
(97, 52, 13, NULL, NULL, 1),
(98, 52, 2, NULL, NULL, 1),
(99, 53, 1, NULL, NULL, 1),
(100, 53, 2, NULL, NULL, 1),
(101, 54, 1, NULL, NULL, 1),
(102, 54, 4, NULL, NULL, 1),
(103, 55, 7, NULL, NULL, 1),
(104, 56, 9, NULL, NULL, 1),
(106, 58, 9, NULL, NULL, 1),
(109, 59, 2, NULL, NULL, 1),
(116, 57, 8, NULL, NULL, 1),
(117, 57, 13, NULL, NULL, 1),
(120, 65, 2, 'Tooth Extraction', 500.00, 1),
(128, 78, 7, 'Teeth Whitening', 6000.00, 1),
(129, 78, 2, 'Tooth Extraction', 500.00, 1),
(130, 79, 8, 'Complete Denture', 15000.00, 1),
(131, 79, 3, 'Dental Filling', 1500.00, 1),
(132, 79, 6, 'Orthodontic Braces', 45000.00, 1),
(133, 79, 7, 'Teeth Whitening', 6000.00, 1),
(134, 80, 1, 'Consultation', 150.00, 1),
(135, 80, 3, 'Dental Filling', 1500.00, 1),
(136, 80, 13, 'Medical Certificate', 150.00, 1),
(137, 80, 2, 'Tooth Extraction', 500.00, 1),
(138, 81, 1, 'Consultation', 150.00, 1),
(139, 81, 2, 'Tooth Extraction', 500.00, 1),
(140, 82, 16, 'Impaction', 800.00, 1),
(141, 83, 5, 'Dental Crown Placement', 10000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dental_vital`
--

CREATE TABLE `dental_vital` (
  `vitals_id` int(11) NOT NULL,
  `appointment_transaction_id` int(11) NOT NULL,
  `admin_user_id` int(11) DEFAULT NULL,
  `body_temp` decimal(4,1) DEFAULT NULL,
  `pulse_rate` int(11) DEFAULT NULL,
  `respiratory_rate` int(11) DEFAULT NULL,
  `blood_pressure` varchar(10) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `is_swelling` enum('Yes','No') NOT NULL,
  `is_bleeding` enum('Yes','No') NOT NULL,
  `is_sensitive` enum('Yes','No') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_vital`
--

INSERT INTO `dental_vital` (`vitals_id`, `appointment_transaction_id`, `admin_user_id`, `body_temp`, `pulse_rate`, `respiratory_rate`, `blood_pressure`, `height`, `weight`, `is_swelling`, `is_bleeding`, `is_sensitive`, `date_created`, `date_updated`) VALUES
(1, 21, NULL, 36.7, 72, 18, '120/80', 168.00, 65.00, 'Yes', 'Yes', 'Yes', '2025-08-23 18:53:50', NULL),
(2, 22, NULL, 37.2, 80, 20, '130/85', 175.00, 70.00, 'No', 'No', 'No', '2025-08-23 18:53:50', NULL),
(3, 23, NULL, 36.5, 70, 19, '115/75', 160.00, 55.00, 'Yes', 'Yes', 'Yes', '2025-08-23 18:53:50', NULL),
(4, 24, NULL, 37.0, 76, 18, '118/78', 165.00, 60.00, 'Yes', 'Yes', 'Yes', '2025-08-23 18:53:50', NULL),
(5, 25, NULL, 36.8, 74, 17, '122/82', 172.00, 68.00, 'Yes', 'Yes', 'Yes', '2025-08-23 18:53:50', NULL),
(6, 26, NULL, 37.1, 82, 21, '135/90', 178.00, 80.00, 'Yes', 'Yes', 'Yes', '2025-08-23 18:53:50', NULL),
(7, 27, NULL, 36.6, 68, 16, '110/70', 158.00, 50.00, 'Yes', 'Yes', 'Yes', '2025-08-23 18:53:50', NULL),
(8, 28, NULL, 37.3, 85, 22, '140/95', 182.00, 85.00, 'Yes', 'Yes', 'Yes', '2025-08-23 18:53:50', NULL),
(10, 61, NULL, 25.0, 25, 25, '25', 25.00, 25.00, 'Yes', 'Yes', 'Yes', '2025-09-24 00:50:19', NULL),
(11, 61, NULL, 25.0, 25, 25, '25', 25.00, 25.00, 'Yes', 'Yes', 'Yes', '2025-09-24 00:53:07', NULL),
(12, 61, NULL, 1.0, 1, 1, '1', 1.00, 1.00, 'Yes', 'Yes', 'Yes', '2025-09-24 00:54:46', NULL),
(13, 61, NULL, 2.0, 2, 2, '2', 2.00, 2.00, 'Yes', 'Yes', 'Yes', '2025-09-24 00:55:32', NULL),
(14, 61, NULL, 3.0, 3, 3, '3', 3.00, 3.00, 'Yes', 'Yes', 'Yes', '2025-09-24 01:10:03', NULL),
(15, 61, NULL, 4.0, 4, 4, '4', 4.00, 4.00, 'Yes', 'Yes', 'Yes', '2025-09-24 01:12:49', NULL),
(16, 52, NULL, 5.0, 5, 5, '5', 5.00, 5.00, 'Yes', 'Yes', 'Yes', '2025-09-26 15:52:13', NULL),
(17, 52, NULL, 6.0, 6, 6, '6', 6.00, 6.00, 'Yes', 'Yes', 'Yes', '2025-09-26 16:16:15', NULL),
(18, 80, NULL, 120.0, 120, 120, '1201', 120.00, 120.00, 'No', 'No', 'No', '2025-10-07 21:33:40', NULL),
(20, 93, NULL, 115.0, 115, 115, '115', 115.00, 115.00, 'No', 'No', 'No', '2025-10-12 22:55:10', NULL),
(21, 95, NULL, 5.0, 5, 5, '5', 5.00, 5.00, 'No', 'No', 'No', '2025-10-13 00:02:40', NULL),
(22, 85, NULL, 123.0, 123, 123, '123', 123.00, 123.00, 'No', 'No', 'No', '2025-10-13 15:50:22', NULL),
(23, 59, NULL, 321.0, 321, 321, '321', 321.00, 321.00, 'No', 'No', 'No', '2025-10-13 16:09:53', NULL),
(24, 97, NULL, 37.0, 100, 100, '120/80', 170.00, 58.00, 'Yes', 'Yes', 'Yes', '2025-10-14 16:46:56', NULL),
(25, 98, 2, 28.0, 101, 100, '120/80', 170.00, 100.00, 'No', 'No', 'No', '2025-10-14 19:33:13', '2025-10-15 03:48:31'),
(26, 99, 2, 25.0, 110, 115, '120/80', 170.00, 100.00, 'Yes', 'Yes', 'Yes', '2025-10-15 01:11:30', '2025-10-15 09:11:30'),
(27, 100, 2, 3.0, 3, 3, '3', 3.00, 3.00, 'No', 'No', 'No', '2025-10-15 01:29:27', '2025-10-15 09:29:27'),
(28, 101, 2, 44.0, 4, 4, '4', 44.00, 4.00, 'No', 'No', 'No', '2025-10-15 01:35:02', '2025-10-15 09:35:02'),
(29, 102, 2, 3.0, 33, 3, '3', 3.00, 3.00, 'No', 'No', 'No', '2025-10-15 14:51:14', '2025-10-15 22:51:14'),
(30, 103, 2, 1.0, 1, 1, '1', 1.00, 1.00, 'No', 'No', 'No', '2025-10-15 20:29:43', '2025-10-16 04:29:43'),
(31, 104, 2, 231.0, 123, 123, '1', 31.00, 3.00, 'No', 'No', 'No', '2025-10-15 20:41:19', '2025-10-16 04:41:19'),
(32, 105, 2, 50.0, 50, 50, '50', 50.00, 50.00, 'No', 'No', 'No', '2025-10-17 07:01:53', '2025-10-17 15:01:53'),
(33, 113, 39, 5.0, 5, 5, '5', 5.00, 5.00, 'No', 'No', 'No', '2025-10-18 18:29:10', '2025-10-19 02:29:10'),
(34, 115, 39, 5.0, 5, 5, '55', 5.00, 5.00, 'No', 'No', 'No', '2025-10-18 19:33:14', '2025-10-19 03:33:14'),
(35, 114, 2, 5.0, 5, 5, '5', 5.00, 5.00, 'No', 'No', 'No', '2025-10-18 19:41:43', '2025-10-19 03:41:43'),
(36, 116, 2, 4.0, 44, 4, '4', 4.00, 4.00, 'No', 'No', 'No', '2025-10-18 19:44:30', '2025-10-19 03:44:30'),
(37, 117, 2, 999.9, 21, 321, '3', 13.00, 3.00, 'No', 'No', 'No', '2025-10-18 19:46:08', '2025-10-19 03:46:08'),
(38, 118, 2, 757.0, 5, 75, '75', 57.00, 6.00, 'No', 'No', 'No', '2025-10-18 19:50:08', '2025-10-19 03:50:08'),
(39, 119, 2, 34.0, 43, 43, '4', 3.00, 4.00, 'No', 'No', 'No', '2025-10-18 19:56:43', '2025-10-19 03:56:43'),
(40, 120, 39, 999.9, 2, 2, '2', 2.00, 2.00, 'No', 'No', 'No', '2025-10-18 20:01:33', '2025-10-19 04:01:33'),
(41, 121, 2, 999.9, 3, 2, '2', 2.00, 2.00, 'No', 'No', 'No', '2025-10-18 20:11:22', '2025-10-19 04:11:22'),
(42, 122, 39, 32.0, 23, 213, '12', 32.00, 13.00, 'No', 'No', 'No', '2025-10-18 20:14:23', '2025-10-19 04:14:23'),
(43, 123, 39, 34.0, 5, 3434, '43', 999.99, 34.00, 'No', 'No', 'No', '2025-10-18 20:23:33', '2025-10-19 04:23:33'),
(44, 124, 2, 6.0, 6, 66, '6', 6.00, 6.00, 'No', 'No', 'No', '2025-10-18 20:23:48', '2025-10-19 04:23:48'),
(45, 126, 2, 35.0, 120, 120, '120/80', 170.00, 100.00, 'No', 'No', 'No', '2025-10-31 18:19:54', '2025-11-01 02:19:54'),
(46, 127, 2, 38.0, 100, 100, '120/80', 170.00, 95.00, 'No', 'No', 'No', '2025-10-31 18:48:54', '2025-11-01 02:48:54'),
(47, 128, 2, 120.0, 120, 120, '220', 120.00, 120.00, 'No', 'No', 'No', '2025-10-31 23:11:43', '2025-11-01 07:11:43'),
(48, 129, 39, 38.0, 100, 100, '120/80', 170.00, 100.00, 'No', 'No', 'No', '2025-11-01 17:19:16', '2025-11-02 01:19:16'),
(49, 130, 39, 120.0, 120, 120, '120', 120.00, 120.00, 'No', 'No', 'No', '2025-11-01 18:47:39', '2025-11-02 02:47:39'),
(50, 131, 39, 12.0, 12, 121, '21', 12.00, 12.00, 'No', 'No', 'No', '2025-11-01 20:00:06', '2025-11-02 04:00:06'),
(51, 132, 39, 35.0, 353, 5, '353', 353.00, 35.00, 'No', 'No', 'No', '2025-11-01 20:29:38', '2025-11-02 04:29:38'),
(52, 133, 39, 10.0, 10, 10, '10', 10.00, 10.00, 'No', 'No', 'No', '2025-11-01 22:01:38', '2025-11-02 06:01:38'),
(53, 134, 2, 213.0, 123, 1, '23', 123.00, 123.00, 'No', 'No', 'No', '2025-11-02 21:52:59', '2025-11-03 05:52:59'),
(54, 135, 2, 121.0, 12, 12, '12', 11.00, 21.00, 'No', 'No', 'No', '2025-11-03 15:38:17', '2025-11-03 23:38:17'),
(55, 136, 2, 120.0, 120, 120, '210', 999.99, 21.00, 'No', 'No', 'No', '2025-11-03 17:13:57', '2025-11-04 01:13:57'),
(56, 139, 2, 35.0, 120, 100, '100', 120.00, 100.00, 'No', 'No', 'No', '2025-11-04 21:47:44', '2025-11-05 05:47:44'),
(57, 137, 41, 38.0, 120, 100, '128/80', 170.00, 89.00, 'No', 'No', 'No', '2025-11-04 21:54:26', '2025-11-05 05:54:26'),
(58, 138, 41, 353.0, 10, 100, '120/80', 170.00, 80.00, 'No', 'Yes', 'No', '2025-11-04 23:06:13', '2025-11-05 07:06:13'),
(59, 140, 2, 35.0, 100, 100, '120', 170.00, 100.00, 'No', 'No', 'No', '2025-11-04 23:11:46', '2025-11-05 07:11:46');

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
  `date_of_birth` varchar(255) NOT NULL,
  `date_of_birth_iv` varchar(255) DEFAULT NULL,
  `date_of_birth_tag` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `contact_number_iv` varchar(255) DEFAULT NULL,
  `contact_number_tag` varchar(255) DEFAULT NULL,
  `license_number` varchar(255) NOT NULL,
  `license_number_iv` varchar(255) DEFAULT NULL,
  `license_number_tag` varchar(255) DEFAULT NULL,
  `date_started` date NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `signature_image` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentist`
--

INSERT INTO `dentist` (`dentist_id`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `date_of_birth_iv`, `date_of_birth_tag`, `email`, `contact_number`, `contact_number_iv`, `contact_number_tag`, `license_number`, `license_number_iv`, `license_number_tag`, `date_started`, `status`, `signature_image`, `profile_image`, `date_created`, `date_updated`) VALUES
(1, 'Ulanday', 'Mansanitass', 'Precious', 'Female', 'rCjjgH2sIlmlgg==', 'xWndtZPYp+qGVoaU', 'mGhemL92aaPF/bJDhqtJlQ==', 'precious@gmail.com', 'QgVLtgQOPKEh9g==', 'sbz3rIIELTI3hxVQ', 'qPAwJpS0CqoIV6SIUH+yaA==', '3leRB/Lci+Vd7Q==', 'wx32rLbCVjUwKgF8', '9HtFS6v3lhkv+2DPWBWkFA==', '2025-10-31', 'Active', NULL, 'ulanday_precious_profile.jpg', '2025-07-11 19:40:26', '2025-11-08 04:00:50'),
(2, 'Chan', 'Marie', 'Kyla', 'Female', 'imiaQDvENbQxQA==', '51fdSUqhokvR/UPE', 'tYWooNhWoDmSrO6WdYLbXQ==', 'kyla.marie@gmail.com', 'tFRhTnpy7XlgyA==', 'rs+RAK1FFtk06hsI', 'FsJL/ToD+F+ctEo7J6gCBw==', '43Sa6tKNUDY=', 'lSm43IAFOZ5CUXh1', '2Qv82H2goQdcD+JzSYPA5Q==', '2023-02-10', 'Active', NULL, 'chan_kyla_profile.jpg', '2025-07-11 19:40:26', '2025-11-08 04:01:38'),
(3, 'Summers', '', 'Daze', 'Female', 'mTuIs0W3s/d6pQ==', 'pzBiCc4qYBps3Gwd', '4mRnKnLLH+2yyyaNoUFonA==', 'daze@gmail.com', '5BluSS/eB9gNqQ==', 'Xn0lqCx9mp/RFjm/', 'F4vOIBC4xJueu4C5Kt80IQ==', 'nOwE8o8HcAg=', 'sqjFM2kDrYL4tlZa', 'm5hbIRh8QlwWGSqHWQCLqw==', '2023-03-05', 'Active', 'summers_daze_signature.png', 'summers_daze_profile.png', '2025-07-11 19:40:26', '2025-11-08 04:01:43'),
(4, 'San Jose', '', 'Solene', 'Female', '6ygFYrJHh5iIpA==', 'r1Ns0MNQCM96cWym', 'IK8rxtl6Uly8bQCJ84JEuQ==', 'solene@gmail.com', 'MmXTTvngyzNh6A==', 'ECwbbxYf71EvtWuW', 'VGEqw02ZpjaStn1o8/ViGQ==', 'OTn41AnQ1Po=', '0pUV/6P8BIjJyefy', 'n3FY6xlqjMnabb/NSxwWWA==', '2023-04-01', 'Active', NULL, 'san_jose_solene_profile.jpeg', '2025-07-11 19:40:26', '2025-11-08 04:01:46'),
(5, 'San Jose', 'Codm', 'Yel', 'Female', 'wk6hHUfyb2dYGg==', 'aR5CiSakV//KmUrs', 'Ktr79/mFancBVzlmNSdV7A==', 'yel@gmail.com', 'Haice3hLspkl8Q==', 'ojg7zAjvF4TajO7B', 'R9AMBxCoZtyr1i7GqdntIQ==', '7qBu3g/uuP2mZQ==', '0zIeaPQ8v+Thm11x', 'f+EyIUM5NJ+FF+kNS39i9Q==', '2023-05-20', 'Active', NULL, 'san_jose_yel_profile.jpg', '2025-08-30 00:24:25', '2025-11-08 04:01:50'),
(6, 'Achas', '', 'Gab', 'Male', 'EdtCS2RRT123Uw==', 'BSn2dcTA52AEMuXw', 'vsS4hx5ZJvFcaDlqnpUmhQ==', 'achas@gmail.com', 'SkVBTin1rYiJUw==', 'CVdfU1kNoAeNkbmB', '0+B6OE1fSe24Rmh6EtEjNg==', '73I/Zxjp', '1GlNqgQ43q0+jweE', 'ZW3yadP+nhXb0IVUmH0g7A==', '2025-10-31', 'Active', NULL, NULL, '2025-08-30 12:07:53', '2025-11-08 04:01:54'),
(7, 'Menano', '', 'Andy', 'Male', 'r8FFc0w6iPqpCg==', 'KGSTg9VnFr+RctAv', 'BUjMw7LttFOX47nUhkpNlg==', 'adny@gmail.com', 'UK90CtxW0lcOmg==', 'FJyMU+lUki9hfm5h', 'DQroC5fGacyLdOISJurnpQ==', 'Qw8BqY9o', 'KtqIELQsOLljr8v2', '0XPVpxf1XF6WJB1cj3ERSA==', '2025-09-25', 'Active', NULL, NULL, '2025-08-30 12:17:41', '2025-11-08 04:01:58'),
(8, 'asd', 'sad', 'asdas', 'Female', '/mvXo/Bm5alKZQ==', 'qM4nz/+ZFabeh3+5', '/utFbc8DvUP2EFhcmegQBw==', 'sample@gmail.com', 'I0c5+7N2HPUWIQ==', 'lXbt9cG5ChQxUV7N', 'TWewxYq42Q+a1arm15xRJQ==', 'sCpILsTZLw==', 'L0F+DfN9Ybmn/KFl', 'tIArG4T2Fac7H4xWe9vcCw==', '2025-09-25', 'Inactive', NULL, NULL, '2025-09-07 22:35:18', '2025-11-08 04:02:01'),
(10, 'parch', '', 'jj', 'Male', 'sOOKbeJ9sJagPg==', 'dUz/xK3KbUbzeEe2', 'y6+7LRUGBCBAN/9zldUQeg==', 'josephparchaso@gmail.com', 'UW6WwPcJhwY1yA==', 'aEE5IEIi9CC8hfbS', 'fU7l6gkZF3V6G3gnTOQFVQ==', 'CmpG4e8=', 'ES3bAG/rXvF8xiSI', '+I+ZeiLbrcyJhbnMSAg8xQ==', '2025-12-01', 'Inactive', 'parch_jj_signature.png', NULL, '2025-10-31 21:57:54', '2025-11-08 04:02:05'),
(11, 'Parchaso', 'espana', 'Jhon', 'Male', 'L2OILKhUo86elg==', 'LXEYBFKD72gSmwuu', 'CevEQ8zW54Ur4bOVm6UQDQ==', 'josephparchaso@gmail.com', 'L/AanZ8R9yn5dw==', 'unGSimnxmO+6cd0U', 'iPc6JMu8AH4ffaiDdfyIoQ==', '5up21xKu9kfM', '3ThdxhP4JT2P3lxv', 't0zpy5gOnqAVU05ZXcG2SA==', '2025-11-10', 'Active', 'sig_parchaso_jhon.png', 'dentist_parchaso_jhon.png', '2025-11-07 19:33:14', '2025-11-08 03:55:36');

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
(85, 8, 1),
(93, 6, 6),
(94, 7, 6),
(95, 5, 3),
(96, 4, 3),
(100, 1, 2),
(102, 3, 1),
(103, 3, 2),
(104, 3, 3),
(112, 2, 1),
(114, 10, 7),
(115, 11, 6);

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
(27, 8, 2),
(32, 7, 1),
(33, 7, 2),
(34, 7, 3),
(35, 7, 4),
(36, 7, 5),
(37, 7, 6),
(38, 7, 7),
(39, 7, 8),
(40, 7, 9),
(41, 7, 10),
(42, 6, 1),
(43, 6, 2),
(44, 6, 3),
(45, 6, 4),
(46, 6, 5),
(47, 6, 6),
(48, 6, 7),
(49, 6, 8),
(50, 6, 9),
(51, 6, 10),
(88, 4, 1),
(89, 4, 2),
(90, 4, 3),
(91, 4, 4),
(92, 4, 5),
(93, 4, 7),
(94, 4, 8),
(95, 4, 9),
(96, 4, 10),
(136, 5, 1),
(137, 5, 2),
(138, 5, 3),
(139, 5, 4),
(140, 5, 5),
(141, 5, 6),
(142, 5, 7),
(143, 5, 8),
(144, 5, 9),
(145, 5, 10),
(161, 2, 1),
(162, 2, 2),
(163, 2, 3),
(164, 2, 4),
(165, 2, 5),
(166, 2, 6),
(167, 2, 7),
(168, 2, 8),
(169, 2, 9),
(170, 2, 10),
(171, 2, 13),
(172, 3, 1),
(173, 3, 2),
(174, 3, 13),
(187, 1, 1),
(188, 1, 2),
(189, 1, 3),
(190, 1, 4),
(191, 1, 5),
(192, 1, 6),
(193, 1, 7),
(194, 1, 8),
(195, 1, 9),
(196, 1, 10),
(197, 1, 13),
(198, 11, 8),
(199, 11, 1),
(200, 11, 5),
(201, 11, 3),
(202, 11, 10),
(203, 11, 16),
(204, 11, 13),
(205, 11, 6),
(206, 11, 9),
(207, 11, 4),
(208, 11, 14),
(209, 11, 7),
(210, 11, 2),
(211, 10, 1),
(212, 10, 2),
(213, 10, 3),
(214, 10, 4),
(215, 10, 5),
(216, 10, 6),
(217, 10, 7),
(218, 10, 8),
(219, 10, 9),
(220, 10, 10),
(221, 10, 13);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `is_read`, `date_created`) VALUES
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
(107, 28, 'Your password was changed successfully on September 26, 2025, 10:49 pm. If this wasn’t you, please contact clinic immediately.', 1, '2025-09-26 14:49:45'),
(108, 28, 'Your password was changed successfully on September 26, 2025, 11:27 pm. If this wasn’t you, please contact clinic immediately.', 1, '2025-09-26 15:27:12'),
(109, 28, 'Your appointment on 2025-10-31 at 09:00 was successfully booked!', 1, '2025-10-03 21:22:21'),
(110, 28, 'Your password was changed successfully on October 4, 2025, 5:30 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-03 21:30:15'),
(111, 28, 'Your appointment on 2025-10-31 at 09:45 was successfully booked!', 1, '2025-10-03 21:42:30'),
(112, 27, 'Your appointment on 2025-10-31 at 10:30 was successfully booked!', 0, '2025-10-03 21:43:55'),
(113, 54, 'Your appointment on 2025-10-31 at 11:15 was successfully booked!', 0, '2025-10-03 21:44:25'),
(114, 54, 'Your appointment on 2025-10-31 at 12:00 was successfully booked!', 0, '2025-10-03 21:46:53'),
(115, 2, 'Your password was changed successfully on October 4, 2025, 6:03 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-03 22:03:33'),
(116, 1, 'Your password was changed successfully on October 4, 2025, 6:10 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-03 22:10:31'),
(117, 28, 'Your password was changed successfully on October 5, 2025, 1:21 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-04 17:21:34'),
(118, 28, 'Your password was changed successfully on October 5, 2025, 1:40 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-04 17:40:24'),
(119, 28, 'Your password was changed successfully on October 5, 2025, 1:56 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-04 17:56:40'),
(120, 2, 'Your password was changed successfully on October 5, 2025, 2:01 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-04 18:01:29'),
(121, 1, 'Your password was changed successfully on October 5, 2025, 2:02 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-04 18:02:35'),
(122, 28, 'Your password was changed successfully on October 5, 2025, 2:25 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-04 18:25:25'),
(123, 28, 'Your email was successfully updated to 18100807@usc.edu.ph on October 5, 2025, 2:51 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-04 18:51:41'),
(124, 28, 'Your email was successfully updated to josephparchaso@gmail.com on October 5, 2025, 2:54 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-04 18:54:59'),
(125, 2, 'Your email was successfully updated to 18102727@usc.edu.ph on October 5, 2025, 3:02 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-04 19:02:32'),
(126, 1, 'Your email was successfully updated to 18100807@usc.edu.ph on October 5, 2025, 3:09 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-04 19:09:00'),
(127, 28, 'Your appointment on 2025-10-08 at 09:00 was successfully booked!', 1, '2025-10-06 19:50:46'),
(128, 62, 'Welcome to Smile-ify! Your account was created.', 0, '2025-10-06 20:35:12'),
(129, 62, 'Your appointment on 2025-10-07 at 15:00 was successfully booked!', 0, '2025-10-06 20:35:12'),
(130, 63, 'Welcome to Smile-ify! Your account was created.', 0, '2025-10-06 20:41:29'),
(131, 63, 'Your appointment on 2025-10-08 at 15:00 was successfully booked!', 0, '2025-10-06 20:41:29'),
(132, 65, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-10-08 16:23:20'),
(133, 65, 'Your appointment on 2025-10-14 at 09:00 was successfully booked!', 0, '2025-10-08 16:23:20'),
(134, 66, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-10-08 16:31:23'),
(135, 66, 'Your appointment on 2025-10-14 at 09:00 was successfully booked!', 0, '2025-10-08 16:31:23'),
(136, 67, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-10-08 16:37:26'),
(137, 67, 'Your appointment on 2025-10-14 at 12:00 was successfully booked!', 0, '2025-10-08 16:37:26'),
(138, 68, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-10-08 17:26:21'),
(139, 68, 'Your appointment on 2025-10-15 at 09:00 was successfully booked!', 0, '2025-10-08 17:26:21'),
(140, 69, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-10-08 17:44:24'),
(141, 69, 'Your appointment on 2025-10-10 at 10:00 was successfully booked!', 0, '2025-10-08 17:44:24'),
(142, 70, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-10-08 18:12:00'),
(143, 70, 'Your appointment on 2025-10-10 at 12:00 was successfully booked!', 0, '2025-10-08 18:12:00'),
(144, 28, 'Your appointment on 2025-10-10 at 09:00 was successfully booked!', 1, '2025-10-09 20:14:11'),
(145, 28, 'Your appointment on 2025-10-10 at 13:30 was successfully booked!', 1, '2025-10-09 20:20:00'),
(146, 71, 'Welcome to Smile-ify! Your account was created.', 0, '2025-10-09 21:25:06'),
(147, 71, 'Your appointment on 2025-10-10 at 15:00 was successfully booked!', 0, '2025-10-09 21:25:06'),
(148, 28, 'Your appointment on 2025-10-20 at 09:00 was successfully booked!', 1, '2025-10-10 01:02:22'),
(149, 46, 'Your appointment on 2025-10-20 at 10:30 was successfully booked!', 0, '2025-10-10 22:22:19'),
(150, 54, 'Your appointment on 2025-10-20 at 13:30 was successfully booked!', 0, '2025-10-10 22:31:38'),
(151, 28, 'Your appointment on 2025-10-15 at 09:00 was successfully booked!', 1, '2025-10-13 17:16:14'),
(157, 28, 'Your appointment (October 15, 2025 at 9:00 AM) has been cancelled.', 1, '2025-10-13 17:22:14'),
(158, 72, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-10-14 16:22:41'),
(159, 72, 'Your appointment on 2025-10-22 at 09:00 was successfully booked!', 0, '2025-10-14 16:22:41'),
(160, 46, 'Your appointment (October 20, 2025 at 10:30 AM) has been cancelled.', 0, '2025-10-14 17:06:26'),
(161, 72, 'Your appointment (October 22, 2025 at 9:00 AM) has been cancelled.', 0, '2025-10-14 17:15:27'),
(162, 54, 'Your appointment (October 20, 2025 at 1:30 PM) has been cancelled.', 0, '2025-10-14 19:26:48'),
(163, 28, 'Your appointment on 2025-10-22 at 09:00 was successfully booked!', 1, '2025-10-14 19:30:57'),
(164, 28, 'Your appointment (October 22, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 00:50:35'),
(165, 28, 'Your appointment (October 22, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 00:51:44'),
(166, 28, 'Your appointment on 2025-10-23 at 09:00 was successfully booked!', 1, '2025-10-15 01:06:42'),
(167, 28, 'Your appointment (October 23, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 01:19:36'),
(168, 28, 'Your appointment on 2025-10-23 at 09:00 was successfully booked!', 1, '2025-10-15 01:27:39'),
(225, 28, 'Your appointment (October 23, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 01:32:40'),
(226, 28, 'Your appointment on 2025-10-23 at 09:00 was successfully booked!', 1, '2025-10-15 01:34:49'),
(269, 28, 'Your appointment (October 23, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 01:36:00'),
(270, 28, 'Your appointment on 2025-10-23 at 09:00 was successfully booked!', 1, '2025-10-15 14:50:48'),
(313, 28, 'Your appointment (October 23, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 14:52:55'),
(314, 28, 'Your appointment on 2025-10-23 at 09:00 was successfully booked!', 1, '2025-10-15 20:28:31'),
(315, 28, 'Your appointment (October 23, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 20:29:54'),
(316, 28, 'Your appointment on 2025-10-23 at 09:00 was successfully booked!', 1, '2025-10-15 20:41:11'),
(345, 28, 'Your appointment (October 23, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-15 20:43:04'),
(346, 28, 'Your appointment on 2025-10-27 at 09:00 was successfully booked!', 1, '2025-10-17 06:50:03'),
(375, 28, 'Your appointment (October 27, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-17 07:14:42'),
(376, 28, 'Your appointment on 2025-10-18 at 09:00 was successfully booked!', 1, '2025-10-17 20:44:06'),
(377, 46, 'Your appointment on 2025-10-18 at 12:00 was successfully booked!', 0, '2025-10-17 22:27:59'),
(378, 54, 'Your appointment on 2025-10-18 at 10:00 was successfully booked!', 0, '2025-10-17 22:28:19'),
(379, 69, 'Your appointment on 2025-10-18 at 11:00 was successfully booked!', 0, '2025-10-17 22:28:37'),
(380, 28, 'Your appointment on 2025-10-18 at 12:00 was successfully booked!', 1, '2025-10-17 22:29:12'),
(381, 46, 'Your appointment on 2025-10-18 at 15:00 was successfully booked!', 0, '2025-10-17 22:29:42'),
(382, 54, 'Your appointment on 2025-10-27 at 09:00 was successfully booked!', 0, '2025-10-18 18:28:24'),
(635, 54, 'Your appointment (October 27, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 0, '2025-10-18 19:14:31'),
(636, 28, 'Your appointment on 2025-10-27 at 09:00 was successfully booked!', 1, '2025-10-18 19:30:10'),
(637, 28, 'Your appointment on 2025-10-27 at 09:00 was successfully booked!', 1, '2025-10-18 19:30:30'),
(652, 28, 'Your appointment (October 27, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 19:35:14'),
(653, 28, 'Your appointment (October 27, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 19:41:45'),
(654, 28, 'Your appointment on 2025-10-22 at 13:00 was successfully booked!', 1, '2025-10-18 19:44:16'),
(655, 28, 'Your appointment (October 22, 2025 at 1:00 PM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 19:44:31'),
(656, 28, 'Your appointment on 2025-10-29 at 13:30 was successfully booked!', 1, '2025-10-18 19:45:54'),
(685, 28, 'Your appointment (October 29, 2025 at 1:30 PM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 19:48:34'),
(686, 28, 'Your appointment on 2025-10-25 at 13:30 was successfully booked!', 1, '2025-10-18 19:49:56'),
(687, 28, 'Your appointment (October 25, 2025 at 1:30 PM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 19:50:20'),
(688, 28, 'Your appointment on 2025-10-22 at 12:00 was successfully booked!', 1, '2025-10-18 19:56:34'),
(689, 28, 'Your appointment (October 22, 2025 at 12:00 PM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 19:56:58'),
(690, 28, 'Your appointment on 2025-10-29 at 11:30 was successfully booked!', 1, '2025-10-18 19:59:13'),
(747, 28, 'Your appointment (October 29, 2025 at 11:30 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 20:08:25'),
(748, 28, 'Your appointment on 2025-10-25 at 09:00 was successfully booked!', 1, '2025-10-18 20:10:32'),
(749, 28, 'Your appointment (October 25, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 20:12:06'),
(750, 28, 'Your appointment on 2025-10-28 at 10:00 was successfully booked!', 1, '2025-10-18 20:14:04'),
(751, 28, 'Your appointment (October 28, 2025 at 10:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 20:14:31'),
(752, 28, 'Your appointment on 2025-10-24 at 11:00 was successfully booked!', 1, '2025-10-18 20:22:43'),
(753, 28, 'Your appointment on 2025-10-29 at 11:30 was successfully booked!', 1, '2025-10-18 20:23:02'),
(768, 28, 'Your appointment (October 24, 2025 at 11:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 20:25:13'),
(769, 28, 'Your appointment (October 29, 2025 at 11:30 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-18 20:25:45'),
(770, 73, 'Welcome to Smile-ify! Your account was successfully created.', 1, '2025-10-24 06:01:06'),
(771, 73, 'Your appointment on 2025-10-30 at 13:00 was successfully booked!', 1, '2025-10-24 06:01:07'),
(772, 73, 'Your password was changed successfully on October 24, 2025, 2:09 pm. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-24 06:09:44'),
(773, 73, 'Your email was successfully updated to theartp1@gmail.com on October 24, 2025, 2:13 pm. If this wasn’t you, please contact the clinic immediately.', 1, '2025-10-24 06:13:08'),
(774, 28, 'Your appointment on 2025-11-10 at 09:00 was successfully booked!', 1, '2025-10-31 18:17:14'),
(775, 28, 'Your appointment (November 10, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-31 18:24:32'),
(776, 28, 'Your appointment on 2025-11-10 at 09:00 was successfully booked!', 1, '2025-10-31 18:47:54'),
(777, 28, 'Your appointment (November 10, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-31 18:49:18'),
(778, 2, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #53', 1, '2025-10-31 18:53:40'),
(779, 38, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #53', 1, '2025-10-31 18:53:40'),
(780, 51, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #53', 0, '2025-10-31 18:53:40'),
(781, 52, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #53', 0, '2025-10-31 18:53:40'),
(785, 39, 'Your password was changed successfully on November 1, 2025, 2:55 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-31 18:55:39'),
(786, 38, 'Your password was changed successfully on November 1, 2025, 2:57 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-10-31 18:57:38'),
(787, 28, 'Your medical certificate request from your appointment on November 10, 2025 at 9:00 AM has been approved.', 1, '2025-10-31 19:08:27'),
(788, 2, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #51', 1, '2025-10-31 20:02:56'),
(789, 38, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #51', 0, '2025-10-31 20:02:56'),
(790, 51, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #51', 0, '2025-10-31 20:02:56'),
(791, 52, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #51', 0, '2025-10-31 20:02:56'),
(795, 39, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #47', 1, '2025-10-31 20:04:40'),
(796, 40, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #47', 0, '2025-10-31 20:04:40'),
(797, 43, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #47', 0, '2025-10-31 20:04:40'),
(798, 2, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #44', 1, '2025-10-31 20:06:23'),
(799, 38, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #44', 0, '2025-10-31 20:06:23'),
(800, 51, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #44', 0, '2025-10-31 20:06:23'),
(801, 52, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #44', 0, '2025-10-31 20:06:23'),
(805, 28, 'Your medical certificate request from your appointment on October 29, 2025 at 1:30 PM has been approved.', 1, '2025-10-31 20:10:44'),
(806, 1, 'The promo <strong>sample notif</strong> has been updated in <strong>Babag</strong>.', 1, '2025-10-31 21:20:36'),
(807, 1, 'The promo sample notif has been updated in Babag.', 1, '2025-10-31 21:25:14'),
(808, 1, 'The promo sample notif has been updated in Babag.', 1, '2025-10-31 21:29:32'),
(809, 1, 'The service Consultation has been updated in Babag.', 1, '2025-10-31 21:31:09'),
(810, 1, 'A new service \'sample notif\' has been added in Babag.', 1, '2025-10-31 21:31:38'),
(811, 28, 'Your appointment on 2025-11-17 at 09:00 was successfully booked!', 1, '2025-10-31 23:11:28'),
(812, 28, 'Your appointment (November 17, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-10-31 23:11:54'),
(813, 2, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #54', 1, '2025-11-01 15:05:33'),
(814, 38, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #54', 0, '2025-11-01 15:05:33'),
(815, 51, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #54', 0, '2025-11-01 15:05:33'),
(816, 52, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #54', 0, '2025-11-01 15:05:33'),
(820, 28, 'Your medical certificate request from your appointment on November 17, 2025 at 9:00 AM has been approved.', 1, '2025-11-01 15:06:31'),
(821, 28, 'Your appointment on 2025-11-10 at 09:00 was successfully booked!', 1, '2025-11-01 17:16:30'),
(822, 39, 'Your password was changed successfully on November 2, 2025, 1:17 am. If this wasn’t you, please contact clinic immediately.', 1, '2025-11-01 17:17:33'),
(851, 28, 'Your appointment (November 10, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-11-01 17:29:47'),
(852, 28, 'Your medical certificate request from your appointment on November 10, 2025 at 9:00 AM has been approved.', 1, '2025-11-01 18:44:59'),
(853, 28, 'Your appointment on 2025-11-03 at 12:30 was successfully booked!', 1, '2025-11-01 18:46:49'),
(854, 28, 'Your appointment (November 3, 2025 at 12:30 PM) has been marked as completed. Thank you for visiting!', 1, '2025-11-01 19:43:25'),
(855, 28, 'Your medical certificate request from your appointment on November 3, 2025 at 12:30 PM has been approved.', 1, '2025-11-01 19:44:49'),
(856, 28, 'Your appointment on 2025-11-24 at 09:30 was successfully booked!', 1, '2025-11-01 19:59:58'),
(857, 73, 'Your appointment on 2025-11-17 at 09:30 was successfully booked!', 0, '2025-11-01 20:29:12'),
(858, 54, 'Your appointment on 2025-11-17 at 11:30 was successfully booked!', 0, '2025-11-01 20:35:15'),
(859, 1, 'A new service \'Medical Certificate\' has been added in Pusok.', 1, '2025-11-01 20:48:39'),
(860, 1, 'The service Medical Certificate has been updated in Pusok.', 1, '2025-11-01 20:50:37'),
(861, 28, 'Your appointment (November 24, 2025 at 9:30 AM) has been marked as completed. Thank you for visiting!', 1, '2025-11-01 21:32:43'),
(862, 73, 'Your appointment (November 17, 2025 at 9:30 AM) has been marked as completed. Thank you for visiting!', 0, '2025-11-01 21:57:50'),
(863, 54, 'Your appointment (November 17, 2025 at 11:30 AM) has been marked as completed. Thank you for visiting!', 0, '2025-11-01 22:01:40'),
(864, 1, 'The service Consultation in Babag was set to Inactive.', 1, '2025-11-02 19:53:36'),
(865, 1, 'The service Consultation in Babag was set to Active.', 1, '2025-11-02 19:53:59'),
(866, 1, 'The promo <strong>owner promo</strong> has been updated in <strong>Babag</strong>.', 1, '2025-11-02 20:44:14'),
(867, 1, 'The promo owner promo in Babag was set to Active.', 1, '2025-11-02 20:48:34'),
(868, 1, 'The promo owner promo in Babag was set to Inactive.', 1, '2025-11-02 20:51:47'),
(869, 1, 'The promo owner promo in Babag was set to Inactive.', 1, '2025-11-02 20:57:25'),
(870, 1, 'The promo owner promo in Babag was set to Active.', 1, '2025-11-02 20:59:14'),
(871, 1, 'The promo owner promo in Babag was set to Inactive.', 1, '2025-11-02 21:04:31'),
(872, 28, 'Your appointment on 2025-11-10 at 09:00 was successfully booked!', 1, '2025-11-02 21:52:52'),
(873, 1, 'The promo Senior in Babag was set to Active.', 1, '2025-11-02 21:53:42'),
(874, 28, 'Your appointment (November 10, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-11-02 22:03:25'),
(875, 1, 'The service Consultation in Babag was set to Active.', 1, '2025-11-02 22:24:40'),
(876, 1, 'The service Consultation in Babag was set to Inactive.', 1, '2025-11-02 22:28:55'),
(877, 73, 'Your appointment on 2025-11-10 at 09:00 was successfully booked!', 0, '2025-11-03 15:38:08'),
(878, 73, 'Your appointment (November 10, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 0, '2025-11-03 16:21:52'),
(879, 73, 'Your appointment on 2025-11-04 at 09:00 was successfully booked!', 0, '2025-11-03 17:13:45'),
(880, 73, 'Your appointment (November 4, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 0, '2025-11-03 17:16:01'),
(881, 1, 'A new announcement titled \'Notify Owner\' was added for Babag.', 1, '2025-11-04 13:52:25'),
(882, 1, 'The announcement \'dummy\' in Babag was updated.', 1, '2025-11-04 13:56:13'),
(883, 1, 'The announcement \'Notify Owner\' in Babag was updated.', 1, '2025-11-04 16:48:13'),
(884, 74, 'Welcome to Smile-ify! Your account was successfully created.', 1, '2025-11-04 17:31:14'),
(885, 74, 'Your appointment on 2025-11-06 at 09:00 was successfully booked!', 1, '2025-11-04 17:31:14'),
(886, 28, 'Your appointment on 2025-11-06 at 10:30 was successfully booked!', 1, '2025-11-04 17:35:52'),
(887, 28, 'Your appointment on 2025-11-06 at 09:00 was successfully booked!', 1, '2025-11-04 17:36:38'),
(888, 28, 'Your password was changed successfully on November 5, 2025, 4:53 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-11-04 20:53:13'),
(889, 28, 'Your email was successfully updated to 18100807@usc.edu.ph on November 5, 2025, 4:54 am. If this wasn’t you, please contact the clinic immediately.', 1, '2025-11-04 20:54:33'),
(890, 2, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #65', 1, '2025-11-04 20:56:12'),
(891, 38, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #65', 0, '2025-11-04 20:56:12'),
(892, 51, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #65', 0, '2025-11-04 20:56:12'),
(893, 52, 'Patient Jhon Joseph E. Parchaso has requested a medical certificate for transaction #65', 0, '2025-11-04 20:56:12'),
(897, 28, 'Your medical certificate request from your appointment on November 10, 2025 at 9:00 AM has been approved.', 1, '2025-11-04 21:29:27'),
(898, 28, 'Your appointment (November 5, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-11-04 21:49:40'),
(899, 74, 'Your appointment (November 5, 2025 at 9:00 AM) has been marked as completed. Thank you for visiting!', 1, '2025-11-04 22:07:57'),
(900, 37, 'Patient JJ Parchaso has requested a medical certificate for transaction #81', 0, '2025-11-04 22:12:23'),
(901, 41, 'Patient JJ Parchaso has requested a medical certificate for transaction #81', 1, '2025-11-04 22:12:23'),
(902, 44, 'Patient JJ Parchaso has requested a medical certificate for transaction #81', 0, '2025-11-04 22:12:23'),
(903, 48, 'Patient JJ Parchaso has requested a medical certificate for transaction #81', 0, '2025-11-04 22:12:23'),
(904, 49, 'Patient JJ Parchaso has requested a medical certificate for transaction #81', 0, '2025-11-04 22:12:23'),
(905, 50, 'Patient JJ Parchaso has requested a medical certificate for transaction #81', 0, '2025-11-04 22:12:23'),
(907, 74, 'Your medical certificate request from your appointment on November 5, 2025 at 9:00 AM has been approved.', 1, '2025-11-04 22:47:27'),
(908, 28, 'Your appointment (November 5, 2025 at 10:30 AM) has been marked as completed. Thank you for visiting!', 1, '2025-11-04 23:06:39'),
(909, 37, 'Patient #28 Jhon Joseph E. Parchaso has requested a medical certificate for transaction #82', 0, '2025-11-04 23:07:36'),
(910, 41, 'Patient #28 Jhon Joseph E. Parchaso has requested a medical certificate for transaction #82', 1, '2025-11-04 23:07:36'),
(911, 44, 'Patient #28 Jhon Joseph E. Parchaso has requested a medical certificate for transaction #82', 0, '2025-11-04 23:07:36'),
(912, 48, 'Patient #28 Jhon Joseph E. Parchaso has requested a medical certificate for transaction #82', 0, '2025-11-04 23:07:36'),
(913, 49, 'Patient #28 Jhon Joseph E. Parchaso has requested a medical certificate for transaction #82', 0, '2025-11-04 23:07:36'),
(914, 50, 'Patient #28 Jhon Joseph E. Parchaso has requested a medical certificate for transaction #82', 0, '2025-11-04 23:07:36'),
(916, 28, 'Your medical certificate request from your appointment on November 5, 2025 at 10:30 AM has been approved.', 1, '2025-11-04 23:09:26'),
(917, 28, 'Your appointment on 2025-11-06 at 09:30 was successfully booked!', 1, '2025-11-04 23:11:22'),
(918, 28, 'Your appointment (November 6, 2025 at 9:30 AM) has been marked as completed. Thank you for visiting!', 1, '2025-11-04 23:12:08'),
(919, 28, 'Your medical certificate request from your appointment on November 6, 2025 at 9:30 AM has been approved.', 1, '2025-11-04 23:13:04'),
(920, 75, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-11-04 23:21:12'),
(921, 75, 'Your appointment on 2025-11-06 at 13:00 was successfully booked!', 0, '2025-11-04 23:21:12'),
(922, 75, 'Your appointment on 2025-11-06 at 09:00 was successfully booked!', 0, '2025-11-04 23:22:48'),
(923, 76, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-11-05 20:39:32'),
(924, 76, 'Your appointment on 2025-11-06 at 09:00 was successfully booked!', 0, '2025-11-05 20:39:32'),
(925, 77, 'Welcome to Smile-ify! Your account was created.', 1, '2025-11-07 19:03:18'),
(926, 77, 'Your appointment on 2025-11-10 at 09:00 was successfully booked!', 1, '2025-11-07 19:03:18');

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
  `discount_value` decimal(10,2) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `name`, `image_path`, `description`, `discount_type`, `discount_value`, `date_created`, `date_updated`) VALUES
(1, 'dummy', NULL, '', 'percentage', 0.00, '2025-11-03 04:35:59', '2025-11-03 23:23:44'),
(2, 'after update', NULL, '', 'fixed', 123.00, '2025-11-03 04:35:59', '2025-11-04 01:17:06'),
(3, 'dummy', NULL, '', 'percentage', 0.00, '2025-11-03 04:35:59', '2025-11-03 05:25:58'),
(4, 'sample with date', '/images/promos/promo_4.jpg', 'sample with date', 'fixed', 120.00, '2025-11-03 04:35:59', '2025-11-05 00:16:21'),
(5, 'after update', '/images/promos/promo_5.jpeg', '60 above', 'percentage', 25.00, '2025-11-03 04:35:59', '2025-11-05 07:15:11'),
(6, 'pusok', '/images/promos/promo_6.jpg', 'sample', 'fixed', 500.00, '2025-11-03 04:35:59', '2025-11-03 04:35:59'),
(7, 'sample notif', NULL, '', 'fixed', 50.00, '2025-11-03 04:35:59', '2025-11-03 04:35:59'),
(8, 'sample notif', NULL, '', 'percentage', 50.00, '2025-11-03 04:35:59', '2025-11-03 04:35:59'),
(9, 'sample notif', NULL, '', 'percentage', 500.00, '2025-11-03 04:35:59', '2025-11-03 04:35:59'),
(10, 'owner promo', NULL, '', 'fixed', 0.00, '2025-11-03 04:43:44', '2025-11-03 05:05:25'),
(12, 'new', '/images/promos/promo_12.png', '', 'percentage', 10.00, '2025-11-05 00:17:40', '2025-11-05 01:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `qr_payment`
--

CREATE TABLE `qr_payment` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qr_payment`
--

INSERT INTO `qr_payment` (`id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(1, 'qr_payment.png', '/images/qr/qr_payment.png', '2025-10-31 23:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 45,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `name`, `price`, `duration_minutes`, `date_created`, `date_updated`) VALUES
(1, 'Consultation', 150, 15, '2025-11-03 06:15:30', '2025-11-03 06:29:26'),
(2, 'Tooth Extraction', 500, 45, '2025-11-03 06:15:30', '2025-11-04 01:08:53'),
(3, 'Dental Filling', 1500, 60, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(4, 'Root Canal Treatment', 7000, 120, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(5, 'Dental Crown Placement', 10000, 90, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(6, 'Orthodontic Braces', 45000, 60, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(7, 'Teeth Whitening', 6000, 60, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(8, 'Complete Denture', 15000, 90, '2025-11-03 06:15:30', '2025-11-04 22:36:45'),
(9, 'Partial Denture', 8000, 60, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(10, 'Dental Implant', 70000, 120, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(13, 'Medical Certificate', 150, 0, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(14, 'Shift to Ownerr', 200, 100, '2025-11-03 06:15:30', '2025-11-03 06:15:30'),
(16, 'Impaction', 800, 40, '2025-11-03 06:15:30', '2025-11-05 00:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `service_supplies`
--

CREATE TABLE `service_supplies` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `supply_id` int(11) NOT NULL,
  `quantity_used` varchar(50) NOT NULL DEFAULT '1.00',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_supplies`
--

INSERT INTO `service_supplies` (`id`, `service_id`, `branch_id`, `supply_id`, `quantity_used`, `date_created`, `date_updated`) VALUES
(3, 1, NULL, 1, '5', '2025-10-12 21:20:44', '2025-10-15 04:06:45'),
(4, 3, NULL, 4, '50', '2025-10-12 21:25:53', '2025-10-13 05:25:53'),
(12, 1, 1, 6, '10', '2025-10-18 19:55:10', '2025-10-19 03:55:10'),
(13, 7, 2, 5, '10', '2025-10-18 19:59:28', '2025-10-19 03:59:28'),
(14, 2, 2, 7, '1', '2025-10-18 20:04:47', '2025-10-19 04:04:47'),
(15, 1, 1, 1, '5', '2025-10-18 20:19:51', '2025-10-19 04:19:51'),
(16, 2, 1, 1, '2', '2025-10-18 20:19:51', '2025-10-19 04:19:51');

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
(1, 'cotton', 'mask', 'mask', 'ppe4e'),
(2, 'knife', 'talinis', 'tools', 'taya'),
(3, 'Knife', '', '', ''),
(4, 'sample', '', '', ''),
(5, 'tooth extract knife', '', '', ''),
(6, 'supply with branch', '', '', ''),
(7, 'gunting', '', '', '');

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
  `date_of_birth` varchar(255) NOT NULL,
  `date_of_birth_iv` text DEFAULT NULL,
  `date_of_birth_tag` text DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `contact_number_iv` text DEFAULT NULL,
  `contact_number_tag` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_iv` text DEFAULT NULL,
  `address_tag` text DEFAULT NULL,
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

INSERT INTO `users` (`user_id`, `username`, `password`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `date_of_birth_iv`, `date_of_birth_tag`, `email`, `contact_number`, `contact_number_iv`, `contact_number_tag`, `address`, `address_iv`, `address_tag`, `role`, `branch_id`, `date_started`, `status`, `date_created`, `date_updated`, `force_logout`) VALUES
(1, 'owner01', '$2y$10$YmX8WyBrkWa5.K1su6H4uez6cxNHkIpp4ZYcA/uPytMaVWeI0adD.', 'Arriesgado', '', 'Owner', 'Female', '0000-00-00', NULL, NULL, '18100807@usc.edu.ph', '9998887777', NULL, NULL, 'deca', NULL, NULL, 'owner', NULL, NULL, 'Active', '2025-06-14 10:39:32', '2025-10-05 03:09:00', 0),
(2, 'admin01', '$2y$10$l04Ft/fD3o4E8XBHrHe.vOjpKZ/qIN.OG75zufwNAzkNY15xConea', 'Potot', 'Travero', 'Rix', 'Female', 'efqp0wW/tzrjGQ==', 'XKXArxOBlj1bxWUb', '2gNil49ibu9b3H3F4l527A==', '18102727@usc.edu.ph', 'm6gpXve+N3WiGg==', 'iVfeC97di4o5NiRI', 'lmBkQFhjLFgVbaaiLs4PYA==', '56eDlS5t//QCUf8gOMqAG43hhg==', 'c+8HU04wrQ2sNlaz', 'vHj4uBVuCmtx3RPBc7dpbQ==', 'admin', 1, '2025-09-30', 'Active', '2025-06-14 10:39:32', '2025-11-08 04:17:15', 1),
(3, 'patient01', '$2a$12$RJZbVUZ3JDsUjDB5eFTyiuACuCvxFJyrQI4cE9u8fQ2ChJf/.Srdq', 'Patient', 'Dummy', 'Sample', 'Male', '0000-00-00', NULL, NULL, '', '9123456789', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-06-14 10:39:32', '2025-11-04 21:22:16', 0),
(8, 'ParchasoJ', '$2y$10$9fqT9Gco1CtAKVKu6bSDgeh9SFZbg/bb8GJR5OJrrVIJycPZgqxWC', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', NULL, NULL, '9055626239', 'josephparc', NULL, NULL, NULL, NULL, NULL, 'owner', NULL, NULL, 'Inactive', '2025-07-11 22:27:56', NULL, 0),
(9, 'ParchasoJJ', '$2y$10$W.BXzGapcq9J/oxpk1RHYeaYMxBCz0fSTp8YiRh41YSUebQ12Hjhy', 'Parchaso', 'Joseph', 'Jhon', 'Male', '0000-00-00', NULL, NULL, '9055626239', 'josephparc', NULL, NULL, NULL, NULL, NULL, 'owner', NULL, NULL, 'Inactive', '2025-07-11 22:30:07', NULL, 0),
(10, 'ParchasoJo', '$2y$10$7TtiXyp5duA0k9e0t7nmX.BfdQgpQkYwzUVT8tiCFDY166aCIZFoG', 'Parchaso', '', 'Joseph', 'Male', '0000-00-00', NULL, NULL, '9055626239', 'josephparc', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 22:31:48', '2025-11-04 21:22:16', 0),
(11, 'PototR', '$2y$10$2LodhIAZ8iTEc7e5U8ciM.ERBdKf5t2XTv1enJGrQyxJC501X7DG.', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', NULL, NULL, '9950217941', 'josephparc', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 22:36:13', '2025-11-04 21:22:16', 0),
(12, 'ParchasoJh', '$2y$10$V9IluHOclcF/fELFexGVPOwsPpXLMCpVz6X5tA53PNxqjGUN39XHq', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:10:37', '2025-11-04 21:22:16', 0),
(13, 'asdasdaa', '$2y$10$xx/z0aCzxsgWfhbTyNeT2ewgqLJDF0eA4MIG2KJAh48nLldnoT7mu', 'asdasda', 'dasdads', 'asdasdas', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '3543535353', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:49:00', '2025-11-04 21:22:16', 0),
(14, 'ParchasoJn', '$2y$10$n0Wn8ENlBKZSmFAc8XIo6.8MBB9.vBHC9jj20HU4E4aBg3QzLnJGa', 'Parchaso', 'espana', 'Jhon', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:53:50', '2025-11-04 21:22:16', 0),
(15, 'pototrr', '$2y$10$81epq2ks0nZntMd5BJtQZeTQgwcM1olJw54tWvY3BCS2.WMKgVy6q', 'potot', 'travs', 'rix', 'Female', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '3242424243', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-11 23:57:34', '2025-11-04 21:22:16', 0),
(16, 'PototRi', '$2y$10$upl6ZnCyMKiiML1SFtOANefWYuh0EKOdUDdNDm/i8b/2nExYEXuea', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626339', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 18:37:17', '2025-11-04 21:22:16', 0),
(17, 'PototRx', '$2y$10$/z0.LVx2xEaDvFVmYKUx9Ou3r8cYEg8Iv0aO6lSArBdZbX2e4XJ9m', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 19:04:48', '2025-11-04 21:22:16', 0),
(18, 'parchr', '$2y$10$rBXard1PzWqKnXOsGVbowu8pT1dv11gHFELYhn2UjusTOkR39ZxVS', 'parch', 'potot', 'rix', 'Female', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '3243242343', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:04:53', '2025-11-04 21:22:16', 0),
(19, 'achasg', '$2y$10$pdkklvpmZcbw451FCvkKt.JI14X7dXVExlkqd4e7hAyzunu1KkRjC', 'achas', 'gab', 'gab', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '2423543265', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:31:49', '2025-11-04 21:22:16', 0),
(20, 'rixp', '$2y$10$qBN90ZhgnNkJMH23cBT6uOHqAmlXeUTkkJgaQ.myzXnRwATFWEvma', 'rix', '', 'potot', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '2342412421', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:36:12', '2025-11-04 21:22:16', 0),
(21, 'rixpp', '$2y$10$nvqUzj8gqqY16SHHkt4NQeVQVeU8CQbOaw6u0hhliacSetzJQU6v2', 'rix', '', 'potot', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '2342412421', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:37:27', '2025-11-04 21:22:16', 0),
(22, 'parchj', '$2y$10$sQwUuUFOgllhhPugQds8k.zXlAGrVCiCuTvbcfiCyBBnp4dd8/e3a', 'parch', 'rix', 'jj', 'Female', '0000-00-00', NULL, NULL, '18100807@usc.edu.ph', '2346676887', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:43:04', '2025-11-04 21:22:16', 0),
(23, 'pretotd', '$2y$10$fTfrKDDNlUlfmfVRvYF.xOfaEyRWPo51Ux8aqHtLpDgBlxbWVjxSy', 'pretot', 'chiku', 'daze', 'Female', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '3214325666', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:45:13', '2025-11-04 21:22:16', 0),
(24, '23dfsfs', '$2y$10$jRDx4wuzWruwA6NDUnGnn.XRyS0qYxK16q.20kDMphYGnVcDNlZKK', '23dfsf', 's', 'sdfsfd', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '4326789879', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 21:20:25', '2025-11-04 21:22:16', 0),
(25, 'AchasGG', '$2y$10$csrxQ1iwxHEcfkhQHKf3se586DUSZSK.WhXgNKB39m9js/HfPwuYK', 'Achas', '', 'Gab', 'Male', '0000-00-00', NULL, NULL, '18100807@usc.edu.ph', '0922626262', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 10:25:16', '2025-11-04 21:22:16', 0),
(26, 'DazeP', '$2y$10$du.PYFR4vnJv9ecdNWDox.UUDcjoC0cTUAvtnsnSG.tXwdqn5vLKO', 'Daze', '', 'Pretot', 'Male', '0000-00-00', NULL, NULL, 'parchasoresidence@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 10:33:22', '2025-11-04 21:22:16', 0),
(27, 'ChikuY', '$2y$10$h7C7FiWzWuf7oS0hUaav/OZwJX4rYOExaPk3NJu3O39mmsutOsUvm', 'Chiku', 'Wix', 'Yel', 'Female', '0000-00-00', NULL, NULL, 'parchasoresidence@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 11:14:19', '2025-11-04 21:25:02', 0),
(28, 'Josephp', '$2y$10$khMwye05DtVTpC6ZAgWty.RuaJcGCkH66wideQU4VJxtbA/2wyiLC', 'Parchaso', 'España', 'Jhon Joseph', 'Male', '1999-08-17', NULL, NULL, '18100807@usc.edu.ph', '9055626239', NULL, NULL, 'Block 22, Lot 6, Deca 4 Bankal Lapu Lapu City Cebu', NULL, NULL, 'patient', 1, NULL, 'Active', '2025-07-14 11:26:32', '2025-11-05 07:11:22', 0),
(29, 'pototj', '$2y$10$9Swzre20c9pLQ8ejMr1ySufYwaARXiCYpp8sUXyb5CP1oI7xNjtC2', 'potot', '', 'jj', 'Male', '0000-00-00', NULL, NULL, '18102727@usc.edu.ph', '9527194102', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 15:48:41', '2025-11-04 21:22:16', 0),
(30, 'pret', '$2y$10$z7r/dpwWQ2m.RZK8EcwJGu2MkUM3tRY2EgG/7OyfSubN.bmXm2yTW', 'pre', '', 'tot', 'Male', '0000-00-00', NULL, NULL, '18102727@usc.edu.ph', '9205251545', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-14 16:03:59', '2025-11-04 21:22:16', 0),
(31, 'Parchaso_J', '$2y$10$14IUZVVauGdjCe04vSuVTechUS8.EYYzOO5yZ0Li6Lq/IUhGx0.Ny', 'Parchaso', 'Espana', 'Jhon', 'Female', '0000-00-00', NULL, NULL, '18100807@usc.edu.ph', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:32:30', '2025-11-04 21:22:16', 0),
(32, 'Parchaso_J1', '$2y$10$jhV55n5K2zZw.hoG40uBw.OceefQ5Q8VftYGFBJND/AdBnP7FmhkS', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:38:20', '2025-11-04 21:22:16', 0),
(33, 'Parchaso_J2', '$2y$10$9RhohMzQ7GCr2dSgX02sROUqqX9BhlYPQbvFzTte0bR7nms04U562', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:38:28', '2025-11-04 21:22:16', 0),
(34, 'parchaso_J', '$2y$10$AzXcLMHhefFKyQJfG3lteu/2wKCjJzmhRM4ncT6oSQzhIfEvci9ca', 'parchaso', 'espana', 'jhon', 'Female', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-31 14:54:44', '2025-11-04 21:22:16', 0),
(35, 'Parchhh_J', '$2y$10$BLbxRzDFxMO/QnMcVMpT/OO7r5CYpuSanK4TIMTrLAv6kq7qMy.IG', 'Parchhh', '', 'jj', 'Female', '0000-00-00', NULL, NULL, '18100807@usc.edu.ph', '6515616165', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-08-05 20:06:22', '2025-11-04 21:22:16', 0),
(36, 'asdasd_A', '$2y$10$bMsAKLtfJ1e00emYMAaNWuFrD00n/n5St9zCFqmlbLvlHKoKNOXfS', 'asdasd', '', 'asdads', 'Female', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '2525325425', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-08-09 17:21:09', '2025-11-04 21:22:16', 0),
(37, 'admin_b1_01', '$2a$12$hBbDjdgIHA7jTYk63MoYCevpRg.Wyl.Q9AlF1k22Adu5ZTZ2scPhm', 'Wonderland', 'In', 'Alice', 'Female', 'GVCJknjmojJMVA==', 'LyKSKieS6HYrU+q5', 'VbmGfOB3VurMIOrBFhb1JA==', 'alice.b1@example.com', 'SGt21aYMgVf4Dg==', 'dlXfgESN90Z38D2Z', 'DQF5zCf6IojMT8eX/xi9Mg==', 'mQpSeg==', 'P65p1iydQEfUrLi0', '2WXI7Bwiv5d/Fdu5ENdEKg==', 'admin', 3, '2023-02-11', 'Active', '2025-08-11 18:06:49', '2025-11-08 04:17:58', 1),
(38, 'admin_b1_02', '$2y$10$VjkNImpO91r4.agk0OiAbe3zCy2KtONJdIG1r.v7vjQahYnxZBeCC', 'Admin', 'B1', 'Bob', 'Male', 'Fh5RcgsZ9UEq4g==', '5Lzi9EHuI0ZLUWxr', 'eK5dnhkzF3s6XPgNCl+BZA==', '18100807@usc.edu.ph', '9czeSlNopN9Klw==', '+6MwJUduDyZ4RUUI', 'RtKozRMr2rF4ARhAPFERHw==', 'gwKzbQ==', 'hPZdCuGCSoT6MAj0', 'DDfQVVs6y1l+XSqpML08qg==', 'admin', 1, '2023-12-05', 'Active', '2025-08-11 18:06:49', '2025-11-08 04:18:01', 1),
(39, 'admin_b2_01', '$2y$10$wlYKNKXYGz20lV/338cuRe4GzWH2sl.Jh4T0MEgANGywjrABLMqcK', 'Admin', 'B2', 'Charlie', 'Male', 'qmb8N+5Vx+UtlQ==', '89TfpzojF2YlOxYD', 'sgrZ0OIiL96tpHG7IklxAQ==', '18100807@usc.edu.ph', 'IjGSJtZ0io4HIw==', 'xzU1YeDf973mrFDc', '/i+Bg/EtLTT4DzFQPorztg==', 'VjU+gw==', 'Zp5LJ0XaRi5d5w+M', 'vpsf1RvNdJLalMQ42cnJkA==', 'admin', 2, '2025-09-12', 'Active', '2025-08-11 18:06:49', '2025-11-08 04:18:05', 1),
(40, 'admin_b2_02', '$2a$12$KL9XSfdZh75UuYWljehw0.zNyPK/arJmS7mEzFMvNuK1sBKqLBTLC', 'Admin', 'B2', 'Diana', 'Female', 'oxPps54a9qXd9A==', '6jqf6MKMApCyf/8l', 'eMCHGkDVBfzDTUM96xi+Bw==', 'diana.b2@example.com', '1Gz0b/OA04gk3g==', 'zSQa9Zw9D4/F8y8F', 'Yv8VIhCeUURgLgOTXzAyyA==', 'bs1HYQ==', '0VeszNas8gLmLuo+', 'Moj/GNX5QdVjZhgVfErOdA==', 'admin', 2, '2024-02-20', 'Active', '2025-08-11 18:06:49', '2025-11-08 04:18:14', 1),
(41, 'admin_b3_01', '$2a$12$hNePRteKgF2EC1nNHkhQP..14KMwMN66/t3YzL4.GGbLNPXhS7ksa', 'Admin', 'B33', 'Evan', 'Male', 'B6pB2Ay2bkZQoQ==', '30clH8WANyArpkh+', 'K9mCcnahhgl30i0Sxhzl1w==', '18100807@usc.edu.ph', 'rP9DdmO93w+CXQ==', 'mGVboLSUhDxtko+N', 'kNer/LHrfAEWe2jsv8Lssg==', 'Xs/8zQ==', 'fYhODQNrWHeQ2wXl', '2ewCJqwWhhKqeQ5werD+xw==', 'admin', 3, '2025-02-20', 'Active', '2025-08-11 18:06:49', '2025-11-08 04:18:18', 1),
(42, 'Parchaso_J3', '$2y$10$7nbX35783pFvgW4/mdIuzuSaFhONUt6S5Gw/Aabgd2akXGwfmzwa2', 'Parchaso', 'Espana', 'JJ', 'Male', '0000-00-00', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-08-12 15:18:53', '2025-11-04 21:22:16', 0),
(43, NULL, '$2y$10$aCLfK7EOsfLFyCYFsCDZzO03iVxSaxZ7D9grAp7C1GMnDs2t.YSYi', 'Potot', 'Travero', 'Thamara', 'Female', 'tLdV9WuvmLVyew==', 'VIDC4HCqDMURajBf', 'AVHdZxVomfGR2S+/46/PKw==', 'josephparchaso@gmail.com', 'HMRSVlndyqWX0g==', 'GFdOPGSr4R8X9VUG', 'ykjxWIga37dCPzQlAZffOg==', '+DAUkh1t', 'Z4KhcRDo/95BG5Wo', '1NsumQ6SnWBN8R3aTbd72Q==', 'admin', 2, '2025-09-25', 'Active', '2025-08-30 11:40:50', '2025-11-08 04:18:23', 1),
(44, 'potot_a', '$2y$10$f5shlmN2IMzn1yz/VacRLOjezOmSdU7xPB7kizyd70K0nvpk7e8AK', 'Potot', 'Travero', 'Anna', 'Female', 'idqWYVVP3O8uhw==', 'D1ggdRUzBj6RwChE', 'g9v+uySuMQDCJYVowHrYPw==', 'ana@gmail.com', '2unEviNBnNgDoQ==', 'U4vjR2n1/f8YvKIO', '1ihFX9TWkEnghFwxcZA8JQ==', 'Pg==', 'x0O8vOVZwmQorV9r', 'Owsp/p857u6IrvzOu9I+2w==', 'admin', 3, '2025-09-29', 'Active', '2025-08-30 11:47:27', '2025-11-08 04:18:26', 1),
(45, 'ttvt_K', '$2y$10$avex/XQe4/bbLQTfGq4vsOeLiFV.SANzStRzaEgpZHUr5kLUuJ1Bq', 'ttvt', 'k', 'kggjkj', 'Female', '2025-09-02', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-09-01 10:51:29', '2025-11-04 21:22:16', 0),
(46, 'Achas_J', '$2y$10$YuOFDFrnJFYnE65JjXFChu.WQxRa2okENHtFER9xJPwLN1LM29l1y', 'Achas', 'Pallasigue', 'Joshua Gabriel', 'Male', '1999-04-27', NULL, NULL, 'gabbyachas99@gmail.com', '9260860681', NULL, NULL, 'P-1 Base Camp, Maramag, Bukidnon', NULL, NULL, 'patient', 1, NULL, 'Active', '2025-09-01 10:54:07', '2025-10-18 06:29:42', 0),
(47, 'Parchaso_J4', '$2y$10$Durf8pKbOk2BG6IioMFST.63gUDR4PRITB5mJbdJrOvg6MfdfZRCK', 'Parchaso', 'Espana', 'Jhon', 'Female', '1999-08-17', NULL, NULL, '18100807@usc.edu.ph', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', NULL, NULL, 'Inactive', '2025-09-01 15:43:24', '2025-11-04 21:22:16', 0),
(48, 'Achas_G', '$2y$10$qF68ie3yW6UnvQyTV74O7.zN7PotiUXW0huXAGuMQ5FY4SDxkqXgK', 'Achas', '', 'Gab', 'Male', 'JSIz8LYWSbhlSQ==', 'HqoYLJt0FXgWW1xO', 'Lt/3KtV0xnVHCG754TECRA==', 'josephparchaso@gmail.com', 'OAdwiOzYxHMb3g==', 'O0Sb+00dmIB9ENqp', 'OtCf9WjOG6DWNYS8YNkz3A==', 'R2tZMQ==', 'cb4YciRkZ4yWkJCB', 'esNu6oRVW8K3+7XjPObzHA==', 'admin', 3, '2025-09-09', 'Active', '2025-09-07 21:54:27', '2025-11-08 04:18:35', 1),
(49, 'asd_A', '$2y$10$mWpr.dorheR9kWYUjq71n.DYPE98YkIwheXxDpRFejM88d6GLslRq', 'asd', 'asd', 'asd', 'Female', 'C3Dzm7vmXjsLtw==', 'FZq0F1+fyubSXAVW', 'sRYf/7i7j8/vkUrdr8CWLQ==', 'josephparchasooo@gmail.com', 'UpwzOJikoMaGsA==', 'MnzUsl+a2kyr1ked', 'jjRnoXn8YIlYXcEeZc27og==', 'kQ==', '+bBV+50vblAz766T', 'URNqou8McJnr2FoSaa///w==', 'admin', 3, '2025-09-24', 'Active', '2025-09-07 21:56:18', '2025-11-08 04:18:48', 1),
(50, 'parch_J', '$2y$10$Pnho0/H8Abi2ZzJcSapU8.5YBJJKsLidoJAr1uCfibTzM9MHLZx82', 'parch', '', 'jj', 'Female', 'fm7slnLdUFL9Tw==', 'hYJl2IGDipv/QCMR', 'S7cp/APHNDE0m6nJslOa/g==', '21313@gmail.com', '0PnmtcwVkCAFAw==', 'lVKWWu29Bilkxvy5', 'lgb0v/w1G4DOTAy19+YObA==', 'WFE=', 'YmAkX6pqrV5PNA5g', 'zm2j00QZkKMX1pdfdxSKKQ==', 'admin', 3, '2025-11-01', 'Active', '2025-09-07 22:00:07', '2025-11-08 04:18:53', 1),
(51, 'adny_A', '$2y$10$7KPScD0EP86YwVfwAxj7tu50e5rO1dDFfSm1SmjYg1dL66SUDS3QC', 'adny', '', 'adsa', 'Female', '2025-09-09', NULL, NULL, 'j@gmail.com', '1324412414', NULL, NULL, '0', NULL, NULL, 'admin', 1, '2025-09-24', 'Active', '2025-09-07 22:03:04', NULL, 0),
(52, 'potot_R', '$2y$10$mnp55PKAKO0Yawgeg2FWqeE4ejo9aK2RCto5E2EtfWHSY6IqNKwjK', 'potot', '', 'rix', 'Male', '2025-09-02', NULL, NULL, 'asd@gmail.com', '1243141414', NULL, NULL, 'deca', NULL, NULL, 'admin', 1, '2025-09-24', 'Active', '2025-09-07 22:05:06', NULL, 0),
(53, 'bakol_K', NULL, 'bakol', '', 'kolad', 'Male', '2025-09-16', NULL, NULL, 'kolado@yahoo.com', '3454353453', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Inactive', '2025-09-16 19:05:45', '2025-11-04 21:25:02', 0),
(54, 'Tan_P', '$2y$10$TZkHD748QzNkgjjvZNpUzOHXTunwayEU9J38.Net11EtuWWWd9lY6', 'Tan', '', 'Pilep', 'Male', '2025-09-11', NULL, NULL, 'josephparchaso@gmail.com', '1231313131', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Active', '2025-09-16 19:22:37', '2025-11-02 04:35:15', 0),
(55, 'sample_S', '$2y$10$DUoVBSk0sV7WTwlLBWmCTu443Nb4FEOe0kwHt0dMfzRJgTlVoBf8O', 'sample', '', 'sample', 'Male', '2025-09-11', NULL, NULL, 'josephparchaso@gmail.com', '1242141414', NULL, NULL, NULL, NULL, NULL, 'patient', 2, NULL, 'Inactive', '2025-09-17 19:45:22', '2025-11-04 21:25:02', 0),
(56, 'Baloy_P', '$2y$10$otDsje.SDYSmiPOSxDfL4OpsQrpLXttB.YPiU7CEBmpuC99J5GsMe', 'Baloy', '', 'Parkley', 'Female', '2025-09-20', NULL, NULL, '18100807@usc.edu.ph', '2114142141', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Inactive', '2025-09-17 22:48:49', '2025-11-04 21:25:02', 0),
(57, 'baloy_B', '$2y$10$48Dxhg4z5kXu7q92qHbMpOqVneCyNkz5Q97epVC0h6yWy.kG8TSG2', 'baloy', '', 'bal', 'Male', '2025-09-24', NULL, NULL, 'josephparchaso@gmail.com', '1243124214', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Inactive', '2025-09-21 22:05:17', '2025-11-04 21:25:02', 0),
(58, 'sampol_T', '$2y$10$xQ1hKR5T9gbf3p7QaHxEYeucqrF6WY.bRISoAGpUt2E7cIVzxsPu2', 'sampol', '', 'time', 'Female', '2025-09-24', NULL, NULL, 'josephparchaso@gmail.com', '1241241421', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Inactive', '2025-09-22 19:59:12', '2025-11-04 21:25:02', 0),
(59, 'tanggol_C', '$2y$10$N4I./LHIANvKF6TQHpHjmu6Zqw95L6L5ZOC3gdGKd7Q.NgpTWohB2', 'tanggol', '', 'coco', 'Male', '2025-09-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Inactive', '2025-09-22 22:01:09', '2025-11-04 21:25:02', 0),
(60, 'Potot_R', '$2y$10$nA2OkSxEr5YigHd7z1dyme/5S1fKnqylLBfjyZDU6J0bAsINMlDSK', 'Potot', 'Travero', 'Rixielie', 'Female', '2000-05-01', NULL, NULL, 'theartp1@gmail.com', '9950217794', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Inactive', '2025-09-24 07:32:21', '2025-11-04 21:25:02', 0),
(61, 'Achas_G1', '$2y$10$2UgaJgb8A5u2GVZxd6t2L.rzDbiHr/hOCYAa7cMBUYLailvn4DLO2', 'Achas', '', 'Gab', 'Male', '2025-09-11', NULL, NULL, 'theartp1@gmail.com', '9995565656', NULL, NULL, 'Talamban, Cebu', NULL, NULL, 'admin', 6, '2025-09-25', 'Active', '2025-09-24 08:29:54', NULL, 0),
(62, 'sample_N', '$2y$10$JcC4qR0GrbSJwN3qumrrQ.CAx73H5uJp04/ovAdibHp3LC6uQB2qu', 'sample', '', 'new this month', 'Female', '2025-10-02', NULL, NULL, 'josephparchaso@gmail.com', '9099999999', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Active', '2025-10-06 20:35:12', '2025-10-10 07:01:08', 0),
(63, 'sample_N1', '$2y$10$Z36eCMjXyihSWAhgCu3RCeDQEzjrvdgpt9SfsWE9XpOsPRo359VUS', 'sample', '', 'new branch 3', 'Female', '2025-10-05', NULL, NULL, 'josephparchaso@gmail.com', '9999999999', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Active', '2025-10-06 20:41:29', '2025-10-10 07:01:01', 0),
(65, 'Potot_R1', '$2y$10$1VzUpAI9j/Wsdrn0FG5nxekjIr.v1jyUiQpMMjYlRUj532JJrNbge', 'Potot', '', 'Rix', 'Male', '1999-08-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Active', '2025-10-08 16:23:20', '2025-10-10 07:01:25', 0),
(66, 'Parch_J', '$2y$10$7t7tXfYO/B5uiYNNFWG3ueDZi.fpYsLXIKtkP7f02vdJS7DUsUyWi', 'Parch', '', 'jj', 'Male', '1999-08-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Active', '2025-10-08 16:31:23', '2025-10-14 01:14:40', 0),
(67, 'Parchaso_J5', '$2y$10$Oi0BTVNoFJ90sffqMBKgTu3Rdd/qZ8yENcF1cdlXjPmCKH/PfDEeO', 'Parchaso', '', 'Jhon', 'Male', '1999-08-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 2, NULL, 'Active', '2025-10-08 16:37:26', '2025-10-10 06:59:24', 0),
(68, 'sample_S1', '$2y$10$DTIZiqKaZsEtNZV1NSXx3uUnGuWNm3ZHe1OVo3sIV1DccVHnX4KHu', 'sample', '', 's', 'Female', '2025-10-02', NULL, NULL, 'josephparchaso@gmail.com', '1111111111', NULL, NULL, NULL, NULL, NULL, 'patient', 2, NULL, 'Active', '2025-10-08 17:26:21', '2025-10-10 07:01:44', 0),
(69, 'Potot_R2', '$2y$10$kwQu8l/Su06.WWUkZhpPXuwEo2n.Y2xZ6kUd5sVZYgB8DlYYv6s7u', 'Potot', 'Travero', 'Rixielie Marie', 'Female', '2000-04-05', NULL, NULL, '18102727@usc.edu.ph', '9950217941', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Active', '2025-10-08 17:44:24', '2025-10-18 06:28:37', 0),
(70, 'Parchaso_J6', '$2y$10$ZoLg67t.ql.SR9ntFRi9gOq96nxTMwIjLjLiEcLFCv/johYD9ub56', 'Parchaso', 'Espana', 'Jhon Joseph', 'Male', '1999-08-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Active', '2025-10-08 18:12:00', '2025-10-10 06:59:33', 0),
(71, 'Potot_M', '$2y$10$OVBiIvEffSKsK3kpPGcE..VcGUOWLrvdv2ypA4B/b7QEB0qLHDPxa', 'Potot', '', 'Maya', 'Male', '1999-08-08', NULL, NULL, 'josephparchaso@gmail.com', '1111111111', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Active', '2025-10-09 21:25:06', '2025-10-10 06:59:55', 0),
(72, 'Achas_J1', '$2y$10$ia9CtkXnG4/9557H0jS3vOik0LaPczHtsa7GfaFBzPbBYeJEwmmQK', 'Achas', '', 'Josh', 'Male', '1999-08-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 1, NULL, 'Active', '2025-10-14 16:22:41', '2025-10-15 03:26:57', 0),
(73, 'Potot_R3', '$2y$10$8m4eid2DSSHOL7pQGVi1N.wCBX7prGyzP4vNOxNEXk2fwSK0OTVIy', 'Potot', 'Daronday', 'Richard', 'Male', '1958-07-22', NULL, NULL, 'theartp1@gmail.com', '9950217944', NULL, NULL, 'San Miguel, Cordova', NULL, NULL, 'patient', 3, NULL, 'Active', '2025-10-24 06:01:06', '2025-11-04 01:13:45', 0),
(74, 'Parchaso_J7', '$2y$10$oR4UaFYaTCUy03TIUQg2jeCbz/DgbwVDoBsAM0mkzU9F3SkMsGhey', 'Parchaso', '', 'JJ', 'Male', '1999-08-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Active', '2025-11-04 17:31:14', NULL, 0),
(75, 'Lebron_J', '$2y$10$zQa19q.IWvvBgFVP9Wt.bO1a7U1CI5Swffs8SB7WXcNXKQS38sP8a', 'Lebron', '', 'James', 'Male', '1999-08-17', NULL, NULL, 'josephparchaso@gmail.com', '9055626239', NULL, NULL, NULL, NULL, NULL, 'patient', 3, NULL, 'Active', '2025-11-04 23:21:12', '2025-11-05 07:22:48', 0),
(76, 'Parchaso_E', '$2y$10$6jV6YYiQDZYWIE0MfsVHWO.ekReXLXXUCsIXIbP/Jj0jp5pP4aTdG', 'Parchaso', '', 'encrypt', 'Male', 'mMqOD9NlVZ0/rg==', 'nT+AVctOpcS8qLPq', '/22BlPMCMreyqeYfpCQ6zA==', '18100807@usc.edu.ph', 'kH9f6SxUM0CC5w==', '8bJCtNgbMhEuB0uz', 'EFb7x5qd1Py5IWmv8gQctQ==', 'I42uOzEGLknfs287ddk=', 'Nt5t4+huWReLmlOB', 'BWTcAGZ8w6kF67yUvcDdtw==', 'patient', 2, NULL, 'Active', '2025-11-05 20:39:32', '2025-11-06 05:20:32', 0),
(77, 'Potot_R4', '$2y$10$3pUNfGUbEwFpSYbyRJoL..UJ9CGOghC51iOB/kFpryXUMJaU8QkJ.', 'Potot', '', 'Rixielie', 'Female', 'ZU8EXl5b6wU99Q==', 'qycs10kyxDFOHsrm', 'sSaolZWQ6B2rqmt+4/ni+A==', '18102727@usc.edu.ph', 'qaiENWhXOFvd6Q==', 'HBaQPM7fStAKsiaw', 'lFUvpv8IqjAMYQYz2GGdgg==', 's14KGvOfcC3zSa0Vp7qEXML9vDiutmJPFo5pbw==', 'nJaRUhKVxzkDyY+G', '8/bd1zwC3f3fXZ0lgNNA3A==', 'patient', 1, NULL, 'Active', '2025-11-07 19:03:18', '2025-11-08 03:04:56', 0),
(78, 'Encrpytion_E', '$2y$10$19QyD8pPrTmrqW3RmX7a1O2Hi.UM78ctjO9O7cJeBops5YGKiJjUe', 'Encrpytion', 'espanaa', 'Encrpyt', 'Male', 'Ob1UYrPq1eE6Uw==', 'HNF1owYs/On/BffK', 'VEBZyimT/34AYV8RDNzQVw==', 'josephparchaso@gmail.com', 'soTNRue4AUQaDw==', 'W+3Dx3S31x7Nl2tm', '2ube8G4sb7JqDUroqqHYxQ==', 'WooZkfqYrG+LOgSKsfREvGg=', 'mYIMj0iH6EnXHwMc', 'owhBwXRGMKNuT3wXoKMb4Q==', 'admin', 6, '2025-11-10', 'Active', '2025-11-07 19:20:37', '2025-11-08 03:58:05', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD PRIMARY KEY (`appointment_services_id`),
  ADD KEY `appointment_transaction_id` (`appointment_transaction_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `appointment_transaction`
--
ALTER TABLE `appointment_transaction`
  ADD PRIMARY KEY (`appointment_transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `dentist_id` (`dentist_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `branch_announcements`
--
ALTER TABLE `branch_announcements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcement_id` (`announcement_id`,`branch_id`),
  ADD KEY `fk_branch_announcements_branch` (`branch_id`);

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
  ADD KEY `appointment_transaction_id` (`appointment_transaction_id`),
  ADD KEY `fk_prescription_admin` (`admin_user_id`);

--
-- Indexes for table `dental_tips`
--
ALTER TABLE `dental_tips`
  ADD PRIMARY KEY (`tip_id`);

--
-- Indexes for table `dental_transaction`
--
ALTER TABLE `dental_transaction`
  ADD PRIMARY KEY (`dental_transaction_id`),
  ADD KEY `appointment_transaction_id` (`appointment_transaction_id`),
  ADD KEY `dentist_id` (`dentist_id`),
  ADD KEY `fk_dental_transaction_promo` (`promo_id`),
  ADD KEY `fk_dental_transaction_admin` (`admin_user_id`);

--
-- Indexes for table `dental_transaction_services`
--
ALTER TABLE `dental_transaction_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dental_transaction_id` (`dental_transaction_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `dental_vital`
--
ALTER TABLE `dental_vital`
  ADD PRIMARY KEY (`vitals_id`),
  ADD KEY `appointment_transaction_id` (`appointment_transaction_id`),
  ADD KEY `fk_vital_admin` (`admin_user_id`);

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
-- Indexes for table `qr_payment`
--
ALTER TABLE `qr_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_supplies`
--
ALTER TABLE `service_supplies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_supplies_service` (`service_id`),
  ADD KEY `fk_service_supplies_supply` (`supply_id`),
  ADD KEY `fk_service_supplies_branch` (`branch_id`);

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
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appointment_services`
--
ALTER TABLE `appointment_services`
  MODIFY `appointment_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `appointment_transaction`
--
ALTER TABLE `appointment_transaction`
  MODIFY `appointment_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `branch_announcements`
--
ALTER TABLE `branch_announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch_promo`
--
ALTER TABLE `branch_promo`
  MODIFY `branch_promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `branch_service`
--
ALTER TABLE `branch_service`
  MODIFY `branch_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `branch_supply`
--
ALTER TABLE `branch_supply`
  MODIFY `branch_supplies_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dental_prescription`
--
ALTER TABLE `dental_prescription`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dental_tips`
--
ALTER TABLE `dental_tips`
  MODIFY `tip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dental_transaction`
--
ALTER TABLE `dental_transaction`
  MODIFY `dental_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `dental_transaction_services`
--
ALTER TABLE `dental_transaction_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `dental_vital`
--
ALTER TABLE `dental_vital`
  MODIFY `vitals_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `dentist`
--
ALTER TABLE `dentist`
  MODIFY `dentist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dentist_branch`
--
ALTER TABLE `dentist_branch`
  MODIFY `dentist_branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `dentist_service`
--
ALTER TABLE `dentist_service`
  MODIFY `dentist_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=927;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `qr_payment`
--
ALTER TABLE `qr_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `service_supplies`
--
ALTER TABLE `service_supplies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `supply`
--
ALTER TABLE `supply`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD CONSTRAINT `appointment_services_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `appointment_transaction`
--
ALTER TABLE `appointment_transaction`
  ADD CONSTRAINT `appointment_transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `appointment_transaction_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `appointment_transaction_ibfk_4` FOREIGN KEY (`dentist_id`) REFERENCES `dentist` (`dentist_id`);

--
-- Constraints for table `branch_announcements`
--
ALTER TABLE `branch_announcements`
  ADD CONSTRAINT `fk_branch_announcements_announcement` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`announcement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_branch_announcements_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `dental_prescription_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`),
  ADD CONSTRAINT `fk_prescription_admin` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dental_transaction`
--
ALTER TABLE `dental_transaction`
  ADD CONSTRAINT `dental_transaction_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`),
  ADD CONSTRAINT `dental_transaction_ibfk_2` FOREIGN KEY (`dentist_id`) REFERENCES `dentist` (`dentist_id`),
  ADD CONSTRAINT `fk_dental_transaction_admin` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dental_transaction_promo` FOREIGN KEY (`promo_id`) REFERENCES `promo` (`promo_id`) ON DELETE SET NULL;

--
-- Constraints for table `dental_transaction_services`
--
ALTER TABLE `dental_transaction_services`
  ADD CONSTRAINT `dental_transaction_services_ibfk_1` FOREIGN KEY (`dental_transaction_id`) REFERENCES `dental_transaction` (`dental_transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dental_transaction_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`);

--
-- Constraints for table `dental_vital`
--
ALTER TABLE `dental_vital`
  ADD CONSTRAINT `dental_vital_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`),
  ADD CONSTRAINT `fk_vital_admin` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
