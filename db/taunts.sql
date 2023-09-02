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
(1, '`5\"`6Warte nur auf meine Rache, `4%W`6. Sie wird schnell sein!`5\" %w erklärt.', 'Bluspring'),
(2, '`5\"`6Ich werde diesen neuen `4%x`6 wirklich genießen, den %w`6 hatte,`5\" rief %W aus.', 'joe'),
(3, '`5\"`6Aah, also ist das, wofür `4%X`6 ist!`5\" %W staunte %w', 'joe'),
(4, '`5\"`6Oh Mann! Ich hätte nicht gedacht, dass du es in dir hast, `5%W`6,`5\" %w ruft aus.', 'Bluspring'),
(5, '`5%W wurde dabei erwischt, wie er sagte: \"`6%p `4%x`6 hatte keine Chance gegen mein `4%X`6!`5\"', 'Bluspring'),
(6, '`5\"`6Du solltest wirklich kein `4%x`6 haben, es sei denn, du weißt, wie man es benutzt,`5\" schlug %W vor.', 'Bluspring'),
(7, '`5\"`6`bARRRGGGGGGG`b!!`5\" %w schreit vor Frustration.', 'Bluspring'),
(8, '`5\"`6Wie konnte ich nur so schwach sein?`5\" %w klagt.', 'Bluspring'),
(9, '`5\"`6Ich muss wohl nicht so robust sein, wie ich dachte...!`5\" %w gibt nach.', 'Bluspring'),
(10, '`5\"`6Pass auf dich auf, `4%W`6, ich komme hinter dir her!`5\" %w warnt.', 'Bluspring'),
(11, '`5\"`6Das ist echt Mist!`5\" jammert %w.', 'Bluspring'),
(12, '`5\"`6Ich sehe London, ich sehe Frankreich, ich sehe `4%w\'s`6 Unterhosen!`5\" enthüllt %W.', 'Bluspring'),
(13, '`5\"`6Die Heilerhütte kann dir jetzt nicht mehr helfen, `4%w`6!`5\" tadelt %W.', 'Bluspring'),
(14, '`5%W lächelt. \"`6Du bist zu langsam. Du bist zu schwach.`5\"', 'Bluspring'),
(15, '`5%w schlägt %p Kopf gegen einen Stein...\"`6Dumm, dumm, dumm!`5\" wurde %o sagen gehört.', 'Bluspring'),
(16, '`5\"`6Mein Ego kann nicht mehr so viele Schläge einstecken!`5\" ruft %w aus.', 'Bluspring'),
(17, '`5\"`6Warum bin ich nicht ein erfolgreicher Arzt geworden, wie mein Vater vorgeschlagen hat?`5\" wundert sich %w laut.', 'Bluspring'),
(18, '`5\"`6Vielleicht wirst du das nächste Mal nicht so überheblich sein!`5\" lacht %W', 'Bluspring'),
(19, '`5\"`6Ein Baby könnte ein `4%x `6besser schwingen als das!`5\" proklamiert %W.', 'Bluspring'),
(20, '`5\"`6Du hättest einfach im Bett bleiben sollen,`5\" schlägt %W vor.', 'Bluspring'),
(21, '`5\"`6Nun, das ist wirklich ein Tritt in den Schritt, oder?`5\" beobachtet %w.', 'Bluspring'),
(22, '`5\"`6Komm zurück, wenn du gelernt hast, wie man kämpft,`5\" spottet %W.', 'Bluspring'),
(23, '`5\"`6Das nächste Mal iss deine Wheaties,`5\" rät %W.', 'Bluspring'),
(24, '`5 \"`6Du bist ehrlos, `4%W`6!`5\" %w weint.', 'Bluspring'),
(25, '`5\"`4%w`6, deine Haltunglosigkeit ist eine Schande,`5\" stellt %W fest.', 'Bluspring'),
(26, '`5\"`6Weißt du, `4%w`6 hat es wirklich verdient, von %s verprügelt zu werden, nach all den Dingen, die `bIch`b über `b%p`b Mutter gesagt hat.`5\" kommentiert %W.', 'Joe');

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
