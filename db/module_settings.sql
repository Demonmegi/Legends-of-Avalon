-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 02:02 PM
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
-- Table structure for table `module_settings`
--

CREATE TABLE `module_settings` (
  `modulename` varchar(50) NOT NULL,
  `setting` varchar(50) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `module_settings`
--

INSERT INTO `module_settings` (`modulename`, `setting`, `value`) VALUES
('cities', 'allowance', '65000'),
('cities', 'coward', '1'),
('cities', 'dangerchance', '66'),
('cities', 'safechance', '0'),
('cities', 'travelspecialchance', '0'),
('dpafterdk', 'maxdp1', '20'),
('dpafterdk', 'maxdp2', '35'),
('dpafterdk', 'maxdp3', '75'),
('expbar', 'showbar', '1'),
('expbar', 'showexpnumber', '1'),
('expbar', 'shownextgoal', '1'),
('findgold', 'maxgold', '50'),
('findgold', 'mingold', '10'),
('goldmine', 'alwaystether', '10'),
('goldmine', 'percentgemloss', '0'),
('goldmine', 'percentgoldloss', '0'),
('healthbar', 'showbar', '1'),
('healthbar', 'showcurrent', '1'),
('healthbar', 'showmax', '1'),
('specialtyarcher', 'mindk', '0'),
('specialtyfighter', 'cost', '0'),
('specialtyfighter', 'mindk', '0'),
('translationwizard', 'autoscan', '0'),
('translationwizard', 'blockcentral', '0'),
('translationwizard', 'blocktrans', '0'),
('translationwizard', 'lookuppath', 'http://translations.nb-core.org'),
('translationwizard', 'page', '20'),
('translationwizard', 'query', '0'),
('translationwizard', 'restricted', '0'),
('translationwizard', 'translationdelete', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module_settings`
--
ALTER TABLE `module_settings`
  ADD PRIMARY KEY (`modulename`,`setting`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
