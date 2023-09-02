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
(1, 'Rechen', 48, 1, 0),
(2, 'Kelle', 225, 2, 0),
(3, 'Spaten', 585, 3, 0),
(4, 'Stemmeisen', 990, 4, 0),
(5, 'Gartenhacke', 1575, 5, 0),
(6, 'Fackel', 2250, 6, 0),
(7, 'Heugabel', 2790, 7, 0),
(8, 'Schaufel', 3420, 8, 0),
(9, 'Heckenschere', 4230, 9, 0),
(10, 'Beil', 5040, 10, 0),
(11, 'Schnitzmesser', 5850, 11, 0),
(12, 'Rostige Holzfälleraxt aus Eisen', 6840, 12, 0),
(13, 'Stumpfe Stahl-Holzfälleraxt', 8010, 13, 0),
(14, 'Scharfe Stahl-Holzfälleraxt', 9000, 14, 0),
(15, 'Waldarbeiteraxt', 10350, 15, 0),
(16, 'Kiesel', 48, 1, 1),
(17, 'Steine', 225, 2, 1),
(18, 'Felsen', 585, 3, 1),
(19, 'Kleiner Baumast', 990, 4, 1),
(20, 'Großer Baumast', 1575, 5, 1),
(21, 'Dicht gepolierter Übungspfosten', 2250, 6, 1),
(22, 'Dünn gepolierter Übungspfosten', 2790, 7, 1),
(23, 'Holzstange', 3420, 8, 1),
(24, 'Holzübungsschwert', 4230, 9, 1),
(25, 'Stumpfes Bronzekurzschwert', 5040, 10, 1),
(26, 'Gut gearbeitetes Bronzekurzschwert', 5850, 11, 1),
(27, 'Rostiges Stahlkurzschwert', 6840, 12, 1),
(28, 'Stumpfes Stahlkurzschwert', 8010, 13, 1),
(29, 'Scharfes Stahlkurzschwert', 9000, 14, 1),
(30, 'Pages Kurzschwert', 10350, 15, 1),
(31, 'Stumpfes Bronzeschwert', 48, 1, 2),
(32, 'Bronzeschwert', 225, 2, 2),
(33, 'Gut gearbeitetes Bronzeschwert', 585, 3, 2),
(34, 'Stumpfes Eisenschwert', 990, 4, 2),
(35, 'Eisenschwert', 1575, 5, 2),
(36, 'Verzaubertes Schwert', 9000, 14, 2),
(37, 'Gut gearbeitetes Eisenschwert', 2250, 6, 2),
(38, 'Rostiges Stahlschwert', 2790, 7, 2),
(39, 'Stumpfes Stahlschwert', 3420, 8, 2),
(40, 'Gut gearbeitetes Stahlschwert', 4230, 9, 2),
(41, 'Graviertes Stahlschwert', 5040, 10, 2),
(42, 'Stahlschwert mit juwelenbesetztem Griff', 5850, 11, 2),
(43, 'Goldgriff-Schwert', 6840, 12, 2),
(44, 'Platin-Schwertgriff', 8010, 13, 2),
(45, 'Adeptenschwert', 10350, 15, 2),
(46, 'Stahl-Langschwert', 48, 1, 3),
(47, 'Graviertes Stahl-Langschwert', 585, 3, 3),
(48, 'Poliertes Stahl-Langschwert', 225, 2, 3),
(49, 'Gut ausbalanciertes Stahl-Langschwert', 990, 4, 3),
(50, 'Perfekt ausbalanciertes Stahl-Langschwert', 1575, 5, 3),
(51, 'Graviertes Stahl-Langschwert mit silberplattiertem Griff', 2250, 6, 3),
(52, 'Langschwert mit goldplattiertem Griff', 2790, 7, 3),
(53, 'Langschwert mit massivem Goldgriff', 3420, 8, 3),
(54, 'Langschwert mit massivem Platingriff', 4230, 9, 3),
(55, 'Langschwert mit massivem Platinklingen', 5040, 10, 3),
(56, 'Mondsilber-Langschwert', 5850, 11, 3),
(57, 'Herbstgold-Langschwert', 6840, 12, 3),
(58, 'Elfsilber-Langschwert', 8010, 13, 3),
(59, 'Verzaubertes Langschwert', 9000, 14, 3),
(60, 'Wolfmeister-Langschwert', 10350, 15, 3),
(61, 'Schlecht ausbalanciertes Bastardschwert', 48, 1, 4),
(62, 'Angelaufenes Bastardschwert', 225, 2, 4),
(63, 'Eisernes Bastardschwert', 585, 3, 4),
(64, 'Stahl-Bastardschwert', 990, 4, 4),
(65, 'Gut ausbalanciertes Stahl-Bastardschwert', 1575, 5, 4),
(66, 'Perfekt ausbalanciertes Stahl-Bastardschwert', 2250, 6, 4),
(67, 'Runen-geätztes Bastardschwert', 2790, 7, 4),
(68, 'Bronze-eingelegtes Bastardschwert', 3420, 8, 4),
(69, 'Silber-eingelegtes Bastardschwert', 4230, 9, 4),
(70, 'Gold-eingelegtes Bastardschwert', 5040, 10, 4),
(71, 'Nacht-Silber-Bastardschwert', 5850, 11, 4),
(72, 'Morgen-Gold-Bastardschwert', 6840, 12, 4),
(73, 'Wahre Pracht Bastardschwert', 8010, 13, 4),
(74, 'Verzaubertes Elfgold-Bastardschwert', 9000, 14, 4),
(75, 'Edelmanns Bastardschwert', 10350, 15, 4),
(76, 'Angelaufenes Eisenschwert', 48, 1, 5),
(77, 'Poliertes Eisenschwert', 225, 2, 5),
(78, 'Rostiges Stahlclaymore', 585, 3, 5),
(79, 'Stahlclaymore', 990, 4, 5),
(80, 'Fein gearbeitetes Stahlclaymore', 1575, 5, 5),
(81, 'Schottisches Breitschwert', 2250, 6, 5),
(82, 'Wiking Kriegsschwert', 2790, 7, 5),
(83, 'Barbar-Schwert', 3420, 8, 5),
(84, 'Schottischer Korbhilt-Claymore', 4230, 9, 5),
(85, 'Agincourt-Stahlschwert', 5040, 10, 5),
(86, 'Keltisches Kampfschwert', 5850, 11, 5),
(87, 'Norseman-Schwert', 6840, 12, 5),
(88, 'Ritter-Schwert', 8010, 13, 5),
(89, 'Heraldic Lion-Claymore', 9000, 14, 5),
(90, 'Drachensoldaten-Claymore', 10350, 15, 5),
(91, 'Zwei gebrochene Kurzschwerter', 48, 1, 6),
(92, 'Zwei Kurzschwerter', 225, 2, 6),
(93, 'Eisensäbel', 585, 3, 6),
(94, 'Ausgeglichene Säbel', 990, 4, 6),
(95, 'Angelaufene Stahlsäbel', 1575, 5, 6),
(96, 'Rostige Stahlsäbel', 2250, 6, 6),
(97, 'Stahlsäbel', 2790, 7, 6),
(98, 'Bronzegriff-Stahlsäbel', 3420, 8, 6),
(99, 'Goldgriff-Stahlsäbel', 4230, 9, 6),
(100, 'Platin-Schwertgriff-Stahlsäbel', 5040, 10, 6),
(101, 'Meisterhaft gefertigte Adamantit-Krummsäbel', 5850, 11, 6),
(102, 'Perfekt gefertigte Adamantit-Krummsäbel', 6840, 12, 6),
(103, 'Verzauberte Krummsäbel', 8010, 13, 6),
(104, 'Drow-gefertigte Krummsäbel', 9000, 14, 6),
(105, 'Einhornblut-geschmiedete Krummsäbel', 10350, 15, 6),
(106, 'Einfache Eisenschneide', 48, 1, 7),
(107, 'Eisenschneide', 225, 2, 7),
(108, 'Rostige Stahlschneide', 585, 3, 7),
(109, 'Feine Stahlschneide', 990, 4, 7),
(110, 'Holzfälleraxt', 1575, 5, 7),
(111, 'Schlecht verarbeitete Streitaxt', 2250, 6, 7),
(112, 'Mittelmäßig verarbeitete Streitaxt', 2790, 7, 7),
(113, 'Hochwertige Streitaxt', 3420, 8, 7),
(114, 'Doppelschneidige Axt', 4230, 9, 7),
(115, 'Doppelschneidige Streitaxt', 5040, 10, 7),
(116, 'Goldbeschichtete Streitaxt', 5850, 11, 7),
(117, 'Platinhilt-Streitaxt', 6840, 12, 7),
(118, 'Verzauberte Streitaxt', 8010, 13, 7),
(119, 'Zwergenschmied-Streitaxt', 9000, 14, 7),
(120, 'Zwergenkrieger-Streitaxt', 10350, 15, 7),
(121, 'Kaputte Eisenkeule', 48, 1, 8),
(122, 'Angelaufene Eisenkeule', 225, 2, 8),
(123, 'Polierte Eisenkeule', 585, 3, 8),
(124, 'Gut gefertigte Eisenkeule', 990, 4, 8),
(125, 'Polierte Stahlkeule', 1575, 5, 8),
(126, 'Gut gefertigte Stahlkeule', 2250, 6, 8),
(127, 'Schlecht ausbalancierte Doppelkeule', 2790, 7, 8),
(128, 'Gut ausbalancierte Doppelkeule', 3420, 8, 8),
(129, 'Kampfkeule', 4230, 9, 8),
(130, 'Kriegshäuptlings-Kampfkeule', 5040, 10, 8),
(131, 'Kriegshäuptlings-Morgenstern', 5850, 11, 8),
(132, 'Adamantit-Morgenstern', 6840, 12, 8),
(133, 'Zwergen-gefertigter Morgenstern', 8010, 13, 8),
(134, 'Zwergenkriegsherr-Morgenstern', 9000, 14, 8),
(135, 'Verzauberter Morgenstern', 10350, 15, 8),
(136, 'Stiefelmesser', 48, 1, 9),
(137, 'Zielmesser', 225, 2, 9),
(138, 'Schlagstock', 585, 3, 9),
(139, 'Wurfninja-Stern', 990, 4, 9),
(140, 'Hira-Shuriken', 1575, 5, 9),
(141, 'Wurfpfeil', 2250, 6, 9),
(142, 'Atlatl', 2790, 7, 9),
(143, 'Qilamitautit Bolo', 3420, 8, 9),
(144, 'Kriegs-Quoait', 4230, 9, 9),
(145, 'Cha Kran', 5040, 10, 9),
(146, 'Fei Piau', 5850, 11, 9),
(147, 'Jen Piau', 6840, 12, 9),
(148, 'Gau dim Piau', 8010, 13, 9),
(149, 'Verzauberte Wurfaxt', 9000, 14, 9),
(150, 'Teksolo\'s Ninja-Sterne', 10350, 15, 9),
(151, 'Bauernbogen & Holzpfeile', 48, 1, 10),
(152, 'Bauernbogen & Steinpfeile', 225, 2, 10),
(153, 'Bauernbogen & Stahlpfeile', 585, 3, 10),
(154, 'Jägerbogen & Holzpfeile', 990, 4, 10),
(155, 'Jägerbogen & Steinpfeile', 1575, 5, 10),
(156, 'Jägerbogen & Stahlpfeile', 2250, 6, 10),
(157, 'Rangerbogen & Holzpfeile', 2790, 7, 10),
(158, 'Rangerbogen & Steinpfeile', 3420, 8, 10),
(159, 'Rangerbogen & Stahlpfeile', 4230, 9, 10),
(160, 'Langbogen', 5040, 10, 10),
(161, 'Armbrust', 5850, 11, 10),
(162, 'Elfen-Langbogen', 6840, 12, 10),
(163, 'Elfen-Langbogen & Flammenpfeile', 8010, 13, 10),
(164, 'Elfen-Langbogen & Verzauberte Pfeile', 9000, 14, 10),
(165, 'Langbogen des Elfenkönigs', 10350, 15, 10),
(166, 'MightyE\'s Langschwert', 225, 2, 11),
(167, 'MightyE\'s Kurzschwert', 48, 1, 11),
(168, 'MightyE\'s Bastardschwert', 585, 3, 11),
(169, 'MightyE\'s Krummsäbel', 990, 4, 11),
(170, 'MightyE\'s Streitaxt', 1575, 5, 11),
(171, 'MightyE\'s Wurfhammer', 2250, 6, 11),
(172, 'MightyE\'s Morgenstern', 2790, 7, 11),
(173, 'MightyE\'s Armbrust', 3420, 8, 11),
(174, 'MightyE\'s Rapier', 4230, 9, 11),
(175, 'MightyE\'s Säbel', 5040, 10, 11),
(176, 'MightyE\'s Lichtschwert', 5850, 11, 11),
(177, 'MightyE\'s Wakizashi', 6840, 12, 11),
(178, 'MightyE\'s Zweihandschwert', 8010, 13, 11),
(179, 'MightyE\'s Zweihandaxt', 9000, 14, 11),
(180, 'MightyE\'s Claymore', 10350, 15, 11),
(181, 'Feuerspruch', 48, 1, 12),
(182, 'Erdbebenspruch', 225, 2, 12),
(183, 'Flutschpruch', 585, 3, 12),
(184, 'Hurrikanspruch', 990, 4, 12),
(185, 'Gedankenkontrollespruch', 1575, 5, 12),
(186, 'Blitzspruch', 2250, 6, 12),
(187, 'Schwächungsspruch', 2790, 7, 12),
(188, 'Furchtspruch', 3420, 8, 12),
(189, 'Giftpilzspruch', 4230, 9, 12),
(190, 'Geisterbesitzungsspruch', 5040, 10, 12),
(191, 'Verzweiflungsspruch', 5850, 11, 12),
(192, 'Fledermausrufspruch', 6840, 12, 12),
(193, 'Wolfrufspruch', 8010, 13, 12),
(194, 'Einhornrufspruch', 9000, 14, 12),
(195, 'Drachenrufspruch', 10350, 15, 12);


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
