-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2023 at 04:41 PM
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
-- Table structure for table `companions`
--

CREATE TABLE `companions` (
  `companionid` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `attack` int(6) UNSIGNED NOT NULL DEFAULT 1,
  `attackperlevel` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `defense` int(6) UNSIGNED NOT NULL DEFAULT 1,
  `defenseperlevel` int(6) UNSIGNED NOT NULL DEFAULT 0,
  `maxhitpoints` int(6) UNSIGNED NOT NULL DEFAULT 10,
  `maxhitpointsperlevel` int(6) UNSIGNED NOT NULL DEFAULT 10,
  `abilities` text NOT NULL,
  `cannotdie` tinyint(4) NOT NULL DEFAULT 0,
  `cannotbehealed` tinyint(4) NOT NULL DEFAULT 1,
  `companionlocation` varchar(25) NOT NULL DEFAULT 'all',
  `companionactive` tinyint(25) NOT NULL DEFAULT 1,
  `companioncostdks` tinyint(4) NOT NULL DEFAULT 0,
  `companioncostgems` int(6) NOT NULL DEFAULT 0,
  `companioncostgold` int(10) NOT NULL DEFAULT 0,
  `jointext` text NOT NULL,
  `dyingtext` varchar(255) NOT NULL,
  `allowinshades` tinyint(4) NOT NULL DEFAULT 0,
  `allowinpvp` tinyint(4) NOT NULL DEFAULT 0,
  `allowintrain` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `companions`
--

INSERT INTO `companions` (`companionid`, `name`, `category`, `description`, `attack`, `attackperlevel`, `defense`, `defenseperlevel`, `maxhitpoints`, `maxhitpointsperlevel`, `abilities`, `cannotdie`, `cannotbehealed`, `companionlocation`, `companionactive`, `companioncostdks`, `companioncostgems`, `companioncostgold`, `jointext`, `dyingtext`, `allowinshades`, `allowinpvp`, `allowintrain`) VALUES
(1, '`^Dillon', 'Krieger', 'Ein Krieger, der an der Front bei der Belagerung von Avalon auf dem Gehsteg mitgekämpft hat. Aufgrund der Gefahren im Wald hat er sich jedoch entschieden, Söldner zu werden.', 5, 2, 1, 2, 20, 20, 'a:4:{s:5:\"fight\";s:1:\"1\";s:4:\"heal\";s:1:\"0\";s:5:\"magic\";s:1:\"0\";s:6:\"defend\";b:0;}', 0, 0, 'Dorf von Avalon', 1, 0, 4, 573, '`^Ich werde euren Rücken freihalten. Mein Schwert soll nun das Blut der Monster trinken.', '`4Argggggh! Ich bin besiegt! Ich verlasse meine sterbliche Hülle. Leb wohl, mein Freund.', 1, 0, 0),
(2, '`qKermen', 'Bogenschütze', 'Ein Bogenschütze der sich an der Front im Aussenhof während der Belagerung von Avalon behauptet hat. Aufgrund der Gefahren im Wald hat er sich jedoch entschieden, Söldner zu werden.', 6, 2, 1, 1, 15, 15, 'a:4:{s:5:\"fight\";s:1:\"1\";s:4:\"heal\";s:1:\"0\";s:5:\"magic\";s:1:\"0\";s:6:\"defend\";b:0;}', 0, 0, 'Dorf von Avalon', 1, 0, 3, 800, '`QKein Gegner wird sich an Euch heranschleichen können. Mein Bogen soll das Herz der Monster zerschmettern.', '`4Argggggh! Ich bin besiegt! Ich verlasse meine sterbliche Hülle. Leb wohl, mein Freund.', 1, 0, 0),
(3, '`$Scur', 'Zauberer', 'Ein Zauberer, der bei der Belagerung von Avalon als Wache gedient hatte. Aufgrund der Gefahren im Wald hat er sich jedoch entschieden, Söldner zu werden.', 1, 1, 5, 5, 15, 10, 'a:4:{s:6:\"defend\";s:1:\"1\";s:4:\"heal\";s:1:\"2\";s:5:\"magic\";s:1:\"2\";s:5:\"fight\";b:0;}', 0, 1, 'Dorf von Avalon', 1, 0, 3, 1000, 'Niemand wird uns überwältigen können. Meine Magie wird alle Monster verjagen.', '`4Argggggh! Ich bin besiegt! Ich verlasse meine sterbliche Hülle. Leb wohl, mein Freund.', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companions`
--
ALTER TABLE `companions`
  ADD PRIMARY KEY (`companionid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companions`
--
ALTER TABLE `companions`
  MODIFY `companionid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
