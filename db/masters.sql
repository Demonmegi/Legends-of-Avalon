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
-- Table structure for table `masters`
--

CREATE TABLE `masters` (
  `creatureid` int(11) UNSIGNED NOT NULL,
  `creaturename` varchar(50) DEFAULT NULL,
  `creaturelevel` int(11) DEFAULT NULL,
  `creatureweapon` varchar(50) DEFAULT NULL,
  `creaturelose` varchar(120) DEFAULT NULL,
  `creaturewin` varchar(120) DEFAULT NULL,
  `creaturegold` int(11) DEFAULT NULL,
  `creatureexp` int(11) DEFAULT NULL,
  `creaturehealth` int(11) DEFAULT NULL,
  `creatureattack` int(11) DEFAULT NULL,
  `creaturedefense` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `masters`
--

INSERT INTO `masters` (`creatureid`, `creaturename`, `creaturelevel`, `creatureweapon`, `creaturelose`, `creaturewin`, `creaturegold`, `creatureexp`, `creaturehealth`, `creatureattack`, `creaturedefense`) VALUES
(1, 'Mireraband', 1, 'Kleines Dolch', 'Gut gemacht %w`&, ich hätte erraten sollen, dass du gewachsen bist.', 'Wie ich dachte, %w`^, deine Fähigkeiten sind nicht mit meinen eigenen zu vergleichen!', NULL, NULL, 12, 2, 2),
(2, 'Fie', 2, 'Kurzschwert', 'Gut gemacht %w`&, du weißt wirklich, wie man dein %x benutzt.', 'Du hättest wissen sollen, dass du meinem %X nicht gewachsen bist.', NULL, NULL, 22, 4, 4),
(3, 'Glynyc', 3, 'Hochspitzige Keule', 'Aah, von jemandem wie dir besiegt! Als nächstes wird Mireraband mich jagen!', 'Haha, vielleicht solltest du zurück in Mirerabands Klasse gehen.', NULL, NULL, 33, 6, 6),
(4, 'Guth', 4, 'Spitzknüppel', 'Ha! Hahaha, ausgezeichneter Kampf %w`&! Ich hatte keinen solchen Kampf mehr seit meiner Zeit bei der RAF!', 'In der RAF hätten wir solche wie dich lebendig gefressen! Arbeite an deinen Fähigkeiten, alter Junge!', NULL, NULL, 44, 8, 8),
(5, 'Unï¿½lith', 5, 'Gedankenkontrolle', 'Dein Geist ist größer als meiner. Ich gebe mich geschlagen.', 'Deine mentalen Kräfte lassen zu wünschen übrig. Meditiere über dieses Versagen, und vielleicht wirst du mich irgendwann besiegen.', NULL, NULL, 55, 10, 10),
(6, 'Adwares', 6, 'Zwergenkampfaxt', 'Ach! Ihr haltet euer %x mit Geschick!', 'Har! Ihr braucht noch mehr Übung, ihr kleiner Lausbub!', NULL, NULL, 66, 12, 12),
(7, 'Gerrard', 7, 'Kampfbogen', 'Hmm, vielleicht habe ich dich unterschätzt.', 'Wie ich dachte.', NULL, NULL, 77, 14, 14),
(8, 'Ceiloth', 8, 'Orkos Breitschwert', 'Gut gemacht %w`&, ich kann sehen, dass große Dinge in deiner Zukunft liegen!', 'Du wirst mächtig, aber noch nicht so mächtig.', NULL, NULL, 88, 16, 16),
(9, 'Dwiredan', 9, 'Zwillingsschwerter', 'Vielleicht hätte ich dein %x in Betracht ziehen sollen...', 'Vielleicht überlegst du es dir, meine Zwillingsschwerter zu benutzen, bevor du das nochmal versuchst?', NULL, NULL, 99, 18, 18),
(10, 'Sensei Noetha', 10, 'Kampfkunstfähigkeiten', 'Dein Stil war überlegen, deine Form größer. Ich verneige mich vor dir.', 'Lerne, deinen Stil anzupassen, und du wirst siegen.', NULL, NULL, 110, 20, 20),
(11, 'Celith', 11, 'Werfende Halos', 'Wow, wie hast du all diesen Halos ausweichen können?', 'Pass auf den letzten Halo auf, er kommt zurück!', NULL, NULL, 121, 22, 22),
(12, 'Gadriel der Elfenranger', 12, 'Elfenlangbogen', 'Ich kann akzeptieren, dass du mich besiegt hast, denn schließlich sind Elfen unsterblich, während du es nicht bist, also wird der Sieg meiner sein.', 'Vergiss nicht, dass Elfen unsterblich sind. Sterbliche werden wahrscheinlich nie einen der Feen besiegen.', NULL, NULL, 132, 24, 24),
(13, 'Adoawyr', 13, 'Gigantisches Breitschwert', 'Wenn ich dieses Schwert hätte aufheben können, hätte ich wahrscheinlich besser abgeschnitten!', 'Haha, ich konnte das Schwert nicht einmal aufheben, und ich habe trotzdem gewonnen!', NULL, NULL, 143, 26, 26),
(14, 'Yoresh', 14, 'Todesberührung', 'Nun, du hast meiner Berührung ausgewichen. Ich verneige mich vor dir!', 'Pass das nächste Mal auf meine Berührung auf!', NULL, NULL, 154, 28, 28);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`creatureid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `masters`
--
ALTER TABLE `masters`
  MODIFY `creatureid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
