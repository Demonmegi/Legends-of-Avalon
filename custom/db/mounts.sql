-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2023 at 04:41 PM
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
(1, 'Pony', 'Dieses sanfte Tier ist noch jung.', 'Pferde', 'a:2:{s:6:\"rounds\";s:1:\"0\";s:6:\"schema\";s:6:\"mounts\";}', 6, 0, 1, 1, 'Du schnallst deine {weapon} an die Satteltaschen deines Ponys und machst dich auf zu einem Abenteuer!', '`&Da dir einfällt, dass es schon eine Weile her ist, seit du dein Pony zuletzt gefüttert hast, beschließt du, dich zu entspannen und ihm zu erlauben, eine Weile auf der Weide zu grasen. Du döst ein und genießt die friedliche Stille.`0', '`&Du steigst auf der Weide ab, um deinem Pony trotzdem eine kurze Pause zum Grasen zu gönnen, obwohl es kürzlich vollständig gefüttert wurde. Als du dich im Gras zurücklehnst und die Wolken beobachtest, wiehert dein Pony leise und trabt in den Unterholz. Du suchst eine Weile, bevor du zurück zur Weide gehst und hoffst, dass es zurückkehrt. Kurze Zeit später kommt dein Pony hoch erhobenen Kopfes und mit einem sehr pferdeähnlichen Grinsen im Gesicht zurück in die Lichtung.`0', 20, 'Dorf von Avalon', 0),
(2, 'Wallach', 'Dieses kräftige Tier ist äußerst loyal.', 'Pferde', 'a:2:{s:6:\"rounds\";s:1:\"0\";s:6:\"schema\";s:6:\"mounts\";}', 10, 0, 1, 2, 'Du schnallst deine {weapon} an die Satteltaschen deines Wallachs und machst dich auf zu einem Abenteuer!', '`&Da dir einfällt, dass es schon eine Weile her ist, seit du deinen Wallach zuletzt gefüttert hast, beschließt du, dich zu entspannen und ihm zu erlauben, eine Weile auf der Weide zu grasen. Du döst ein und genießt die friedliche Stille.`0', '`&Du steigst auf der Weide ab, um deinem Wallach trotzdem eine kurze Pause zum Grasen zu gönnen, obwohl es kürzlich vollständig gefüttert wurde. Als du dich im Gras zurücklehnst und die Wolken beobachtest, wiehert dein Wallach leise und trabt in den Unterholz. Du suchst eine Weile, bevor du zurück zur Weide gehst und hoffst, dass es zurückkehrt. Kurze Zeit später kommt dein Wallach hoch erhobenen Kopfes und mit einem sehr pferdeähnlichen Grinsen im Gesicht zurück in die Lichtung.`n`nUnd du dachtest, Wallache wären nicht mehr so ausgestattet!`0', 25, 'Dorf von Avalon', 0),
(3, 'Hengst', 'Dieses edle Tier ist riesig und mächtig!', 'Pferde', 'a:2:{s:6:\"rounds\";s:1:\"0\";s:6:\"schema\";s:6:\"mounts\";}', 16, 0, 1, 3, 'Du schnallst deine {weapon} an die Satteltaschen deines Hengsts und machst dich auf zu einem Abenteuer!', '`&Da dir einfällt, dass es schon eine Weile her ist, seit du deinen Hengst zuletzt gefüttert hast, beschließt du, dich zu entspannen und ihm zu erlauben, eine Weile auf der Weide zu grasen. Du döst ein und genießt die friedliche Stille.`0', '`&Du steigst auf der Weide ab, um deinem Hengst trotzdem eine kurze Pause zum Grasen zu gönnen, obwohl es kürzlich vollständig gefüttert wurde. Als du dich im Gras zurücklehnst und die Wolken beobachtest, wiehert dein Hengst leise und trabt in den Unterholz. Du suchst eine Weile, bevor du zurück zur Weide gehst und hoffst, dass es zurückkehrt. Kurze Zeit später kommt dein Hengst hoch erhobenen Kopfes und mit einem sehr pferdeähnlichen Grinsen im Gesicht zurück in die Lichtung.`0', 30, 'Dorf von Avalon', 0),
(4, 'Esel', 'Geringer Unterhalt und Kosten, kann jedoch nicht die gleiche Leistung wie ein pferd erbringen..', '', 'a:2:{s:6:\"rounds\";s:1:\"0\";s:6:\"schema\";s:6:\"mounts\";}', 0, 5000, 0, 1, 'Du schnallst deine {weapon} an die Satteltaschen deines Esels und machst dich auf zu einem Abenteuer!', '`&Da dir einfällt, dass es schon eine Weile her ist, seit du deinen Esel zuletzt gefüttert hast, beschließt du, dich zu entspannen und ihm zu erlauben, eine Weile auf der Weide zu grasen. Du döst ein und genießt die friedliche Stille.`0', '`&Du steigst auf der Weide ab, um deinem Esel trotzdem eine kurze Pause zum Grasen zu gönnen, obwohl es kürzlich vollständig gefüttert wurde. Als du dich im Gras zurücklehnst und die Wolken beobachtest, wiehert dein Esel leise und trabt in den Unterholz. Du suchst eine Weile, bevor du zurück zur Weide gehst und hoffst, dass es zurückkehrt. Kurze Zeit später kommt dein Esel hoch erhobenen Kopfes und mit einem sehr pferdeähnlichen Grinsen im Gesicht zurück in die Lichtung.`0', 15, 'Dorf von Avalon', 0),
(5, '`XFrostpferd', 'Dieses Pferd scheint nicht von dieser Welt zu sein. Seine Augen leuchten Schneeweiss.', 'Pferde', 'a:6:{s:4:\"name\";s:22:\"`#Kälte des Frosthelms\";s:8:\"roundmsg\";s:45:\"Die Kälte deiner Pferdes zermürbt die Gegner!\";s:7:\"wearoff\";s:20:\"Aktion aufgebraucht.\";s:6:\"rounds\";s:2:\"10\";s:6:\"atkmod\";s:3:\"1.2\";s:6:\"schema\";s:6:\"mounts\";}', 5, 20, 0, 3, 'Du schnallst deine {weapon} an die Satteltaschen deines Frostpferdes und machst dich auf zu einem Abenteuer!', '`&Da dir einfällt, dass es schon eine Weile her ist, seit du deinen `XFrostpferd zuletzt gefüttert hast, beschließt du, dich zu entspannen und ihm zu erlauben, eine Weile auf der Weide zu grasen. Du döst ein und genießt die friedliche Stille.`0', '`&Du steigst auf der Weide ab, um deinem `XFrostpferd trotzdem eine kurze Pause zum Grasen zu gönnen, obwohl es kürzlich vollständig gefüttert wurde. Als du dich im Gras zurücklehnst und die Wolken beobachtest, wiehert dein `XFrostpferd leise und trabt in den Unterholz. Du suchst eine Weile, bevor du zurück zur Weide gehst und hoffst, dass es zurückkehrt. Kurze Zeit später kommt dein `XFrostpferd hoch erhobenen Kopfes und mit einem sehr pferdeähnlichen Grinsen im Gesicht zurück in die Lichtung.`0', 35, 'Dorf von Avalon', 0);

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
  MODIFY `mountid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
