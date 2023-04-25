-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 24, 2023 at 04:22 PM
-- Server version: 10.6.7-MariaDB-1:10.6.7+maria~focal
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dsw2_fakedex`
--

-- --------------------------------------------------------

--
-- Table structure for table `creature`
--

CREATE TABLE `creature` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `id_type1` int(11) DEFAULT NULL,
  `id_type2` int(11) DEFAULT NULL,
  `hp` int(11) DEFAULT 0,
  `atk` int(11) DEFAULT 0,
  `def` int(11) DEFAULT 0,
  `sp_atk` int(11) DEFAULT 0,
  `sp_def` int(11) DEFAULT 0,
  `speed` int(11) DEFAULT 0,
  `description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `creature`
--

INSERT INTO `creature` (`id`, `nom`, `id_type1`, `id_type2`, `hp`, `atk`, `def`, `sp_atk`, `sp_def`, `speed`, `description`) VALUES
(1, 'Léviathan', 4, 17, 500, 240, 150, 100, 100, 25, 'Monstre mythologique des océans qui a détruit l\'Atlantide selon la légende.'),
(5, 'Ostreo', 10, 1, 50, 24, 15, 10, 10, 250, 'sdafsdafsdafdsfa.');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `nom`) VALUES
(18, 'Acier'),
(1, 'Aucun'),
(8, 'Combat'),
(16, 'Dragon'),
(4, 'Eau'),
(6, 'Électrique'),
(19, 'Fée'),
(3, 'Feu'),
(7, 'Glace'),
(13, 'Insecte'),
(2, 'Normal'),
(5, 'Plante'),
(9, 'Poison'),
(12, 'Psy'),
(14, 'Roche'),
(10, 'Sol'),
(15, 'Spectre'),
(17, 'Ténèbre'),
(11, 'Vol');

-- --------------------------------------------------------

--
-- Table structure for table `usager`
--

CREATE TABLE `usager` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `api_key` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usager`
--

INSERT INTO `usager` (`id`, `username`, `password`, `api_key`) VALUES
(1, 'admin', '$2y$10$PTcjxP47PlQQ9DvAQKMcA.M2dTRCbcbimSsYLMFqE.IFIqsxwDU4C', '5a72df75-4651-4baf-b17a-9ee326fd8a11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `creature`
--
ALTER TABLE `creature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creature_FK` (`id_type1`),
  ADD KEY `creature_FK_1` (`id_type2`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_UN` (`nom`);

--
-- Indexes for table `usager`
--
ALTER TABLE `usager`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usager_UN` (`username`,`api_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `creature`
--
ALTER TABLE `creature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `usager`
--
ALTER TABLE `usager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `creature`
--
ALTER TABLE `creature`
  ADD CONSTRAINT `creature_FK` FOREIGN KEY (`id_type1`) REFERENCES `type` (`id`),
  ADD CONSTRAINT `creature_FK_1` FOREIGN KEY (`id_type2`) REFERENCES `type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
