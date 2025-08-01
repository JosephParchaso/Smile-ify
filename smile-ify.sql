-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 05:15 PM
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
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_transaction`
--

INSERT INTO `appointment_transaction` (`appointment_transaction_id`, `user_id`, `branch_id`, `service_id`, `dentist_id`, `appointment_date`, `appointment_time`, `date_created`) VALUES
(1, 10, 3, 5, 4, '2025-07-18', '15:00:00', '2025-07-11 22:31:48'),
(2, 11, 3, 8, NULL, '2025-07-18', '12:00:00', '2025-07-11 22:36:13'),
(3, 12, 1, 1, 3, '2025-07-18', '09:00:00', '2025-07-11 23:10:37'),
(4, 13, 1, 1, 3, '2025-08-07', '13:30:00', '2025-07-11 23:49:00'),
(5, 14, 1, 1, 3, '2025-07-18', '09:00:00', '2025-07-11 23:53:50'),
(6, 15, 1, 5, 3, '2025-07-19', '12:45:00', '2025-07-11 23:57:34'),
(7, 16, 1, 5, 3, '2025-07-25', '12:00:00', '2025-07-12 18:37:17'),
(8, 17, 1, 1, 1, '2025-08-01', '14:15:00', '2025-07-12 19:04:48'),
(9, 18, 1, 1, 1, '2025-07-22', '09:00:00', '2025-07-12 20:04:53'),
(10, 19, 1, 1, 1, '2025-07-17', '12:45:00', '2025-07-12 20:31:49'),
(11, 20, 1, 1, 3, '2025-07-23', '13:30:00', '2025-07-12 20:36:12'),
(12, 21, 1, 1, 3, '2025-07-23', '13:30:00', '2025-07-12 20:37:27'),
(13, 22, 2, 2, 2, '2025-07-29', '14:15:00', '2025-07-12 20:43:04'),
(14, 23, 2, 10, NULL, '2025-07-24', '13:30:00', '2025-07-12 20:45:13'),
(15, 24, 1, 5, NULL, '2025-07-23', '13:30:00', '2025-07-12 21:20:25'),
(16, 25, 2, 10, 3, '2025-07-24', '13:30:00', '2025-07-14 10:25:16'),
(17, 26, 1, 5, 3, '2025-07-30', '13:30:00', '2025-07-14 10:33:22'),
(18, 27, 2, 10, 3, '2025-07-29', '13:30:00', '2025-07-14 11:14:19'),
(19, 28, 1, 3, 3, '2025-07-29', '14:15:00', '2025-07-14 11:26:32'),
(20, 29, 1, 1, 1, '2025-07-24', '10:30:00', '2025-07-14 15:48:41'),
(21, 30, 2, 8, 3, '2025-07-31', '13:30:00', '2025-07-14 16:03:59'),
(22, 28, 2, 10, 3, '2025-07-23', '09:45:00', '2025-07-21 18:30:17'),
(23, 28, 1, 2, NULL, '2025-07-31', '15:00:00', '2025-07-21 18:42:53'),
(24, 28, 3, 2, NULL, '2025-07-30', '15:00:00', '2025-07-21 20:03:40'),
(25, 28, 1, 5, 3, '2025-07-30', '10:30:00', '2025-07-21 20:10:59'),
(26, 28, 1, 1, 1, '2025-07-24', '12:00:00', '2025-07-21 20:30:32'),
(27, 28, 2, 8, 3, '2025-07-31', '10:30:00', '2025-07-24 15:58:38'),
(28, 31, 1, 1, 1, '2025-08-02', '12:45:00', '2025-07-31 14:32:30'),
(29, 32, 2, 6, 2, '2025-08-16', '11:15:00', '2025-07-31 14:38:20'),
(30, 33, 2, 6, 2, '2025-08-16', '11:15:00', '2025-07-31 14:38:28'),
(31, 34, 2, 6, 2, '2025-08-01', '10:30:00', '2025-07-31 14:54:44');

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
-- Table structure for table `dentist`
--

CREATE TABLE `dentist` (
  `dentist_id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentist`
--

INSERT INTO `dentist` (`dentist_id`, `last_name`, `middle_name`, `first_name`, `gender`, `email`, `contact_number`, `license_number`, `status`, `date_created`) VALUES
(1, 'Ulanday', '', 'Precious', 'female', 'precious@gmail.com', '0912345678', 'LIC-1001', 'active', '2025-07-11 19:40:26'),
(2, 'Chan', 'Marie', 'Kyla', 'female', 'kyla.marie@gmail.com', '0912345679', 'LIC-1002', 'active', '2025-07-11 19:40:26'),
(3, 'Summers', '', 'Daze', 'female', 'daze@gmail.com', '0912345680', 'LIC-1003', 'active', '2025-07-11 19:40:26'),
(4, 'San Jose', '', 'Solene', 'female', 'solene@gmail.com', '0912345681', 'LIC-1004', 'active', '2025-07-11 19:40:26');

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
(1, 1, 1),
(2, 1, 3),
(3, 2, 2),
(4, 3, 1),
(5, 3, 2),
(6, 4, 3);

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
(14, 30, 'Welcome to Smile-ify! Your account was successfully created.', 0, '2025-07-14 16:03:59'),
(15, 30, 'Your appointment on 2025-07-31 at 13:30 was successfully booked!', 0, '2025-07-14 16:03:59'),
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
(29, 34, 'Your appointment on 2025-08-01 at 10:30 was successfully booked!', 0, '2025-07-31 14:54:44');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `name`, `status`, `date_created`) VALUES
(1, 'Consultation', 'active', '2025-07-11 19:08:44'),
(2, 'Tooth Extraction', 'active', '2025-07-11 19:08:44'),
(3, 'Dental Filling', 'active', '2025-07-11 19:08:44'),
(4, 'Root Canal Treatment', 'active', '2025-07-11 19:08:44'),
(5, 'Dental Crown Placement', 'active', '2025-07-11 19:08:44'),
(6, 'Orthodontic Braces', 'active', '2025-07-11 19:08:44'),
(7, 'Teeth Whitening', 'active', '2025-07-11 19:08:44'),
(8, 'Complete Denture', 'active', '2025-07-11 19:08:44'),
(9, 'Partial Denture', 'active', '2025-07-11 19:08:44'),
(10, 'Dental Implant', 'active', '2025-07-11 19:08:44');

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
  `gender` enum('male','female') NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `role` enum('owner','admin','patient') NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `last_name`, `middle_name`, `first_name`, `gender`, `email`, `contact_number`, `role`, `status`, `date_created`) VALUES
(1, 'owner01', '$2a$12$tpxGgFFwdB5hG7rOus1ZuuQzJy8xwA4kvaUTZdvMqCTB9dK/v0yFS', 'Owner', 'Dummy', 'Sample', 'male', '', '9998887777', 'owner', 'active', '2025-06-14 10:39:32'),
(2, 'admin01', '$2a$12$pKUNknha3XVdUTPXL84XUe8YxjAnrLmF7ZeB8KUspXb.ouNVrFGt6', 'Admin', 'Dummy', 'Sample', 'female', '', '9223334444', 'admin', 'active', '2025-06-14 10:39:32'),
(3, 'patient01', '$2a$12$RJZbVUZ3JDsUjDB5eFTyiuACuCvxFJyrQI4cE9u8fQ2ChJf/.Srdq', 'Patient', 'Dummy', 'Sample', 'male', '', '9123456789', 'patient', 'active', '2025-06-14 10:39:32'),
(8, 'ParchasoJ', '$2y$10$9fqT9Gco1CtAKVKu6bSDgeh9SFZbg/bb8GJR5OJrrVIJycPZgqxWC', 'Parchaso', 'Espana', 'Jhon', 'male', '9055626239', 'josephparc', 'owner', 'active', '2025-07-11 22:27:56'),
(9, 'ParchasoJJ', '$2y$10$W.BXzGapcq9J/oxpk1RHYeaYMxBCz0fSTp8YiRh41YSUebQ12Hjhy', 'Parchaso', 'Joseph', 'Jhon', 'male', '9055626239', 'josephparc', 'owner', 'active', '2025-07-11 22:30:07'),
(10, 'ParchasoJo', '$2y$10$7TtiXyp5duA0k9e0t7nmX.BfdQgpQkYwzUVT8tiCFDY166aCIZFoG', 'Parchaso', '', 'Joseph', 'male', '9055626239', 'josephparc', 'patient', 'active', '2025-07-11 22:31:48'),
(11, 'PototR', '$2y$10$2LodhIAZ8iTEc7e5U8ciM.ERBdKf5t2XTv1enJGrQyxJC501X7DG.', 'Potot', 'Travero', 'Rix', 'female', '9950217941', 'josephparc', 'patient', 'active', '2025-07-11 22:36:13'),
(12, 'ParchasoJh', '$2y$10$V9IluHOclcF/fELFexGVPOwsPpXLMCpVz6X5tA53PNxqjGUN39XHq', 'Parchaso', 'Espana', 'Jhon', 'male', 'josephparchaso@gmail.com', '9055626239', 'patient', 'active', '2025-07-11 23:10:37'),
(13, 'asdasdaa', '$2y$10$xx/z0aCzxsgWfhbTyNeT2ewgqLJDF0eA4MIG2KJAh48nLldnoT7mu', 'asdasda', 'dasdads', 'asdasdas', 'male', 'josephparchaso@gmail.com', '3543535353', 'patient', 'active', '2025-07-11 23:49:00'),
(14, 'ParchasoJn', '$2y$10$n0Wn8ENlBKZSmFAc8XIo6.8MBB9.vBHC9jj20HU4E4aBg3QzLnJGa', 'Parchaso', 'espana', 'Jhon', 'male', 'josephparchaso@gmail.com', '9055626239', 'patient', 'active', '2025-07-11 23:53:50'),
(15, 'pototrr', '$2y$10$81epq2ks0nZntMd5BJtQZeTQgwcM1olJw54tWvY3BCS2.WMKgVy6q', 'potot', 'travs', 'rix', 'female', 'josephparchaso@gmail.com', '3242424243', 'patient', 'active', '2025-07-11 23:57:34'),
(16, 'PototRi', '$2y$10$upl6ZnCyMKiiML1SFtOANefWYuh0EKOdUDdNDm/i8b/2nExYEXuea', 'Potot', 'Travero', 'Rix', 'female', 'josephparchaso@gmail.com', '9055626339', 'patient', 'active', '2025-07-12 18:37:17'),
(17, 'PototRx', '$2y$10$/z0.LVx2xEaDvFVmYKUx9Ou3r8cYEg8Iv0aO6lSArBdZbX2e4XJ9m', 'Potot', 'Travero', 'Rix', 'female', 'josephparchaso@gmail.com', '9055626239', 'patient', 'active', '2025-07-12 19:04:48'),
(18, 'parchr', '$2y$10$rBXard1PzWqKnXOsGVbowu8pT1dv11gHFELYhn2UjusTOkR39ZxVS', 'parch', 'potot', 'rix', 'female', 'josephparchaso@gmail.com', '3243242343', 'patient', 'active', '2025-07-12 20:04:53'),
(19, 'achasg', '$2y$10$pdkklvpmZcbw451FCvkKt.JI14X7dXVExlkqd4e7hAyzunu1KkRjC', 'achas', 'gab', 'gab', 'male', 'josephparchaso@gmail.com', '2423543265', 'patient', 'active', '2025-07-12 20:31:49'),
(20, 'rixp', '$2y$10$qBN90ZhgnNkJMH23cBT6uOHqAmlXeUTkkJgaQ.myzXnRwATFWEvma', 'rix', '', 'potot', 'male', 'josephparchaso@gmail.com', '2342412421', 'patient', 'active', '2025-07-12 20:36:12'),
(21, 'rixpp', '$2y$10$nvqUzj8gqqY16SHHkt4NQeVQVeU8CQbOaw6u0hhliacSetzJQU6v2', 'rix', '', 'potot', 'male', 'josephparchaso@gmail.com', '2342412421', 'patient', 'active', '2025-07-12 20:37:27'),
(22, 'parchj', '$2y$10$sQwUuUFOgllhhPugQds8k.zXlAGrVCiCuTvbcfiCyBBnp4dd8/e3a', 'parch', 'rix', 'jj', 'female', '18100807@usc.edu.ph', '2346676887', 'patient', 'active', '2025-07-12 20:43:04'),
(23, 'pretotd', '$2y$10$fTfrKDDNlUlfmfVRvYF.xOfaEyRWPo51Ux8aqHtLpDgBlxbWVjxSy', 'pretot', 'chiku', 'daze', 'female', 'josephparchaso@gmail.com', '3214325666', 'patient', 'active', '2025-07-12 20:45:13'),
(24, '23dfsfs', '$2y$10$jRDx4wuzWruwA6NDUnGnn.XRyS0qYxK16q.20kDMphYGnVcDNlZKK', '23dfsf', 's', 'sdfsfd', 'male', 'josephparchaso@gmail.com', '4326789879', 'patient', 'active', '2025-07-12 21:20:25'),
(25, 'AchasGG', '$2y$10$csrxQ1iwxHEcfkhQHKf3se586DUSZSK.WhXgNKB39m9js/HfPwuYK', 'Achas', '', 'Gab', 'male', '18100807@usc.edu.ph', '0922626262', 'patient', 'active', '2025-07-14 10:25:16'),
(26, 'DazeP', '$2y$10$du.PYFR4vnJv9ecdNWDox.UUDcjoC0cTUAvtnsnSG.tXwdqn5vLKO', 'Daze', '', 'Pretot', 'male', 'parchasoresidence@gmail.com', '9055626239', 'patient', 'active', '2025-07-14 10:33:22'),
(27, 'ChikuY', '$2y$10$h7C7FiWzWuf7oS0hUaav/OZwJX4rYOExaPk3NJu3O39mmsutOsUvm', 'Chiku', 'Wix', 'Yel', 'female', 'parchasoresidence@gmail.com', '9055626239', 'patient', 'active', '2025-07-14 11:14:19'),
(28, 'Josephp', '$2y$10$r842TnJ2H403dHtEVZX3ZuEsp/PneORgp0aQ6iOkCbc.n/5BCqyta', 'Joseph', '', 'parch', 'male', 'theartp1@gmail.com', '1221412515', 'patient', 'active', '2025-07-14 11:26:32'),
(29, 'pototj', '$2y$10$9Swzre20c9pLQ8ejMr1ySufYwaARXiCYpp8sUXyb5CP1oI7xNjtC2', 'potot', '', 'jj', 'male', '18102727@usc.edu.ph', '9527194102', 'patient', 'active', '2025-07-14 15:48:41'),
(30, 'pret', '$2y$10$qvBLwb6Rn1BwPq6OUHvJu.J7BQv21/byAtwbrlavv3ooZycF4fDIa', 'pre', '', 'tot', 'male', '18102727@usc.edu.ph', '9205251545', 'patient', 'active', '2025-07-14 16:03:59'),
(31, 'Parchaso_J', '$2y$10$14IUZVVauGdjCe04vSuVTechUS8.EYYzOO5yZ0Li6Lq/IUhGx0.Ny', 'Parchaso', 'Espana', 'Jhon', 'female', '18100807@usc.edu.ph', '9055626239', 'patient', 'active', '2025-07-31 14:32:30'),
(32, 'Parchaso_J1', '$2y$10$jhV55n5K2zZw.hoG40uBw.OceefQ5Q8VftYGFBJND/AdBnP7FmhkS', 'Parchaso', 'Espana', 'Jhon', 'male', 'josephparchaso@gmail.com', '9055626239', 'patient', 'active', '2025-07-31 14:38:20'),
(33, 'Parchaso_J2', '$2y$10$9RhohMzQ7GCr2dSgX02sROUqqX9BhlYPQbvFzTte0bR7nms04U562', 'Parchaso', 'Espana', 'Jhon', 'male', 'josephparchaso@gmail.com', '9055626239', 'patient', 'active', '2025-07-31 14:38:28'),
(34, 'parchaso_J', '$2y$10$AzXcLMHhefFKyQJfG3lteu/2wKCjJzmhRM4ncT6oSQzhIfEvci9ca', 'parchaso', 'espana', 'jhon', 'female', 'josephparchaso@gmail.com', '9055626239', 'patient', 'active', '2025-07-31 14:54:44');

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
  ADD UNIQUE KEY `index_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_transaction`
--
ALTER TABLE `appointment_transaction`
  MODIFY `appointment_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
-- AUTO_INCREMENT for table `dentist`
--
ALTER TABLE `dentist`
  MODIFY `dentist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dentist_branch`
--
ALTER TABLE `dentist_branch`
  MODIFY `dentist_branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dentist_service`
--
ALTER TABLE `dentist_service`
  MODIFY `dentist_services_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
