-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 02:53 AM
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
  `status` enum('Pending','Completed','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_transaction`
--

INSERT INTO `appointment_transaction` (`appointment_transaction_id`, `user_id`, `branch_id`, `service_id`, `dentist_id`, `appointment_date`, `appointment_time`, `notes`, `date_created`, `status`) VALUES
(1, 10, 3, 5, 4, '2025-07-18', '15:00:00', '', '2025-07-11 22:31:48', 'Completed'),
(2, 11, 3, 8, NULL, '2025-07-18', '12:00:00', '', '2025-07-11 22:36:13', 'Completed'),
(3, 12, 1, 1, 3, '2025-07-18', '09:00:00', '', '2025-07-11 23:10:37', 'Completed'),
(4, 13, 1, 1, 3, '2025-08-07', '13:30:00', '', '2025-07-11 23:49:00', 'Completed'),
(5, 14, 1, 1, 3, '2025-07-18', '09:00:00', '', '2025-07-11 23:53:50', 'Completed'),
(6, 15, 1, 5, 3, '2025-07-19', '12:45:00', '', '2025-07-11 23:57:34', 'Completed'),
(7, 16, 1, 5, 3, '2025-07-25', '12:00:00', '', '2025-07-12 18:37:17', 'Completed'),
(8, 17, 1, 1, 1, '2025-08-01', '14:15:00', '', '2025-07-12 19:04:48', 'Completed'),
(9, 18, 1, 1, 1, '2025-07-22', '09:00:00', '', '2025-07-12 20:04:53', 'Completed'),
(10, 19, 1, 1, 1, '2025-07-17', '12:45:00', '', '2025-07-12 20:31:49', 'Completed'),
(11, 20, 1, 1, 3, '2025-07-23', '13:30:00', '', '2025-07-12 20:36:12', 'Completed'),
(12, 21, 1, 1, 3, '2025-07-23', '13:30:00', '', '2025-07-12 20:37:27', 'Completed'),
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
(26, 28, 1, 1, 1, '2025-07-24', '12:00:00', '', '2025-07-21 20:30:32', 'Cancelled'),
(27, 28, 2, 8, 3, '2025-07-31', '10:30:00', '', '2025-07-24 15:58:38', 'Cancelled'),
(28, 31, 1, 1, 1, '2025-08-02', '12:45:00', '', '2025-07-31 14:32:30', 'Completed'),
(29, 32, 2, 6, 2, '2025-08-16', '11:15:00', '', '2025-07-31 14:38:20', 'Completed'),
(30, 33, 2, 6, 2, '2025-08-16', '11:15:00', '', '2025-07-31 14:38:28', 'Completed'),
(31, 34, 2, 6, 2, '2025-08-01', '10:30:00', '', '2025-07-31 14:54:44', 'Completed'),
(32, 35, 3, 1, 1, '2025-08-29', '15:00:00', '', '2025-08-05 20:06:22', 'Pending'),
(33, 36, 2, 8, 3, '2025-08-12', '14:15:00', '', '2025-08-09 17:21:09', 'Completed'),
(34, 42, 3, 1, 1, '2025-08-18', '15:00:00', '', '2025-08-12 15:18:53', 'Completed'),
(35, 28, 3, 7, 4, '2025-08-27', '15:00:00', '', '2025-08-19 20:55:36', 'Pending'),
(36, 28, 2, 2, 2, '2025-08-29', '15:00:00', 'sample note', '2025-08-23 18:39:11', 'Pending'),
(37, 45, 1, 1, 3, '2025-09-09', '11:15:00', 'hhff', '2025-09-01 10:51:29', 'Pending'),
(38, 46, 2, 2, 2, '2025-09-05', '09:00:00', 'Need t extract', '2025-09-01 10:54:07', 'Pending'),
(39, 47, 2, 10, 3, '2025-09-04', '15:00:00', '', '2025-09-01 15:43:24', 'Pending'),
(40, 28, 2, 10, 3, '2025-09-12', '10:30:00', '', '2025-09-07 19:43:36', 'Pending'),
(41, 28, 1, 1, 1, '2025-09-11', '10:30:00', '', '2025-09-07 19:44:03', 'Pending'),
(42, 28, 1, 5, NULL, '2025-09-12', '09:45:00', '', '2025-09-07 19:47:38', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `name`) VALUES
(1, 'Babag'),
(2, 'Pusok'),
(3, 'Mandaue');

-- --------------------------------------------------------

--
-- Table structure for table `branch_service`
--

CREATE TABLE `branch_service` (
  `branch_services_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_service`
--

INSERT INTO `branch_service` (`branch_services_id`, `branch_id`, `service_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 6),
(7, 2, 7),
(8, 2, 8),
(9, 2, 9),
(10, 2, 10),
(11, 3, 1),
(12, 3, 2),
(13, 3, 3),
(14, 3, 4),
(15, 3, 5),
(16, 3, 6),
(17, 3, 7),
(18, 3, 8),
(19, 3, 9),
(20, 3, 10),
(21, 2, 2);

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
  `instructions` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dental_prescription`
--

INSERT INTO `dental_prescription` (`prescription_id`, `appointment_transaction_id`, `drug`, `route`, `frequency`, `dosage`, `duration`, `instructions`, `date_created`) VALUES
(1, 21, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', 'Take after meals', '2025-08-23 18:54:01'),
(2, 21, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '3 days', 'For pain, take only when needed', '2025-08-23 18:54:01'),
(3, 22, 'Ibuprofen', 'Oral', '2x/day', '400mg', '5 days', 'Take after meals', '2025-08-23 18:54:01'),
(4, 23, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', 'Do not swallow', '2025-08-23 18:54:01'),
(5, 24, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', 'Take after meals', '2025-08-23 18:54:01'),
(6, 24, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', 'For pain and fever', '2025-08-23 18:54:01'),
(7, 25, 'Clindamycin', 'Oral', '3x/day', '300mg', '7 days', 'Use if allergic to penicillin', '2025-08-23 18:54:01'),
(8, 27, 'Sodium Fluoride Gel', 'Topical', '1x/day', 'Thin layer', '14 days', 'Apply at night before bed', '2025-08-23 18:54:01'),
(9, 28, 'Amoxicillin', 'Oral', '3x/day', '500mg', '7 days', 'Take after meals', '2025-08-23 18:54:01'),
(10, 28, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '5 days', 'Take only when needed', '2025-08-23 18:54:01'),
(11, 28, 'Paracetamol', 'Oral', '3x/day', '500mg', '5 days', 'Alternate with Mefenamic Acid if severe pain', '2025-08-23 18:54:01'),
(12, 24, 'Ibuprofen', 'Oral', '3x/day', '400mg', '5 days', 'Take after meals for pain and inflammation', '2025-09-07 19:57:34'),
(13, 24, 'Mefenamic Acid', 'Oral', '3x/day', '500mg', '5 days', 'Take only when needed for severe pain', '2025-09-07 19:57:34'),
(14, 24, 'Chlorhexidine Mouthwash', 'Oral Rinse', '2x/day', '15ml', '7 days', 'Rinse for 30 seconds, do not swallow', '2025-09-07 19:57:34'),
(15, 24, 'Prednisone', 'Oral', '1x/day', '10mg', '3 days', 'Take in the morning to reduce swelling', '2025-09-07 19:57:34'),
(16, 24, 'Metronidazole', 'Oral', '3x/day', '500mg', '7 days', 'Take after meals, avoid alcohol', '2025-09-07 19:57:34');

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
(1, 21, 3, 1500.00, 'Yes', 'No', 'No', 'Tooth #12 extraction, mild swelling.', '2025-08-23 19:37:15', 1),
(2, 22, 3, 2000.00, 'No', 'Yes', 'No', 'Tooth filling, slight sensitivity.', '2025-08-23 19:37:15', 1),
(3, 23, 1, 1200.00, 'No', 'No', 'No', 'Routine cleaning, no complications.', '2025-08-23 19:37:15', 1),
(4, 24, 4, 1800.00, 'Yes', 'No', 'Yes', 'Wisdom tooth removal, moderate bleeding.', '2025-08-23 19:37:15', 1),
(5, 25, 3, 2500.00, 'No', 'No', 'No', 'Root canal treatment, stable condition.', '2025-08-23 19:37:15', 1),
(8, 28, 1, 3000.00, 'Yes', 'Yes', 'Yes', 'Complex surgical extraction with swelling & bleeding.', '2025-08-23 19:37:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dental_vitals`
--

CREATE TABLE `dental_vitals` (
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
-- Dumping data for table `dental_vitals`
--

INSERT INTO `dental_vitals` (`vitals_id`, `appointment_transaction_id`, `body_temp`, `pulse_rate`, `respiratory_rate`, `blood_pressure`, `height`, `weight`, `date_created`) VALUES
(1, 21, 36.7, 72, 18, '120/80', 168.00, 65.00, '2025-08-23 18:53:50'),
(2, 22, 37.2, 80, 20, '130/85', 175.00, 70.00, '2025-08-23 18:53:50'),
(3, 23, 36.5, 70, 19, '115/75', 160.00, 55.00, '2025-08-23 18:53:50'),
(4, 24, 37.0, 76, 18, '118/78', 165.00, 60.00, '2025-08-23 18:53:50'),
(5, 25, 36.8, 74, 17, '122/82', 172.00, 68.00, '2025-08-23 18:53:50'),
(6, 26, 37.1, 82, 21, '135/90', 178.00, 80.00, '2025-08-23 18:53:50'),
(7, 27, 36.6, 68, 16, '110/70', 158.00, 50.00, '2025-08-23 18:53:50'),
(8, 28, 37.3, 85, 22, '140/95', 182.00, 85.00, '2025-08-23 18:53:50');

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
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentist`
--

INSERT INTO `dentist` (`dentist_id`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `email`, `contact_number`, `license_number`, `date_started`, `status`, `signature_image`, `date_created`) VALUES
(1, 'Ulanday', 'Mansanitas', 'Precious', 'Female', '2025-01-02', 'precious@gmail.com', '9789321654', 'LIC-100111', '2023-01-15', 'Active', '68be0b0fa22c2_pretot.png', '2025-07-11 19:40:26'),
(2, 'Chan', 'Marie', 'Kyla', 'Female', '2025-08-29', 'kyla.marie@gmail.com', '2112321321', 'LIC-1002', '2023-02-10', 'Active', '68be0b1e6d278_chiku.png', '2025-07-11 19:40:26'),
(3, 'Summers', '', 'Daze', 'Female', '2025-09-09', 'daze@gmail.com', '0912345680', 'LIC-1003', '2023-03-05', 'Active', '68be0b26e6fc2_daze.png', '2025-07-11 19:40:26'),
(4, 'San Jose', '', 'Solene', 'Female', '2025-09-12', 'solene@gmail.com', '0912345681', 'LIC-1004', '2023-04-01', 'Active', '68be0b34297fb_sol.png', '2025-07-11 19:40:26'),
(5, 'San Jose', 'Codm', 'Yel', 'Female', '2025-09-04', 'yel@gmail.com', '9123456789', 'LIC-100322', '2023-05-20', 'Active', '68be0b3d5870b_yel.png', '2025-08-30 00:24:25'),
(6, 'Achas', '', 'Gab', 'Male', '2025-08-02', 'achas@gmail.com', '7864515665', '123123', '0000-00-00', 'Active', NULL, '2025-08-30 12:07:53'),
(7, 'Menano', '', 'Andy', 'Male', '2025-08-29', 'adny@gmail.com', '8756465486', '123321', '0000-00-00', 'Inactive', NULL, '2025-08-30 12:17:41'),
(8, 'asd', 'sad', 'asdas', 'Female', '2025-09-08', 'asd@sad.casd', '1241421241', '1221211', '0000-00-00', 'Inactive', '68be08a6d924a_gary-vaynerchuk-signature-0.png', '2025-09-07 22:35:18');

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
(20, 3, 1),
(21, 3, 3),
(22, 3, 2),
(28, 2, 3),
(29, 2, 2),
(35, 7, 3),
(74, 1, 1),
(75, 1, 2),
(76, 1, 3),
(77, 8, 2);

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
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 6),
(5, 3, 1),
(6, 3, 2),
(7, 3, 3),
(8, 3, 4),
(9, 3, 5),
(10, 3, 6),
(11, 3, 7),
(12, 3, 8),
(13, 3, 9),
(14, 3, 10),
(15, 4, 5),
(16, 4, 7);

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
(55, 1, 'Your password was changed successfully on August 21, 2025, 6:44 am. If this wasn’t you, please contact support immediately.', 0, '2025-08-20 22:44:20'),
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
(69, 2, 'Your password was successfully reset on September 8, 2025, 6:12 am. If this wasn’t you, please contact support immediately.', 0, '2025-09-07 22:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `name`, `price`, `status`, `date_created`) VALUES
(1, 'Consultation', 0, 'active', '2025-07-11 19:08:44'),
(2, 'Tooth Extraction', 0, 'active', '2025-07-11 19:08:44'),
(3, 'Dental Filling', 0, 'active', '2025-07-11 19:08:44'),
(4, 'Root Canal Treatment', 0, 'active', '2025-07-11 19:08:44'),
(5, 'Dental Crown Placement', 0, 'active', '2025-07-11 19:08:44'),
(6, 'Orthodontic Braces', 0, 'active', '2025-07-11 19:08:44'),
(7, 'Teeth Whitening', 0, 'active', '2025-07-11 19:08:44'),
(8, 'Complete Denture', 0, 'active', '2025-07-11 19:08:44'),
(9, 'Partial Denture', 0, 'active', '2025-07-11 19:08:44'),
(10, 'Dental Implant', 0, 'active', '2025-07-11 19:08:44');

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
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `email`, `contact_number`, `address`, `role`, `branch_id`, `date_started`, `status`, `date_created`) VALUES
(1, 'owner01', '$2y$10$EABxPBtN.h3tZJ635PA61.HsgAlxeTn6bZWxOA4hXTkYX/Ls9pLi.', 'Owner', 'Dummy', 'Sample', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9998887777', 'decaasdad', 'owner', NULL, NULL, 'Active', '2025-06-14 10:39:32'),
(2, 'admin01', '$2y$10$fs8iUS2ahGMXZyNsC5C7.uVfOyG.ele6uTjXyrto46PUVFIYcnnEa', 'Potot', 'Travero', 'Rix', 'Female', '2000-04-05', '18102727@usc.edu.ph', '9950217941', 'San Miguel, Cordovaa', 'admin', 1, '2025-08-17', 'Active', '2025-06-14 10:39:32'),
(3, 'patient01', '$2a$12$RJZbVUZ3JDsUjDB5eFTyiuACuCvxFJyrQI4cE9u8fQ2ChJf/.Srdq', 'Patient', 'Dummy', 'Sample', 'Male', '0000-00-00', '', '9123456789', NULL, 'patient', NULL, NULL, 'Active', '2025-06-14 10:39:32'),
(8, 'ParchasoJ', '$2y$10$9fqT9Gco1CtAKVKu6bSDgeh9SFZbg/bb8GJR5OJrrVIJycPZgqxWC', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', '9055626239', 'josephparc', NULL, 'owner', NULL, NULL, 'Active', '2025-07-11 22:27:56'),
(9, 'ParchasoJJ', '$2y$10$W.BXzGapcq9J/oxpk1RHYeaYMxBCz0fSTp8YiRh41YSUebQ12Hjhy', 'Parchaso', 'Joseph', 'Jhon', 'Male', '0000-00-00', '9055626239', 'josephparc', NULL, 'owner', NULL, NULL, 'Active', '2025-07-11 22:30:07'),
(10, 'ParchasoJo', '$2y$10$7TtiXyp5duA0k9e0t7nmX.BfdQgpQkYwzUVT8tiCFDY166aCIZFoG', 'Parchaso', '', 'Joseph', 'Male', '0000-00-00', '9055626239', 'josephparc', NULL, 'patient', NULL, NULL, 'Active', '2025-07-11 22:31:48'),
(11, 'PototR', '$2y$10$2LodhIAZ8iTEc7e5U8ciM.ERBdKf5t2XTv1enJGrQyxJC501X7DG.', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', '9950217941', 'josephparc', NULL, 'patient', NULL, NULL, 'Active', '2025-07-11 22:36:13'),
(12, 'ParchasoJh', '$2y$10$V9IluHOclcF/fELFexGVPOwsPpXLMCpVz6X5tA53PNxqjGUN39XHq', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-11 23:10:37'),
(13, 'asdasdaa', '$2y$10$xx/z0aCzxsgWfhbTyNeT2ewgqLJDF0eA4MIG2KJAh48nLldnoT7mu', 'asdasda', 'dasdads', 'asdasdas', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '3543535353', NULL, 'patient', NULL, NULL, 'Active', '2025-07-11 23:49:00'),
(14, 'ParchasoJn', '$2y$10$n0Wn8ENlBKZSmFAc8XIo6.8MBB9.vBHC9jj20HU4E4aBg3QzLnJGa', 'Parchaso', 'espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-11 23:53:50'),
(15, 'pototrr', '$2y$10$81epq2ks0nZntMd5BJtQZeTQgwcM1olJw54tWvY3BCS2.WMKgVy6q', 'potot', 'travs', 'rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '3242424243', NULL, 'patient', NULL, NULL, 'Active', '2025-07-11 23:57:34'),
(16, 'PototRi', '$2y$10$upl6ZnCyMKiiML1SFtOANefWYuh0EKOdUDdNDm/i8b/2nExYEXuea', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '9055626339', NULL, 'patient', NULL, NULL, 'Active', '2025-07-12 18:37:17'),
(17, 'PototRx', '$2y$10$/z0.LVx2xEaDvFVmYKUx9Ou3r8cYEg8Iv0aO6lSArBdZbX2e4XJ9m', 'Potot', 'Travero', 'Rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-12 19:04:48'),
(18, 'parchr', '$2y$10$rBXard1PzWqKnXOsGVbowu8pT1dv11gHFELYhn2UjusTOkR39ZxVS', 'parch', 'potot', 'rix', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '3243242343', NULL, 'patient', NULL, NULL, 'Active', '2025-07-12 20:04:53'),
(19, 'achasg', '$2y$10$pdkklvpmZcbw451FCvkKt.JI14X7dXVExlkqd4e7hAyzunu1KkRjC', 'achas', 'gab', 'gab', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '2423543265', NULL, 'patient', NULL, NULL, 'Active', '2025-07-12 20:31:49'),
(20, 'rixp', '$2y$10$qBN90ZhgnNkJMH23cBT6uOHqAmlXeUTkkJgaQ.myzXnRwATFWEvma', 'rix', '', 'potot', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '2342412421', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:36:12'),
(21, 'rixpp', '$2y$10$nvqUzj8gqqY16SHHkt4NQeVQVeU8CQbOaw6u0hhliacSetzJQU6v2', 'rix', '', 'potot', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '2342412421', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:37:27'),
(22, 'parchj', '$2y$10$sQwUuUFOgllhhPugQds8k.zXlAGrVCiCuTvbcfiCyBBnp4dd8/e3a', 'parch', 'rix', 'jj', 'Female', '0000-00-00', '18100807@usc.edu.ph', '2346676887', NULL, 'patient', NULL, NULL, 'Inactive', '2025-07-12 20:43:04'),
(23, 'pretotd', '$2y$10$fTfrKDDNlUlfmfVRvYF.xOfaEyRWPo51Ux8aqHtLpDgBlxbWVjxSy', 'pretot', 'chiku', 'daze', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '3214325666', NULL, 'patient', NULL, NULL, 'Active', '2025-07-12 20:45:13'),
(24, '23dfsfs', '$2y$10$jRDx4wuzWruwA6NDUnGnn.XRyS0qYxK16q.20kDMphYGnVcDNlZKK', '23dfsf', 's', 'sdfsfd', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '4326789879', NULL, 'patient', NULL, NULL, 'Active', '2025-07-12 21:20:25'),
(25, 'AchasGG', '$2y$10$csrxQ1iwxHEcfkhQHKf3se586DUSZSK.WhXgNKB39m9js/HfPwuYK', 'Achas', '', 'Gab', 'Male', '0000-00-00', '18100807@usc.edu.ph', '0922626262', NULL, 'patient', NULL, NULL, 'Active', '2025-07-14 10:25:16'),
(26, 'DazeP', '$2y$10$du.PYFR4vnJv9ecdNWDox.UUDcjoC0cTUAvtnsnSG.tXwdqn5vLKO', 'Daze', '', 'Pretot', 'Male', '0000-00-00', 'parchasoresidence@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-14 10:33:22'),
(27, 'ChikuY', '$2y$10$h7C7FiWzWuf7oS0hUaav/OZwJX4rYOExaPk3NJu3O39mmsutOsUvm', 'Chiku', 'Wix', 'Yel', 'Female', '0000-00-00', 'parchasoresidence@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-14 11:14:19'),
(28, 'Josephp', '$2y$10$WFRSiU6H8ER6LfQ2KYYdWupYZknVTM6WGZl39Lt0glRYJdr7rTpiW', 'Joseph', '', 'parch', 'Male', '1999-08-17', 'theartp1@gmail.com', '9055626239', 'Block 22, Lot 6, Deca 4 Bankal Lapu Lapu City Cebu', 'patient', NULL, NULL, 'Active', '2025-07-14 11:26:32'),
(29, 'pototj', '$2y$10$9Swzre20c9pLQ8ejMr1ySufYwaARXiCYpp8sUXyb5CP1oI7xNjtC2', 'potot', '', 'jj', 'Male', '0000-00-00', '18102727@usc.edu.ph', '9527194102', NULL, 'patient', NULL, NULL, 'Active', '2025-07-14 15:48:41'),
(30, 'pret', '$2y$10$z7r/dpwWQ2m.RZK8EcwJGu2MkUM3tRY2EgG/7OyfSubN.bmXm2yTW', 'pre', '', 'tot', 'Male', '0000-00-00', '18102727@usc.edu.ph', '9205251545', NULL, 'patient', NULL, NULL, 'Active', '2025-07-14 16:03:59'),
(31, 'Parchaso_J', '$2y$10$14IUZVVauGdjCe04vSuVTechUS8.EYYzOO5yZ0Li6Lq/IUhGx0.Ny', 'Parchaso', 'Espana', 'Jhon', 'Female', '0000-00-00', '18100807@usc.edu.ph', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-31 14:32:30'),
(32, 'Parchaso_J1', '$2y$10$jhV55n5K2zZw.hoG40uBw.OceefQ5Q8VftYGFBJND/AdBnP7FmhkS', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-31 14:38:20'),
(33, 'Parchaso_J2', '$2y$10$9RhohMzQ7GCr2dSgX02sROUqqX9BhlYPQbvFzTte0bR7nms04U562', 'Parchaso', 'Espana', 'Jhon', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-31 14:38:28'),
(34, 'parchaso_J', '$2y$10$AzXcLMHhefFKyQJfG3lteu/2wKCjJzmhRM4ncT6oSQzhIfEvci9ca', 'parchaso', 'espana', 'jhon', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-07-31 14:54:44'),
(35, 'Parchhh_J', '$2y$10$BLbxRzDFxMO/QnMcVMpT/OO7r5CYpuSanK4TIMTrLAv6kq7qMy.IG', 'Parchhh', '', 'jj', 'Female', '0000-00-00', '18100807@usc.edu.ph', '6515616165', NULL, 'patient', NULL, NULL, 'Active', '2025-08-05 20:06:22'),
(36, 'asdasd_A', '$2y$10$bMsAKLtfJ1e00emYMAaNWuFrD00n/n5St9zCFqmlbLvlHKoKNOXfS', 'asdasd', '', 'asdads', 'Female', '0000-00-00', 'josephparchaso@gmail.com', '2525325425', NULL, 'patient', NULL, NULL, 'Active', '2025-08-09 17:21:09'),
(37, 'admin_b1_01', '$2a$12$hBbDjdgIHA7jTYk63MoYCevpRg.Wyl.Q9AlF1k22Adu5ZTZ2scPhm', 'Wonderland', 'In', 'Alice', 'Female', '2020-03-25', 'alice.b1@example.com', '9789456231', 'Cebu', 'admin', 3, '2023-02-11', 'Inactive', '2025-08-11 18:06:49'),
(38, 'admin_b1_02', '$2a$12$q3izbTzuli5uTm1twK/4YuDY3QSDbWej0pkWVyGsSMRpXVhbrbVRO', 'Admin', 'B1', 'Bob', 'Male', '0000-00-00', 'bob.b1@example.com', '0911111111', NULL, 'admin', 1, '2023-12-05', 'Active', '2025-08-11 18:06:49'),
(39, 'admin_b2_01', '$2a$12$zoGuJuLYhOVs6B828pgDe.lrvUEwXroV1zUzbmxgfwZgCSLi39mHa', 'Admin', 'B2', 'Charlie', 'Male', '0000-00-00', 'charlie.b2@example.com', '0922222222', NULL, 'admin', 2, NULL, 'Inactive', '2025-08-11 18:06:49'),
(40, 'admin_b2_02', '$2a$12$KL9XSfdZh75UuYWljehw0.zNyPK/arJmS7mEzFMvNuK1sBKqLBTLC', 'Admin', 'B2', 'Diana', 'Female', '0000-00-00', 'diana.b2@example.com', '0922222222', NULL, 'admin', 2, '2024-02-20', 'Active', '2025-08-11 18:06:49'),
(41, 'admin_b3_01', '$2a$12$hNePRteKgF2EC1nNHkhQP..14KMwMN66/t3YzL4.GGbLNPXhS7ksa', 'Admin', 'B3', 'Evan', 'Male', '0000-00-00', 'evan.b3@example.com', '0933333333', NULL, 'admin', 3, '2025-02-20', 'Active', '2025-08-11 18:06:49'),
(42, 'Parchaso_J3', '$2y$10$7nbX35783pFvgW4/mdIuzuSaFhONUt6S5Gw/Aabgd2akXGwfmzwa2', 'Parchaso', 'Espana', 'JJ', 'Male', '0000-00-00', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-08-12 15:18:53'),
(43, NULL, '$2y$10$aCLfK7EOsfLFyCYFsCDZzO03iVxSaxZ7D9grAp7C1GMnDs2t.YSYi', 'Potot', 'Travero', 'Thamara', 'Female', '2013-09-25', 'maya@gmail.com', '5465464654', 'asdsad', 'admin', 1, '2025-09-25', 'Inactive', '2025-08-30 11:40:50'),
(44, 'potot_a', '$2y$10$f5shlmN2IMzn1yz/VacRLOjezOmSdU7xPB7kizyd70K0nvpk7e8AK', 'Potot', 'Travero', 'Anna', 'Female', '2025-07-27', 'ana@gmail.com', '1231324654', '0', 'admin', 3, '2025-09-29', 'Inactive', '2025-08-30 11:47:27'),
(45, 'ttvt_K', '$2y$10$avex/XQe4/bbLQTfGq4vsOeLiFV.SANzStRzaEgpZHUr5kLUuJ1Bq', 'ttvt', 'k', 'kggjkj', 'Female', '2025-09-02', 'josephparchaso@gmail.com', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-09-01 10:51:29'),
(46, 'Achas_J', '$2y$10$YuOFDFrnJFYnE65JjXFChu.WQxRa2okENHtFER9xJPwLN1LM29l1y', 'Achas', 'Pallasigue', 'Joshua Gabriel', 'Male', '1999-04-27', 'gabbyachas99@gmail.com', '9260860681', 'P-1 Base Camp, Maramag, Bukidnon', 'patient', NULL, NULL, 'Active', '2025-09-01 10:54:07'),
(47, 'Parchaso_J4', '$2y$10$Durf8pKbOk2BG6IioMFST.63gUDR4PRITB5mJbdJrOvg6MfdfZRCK', 'Parchaso', 'Espana', 'Jhon', 'Female', '1999-08-17', '18100807@usc.edu.ph', '9055626239', NULL, 'patient', NULL, NULL, 'Active', '2025-09-01 15:43:24'),
(48, 'Achas_G', '$2y$10$qF68ie3yW6UnvQyTV74O7.zN7PotiUXW0huXAGuMQ5FY4SDxkqXgK', 'Achas', '', 'Gab', 'Male', '2025-09-11', 'josephparchaso@gmail.com', '9055626239', 'deca', 'admin', 3, '2025-09-09', 'Active', '2025-09-07 21:54:27'),
(49, 'asd_A', '$2y$10$mWpr.dorheR9kWYUjq71n.DYPE98YkIwheXxDpRFejM88d6GLslRq', 'asd', 'asd', 'asd', 'Female', '2025-09-04', 'josephparchasooo@gmail.com', '8481198919', '0', 'admin', 3, '2025-09-24', 'Inactive', '2025-09-07 21:56:18'),
(50, 'parch_J', '$2y$10$Pnho0/H8Abi2ZzJcSapU8.5YBJJKsLidoJAr1uCfibTzM9MHLZx82', 'parch', '', 'jj', 'Female', '2025-09-04', '21313@gmail.com', '1232141242', '0', 'admin', 3, '2025-09-10', 'Active', '2025-09-07 22:00:07'),
(51, 'adny_A', '$2y$10$7KPScD0EP86YwVfwAxj7tu50e5rO1dDFfSm1SmjYg1dL66SUDS3QC', 'adny', '', 'adsa', 'Female', '2025-09-09', 'j@gmail.com', '1324412414', '0', 'admin', 1, '2025-09-24', 'Inactive', '2025-09-07 22:03:04'),
(52, 'potot_R', '$2y$10$mnp55PKAKO0Yawgeg2FWqeE4ejo9aK2RCto5E2EtfWHSY6IqNKwjK', 'potot', '', 'rix', 'Male', '2025-09-02', 'asd@gmail.com', '1243141414', 'deca', 'admin', 1, '2025-09-24', 'Active', '2025-09-07 22:05:06');

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
-- Indexes for table `branch_service`
--
ALTER TABLE `branch_service`
  ADD PRIMARY KEY (`branch_services_id`),
  ADD KEY `fk_branch` (`branch_id`),
  ADD KEY `fk_service` (`service_id`);

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
-- Indexes for table `dental_vitals`
--
ALTER TABLE `dental_vitals`
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
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

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
  MODIFY `appointment_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch_service`
--
ALTER TABLE `branch_service`
  MODIFY `branch_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `dental_prescription`
--
ALTER TABLE `dental_prescription`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dental_transaction`
--
ALTER TABLE `dental_transaction`
  MODIFY `dental_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dental_vitals`
--
ALTER TABLE `dental_vitals`
  MODIFY `vitals_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dentist`
--
ALTER TABLE `dentist`
  MODIFY `dentist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dentist_branch`
--
ALTER TABLE `dentist_branch`
  MODIFY `dentist_branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `dentist_service`
--
ALTER TABLE `dentist_service`
  MODIFY `dentist_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
-- Constraints for table `branch_service`
--
ALTER TABLE `branch_service`
  ADD CONSTRAINT `fk_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE;

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
-- Constraints for table `dental_vitals`
--
ALTER TABLE `dental_vitals`
  ADD CONSTRAINT `dental_vitals_ibfk_1` FOREIGN KEY (`appointment_transaction_id`) REFERENCES `appointment_transaction` (`appointment_transaction_id`);

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
