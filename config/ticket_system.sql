-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2024 at 03:00 PM
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
-- Database: `ticket_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `date_logged` date NOT NULL DEFAULT current_timestamp(),
  `content` text NOT NULL,
  `logged_by` varchar(100) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `date_logged`, `content`, `logged_by`, `assigned_to`) VALUES
(4, '2024-03-29', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '11', 29),
(5, '2024-03-29', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '12', 18),
(6, '2024-03-29', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '29', 29),
(7, '2024-03-29', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', '13', NULL),
(8, '2024-03-29', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '14', NULL),
(9, '2024-04-18', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '15', 18),
(10, '2024-03-30', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '16', 29),
(11, '2024-03-29', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', '17', 18),
(12, '2024-03-29', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `access_level` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reports_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `access_level`, `first_name`, `surname`, `username`, `password`, `reports_to`) VALUES
(11, 'user', 'John', 'Doe', 'johndoe', '482c811da5d5b4bc6d497ffa98491e38', 0),
(12, 'user', 'Jane', 'Smith', 'janesmith', '482c811da5d5b4bc6d497ffa98491e38', 0),
(13, 'admin', 'Michael', 'Johnson', 'mikejohn', '482c811da5d5b4bc6d497ffa98491e38', 29),
(14, 'admin', 'Emily', 'Brown', 'emilybrown', '482c811da5d5b4bc6d497ffa98491e38', 29),
(15, 'owner', 'David', 'Jones', 'davidjones', '482c811da5d5b4bc6d497ffa98491e38', 0),
(16, 'agent', 'Alice', 'Smith', 'asmith', '482c811da5d5b4bc6d497ffa98491e38', 32),
(17, 'agent', 'Bob', 'Johnson', 'bjohnson', '482c811da5d5b4bc6d497ffa98491e38', 32),
(18, 'admin', 'Carol', 'Williams', 'cwilliams', '482c811da5d5b4bc6d497ffa98491e38', 29),
(19, 'agent', 'David', 'Brown', 'dbrown', '482c811da5d5b4bc6d497ffa98491e38', 32),
(20, 'agent', 'Emma', 'Jones', 'ejones', '482c811da5d5b4bc6d497ffa98491e38', 32),
(21, 'admin', 'Frank', 'Davis', 'fdavis', '482c811da5d5b4bc6d497ffa98491e38', 29),
(22, 'agent', 'Grace', 'Miller', 'gmiller', '482c811da5d5b4bc6d497ffa98491e38', 32),
(23, 'agent', 'Henry', 'Wilson', 'hwilson', '482c811da5d5b4bc6d497ffa98491e38', 32),
(24, 'admin', 'Iris', 'Moore', 'imoore', '482c811da5d5b4bc6d497ffa98491e38', 29),
(25, 'agent', 'Jack', 'Taylor', 'jtaylor', '482c811da5d5b4bc6d497ffa98491e38', 35),
(26, 'agent', 'Kate', 'Anderson', 'kanderson', '482c811da5d5b4bc6d497ffa98491e38', 35),
(27, 'admin', 'Liam', 'Martinez', 'lmartinez', '482c811da5d5b4bc6d497ffa98491e38', 29),
(28, 'agent', 'Mia', 'Garcia', 'mgarcia', '482c811da5d5b4bc6d497ffa98491e38', 35),
(29, 'manager', 'Noah', 'Rodriguez', 'nrodriguez', '482c811da5d5b4bc6d497ffa98491e38', 15),
(30, 'admin', 'Olivia', 'Hernandez', 'ohernandez', '482c811da5d5b4bc6d497ffa98491e38', 29),
(31, 'agent', 'Sophia', 'Lopez', 'slopez', '482c811da5d5b4bc6d497ffa98491e38', 35),
(32, 'manager', 'William', 'Gonzalez', 'wgonzalez', '482c811da5d5b4bc6d497ffa98491e38', 15),
(33, 'admin', 'Elijah', 'Perez', 'eperez', '482c811da5d5b4bc6d497ffa98491e38', 29),
(34, 'agent', 'Ava', 'Torres', 'atorres', '482c811da5d5b4bc6d497ffa98491e38', 35),
(35, 'manager', 'James', 'Rivera', 'jrivera', '482c811da5d5b4bc6d497ffa98491e38', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
