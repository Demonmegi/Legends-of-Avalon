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
-- Table structure for table `taunts`
--

CREATE TABLE `taunts` (
  `tauntid` int(11) UNSIGNED NOT NULL,
  `taunt` text DEFAULT NULL,
  `editor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `taunts`
--

INSERT INTO `taunts` (`tauntid`, `taunt`, `editor`) VALUES
(1, '`5\"`6Just wait for my revenge, `4%W`6. It will be swift!`5\" %w declares.', 'Bluspring'),
(2, '`5\"`6I\'m really going to enjoy this new `4%x`6 that %w`6 had,`5\" exclaimed %W.', 'joe'),
(3, '`5\"`6Aah, so `bthat\'s`b what `4%X`6 is for!`5\" exclaimed %W', 'joe'),
(4, '`5\"`6Oh man!  I didn\'t think you had it in you, `5%W`6,`5\" %w exclaims.', 'Bluspring'),
(5, '`5%W was overheard saying, \"`6%p `4%x`6 was no match for my `4%X`6!`5\"', 'Bluspring'),
(6, '`5\"`6You know, you really shouldn\'t have a `4%x`6 unless you know how to use it,`5\" suggested %W.', 'Bluspring'),
(7, '`5\"`6`bARRRGGGGGGG`b!!`5\" %w screams in frustration.', 'Bluspring'),
(8, '`5\"`6How could I be so feeble?`5\" %w laments.', 'Bluspring'),
(9, '`5\"`6I must not be as sturdy as I thought...!`5\" %w concedes.', 'Bluspring'),
(10, '`5\"`6Watch your back, `4%W`6, I am coming for you!`5\" %w warns.', 'Bluspring'),
(11, '`5\"`6This both sucks and blows!`5\" wails %w.', 'Bluspring'),
(12, '`5\"`6I see London, I see France, I see `4%w\'s`6 underpants!`5\" reveals %W.', 'Bluspring'),
(13, '`5\"`6The Healer\'s Hut can\'t help you now, `4%w`6!`5\" chides %W.', 'Bluspring'),
(14, '`5%W smiles.  \"`6You are too slow.  You are too weak.`5\"', 'Bluspring'),
(15, '`5%w bangs %p head against a stone...\"`6Stupid, stupid, stupid!`5\" %o was heard to say.', 'Bluspring'),
(16, '`5\"`6My ego can\'t take much more of this bruising!`5\" exclaims %w.', 'Bluspring'),
(17, '`5\"`6Why didn\'t I become a successful doctor like my father suggested?`5\" wonders %w aloud.', 'Bluspring'),
(18, '`5\"`6Maybe `bnext`b time you won\'t be so cocky!`5\" laughs %W', 'Bluspring'),
(19, '`5\"`6A baby could wield a `4%x `6better than that!`5\" %W proclaims.', 'Bluspring'),
(20, '`5\"`6You should have just stayed in bed,`5\" %W suggests.', 'Bluspring'),
(21, '`5\"`6Well isn\'t that a kick in the crotch?!`5\" %w observes.', 'Bluspring'),
(22, '`5\"`6Come back when you learn how to fight,`5\" %W scoffs.', 'Bluspring'),
(23, '`5\"`6Next time, eat your Wheaties,`5\" %W suggests.', 'Bluspring'),
(24, '`5 \"`6You are dishonorable, `4%W`6!`5\" %w cries.', 'Bluspring'),
(25, '`5\"`4%w`6, your lack of posture is a disgrace,`5\" %W states. ', 'Bluspring'),
(26, '`5\"`6You know, `4%w`6 really had it coming to %s after all those things `bI`b said about `b%p`b mom`5,\" commented %W.', 'Joe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `taunts`
--
ALTER TABLE `taunts`
  ADD PRIMARY KEY (`tauntid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `taunts`
--
ALTER TABLE `taunts`
  MODIFY `tauntid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
