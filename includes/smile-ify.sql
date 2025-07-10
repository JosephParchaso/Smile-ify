-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 03:36 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `role` enum('owner','admin','patient') NOT NULL,
  `status` enum('active','female') NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `last_name`, `middle_name`, `first_name`, `gender`, `contact_number`, `role`, `status`, `date_created`) VALUES
(1, 'owner01', '$2a$12$tpxGgFFwdB5hG7rOus1ZuuQzJy8xwA4kvaUTZdvMqCTB9dK/v0yFS', 'Owner', 'Dummy', 'Sample', 'male', '9998887777', 'owner', 'active', '2025-06-14 18:39:32'),
(2, 'admin01', '$2a$12$pKUNknha3XVdUTPXL84XUe8YxjAnrLmF7ZeB8KUspXb.ouNVrFGt6', 'Admin', 'Dummy', 'Sample', 'female', '9223334444', 'admin', 'active', '2025-06-14 18:39:32'),
(3, 'patient01', '$2a$12$RJZbVUZ3JDsUjDB5eFTyiuACuCvxFJyrQI4cE9u8fQ2ChJf/.Srdq', 'Patient', 'Dummy', 'Sample', 'male', '9123456789', 'patient', 'active', '2025-06-14 18:39:32');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
