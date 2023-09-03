-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2023 at 05:11 PM
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
('alignment', 'creatures', 'al', 5, '0'),
('alignment', 'creatures', 'al', 6, '0'),
('alignment', 'creatures', 'al', 11, '0'),
('alignment', 'creatures', 'al', 14, '0'),
('alignment', 'creatures', 'al', 15, '0'),
('alignment', 'creatures', 'al', 16, '0'),
('alignment', 'creatures', 'al', 17, '0'),
('alignment', 'creatures', 'al', 18, '0'),
('alignment', 'creatures', 'al', 20, '0'),
('alignment', 'creatures', 'al', 21, '0'),
('alignment', 'creatures', 'al', 150, '0'),
('alignment', 'creatures', 'al', 156, '0'),
('alignment', 'creatures', 'al', 160, '0'),
('alignment', 'creatures', 'al', 177, '0'),
('alignment', 'creatures', 'al', 179, '0'),
('alignment', 'creatures', 'al', 223, '0'),
('alignment', 'creatures', 'al', 224, '0'),
('alignment', 'creatures', 'al', 225, '0'),
('alignment', 'creatures', 'al', 230, '0'),
('alignment', 'creatures', 'al', 231, '0'),
('alignment', 'creatures', 'al', 234, '0'),
('alignment', 'creatures', 'al', 235, '0'),
('alignment', 'creatures', 'al', 236, '0'),
('alignment', 'creatures', 'al', 241, '0'),
('alignment', 'creatures', 'al', 242, '0'),
('alignment', 'creatures', 'al', 243, '0'),
('alignment', 'creatures', 'al', 244, '0'),
('alignment', 'creatures', 'al', 249, '0'),
('alignment', 'creatures', 'al', 251, '0'),
('alignment', 'creatures', 'al', 253, '0'),
('alignment', 'creatures', 'al', 254, '0'),
('alignment', 'creatures', 'al', 255, '0'),
('alignment', 'creatures', 'al', 258, '0'),
('alignment', 'creatures', 'al', 259, '0'),
('cityimages', 'city', 'cityimg', 1, 'images/village.jpg'),
('cityimages', 'city', 'cityimg', 2, 'images/southgate.jpg'),
('cityimages', 'city', 'cityimg', 3, 'images/outerbailey.jpg'),
('cityimages', 'city', 'cityimg', 4, 'images/peasantsbailey.jpg'),
('cityimages', 'city', 'cityimg', 5, 'images/outerkeep.jpg'),
('cityimages', 'city', 'cityimg', 6, 'images/innerbailey.jpg'),
('cityimages', 'city', 'cityimg', 7, 'images/innerkeep.jpg'),
('cityimages', 'city', 'cityimgtags', 1, ''),
('cityimages', 'city', 'cityimgtags', 2, ''),
('cityimages', 'city', 'cityimgtags', 3, ''),
('cityimages', 'city', 'cityimgtags', 4, ''),
('cityimages', 'city', 'cityimgtags', 5, ''),
('cityimages', 'city', 'cityimgtags', 6, ''),
('cityimages', 'city', 'cityimgtags', 7, ''),
('city_weather', 'city', 'chance', 1, '0'),
('city_weather', 'city', 'chance', 2, '0'),
('city_weather', 'city', 'chance', 3, '0'),
('city_weather', 'city', 'chance', 4, '0'),
('city_weather', 'city', 'chance', 5, '0'),
('city_weather', 'city', 'chance', 6, '0'),
('city_weather', 'city', 'chance', 7, '0'),
('city_weather', 'city', 'chance', 8, '50'),
('city_weather', 'city', 'chance', 9, '50'),
('city_weather', 'city', 'chance', 10, '50'),
('city_weather', 'city', 'wx', 1, 'snow flurries'),
('city_weather', 'city', 'wx', 8, 'frost'),
('city_weather', 'city', 'wx', 9, 'snow flurries'),
('city_weather', 'city', 'wx', 10, 'frost'),
('city_weather', 'city', 'wx1', 8, 'snow flurries'),
('city_weather', 'city', 'wx1', 9, 'snow flurries'),
('city_weather', 'city', 'wx1', 10, 'snow flurries'),
('city_weather', 'city', 'wx2', 8, 'clear and cold'),
('city_weather', 'city', 'wx2', 9, 'clear and cold'),
('city_weather', 'city', 'wx2', 10, 'clear and cold'),
('city_weather', 'city', 'wx3', 8, 'snow blizzards'),
('city_weather', 'city', 'wx3', 9, 'snow blizzards'),
('city_weather', 'city', 'wx3', 10, 'snow blizzards'),
('city_weather', 'city', 'wx4', 8, 'frost'),
('city_weather', 'city', 'wx4', 9, 'frost'),
('city_weather', 'city', 'wx4', 10, 'frost'),
('city_weather', 'city', 'wx5', 8, 'soft falling snow'),
('city_weather', 'city', 'wx5', 9, 'soft falling snow'),
('city_weather', 'city', 'wx5', 10, 'soft falling snow'),
('city_weather', 'city', 'wx6', 8, 'some great skiing weather'),
('city_weather', 'city', 'wx6', 9, 'some great skiing weather'),
('city_weather', 'city', 'wx6', 10, 'some great skiing weather'),
('city_weather', 'city', 'wx7', 8, 'a possibility of snow'),
('city_weather', 'city', 'wx7', 9, 'a possibility of snow'),
('city_weather', 'city', 'wx7', 10, 'a possibility of snow'),
('city_weather', 'city', 'wx8', 8, 'fog and frost'),
('city_weather', 'city', 'wx8', 9, 'fog and frost'),
('city_weather', 'city', 'wx8', 10, 'fog and frost'),
('city_weather', 'city', 'wxreport', 1, '`n`&The weather elf is predicting `^%s`& today.`n'),
('city_weather', 'city', 'wxreport', 8, '`n`&The weather elf is predicting `^%s`& today.`n'),
('city_weather', 'city', 'wxreport', 9, '`n`&The weather elf is predicting `^%s`& today.`n'),
('city_weather', 'city', 'wxreport', 10, '`n`&The weather elf is predicting `^%s`& today.`n'),
('darkhorse', 'mounts', 'findtavern', 0, '0'),
('darkhorse', 'mounts', 'findtavern', 1, '0'),
('darkhorse', 'mounts', 'findtavern', 2, '0'),
('darkhorse', 'mounts', 'findtavern', 3, '0'),
('darkhorse', 'mounts', 'findtavern', 4, '0'),
('darkhorse', 'mounts', 'findtavern', 5, '0'),
('race_customisetext', 'races', 'disable', 0, '1'),
('race_customisetext', 'races', 'disable', 1, '1'),
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
