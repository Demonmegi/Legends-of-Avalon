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
-- Table structure for table `weapons`
--

CREATE TABLE `weapons` (
  `weaponid` int(11) UNSIGNED NOT NULL,
  `weaponname` varchar(128) DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `damage` int(11) NOT NULL DEFAULT 1,
  `level` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `weapons`
--

INSERT INTO `weapons` (`weaponid`, `weaponname`, `value`, `damage`, `level`) VALUES
(1, 'Rake', 48, 1, 0),
(2, 'Trowel', 225, 2, 0),
(3, 'Spade', 585, 3, 0),
(4, 'Adze', 990, 4, 0),
(5, 'Gardening Hoe', 1575, 5, 0),
(6, 'Torch', 2250, 6, 0),
(7, 'Pitchfork', 2790, 7, 0),
(8, 'Shovel', 3420, 8, 0),
(9, 'Hedge Trimmers', 4230, 9, 0),
(10, 'Hatchet', 5040, 10, 0),
(11, 'Carving Knife', 5850, 11, 0),
(12, 'Rusty Iron Wood-Chopping Axe', 6840, 12, 0),
(13, 'Dull Steel Wood-chopping Axe', 8010, 13, 0),
(14, 'Sharp Steel Wood-chopping Axe', 9000, 14, 0),
(15, 'Woodsman\'s Axe', 10350, 15, 0),
(16, 'Pebbles', 48, 1, 1),
(17, 'Stones', 225, 2, 1),
(18, 'Rocks', 585, 3, 1),
(19, 'Small Treebranch', 990, 4, 1),
(20, 'Large Treebranch', 1575, 5, 1),
(21, 'Thickly Padded Sparring Pole', 2250, 6, 1),
(22, 'Thinly Padded Sparring Pole', 2790, 7, 1),
(23, 'Wooden Stave', 3420, 8, 1),
(24, 'Wooden Practice Sword', 4230, 9, 1),
(25, 'Blunt Bronze Short Sword', 5040, 10, 1),
(26, 'Well Crafted Bronze Short Sword', 5850, 11, 1),
(27, 'Rusty Steel Short Sword', 6840, 12, 1),
(28, 'Dull Steel Short Sword', 8010, 13, 1),
(29, 'Sharp Steel Short Sword', 9000, 14, 1),
(30, 'Pages\'s Short Sword', 10350, 15, 1),
(31, 'Dull Bronze Sword', 48, 1, 2),
(32, 'Bronze Sword', 225, 2, 2),
(33, 'Well Crafted Bronze Sword', 585, 3, 2),
(34, 'Dull Iron Sword', 990, 4, 2),
(35, 'Iron Sword', 1575, 5, 2),
(36, 'Enchanted Sword', 9000, 14, 2),
(37, 'Well Crafted Iron Sword', 2250, 6, 2),
(38, 'Rusty Steel Sword', 2790, 7, 2),
(39, 'Dull Steel Sword', 3420, 8, 2),
(40, 'Well Crafted Steel Sword', 4230, 9, 2),
(41, 'Engraved Steel Sword', 5040, 10, 2),
(42, 'Steel Sword with Jeweled Hilt', 5850, 11, 2),
(43, 'Golden Hilted Sword', 6840, 12, 2),
(44, 'Platinum Hilted Sword', 8010, 13, 2),
(45, 'Adept\'s Sword', 10350, 15, 2),
(46, 'Steel Longsword', 48, 1, 3),
(47, 'Etched Steel Longsword', 585, 3, 3),
(48, 'Polished Steel Longsword', 225, 2, 3),
(49, 'Well Balanced Steel Longsword', 990, 4, 3),
(50, 'Perfectly Balanced Steel Longsword', 1575, 5, 3),
(51, 'Engraved Steel Longsword', 2250, 6, 3),
(52, 'Longsword with Silver-plated Hilt', 2790, 7, 3),
(53, 'Longsword with Gold-plated Hilt', 3420, 8, 3),
(54, 'Longsword with Solid Gold Hilt', 4230, 9, 3),
(55, 'Longsword with Solid Platinum Hilt', 5040, 10, 3),
(56, 'Moonsilver Longsword', 5850, 11, 3),
(57, 'Autumngold Longsword', 6840, 12, 3),
(58, 'Elfsilver Longsword', 8010, 13, 3),
(59, 'Enchanted Longsword', 9000, 14, 3),
(60, 'Wolfmaster\'s Longsword', 10350, 15, 3),
(61, 'Poorly Balanced Bastard Sword', 48, 1, 4),
(62, 'Tarnished Bastard Sword', 225, 2, 4),
(63, 'Iron Bastard Sword', 585, 3, 4),
(64, 'Steel Bastard Sword', 990, 4, 4),
(65, 'Well Balanced Steel Bastard Sword', 1575, 5, 4),
(66, 'Perfectly Balanced Bastard Sword', 2250, 6, 4),
(67, 'Rune-etched Bastard Sword', 2790, 7, 4),
(68, 'Bronze-inlay Bastard Sword', 3420, 8, 4),
(69, 'Silver-inlay Bastard Sword', 4230, 9, 4),
(70, 'Gold-inlay Bastard Sword', 5040, 10, 4),
(71, 'Nightsilver Bastard Sword', 5850, 11, 4),
(72, 'Morning-gold Bastard Sword', 6840, 12, 4),
(73, 'Truesplendor Bastard Sword', 8010, 13, 4),
(74, 'Enchanted Elfgold Bastard Sword', 9000, 14, 4),
(75, 'Noble\'s Bastard Sword', 10350, 15, 4),
(76, 'Tarnished Iron Claymore', 48, 1, 5),
(77, 'Polished Iron Claymore', 225, 2, 5),
(78, 'Rusty Steel Claymore', 585, 3, 5),
(79, 'Steel Claymore', 990, 4, 5),
(80, 'Finely Crafted Steel Claymore', 1575, 5, 5),
(81, 'Scottish Broadsword', 2250, 6, 5),
(82, 'Viking War Sword', 2790, 7, 5),
(83, 'Barbarian\'s Sword', 3420, 8, 5),
(84, 'Scottish Basket-Hilt Claymore', 4230, 9, 5),
(85, 'Agincourt Steel Sword', 5040, 10, 5),
(86, 'Celtic Combat Sword', 5850, 11, 5),
(87, 'Norseman\'s Sword', 6840, 12, 5),
(88, 'Knight\'s Sword', 8010, 13, 5),
(89, 'Heraldic Lion Claymore', 9000, 14, 5),
(90, 'Dragon Soldier\'s Claymore', 10350, 15, 5),
(91, 'Two Broken Short Swords', 48, 1, 6),
(92, 'Two Short Swords', 225, 2, 6),
(93, 'Iron Scimitars', 585, 3, 6),
(94, 'Balanced Scimitars', 990, 4, 6),
(95, 'Tarnished Steel Scimitars', 1575, 5, 6),
(96, 'Rusty Steel Scimitars', 2250, 6, 6),
(97, 'Steel Scimitars', 2790, 7, 6),
(98, 'Bronze Hilted Steel Scimitars', 3420, 8, 6),
(99, 'Gold Hilted Steel Scimitars', 4230, 9, 6),
(100, 'Platinum Hilted Steel Scimitars', 5040, 10, 6),
(101, 'Well Crafted Adamantite Scimitars', 5850, 11, 6),
(102, 'Perfectly Crafted Adamantite Scimitars', 6840, 12, 6),
(103, 'Enchanted Scimitars', 8010, 13, 6),
(104, 'Drow Crafted Scimitars', 9000, 14, 6),
(105, 'Unicorn Blood-Forged Scimitars', 10350, 15, 6),
(106, 'Chipped Iron Axe', 48, 1, 7),
(107, 'Iron Axe', 225, 2, 7),
(108, 'Rusty Steel Axe', 585, 3, 7),
(109, 'Fine Steel Axe', 990, 4, 7),
(110, 'Lumberjack\'s Axe', 1575, 5, 7),
(111, 'Low Quality Battle Axe', 2250, 6, 7),
(112, 'Medium Quality Battle Axe', 2790, 7, 7),
(113, 'High Quality Battle Axe', 3420, 8, 7),
(114, 'Double Bladed Axe', 4230, 9, 7),
(115, 'Double Bladed Battle Axe', 5040, 10, 7),
(116, 'Gold Plated Battle Axe', 5850, 11, 7),
(117, 'Platinum Hilted Battle Axe', 6840, 12, 7),
(118, 'Enchanted Battle Axe', 8010, 13, 7),
(119, 'Dwarf Smith\'s Battle Axe', 9000, 14, 7),
(120, 'Dwarf Warrior\'s Battle Axe', 10350, 15, 7),
(121, 'Broken Iron Mace', 48, 1, 8),
(122, 'Tarnished Iron Mace', 225, 2, 8),
(123, 'Polished Iron Mace', 585, 3, 8),
(124, 'Well Crafted Iron Mace', 990, 4, 8),
(125, 'Polished Steel Mace', 1575, 5, 8),
(126, 'Well Crafted Steel Mace', 2250, 6, 8),
(127, 'Poorly Balanced Double Mace', 2790, 7, 8),
(128, 'Well Balanced Double Mace', 3420, 8, 8),
(129, 'Battle Mace', 4230, 9, 8),
(130, 'War Chieftain\'s Battle Mace', 5040, 10, 8),
(131, 'War Chieftain\'s Morning Star', 5850, 11, 8),
(132, 'Adamantite Morning Star', 6840, 12, 8),
(133, 'Dwarf Crafted Morning Star', 8010, 13, 8),
(134, 'Dwarf Warlord\'s Morning Star', 9000, 14, 8),
(135, 'Enchanted Morning Star', 10350, 15, 8),
(136, 'Boot Knife', 48, 1, 9),
(137, 'Target Knife', 225, 2, 9),
(138, 'Blackjack', 585, 3, 9),
(139, 'Throwing Star', 990, 4, 9),
(140, 'Hira-Shuriken', 1575, 5, 9),
(141, 'Throwing Spike', 2250, 6, 9),
(142, 'Atlatl', 2790, 7, 9),
(143, 'Qilamitautit Bolo', 3420, 8, 9),
(144, 'War Quoait', 4230, 9, 9),
(145, 'Cha Kran', 5040, 10, 9),
(146, 'Fei Piau', 5850, 11, 9),
(147, 'Jen Piau', 6840, 12, 9),
(148, 'Gau dim Piau', 8010, 13, 9),
(149, 'Enchanted Throwing Axe', 9000, 14, 9),
(150, 'Teksolo\'s Ninja Stars', 10350, 15, 9),
(151, 'Farmer\'s Bow & Wooden Arrows', 48, 1, 10),
(152, 'Farmer\'s Bow & Stone Tipped Arrows', 225, 2, 10),
(153, 'Farmer\'s Bow & Steel Tipped Arrows', 585, 3, 10),
(154, 'Hunter\'s Bow & Wooden Arrows', 990, 4, 10),
(155, 'Hunter\'s Bow & Stone Tipped Arrows', 1575, 5, 10),
(156, 'Hunter\'s Bow & Steel Tipped Arrows', 2250, 6, 10),
(157, 'Ranger\'s Bow & Wooden Arrows', 2790, 7, 10),
(158, 'Ranger\'s Bow & Stone Tipped Arrows', 3420, 8, 10),
(159, 'Ranger\'s Bow & Steel Tipped Arrows', 4230, 9, 10),
(160, 'Longbow', 5040, 10, 10),
(161, 'Crossbow', 5850, 11, 10),
(162, 'Elvish Longbow', 6840, 12, 10),
(163, 'Elvish Longbow & Flame Tipped Arrows', 8010, 13, 10),
(164, 'Elvish Longbow & Enchanted Arrows', 9000, 14, 10),
(165, 'Longbow of the Elf King', 10350, 15, 10),
(166, 'MightyE\'s Long Sword', 225, 2, 11),
(167, 'MightyE\'s Short Sword', 48, 1, 11),
(168, 'MightyE\'s Bastard Sword', 585, 3, 11),
(169, 'MightyE\'s Scimitars', 990, 4, 11),
(170, 'MightyE\'s Battle Axe', 1575, 5, 11),
(171, 'MightyE\'s Throwing Hammer', 2250, 6, 11),
(172, 'MightyE\'s Morning Star', 2790, 7, 11),
(173, 'MightyE\'s Compound Bow', 3420, 8, 11),
(174, 'MightyE\'s Rapier', 4230, 9, 11),
(175, 'MightyE\'s Sabre', 5040, 10, 11),
(176, 'MightyE\'s Light Sabre', 5850, 11, 11),
(177, 'MightyE\'s Wakizashi', 6840, 12, 11),
(178, 'MightyE\'s 2-Handed War Sword', 8010, 13, 11),
(179, 'MightyE\'s 2-handed War Axe', 9000, 14, 11),
(180, 'MightyE\'s Claymore', 10350, 15, 11),
(181, 'Spell of Fire', 48, 1, 12),
(182, 'Spell of Earthquake', 225, 2, 12),
(183, 'Spell of Flood', 585, 3, 12),
(184, 'Spell of Hurricane', 990, 4, 12),
(185, 'Spell of Mind Control', 1575, 5, 12),
(186, 'Spell of Lightning', 2250, 6, 12),
(187, 'Spell of Weakness', 2790, 7, 12),
(188, 'Spell of Fear', 3420, 8, 12),
(189, 'Spell of Poison', 4230, 9, 12),
(190, 'Spell of Spirit Possession', 5040, 10, 12),
(191, 'Spell of Despair', 5850, 11, 12),
(192, 'Spell of Bat Summoning', 6840, 12, 12),
(193, 'Spell of Wolf Summoning', 8010, 13, 12),
(194, 'Spell of Unicorn Summoning', 9000, 14, 12),
(195, 'Spell of Dragon Summoning', 10350, 15, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weapons`
--
ALTER TABLE `weapons`
  ADD PRIMARY KEY (`weaponid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weapons`
--
ALTER TABLE `weapons`
  MODIFY `weaponid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
