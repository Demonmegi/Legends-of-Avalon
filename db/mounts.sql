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
-- Table structure for table `mounts`
--

CREATE TABLE `mounts` (
  `mountid` int(11) UNSIGNED NOT NULL,
  `mountname` varchar(50) NOT NULL,
  `mountdesc` text DEFAULT NULL,
  `mountcategory` varchar(50) NOT NULL,
  `mountbuff` text DEFAULT NULL,
  `mountcostgems` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `mountcostgold` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `mountactive` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `mountforestfights` int(11) NOT NULL DEFAULT 0,
  `newday` text NOT NULL,
  `recharge` text NOT NULL,
  `partrecharge` text NOT NULL,
  `mountfeedcost` int(11) UNSIGNED NOT NULL DEFAULT 20,
  `mountlocation` varchar(25) NOT NULL DEFAULT 'all',
  `mountdkcost` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mounts`
--

INSERT INTO `mounts` (`mountid`, `mountname`, `mountdesc`, `mountcategory`, `mountbuff`, `mountcostgems`, `mountcostgold`, `mountactive`, `mountforestfights`, `newday`, `recharge`, `partrecharge`, `mountfeedcost`, `mountlocation`, `mountdkcost`) VALUES
(1, 'Pony', 'This docile beast is young yet.', 'Horses', 'a:5:{s:4:\"name\";s:13:\"`&Pony Attack\";s:8:\"roundmsg\";s:26:\"Your pony fights with you!\";s:6:\"rounds\";s:2:\"20\";s:6:\"atkmod\";s:3:\"1.2\";s:8:\"activate\";s:7:\"offense\";}', 6, 0, 1, 1, 'You strap your {weapon} to your pony\'s saddle bags, and head out for some adventure!', '`&Remembering that is has been quite some time since you last fed your pony, you decide this is a perfect time to relax and allow it to graze the field a bit. You doze off enjoying this peaceful serenity.`0', '`&You dismount in the field to allow your pony to graze for a moment even though it has recently been fully fed.  As you lean back in the grass to watch the clouds, your pony whickers softly and trots off into the underbrush.  You search for a while before returning to the fields hoping that it\'ll return.  A short time later, your pony trots back into the clearing holding its head high, looking much more energized and with a very equine grin on its face.`0', 20, 'all', 0),
(2, 'Gelding', 'This powerful beast is fiercely loyal.', 'Horses', 'a:5:{s:4:\"name\";s:16:\"`&Gelding Attack\";s:8:\"roundmsg\";s:29:\"Your gelding fights with you!\";s:6:\"rounds\";s:2:\"40\";s:6:\"atkmod\";s:3:\"1.2\";s:8:\"activate\";s:7:\"offense\";}', 10, 0, 1, 2, 'You strap your {weapon} to your gelding\'s saddle bags, and head out for some adventure!', '`&Remembering that is has been quite some time since you last fed your gelding, you decide this is a perfect time to relax and allow it to graze the field a bit. You doze off enjoying this peaceful serenity.`0', '`&You dismount in the field to allow your gelding to graze for a moment even though it has recently been fully fed.  As you lean back in the grass to watch the clouds, your gelding whickers softly and trots off into the underbrush.  You search for a while before returning to the fields hoping that it\'ll return.  A short time later, your gelding trots back into the clearing holding its head high, looking much more energized and with a very equine grin on its face.`n`nAnd here you thought geldings weren\'t equipped that way any longer!`0', 25, 'all', 0),
(3, 'Stallion', 'This noble beast is huge and powerful!', 'Horses', 'a:5:{s:4:\"name\";s:17:\"`&Stallion Attack\";s:8:\"roundmsg\";s:30:\"Your stallion fights with you!\";s:6:\"rounds\";s:2:\"60\";s:6:\"atkmod\";s:3:\"1.2\";s:8:\"activate\";s:7:\"offense\";}', 16, 0, 1, 3, 'You strap your {weapon} to your stallion\'s saddle bags, and head out for some adventure!', '`&Remembering that is has been quite some time since you last fed your stallion, you decide this is a perfect time to relax and allow it to graze the field a bit. You doze off enjoying this peaceful serenity.`0', '`&You dismount in the field to allow your stallion to graze for a moment even though it has recently been fully fed.  As you lean back in the grass to watch the clouds, your stallion whickers softly and trots off into the underbrush.  You search for a while before returning to the fields hoping that it\'ll return.  A short time later, your stallion trots back into the clearing holding its head high, looking much more energized and with a very equine grin on its face.`0', 30, 'all', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mounts`
--
ALTER TABLE `mounts`
  ADD PRIMARY KEY (`mountid`),
  ADD KEY `mountid` (`mountid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mounts`
--
ALTER TABLE `mounts`
  MODIFY `mountid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
