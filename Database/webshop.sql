-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2021 at 09:04 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` double NOT NULL,
  `genre` varchar(50) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `author` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `genre`, `url`, `author`) VALUES
(1, 'Amongus', 'Among Us is a computer game developed by the company InnerSloth and released in 2018, described as an \"online multiplayer social deduction game\" wherein up to ten players run around inside a virtual spaceship completing classic spaceship tasks..................', 6, 'social deduction game', '/images/amongus.jpeg', 'johny'),
(2, 'Cs:go', 'oldschool multiplayer game', 10, 'FPS', '/images/csgo.jpg', NULL),
(3, 'Dota 2', 'Multiplayer online battle arena', 17, 'Moba', '/images/dota2.jpg', NULL),
(4, 'League of Legends', 'Multiplayer online battle arena', 17, 'Moba', '/images/LoL.jpg', NULL),
(8, 'Cyberpunk', 'Cyberpunk is a subgenre of science fiction in a dystopian futuristic setting that tends to focus on a \"combination of low-life and high tech\" featuring advanced technological and scientific achievements', 12, 'RPG', '/images/cyberpunk.jpg', 'johny'),
(9, 'Call of Duty: Warzone', 'Call of Duty: Warzone is a free-to-play battle royale video game released on March 10, 2020, for PlayStation 4, Xbox One, and Microsoft Windows. The game is a part of the 2019 title Call of Duty: Modern Warfare but does not require purchase of it and is introduced during Season 2 of Modern Warfare content', 50, 'FPS', '/images/CoD.jpg', NULL),
(10, 'Fall guys', 'Fall Guys: Ultimate Knockout is a platformer battle royale game developed by Mediatonic and published by Devolver Digital. It released for Microsoft Windows and PlayStation 4 on 4 August 2020', 30, 'Battle Royale', '/images/fallGuys.jpg', NULL),
(11, 'Doom: Eternal', 'Doom Eternal is a first-person shooter game developed by id Software and published by Bethesda Softworks', 30, 'FPS', '/images/Doom.jpg', 'johny'),
(12, 'Valorant', 'Update 123', 10, 'FPS', '/images/Valorant.jpg', 'ivan');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `author` varchar(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `text`, `date_posted`, `author`, `product_id`) VALUES
(1, 'disapointed', '2021-01-06', 'ivan', 1),
(2, 'i like it', '2021-01-08', 'test123', 2),
(3, 'too expensive', '2021-01-08', 'test1234', 2),
(4, 'bad game', '2021-01-21', 'johny', 3),
(7, 'cool game', NULL, 'ivan', 8),
(8, '', NULL, 'ivan', 10),
(9, 'Great game', NULL, 'ivan', 3),
(10, '', NULL, 'johny', 9),
(11, '', NULL, 'johny', 10),
(12, 'nice game', NULL, 'ivan', 4);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'ROLE_CUSTOMER'),
(2, 'ROLE_DEVELOPER'),
(3, 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'ivan', 'ivan@gmail', '$2y$10$I0qIZRYroqzYsIejnT1j6.JWthN9Z3tj.ebxuUmMpp.WQOddZWSha', 'Admin'),
(3, 'testUser1', 'testUser@', '12345', 'User'),
(4, 'test123', 'test@example.com', '$2a$10$YrXTiwAO75IoiL0Di.gBVOcNhzgHGDKIuXU032sg6MWtUMIxND0Re', NULL),
(5, 'test1234', 'user2@example.com', '$2a$10$xOHZoxN3yE/a6eqAIsBPze0.SCLpoVVXpQ4pCZ1mzQYRBMIBe1vNy', NULL),
(6, 'bezkoder', 'bezkoder@example.com', '$2a$10$JRU1YzmEOSfuDtJ1x6pQ5OOd/.Z/ICBOvTGyGG.TuyPXfMEe6nwty', NULL),
(7, 'johny', 'johny@gmail.com', '$2a$10$pNI/.TRJwUW6VYbo8lFsQOlwchKaEmY0ldwrtPrtq2FCZgcsuh69K', 'User'),
(8, 'sam', 'sam@example.org', '$2a$10$sazU8bujVYFoEVzdjflc3eKQXE6pBKt8ZoMpx441C9yh5J9FWGK4S', NULL),
(9, 'johnDoe', 'john@example.com', '$2a$10$n3txk.GhqYnCZQ57ecf9CuveyFgR7dEIVM5Xb6/jiOn49DIa2h77K', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 3),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UKr43af9ap4edm43mmtq01oddj6` (`username`),
  ADD UNIQUE KEY `UK6dotkott2kjsp8vw4d0m25fb7` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD KEY `FKh8ciramu9cc9q3qcqiv4ue8a6` (`role_id`),
  ADD KEY `FKhfh9dx7w3ubf1co1vdev94g3f` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `FKh8ciramu9cc9q3qcqiv4ue8a6` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FKhfh9dx7w3ubf1co1vdev94g3f` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
