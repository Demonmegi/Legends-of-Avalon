-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 01:04 AM
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
(1, 'Mortimer teh javelin man', 'Knight', 'A rough and ready warrior.  Beneath his hardened exterior, one can detect a man of strong honour.', 5, 2, 1, 2, 20, 20, 'a:4:{s:5:\"fight\";s:1:\"1\";s:4:\"heal\";s:1:\"0\";s:5:\"magic\";s:1:\"0\";s:6:\"defend\";b:0;}', 0, 0, 'Degolburg', 1, 0, 4, 573, '`^Greetings unto thee, my friend.  Let us go forth and conquer the evils of this world together!', '`4Argggggh!  I am slain!  Shuffling off my mortal coil.  Fare thee well, my friends.', 1, 0, 0),
(2, 'Florenz', 'Healer', 'With a slight build, Florenz is better suited as a healer than a fighter.', 1, 1, 5, 5, 15, 10, 'a:4:{s:4:\"heal\";s:1:\"2\";s:5:\"magic\";s:1:\"0\";s:5:\"fight\";b:0;s:6:\"defend\";b:0;}', 0, 0, 'Degolburg', 1, 0, 3, 1000, 'Thank ye for thy faith in my skills.  I shall endeavour to keep ye away from Ramius\' claws.', 'O Discordia!', 1, 0, 0);

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
  MODIFY `companionid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
