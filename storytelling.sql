-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 05:41 AM
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
-- Database: `storytelling`
--

-- --------------------------------------------------------

--
-- Table structure for table `sketches`
--

CREATE TABLE `sketches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sketches`
--

INSERT INTO `sketches` (`id`, `user_id`, `image_path`, `created_at`) VALUES
(5, 10, 'uploads/1765004271_tree.jpg', '2025-12-06 06:57:51'),
(6, 10, 'uploads/1765004283_house.jpg', '2025-12-06 06:58:03'),
(8, 10, 'uploads/1765004296_tree.jpg', '2025-12-06 06:58:16'),
(9, 10, 'uploads/1765004322_tree.jpg', '2025-12-06 06:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sketch_id` int(11) NOT NULL,
  `language` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `user_id`, `sketch_id`, `language`, `created_at`) VALUES
(2, 6, 5, 'story is good', '2025-12-06 03:54:10'),
(3, 6, 2, 'moral stories', '2025-12-06 03:54:31'),
(4, 101, 1, 'My first story', '2025-12-06 07:27:49'),
(5, 21, 9, 'My second story', '2025-12-06 07:29:09'),
(6, 44, 9, 'My third story', '2025-12-06 07:29:40'),
(7, 55, 8, 'My fourth story', '2025-12-06 07:30:17'),
(8, 77, 8, 'My fifth story', '2025-12-06 07:30:40');

-- --------------------------------------------------------

--
-- Table structure for table `story_audios`
--

CREATE TABLE `story_audios` (
  `id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `audio_file` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `story_audios`
--

INSERT INTO `story_audios` (`id`, `story_id`, `audio_file`, `created_at`) VALUES
(1, 3, 'uploads/audio/1765250322_voice 1.opus', '2025-12-09 03:18:42'),
(3, 4, 'uploads/audio/1765252584_voice 3.opus', '2025-12-09 03:20:48'),
(4, 6, 'uploads/audio/1765250481_voice 3.opus', '2025-12-09 03:21:21'),
(5, 5, 'uploads/audio/1765250581_voice 4.opus', '2025-12-09 03:23:01'),
(6, 2, 'uploads/audio/1765250608_voice 5.opus', '2025-12-09 03:23:28'),
(9, 5, 'uploads/audio/1765252262_voice 6.opus', '2025-12-09 03:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `usertype`) VALUES
(1, 'JohnDoe', 'john@example.com', '9876543210', '123456', 'admin'),
(2, 'manasa', 'manasa@example.com', '9876543211', '1234567', 'admin'),
(3, 'pranitha', 'pranitha@example.com', '9876543212', '12345678', 'admin'),
(4, 'praneetha', 'praneetha@example.com', '9876543213', '123456789', 'user'),
(11, 'neetha', 'neetha@example.com', '9876543219', '1234567890', 'user'),
(12, 'dhatchu', 'dhatchu@gmail.com', '9876543219', '123', 'admin'),
(13, 'naveen', 'naveen@gmail.com', '', '123456', 'user'),
(14, 'Shaik Muzamil', 'muzzushaik1619@gmail.com', '', 'muzzu', 'user'),
(15, 'vasu', 'vasu@gmail.com', '', 'vasu', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sketches`
--
ALTER TABLE `sketches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sketch_id` (`sketch_id`);

--
-- Indexes for table `story_audios`
--
ALTER TABLE `story_audios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `story_id` (`story_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sketches`
--
ALTER TABLE `sketches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `story_audios`
--
ALTER TABLE `story_audios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `story_audios`
--
ALTER TABLE `story_audios`
  ADD CONSTRAINT `story_audios_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
