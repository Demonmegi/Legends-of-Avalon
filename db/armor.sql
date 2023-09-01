-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 01:01 AM
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
-- Table structure for table `armor`
--

CREATE TABLE `armor` (
  `armorid` int(11) UNSIGNED NOT NULL,
  `armorname` varchar(128) DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `defense` int(11) NOT NULL DEFAULT 1,
  `level` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `armor`
--

INSERT INTO `armor` (`armorid`, `armorname`, `value`, `defense`, `level`) VALUES
(1, 'Fuzzy Slippers', 48, 1, 0),
(2, 'Flannel Pajamas', 225, 2, 0),
(3, 'Homespun Longjohns', 585, 3, 0),
(4, 'Homespun Undershirt', 990, 4, 0),
(5, 'Knitted Socks', 1575, 5, 0),
(6, 'Knitted Gloves', 2250, 6, 0),
(7, 'Old Leather Boots', 2790, 7, 0),
(8, 'Homespun Pants', 3420, 8, 0),
(9, 'Homespun Tunic', 4230, 9, 0),
(10, 'Gypsy Cape', 5040, 10, 0),
(11, 'Old Leather Cap', 5850, 11, 0),
(12, 'Old Leather Bracers', 6840, 12, 0),
(13, 'Traveller\'s Shield', 8010, 13, 0),
(14, 'Old Leather Pants', 9000, 14, 0),
(15, 'Old Leather Tunic', 10350, 15, 0),
(16, 'Flip-Flops', 48, 1, 1),
(17, 'Swimsuit and Towel', 225, 2, 1),
(18, 'Cotton Undershirt', 585, 3, 1),
(19, 'Wool Socks', 990, 4, 1),
(20, 'Wool Gloves', 1575, 5, 1),
(21, 'Leather Boots', 2250, 6, 1),
(22, 'Leather Cap', 2790, 7, 1),
(23, 'Leather Bracers', 3420, 8, 1),
(24, 'Leather Leggings', 4230, 9, 1),
(25, 'Leather Tunic', 5040, 10, 1),
(26, 'Hooded Leather Cape', 5850, 11, 1),
(27, 'Deerskin Leggings', 6840, 12, 1),
(28, 'Deerskin Belt', 8010, 13, 1),
(29, 'Deerskin Tunic', 9000, 14, 1),
(30, 'Small Rawhide Shield', 10350, 15, 1),
(31, 'Workboots', 48, 1, 2),
(32, 'Overalls', 225, 2, 2),
(33, 'Sturdy Leather Gloves', 585, 3, 2),
(34, 'Sturdy Leather Bracers', 990, 4, 2),
(35, 'Sturdy Leather Boots', 1575, 5, 2),
(36, 'Sturdy Leather Helm', 2250, 6, 2),
(37, 'Sturdy Leather Pants', 2790, 7, 2),
(38, 'Sturdy Leather Tunic', 3420, 8, 2),
(39, 'Sturdy Leather Cloak', 4230, 9, 2),
(40, 'Woodsman\'s Helm', 5040, 10, 2),
(41, 'Woodsman\'s Gauntlets', 5850, 11, 2),
(42, 'Woodsman\'s Bracers', 6840, 12, 2),
(43, 'Woodsman\'s Greaves', 8010, 13, 2),
(44, 'Woodsman\'s Tunic', 9000, 14, 2),
(45, 'Woodsman\'s Kite Shield', 10350, 15, 2),
(46, 'Showercap and Towel', 48, 1, 3),
(47, 'Bathrobe', 225, 2, 3),
(48, 'Wolfskin Gloves', 585, 3, 3),
(49, 'Wolfskin-lined Boots', 990, 4, 3),
(50, 'Wolfskin Bracers', 1575, 5, 3),
(51, 'Wolfskin Pants', 2250, 6, 3),
(52, 'Wolfskin Tunic', 2790, 7, 3),
(53, 'Hooded Wolfskin Cape', 3420, 8, 3),
(54, 'Wolfmaster\'s Bracers', 4230, 9, 3),
(55, 'Wolfmaster\'s Gauntlets', 5040, 10, 3),
(56, 'Wolfmasters Helm', 5850, 11, 3),
(57, 'Wolfmaster\'s Leggings', 6840, 12, 3),
(58, 'Wolfmaster\'s Belted Jerkin', 8010, 13, 3),
(59, 'Wolfhide Cape', 9000, 14, 3),
(60, 'Shield of the Wolf Master', 10350, 15, 3),
(61, 'Sweat Pants', 48, 1, 4),
(62, 'Sweat Shirt', 225, 2, 4),
(63, 'Studded Leather Helm', 585, 3, 4),
(64, 'Studded Leather Gauntlets', 990, 4, 4),
(65, 'Hardened Leather Boots', 1575, 5, 4),
(66, 'Studded Leather Leggings', 2250, 6, 4),
(67, 'Studded Leather Tunic', 2790, 7, 4),
(68, 'Tanner\'s Cape', 3420, 8, 4),
(69, 'Rusty Chainmail Helm', 4230, 9, 4),
(70, 'Rusty Chainmail Gauntlets', 5040, 10, 4),
(71, 'Rusty Chainmail Bracers', 5850, 11, 4),
(72, 'Rusty Chainmail Boots', 6840, 12, 4),
(73, 'Rusty Chainmail Greaves', 8010, 13, 4),
(74, 'Rusty Chainmail Tunic', 9000, 14, 4),
(75, 'Large Iron Buckler', 10350, 15, 4),
(76, 'Bunny Slippers', 48, 1, 5),
(77, 'Feety Pajamas', 225, 2, 5),
(78, 'Comfortable Leather Undergarments', 585, 3, 5),
(79, 'Heavy Chainmail Helm', 990, 4, 5),
(80, 'Heavy Chainmail Gauntlets', 1575, 5, 5),
(81, 'Heavy Chainmail Bracers', 2250, 6, 5),
(82, 'Heavy Chainmail Boots', 2790, 7, 5),
(83, 'Heavy Chainmail Greaves', 3420, 8, 5),
(84, 'Heavy Chainmail Tunic', 4230, 9, 5),
(85, 'Dragon Soldier\'s Bracers', 5040, 10, 5),
(86, 'Dragon Soldier\'s Gauntlets', 5850, 11, 5),
(87, 'Dragon Soldier\'s Boots', 6840, 12, 5),
(88, 'Dragon Soldier\'s Greaves', 8010, 13, 5),
(89, 'Dragon Soldier\'s Chestplate', 9000, 14, 5),
(90, 'Dragon Soldier\'s Shield', 10350, 15, 5),
(91, 'Bluejeans', 48, 1, 6),
(92, 'Flannel Shirt', 225, 2, 6),
(93, 'Well Crafted Bronze Helm', 585, 3, 6),
(94, 'Well Crafted Bronze Gauntlets', 990, 4, 6),
(95, 'Well Crafted Bronze Bracers', 1575, 5, 6),
(96, 'Well Crafted Bronze Boots', 2250, 6, 6),
(97, 'Well Crafted Bronze Greaves', 2790, 7, 6),
(98, 'Well Crafted Bronze Chestplate', 3420, 8, 6),
(99, 'Enchanted Bronze Helm', 4230, 9, 6),
(100, 'Enchanted Bronze Gauntlets', 5040, 10, 6),
(101, 'Enchanted Bronze Bracers', 5850, 11, 6),
(102, 'Enchanted Bronze Boots', 6840, 12, 6),
(103, 'Enchanted Bronze Greaves', 8010, 13, 6),
(104, 'Enchanted Bronze Chestplate', 9000, 14, 6),
(105, 'Hooded Unicorn Skin Cloak', 10350, 15, 6),
(106, 'Barrel', 48, 1, 7),
(107, 'Lampshade', 225, 2, 7),
(108, 'Perfectly Crafted Steel Helm', 585, 3, 7),
(109, 'Perfectly Crafted Steel Gauntlets', 990, 4, 7),
(110, 'Perfectly Crafted Steel Boots', 1575, 5, 7),
(111, 'Perfectly Crafted Steel Bracers', 2250, 6, 7),
(112, 'Perfectly Crafted Steel Greaves', 2790, 7, 7),
(113, 'Perfectly Crafted Steel Chestplate', 3420, 8, 7),
(114, 'Griffon-Feather Cloak', 4230, 9, 7),
(115, 'Dwarven Chainmail Helm', 5040, 10, 7),
(116, 'Dwarven Chainmail Gauntlets', 5850, 11, 7),
(117, 'Dwarven Chainmail Boots', 6840, 12, 7),
(118, 'Dwarven Chainmail Bracers', 8010, 13, 7),
(119, 'Dwarven Chainmail Greaves', 9000, 14, 7),
(120, 'Dwarven Chainmail Chestplate', 10350, 15, 7),
(121, 'Fig Leaf', 48, 1, 8),
(122, 'Kilt', 225, 2, 8),
(123, 'Majestic Gold Helm', 585, 3, 8),
(124, 'Majestic Gold Gauntlets', 990, 4, 8),
(125, 'Majestic Gold Boots', 1575, 5, 8),
(126, 'Bracers', 2250, 6, 8),
(127, 'Majestic Gold Greaves', 2790, 7, 8),
(128, 'Majestic Gold Chestplate', 3420, 8, 8),
(129, 'Majestic Gold Shield', 4230, 9, 8),
(130, 'Gold-Threaded Cloak', 5040, 10, 8),
(131, 'Enchanted Ruby Ring', 5850, 11, 8),
(132, 'Enchanted Sapphire Ring', 6840, 12, 8),
(133, 'Enchanted Jade Ring', 8010, 13, 8),
(134, 'Enchanted Amethyst Ring', 9000, 14, 8),
(135, 'Enchanted Diamond Ring', 10350, 15, 8),
(136, 'Button', 48, 1, 9),
(137, 'Elven Silk Nightclothes', 225, 2, 9),
(138, 'Elven Silk Gloves', 585, 3, 9),
(139, 'Elven Silk Slippers', 990, 4, 9),
(140, 'Elven Silk Wristband', 1575, 5, 9),
(141, 'Leggings', 2250, 6, 9),
(142, 'Elven Silk Tunic', 2790, 7, 9),
(143, 'Elven Silk Cloak', 3420, 8, 9),
(144, 'Ring of Night', 4230, 9, 9),
(145, 'Ring of Day', 5040, 10, 9),
(146, 'Ring of Solitude', 5850, 11, 9),
(147, 'Ring of Peace', 6840, 12, 9),
(148, 'Ring of Courage', 8010, 13, 9),
(149, 'Ring of Virtue', 9000, 14, 9),
(150, 'Ring of Life', 10350, 15, 9),
(151, 'Pegasus\' Hooded Cloak', 5040, 10, 10),
(152, 'Pegasus\' Chestplate', 4230, 9, 10),
(153, 'Pegasus\' Greaves', 3420, 8, 10),
(154, 'Pegasus\' Boots', 2790, 7, 10),
(155, 'Pegasus\' Gorget', 2250, 6, 10),
(156, 'Pegasus\' Bracers', 1575, 5, 10),
(157, 'Pegasus\' Gauntlets', 990, 4, 10),
(158, 'Pegasus\' Helm', 585, 3, 10),
(159, 'Platform Shoes', 225, 2, 10),
(160, 'Leisure Suit', 48, 1, 10),
(161, 'Pegasus Feather Pendant', 5850, 11, 10),
(162, 'Pegasus Feather Belt', 6840, 12, 10),
(163, 'Pegasus\' Emblazoned Shield', 8010, 13, 10),
(164, 'Pegasus\' Emblazoned Ring', 9000, 14, 10),
(165, 'Pegasus\' Emblazoned Crown', 10350, 15, 10),
(166, 'New Clothes', 48, 1, 11),
(167, 'Chicken Suit', 225, 2, 11),
(168, 'Gauntlets of Grace', 585, 3, 11),
(169, 'Bracer of Beauty', 990, 4, 11),
(170, 'Helm of Health', 1575, 5, 11),
(171, 'Greaves of Good Fortune', 2250, 6, 11),
(172, 'Boots of Bravery', 2790, 7, 11),
(173, 'Tunic of Tolerance', 3420, 8, 11),
(174, 'Cloak of Confidence', 4230, 9, 11),
(175, 'Ring of Righteousness', 5040, 10, 11),
(176, 'Necklace of Narcissism', 5850, 11, 11),
(177, 'Pendant of Power', 6840, 12, 11),
(178, 'Breastplate of Benevolence', 8010, 13, 11),
(179, 'Shield of Superiority', 9000, 14, 11),
(180, 'Scepter of Strength', 10350, 15, 11),
(181, 'Dragon Skin Leather Helm', 48, 1, 12),
(182, 'Dragon Skin Leather Gauntlets', 225, 2, 12),
(183, 'Dragon Skin Leather Boots', 585, 3, 12),
(184, 'Dragon Skin Leather Bracers', 990, 4, 12),
(185, 'Dragon Skin Leather Leggings', 1575, 5, 12),
(186, 'Dragon Skin Leather Tunic', 2250, 6, 12),
(187, 'Dragon Skin Leather Cloak', 2790, 7, 12),
(188, 'Dragon Scale Helm', 3420, 8, 12),
(189, 'Dragon Scale Gauntlets', 4230, 9, 12),
(190, 'Dragon Scale Boots', 5040, 10, 12),
(191, 'Dragon Scale Bracers', 5850, 11, 12),
(192, 'Dragon Scale Greaves', 6840, 12, 12),
(193, 'Dragon Scale Chestplate', 8010, 13, 12),
(194, 'Dragon Scale Cloak', 9000, 14, 12),
(195, 'Dragon Talon Shield', 10350, 15, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `armor`
--
ALTER TABLE `armor`
  ADD PRIMARY KEY (`armorid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `armor`
--
ALTER TABLE `armor`
  MODIFY `armorid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
