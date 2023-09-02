-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 12:47 AM
-- Server version: 10.5.19-MariaDB-0+deb11u2
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `titleid` int(11) UNSIGNED NOT NULL,
  `dk` int(11) NOT NULL DEFAULT 0,
  `ref` varchar(100) NOT NULL,
  `male` varchar(25) NOT NULL,
  `female` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`titleid`, `dk`, `ref`, `male`, `female`) VALUES
(1, 0, '', 'Bauernjunge', 'Bauernmädchen'),
(2, 1, '', 'Seite', 'Seite'),
(3, 2, '', 'Knappe', 'Knappin'),
(4, 3, '', 'Gladiator', 'Gladiatrix'),
(5, 4, '', 'Legionär', 'Legionärin'),
(6, 5, '', 'Zenturio', 'Zenturionin'),
(7, 6, '', 'Herr', 'Dame'),
(8, 7, '', 'Reeve', 'Reeve'),
(9, 8, '', 'Verwalter', 'Verwalterin'),
(10, 9, '', 'Bürgermeister', 'Bürgermeisterin'),
(11, 10, '', 'Baron', 'Baronin'),
(12, 11, '', 'Graf', 'Grafin'),
(13, 12, '', 'Vizegraf', 'Vizegräfin'),
(14, 13, '', 'Marquis', 'Marchioness'),
(15, 14, '', 'Kanzler', 'Kanzlerin'),
(16, 15, '', 'Prinz', 'Prinzessin'),
(17, 16, '', 'König', 'Königin'),
(18, 17, '', 'Kaiser', 'Kaiserin'),
(19, 18, '', 'Engel', 'Engel'),
(20, 19, '', 'Erzengel', 'Erzengel'),
(21, 20, '', 'Fürstentum', 'Fürstentum'),
(22, 21, '', 'Macht', 'Macht'),
(23, 22, '', 'Tugend', 'Tugend'),
(24, 23, '', 'Herrschaft', 'Herrschaft'),
(25, 24, '', 'Thron', 'Thron'),
(26, 25, '', 'Cherub', 'Cherub'),
(27, 26, '', 'Seraph', 'Seraph'),
(28, 27, '', 'Halbgott', 'Halbgöttin'),
(29, 28, '', 'Titan', 'Titanin'),
(30, 29, '', 'Erztitan', 'Erztitanin'),
(31, 30, '', 'Untergott', 'Untergöttin'),
(32, 31, '', 'Gott', 'Göttin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`titleid`),
  ADD KEY `dk` (`dk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `titleid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
