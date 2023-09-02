-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 11:42 AM
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
-- Table structure for table `module_objprefs`
--

CREATE TABLE `module_objprefs` (
  `modulename` varchar(50) NOT NULL,
  `objtype` varchar(50) NOT NULL,
  `setting` varchar(50) NOT NULL,
  `objid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `module_objprefs`
--

INSERT INTO `module_objprefs` (`modulename`, `objtype`, `setting`, `objid`, `value`) VALUES
('race_customisetext', 'races', 'disable', 0, '1'),
('race_customisetext', 'races', 'tradeinarm', 3, '100'),
('race_customisetext', 'races', 'tradeinweap', 3, '100'),
('race_prerequisites', 'races', 'alignment', 3, '0'),
('race_prerequisites', 'races', 'alignment', 5, '0'),
('race_prerequisites', 'races', 'alignment', 6, '0'),
('race_prerequisites', 'races', 'alignment', 7, '0'),
('race_prerequisites', 'races', 'alignment', 8, '0'),
('race_prerequisites', 'races', 'alignment', 9, '0'),
('race_prerequisites', 'races', 'alignment', 10, '0'),
('race_prerequisites', 'races', 'alignment', 11, '0'),
('race_prerequisites', 'races', 'alignment', 12, '0'),
('race_prerequisites', 'races', 'dks', 3, '0'),
('race_prerequisites', 'races', 'dks', 5, '3'),
('race_prerequisites', 'races', 'dks', 6, '3'),
('race_prerequisites', 'races', 'dks', 7, '3'),
('race_prerequisites', 'races', 'dks', 8, '3'),
('race_prerequisites', 'races', 'dks', 9, '3'),
('race_prerequisites', 'races', 'dks', 10, '3'),
('race_prerequisites', 'races', 'dks', 11, '3'),
('race_prerequisites', 'races', 'dks', 12, '3'),
('race_prerequisites', 'races', 'dkshi', 5, '5'),
('race_prerequisites', 'races', 'dkshi', 6, '5'),
('race_prerequisites', 'races', 'dkshi', 7, '5'),
('race_prerequisites', 'races', 'dkshi', 8, '5'),
('race_prerequisites', 'races', 'dkshi', 9, '5'),
('race_prerequisites', 'races', 'dkshi', 10, '15'),
('race_prerequisites', 'races', 'dkshi', 11, '15'),
('race_prerequisites', 'races', 'dkshi', 12, '15'),
('race_prerequisites', 'races', 'sexreq', 3, '0'),
('race_prerequisites', 'races', 'sexreq', 5, '0'),
('race_prerequisites', 'races', 'sexreq', 6, '0'),
('race_prerequisites', 'races', 'sexreq', 7, '0'),
('race_prerequisites', 'races', 'sexreq', 8, '0'),
('race_prerequisites', 'races', 'sexreq', 9, '0'),
('race_prerequisites', 'races', 'sexreq', 10, '0'),
('race_prerequisites', 'races', 'sexreq', 11, '0'),
('race_prerequisites', 'races', 'sexreq', 12, '0'),
('race_weaponarmour', 'races', 'armorshop', 3, '0'),
('race_weaponarmour', 'races', 'armorshop', 5, '0'),
('race_weaponarmour', 'races', 'armorshop', 6, '0'),
('race_weaponarmour', 'races', 'armorshop', 7, '0'),
('race_weaponarmour', 'races', 'armorshop', 8, '0'),
('race_weaponarmour', 'races', 'armorshop', 9, '0'),
('race_weaponarmour', 'races', 'armorshop', 10, '0'),
('race_weaponarmour', 'races', 'armorshop', 11, '0'),
('race_weaponarmour', 'races', 'armorshop', 12, '0'),
('race_weaponarmour', 'races', 'armourcost', 3, '5'),
('race_weaponarmour', 'races', 'weaponcost', 3, '5'),
('race_weaponarmour', 'races', 'weaponshop', 3, '0'),
('race_weaponarmour', 'races', 'weaponshop', 5, '0'),
('race_weaponarmour', 'races', 'weaponshop', 6, '0'),
('race_weaponarmour', 'races', 'weaponshop', 7, '0'),
('race_weaponarmour', 'races', 'weaponshop', 8, '0'),
('race_weaponarmour', 'races', 'weaponshop', 9, '0'),
('race_weaponarmour', 'races', 'weaponshop', 10, '0'),
('race_weaponarmour', 'races', 'weaponshop', 11, '0'),
('race_weaponarmour', 'races', 'weaponshop', 12, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module_objprefs`
--
ALTER TABLE `module_objprefs`
  ADD PRIMARY KEY (`modulename`,`objtype`,`setting`,`objid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
