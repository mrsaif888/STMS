-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 06:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stms_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `priority` enum('high','medium','low') DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'todo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `created_by`, `deadline`, `priority`, `status`) VALUES
(10, 'work', 'abc', 5, 3, '2025-03-21', 'medium', 'todo'),
(12, 'code', 'wqw', 8, 3, '2025-03-29', 'low', 'todo'),
(14, 'daad', 'dsadas', 5, 3, '2025-10-31', 'medium', 'todo'),
(16, 'das', 'dad', 7, 4, '2024-12-31', 'low', 'completed'),
(17, 'hey', 'world', 8, 4, '2026-12-31', 'high', 'completed'),
(18, 'abcd', 'abc', 5, 4, '2025-12-01', 'high', 'todo'),
(20, 'abcdsasd', 'hello', 5, 3, '2025-01-01', 'high', 'inprogress'),
(21, 'hello world', 'complete task on time', 10, 3, '2025-04-30', 'high', 'todo'),
(22, 'task 1', 'do the task', 11, 3, '2025-04-25', 'high', 'todo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','team-lead','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(3, 'admin', '$2y$10$dKP3ATzo1tIIfVYjAn7RC.pjuBnHiNaHe0TZkXOWczvpNoMLDAKuu', 'admin'),
(4, 'saif', '$2y$10$pufQqblYe93BdxHRXQ0T6eELhEBf/zPszIL/4w0/WZkyTm5QPOzYy', 'team-lead'),
(5, 'viren', '$2y$10$1VZhSSMSitfH5aYSpUW2LeH5TY3ikQPhSWmJCRT/WkYQrH1SD7GcC', 'user'),
(6, 'harman', '$2y$10$RnX3zPRZg7VCdxu1h05g7OuGjDZEBNHtEQISb0CW.1R5Y9n4zWRhO', 'team-lead'),
(7, 'user1', '$2y$10$2xDc8SZF/N1q2789wInAYOT.7AQ.iJjUxnuUz43zLJBQ7SRs5YR6i', 'user'),
(8, 'user2', '$2y$10$piAShREQnswOf2SaU8Y.N.SPXuaeNU4Rk.agnBj3nTmF/L5ihgNiW', 'user'),
(9, 'test1', '$2y$10$W9TBY4kqDKM4j/7DrjLgj.DwFMEH6LmP73NxqO6UovO//lRTb2rWu', 'user'),
(10, 'test2', '$2y$10$gtrCILRVq3IVAj/EbnJCMuk6c4jBj7AcWXwROPYz19klG4mgg87/e', 'user'),
(11, 'musa', '$2y$10$bwZFjYgRKkbSrMqEwunaJ.eoIlRCjN5J6rxjXMW4A7XdoX.O/0qQ6', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
