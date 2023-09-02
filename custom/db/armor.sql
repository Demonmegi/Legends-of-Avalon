-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 12:46 AM
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
# Dies sind Beispieldaten
(1, 'Fuzzy Hausschuhe', 48, 1, 0),
(2, 'Flanell-Pyjamas', 225, 2, 0),
(3, 'Homespun-Longjohns', 585, 3, 0),
(4, 'Homespun-Unterhemd', 990, 4, 0),
(5, 'Gestrickte Socken', 1575, 5, 0),
(6, 'Gestrickte Handschuhe', 2250, 6, 0),
(7, 'Alte Lederschuhe', 2790, 7, 0),
(8, 'Homespun-Hose', 3420, 8, 0),
(9, 'Homespun-Tunika', 4230, 9, 0),
(10, 'Zigeunerumhang', 5040, 10, 0),
(11, 'Alte Lederkappe', 5850, 11, 0),
(12, 'Alte Lederarmschienen', 6840, 12, 0),
(13, 'Reiseschild', 8010, 13, 0),
(14, 'Alte Lederhose', 9000, 14, 0),
(15, 'Alte Ledertunika', 10350, 15, 0),
(16, 'Flip-Flops', 48, 1, 1),
(17, 'Badeanzug und Handtuch', 225, 2, 1),
(18, 'Baumwollunterhemd', 585, 3, 1),
(19, 'Wollsocken', 990, 4, 1),
(20, 'Wollhandschuhe', 1575, 5, 1),
(21, 'Lederschuhe', 2250, 6, 1),
(22, 'Ledermütze', 2790, 7, 1),
(23, 'Lederarmschienen', 3420, 8, 1),
(24, 'Ledergamaschen', 4230, 9, 1),
(25, 'Ledertunika', 5040, 10, 1),
(26, 'Kapuzenumhang aus Leder', 5850, 11, 1),
(27, 'Hirschledergamaschen', 6840, 12, 1),
(28, 'Hirschledergürtel', 8010, 13, 1),
(29, 'Hirschledertunika', 9000, 14, 1),
(30, 'Kleiner Rohlederschild', 10350, 15, 1),
(31, 'Arbeitsstiefel', 48, 1, 2),
(32, 'Arbeitsanzug', 225, 2, 2),
(33, 'Robuste Lederhandschuhe', 585, 3, 2),
(34, 'Robuste Lederarmschienen', 990, 4, 2),
(35, 'Robuste Lederschuhe', 1575, 5, 2),
(36, 'Robuste Lederhelm', 2250, 6, 2),
(37, 'Robuste Lederhose', 2790, 7, 2),
(38, 'Robuste Ledertunika', 3420, 8, 2),
(39, 'Robuster Ledermantel', 4230, 9, 2),
(40, 'Waldarbeiterhelm', 5040, 10, 2),
(41, 'Waldarbeiter-Handschuhe', 5850, 11, 2),
(42, 'Waldarbeiterarmschienen', 6840, 12, 2),
(43, 'Waldarbeiter-Beinschützer', 8010, 13, 2),
(44, 'Waldarbeiter-Tunika', 9000, 14, 2),
(45, 'Waldarbeiter-Kiteschild', 10350, 15, 2),
(46, 'Duschhaube und Handtuch', 48, 1, 3),
(47, 'Bademantel', 225, 2, 3),
(48, 'Wolfskin-Handschuhe', 585, 3, 3),
(49, 'Wolfskin-gefütterte Stiefel', 990, 4, 3),
(50, 'Wolfskin-Armschienen', 1575, 5, 3),
(51, 'Wolfskin-Hose', 2250, 6, 3),
(52, 'Wolfskin-Tunika', 2790, 7, 3),
(53, 'Kapuzenumhang aus Wolfskin', 3420, 8, 3),
(54, 'Wolfmeister-Armschienen', 4230, 9, 3),
(55, 'Wolfmeister-Handschuhe', 5040, 10, 3),
(56, 'Wolfmeisters Helm', 5850, 11, 3),
(57, 'Wolfmeister-Beinschützer', 6840, 12, 3),
(58, 'Wolfmeister-Gürteljacke', 8010, 13, 3),
(59, 'Wolfshautcape', 9000, 14, 3),
(60, 'Schild des Wolfmeisters', 10350, 15, 3),
(61, 'Sweatpants', 48, 1, 4),
(62, 'Sweatshirt', 225, 2, 4),
(63, 'Genieteter Lederhelm', 585, 3, 4),
(64, 'Genietete Lederhandschuhe', 990, 4, 4),
(65, 'Stiefel aus gehärtetem Leder', 1575, 5, 4),
(66, 'Genietete Lederleggings', 2250, 6, 4),
(67, 'Genietete Ledertunika', 2790, 7, 4),
(68, 'Gerbermütze', 3420, 8, 4),
(69, 'Rostiger Kettenhelm', 4230, 9, 4),
(70, 'Rostige Kettenhandschuhe', 5040, 10, 4),
(71, 'Rostige Kettenarmschienen', 5850, 11, 4),
(72, 'Rostige Kettenstiefel', 6840, 12, 4),
(73, 'Rostige Kettenbeinschützer', 8010, 13, 4),
(74, 'Rostige Kettentunika', 9000, 14, 4),
(75, 'Großer Eisenbuckler', 10350, 15, 4),
(76, 'Hasenschlappen', 48, 1, 5),
(77, 'Fußpyjamas', 225, 2, 5),
(78, 'Bequeme Lederunterwäsche', 585, 3, 5),
(79, 'Schwerer Kettenhelm', 990, 4, 5),
(80, 'Schwere Kettenhandschuhe', 1575, 5, 5),
(81, 'Schwere Kettenarmschienen', 2250, 6, 5),
(82, 'Schwere Kettenstiefel', 2790, 7, 5),
(83, 'Schwere Kettenbeinschützer', 3420, 8, 5),
(84, 'Schwere Kettentunika', 4230, 9, 5),
(85, 'Brustplatte des Drachensoldaten', 5040, 10, 5),
(86, 'Gauntlets des Drachensoldaten', 5850, 11, 5),
(87, 'Stiefel des Drachensoldaten', 6840, 12, 5),
(88, 'Beinschützer des Drachensoldaten', 8010, 13, 5),
(89, 'Brustplatte des Drachensoldaten', 9000, 14, 5),
(90, 'Schild des Drachensoldaten', 10350, 15, 5),
(91, 'Bluejeans', 48, 1, 6),
(92, 'Flanellhemd', 225, 2, 6),
(93, 'Gut gefertigter Bronzehelm', 585, 3, 6),
(94, 'Gut gefertigte Bronzehandschuhe', 990, 4, 6),
(95, 'Gut gefertigte Bronzearmschienen', 1575, 5, 6),
(96, 'Gut gefertigte Bronze-Stiefel', 2250, 6, 6),
(97, 'Gut gefertigte Bronzegamaschen', 2790, 7, 6),
(98, 'Gut gefertigte Bronzechestplate', 3420, 8, 6),
(99, 'Verzauberter Bronzehelm', 4230, 9, 6),
(100, 'Verzauberte Bronzehandschuhe', 5040, 10, 6),
(101, 'Verzauberte Bronzearmschienen', 5850, 11, 6),
(102, 'Verzauberte Bronze-Stiefel', 6840, 12, 6),
(103, 'Verzauberte Bronze-Gamaschen', 8010, 13, 6),
(104, 'Verzauberte Bronzechestplate', 9000, 14, 6),
(105, 'Kapuzenumhang aus Einhornhaut', 10350, 15, 6),
(106, 'Fass', 48, 1, 7),
(107, 'Lampenschirm', 225, 2, 7),
(108, 'Perfekt gefertigter Stahlhelm', 585, 3, 7),
(109, 'Perfekt gefertigte Stahlhandschuhe', 990, 4, 7),
(110, 'Perfekt gefertigte Stahlstiefel', 1575, 5, 7),
(111, 'Perfekt gefertigte Stahlarmschienen', 2250, 6, 7),
(112, 'Perfekt gefertigte Stahlbeinschützer', 2790, 7, 7),
(113, 'Perfekt gefertigte Stahlbrustplatte', 3420, 8, 7),
(114, 'Greifenfederumhang', 4230, 9, 7),
(115, 'Zwergenkettenhelm', 5040, 10, 7),
(116, 'Zwergenkettenhandschuhe', 5850, 11, 7),
(117, 'Zwergenkettenstiefel', 6840, 12, 7),
(118, 'Zwergenkettenarmschienen', 8010, 13, 7),
(119, 'Zwergenkettenbeinschützer', 9000, 14, 7),
(120, 'Zwergenkettenbrustplatte', 10350, 15, 7),
(121, 'Feigenblatt', 48, 1, 8),
(122, 'Schottenrock', 225, 2, 8),
(123, 'Majestätischer Goldhelm', 585, 3, 8),
(124, 'Majestätische Goldhandschuhe', 990, 4, 8),
(125, 'Majestätische Goldstiefel', 1575, 5, 8),
(126, 'Armschienen', 2250, 6, 8),
(127, 'Majestätische Goldbeinschützer', 2790, 7, 8),
(128, 'Majestätische Goldbrustplatte', 3420, 8, 8),
(129, 'Majestätischer Goldschild', 4230, 9, 8),
(130, 'Goldfädenumhang', 5040, 10, 8),
(131, 'Verzauberter Rubinring', 5850, 11, 8),
(132, 'Verzauberter Saphirring', 6840, 12, 8),
(133, 'Verzauberter Jadesteinring', 8010, 13, 8),
(134, 'Verzauberter Amethystring', 9000, 14, 8),
(135, 'Verzauberter Diamantring', 10350, 15, 8),
(136, 'Knopf', 48, 1, 9),
(137, 'Elfen-Seidennachtwäsche', 225, 2, 9),
(138, 'Elfen-Seidenhandschuhe', 585, 3, 9),
(139, 'Elfen-Seidenslipper', 990, 4, 9),
(140, 'Elfen-Seidenarmband', 1575, 5, 9),
(141, 'Leggings', 2250, 6, 9),
(142, 'Elfen-Seidentunika', 2790, 7, 9),
(143, 'Elfen-Seidenumhang', 3420, 8, 9),
(144, 'Ring der Nacht', 4230, 9, 9),
(145, 'Ring des Tages', 5040, 10, 9),
(146, 'Ring der Einsamkeit', 5850, 11, 9),
(147, 'Ring des Friedens', 6840, 12, 9),
(148, 'Ring des Mutes', 8010, 13, 9),
(149, 'Ring der Tugend', 9000, 14, 9),
(150, 'Ring des Lebens', 10350, 15, 9),
(151, 'Pegasus\' Kapuzenumhang', 5040, 10, 10),
(152, 'Pegasus\' Brustplatte', 4230, 9, 10),
(153, 'Pegasus\' Beinschützer', 3420, 8, 10),
(154, 'Pegasus\' Stiefel', 2790, 7, 10),
(155, 'Pegasus\' Halsberge', 2250, 6, 10),
(156, 'Pegasus\' Armschienen', 1575, 5, 10),
(157, 'Pegasus\' Handschuhe', 990, 4, 10),
(158, 'Pegasus\' Helm', 585, 3, 10),
(159, 'Plateauschuhe', 225, 2, 10),
(160, 'Freizeitanzug', 48, 1, 10),
(161, 'Pegasus-Federschmuckanhänger', 5850, 11, 10),
(162, 'Pegasus-Feder-Gürtel', 6840, 12, 10),
(163, 'Pegasus\' geprägter Schild', 8010, 13, 10),
(164, 'Pegasus\' geprägter Ring', 9000, 14, 10),
(165, 'Pegasus\' geprägte Krone', 10350, 15, 10),
(166, 'Neue Kleidung', 48, 1, 11),
(167, 'Hühnerkostüm', 225, 2, 11),
(168, 'Handschuhe der Anmut', 585, 3, 11),
(169, 'Armband der Schönheit', 990, 4, 11),
(170, 'Helm der Gesundheit', 1575, 5, 11),
(171, 'Beinschützer des Glücks', 2250, 6, 11),
(172, 'Stiefel der Tapferkeit', 2790, 7, 11),
(173, 'Tunika der Toleranz', 3420, 8, 11),
(174, 'Umhang des Selbstvertrauens', 4230, 9, 11),
(175, 'Ring der Rechtschaffenheit', 5040, 10, 11),
(176, 'Halskette des Narzissmus', 5850, 11, 11),
(177, 'Anhänger der Macht', 6840, 12, 11),
(178, 'Brustplatte der Güte', 8010, 13, 11),
(179, 'Schild der Überlegenheit', 9000, 14, 11),
(180, 'Zepter der Stärke', 10350, 15, 11),
(181, 'Helm aus Drachenhaut', 48, 1, 12),
(182, 'Handschuhe aus Drachenhaut', 225, 2, 12),
(183, 'Stiefel aus Drachenhaut', 585, 3, 12),
(184, 'Armschienen aus Drachenhaut', 990, 4, 12),
(185, 'Leggings aus Drachenhaut', 1575, 5, 12),
(186, 'Tunika aus Drachenhaut', 2250, 6, 12),
(187, 'Umhang aus Drachenhaut', 2790, 7, 12),
(188, 'Helm aus Drachenschuppen', 3420, 8, 12),
(189, 'Handschuhe aus Drachenschuppen', 4230, 9, 12),
(190, 'Stiefel aus Drachenschuppen', 5040, 10, 12),
(191, 'Armschienen aus Drachenschuppen', 5850, 11, 12),
(192, 'Beinschützer aus Drachenschuppen', 6840, 12, 12),
(193, 'Brustplatte aus Drachenschuppen', 8010, 13, 12),
(194, 'Umhang aus Drachenschuppen', 9000, 14, 12),
(195, 'Schild aus Drachentatze', 10350, 15, 12);

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
