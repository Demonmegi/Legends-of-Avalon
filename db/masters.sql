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
(1, 'Mireraband', 1, 'Small Dagger', 'Well done %w`&, I should have guessed you\'d grown some.', 'As I thought, %w`^, your skills are no match for my own!', NULL, NULL, 12, 2, 2),
(2, 'Fie', 2, 'Short Sword', 'Well done %w`&, you really know how to use your %x.', 'You should have known you were no match for my %X', NULL, NULL, 22, 4, 4),
(3, 'Glynyc', 3, 'Hugely Spiked Mace', 'Aah, defeated by the likes of you!  Next thing you know, Mireraband will be hunting me down!', 'Haha, maybe you should go back to Mireraband\'s class.', NULL, NULL, 33, 6, 6),
(4, 'Guth', 4, 'Spiked Club', 'Ha!  Hahaha, excellent fight %w`&!  Haven\'t had a battle like that since I was in the RAF!', 'Back in the RAF, we\'d have eaten the likes of you alive!  Go work on your skills some old boy!', NULL, NULL, 44, 8, 8),
(5, 'Unï¿½lith', 5, 'Thought Control', 'Your mind is greater than mine.  I concede defeat.', 'Your mental powers are lacking.  Meditate on this failure and perhaps some day you will defeat me.', NULL, NULL, 55, 10, 10),
(6, 'Adwares', 6, 'Dwarven Battle Axe', 'Ach!  Y\' do hold yer %x with skeel!', 'Har!  Y\' do be needin moore praktise y\' wee cub!', NULL, NULL, 66, 12, 12),
(7, 'Gerrard', 7, 'Battle Bow', 'Hmm, mayhaps I underestimated you.', 'As I thought.', NULL, NULL, 77, 14, 14),
(8, 'Ceiloth', 8, 'Orkos Broadsword', 'Well done %w`&, I can see that great things lie in the future for you!', 'You are becoming powerful, but not yet that powerful.', NULL, NULL, 88, 16, 16),
(9, 'Dwiredan', 9, 'Twin Swords', 'Perhaps I should have considered your %x...', 'Perhaps you\'ll reconsider my twin swords before you try that again?', NULL, NULL, 99, 18, 18),
(10, 'Sensei Noetha', 10, 'Martial Arts Skills', 'Your style was superior, your form greater.  I bow to you.', 'Learn to adapt your style, and you shall prevail.', NULL, NULL, 110, 20, 20),
(11, 'Celith', 11, 'Throwing Halos', 'Wow, how did you dodge all those halos?', 'Watch out for that last halo, it\'s coming back this way!', NULL, NULL, 121, 22, 22),
(12, 'Gadriel the Elven Ranger', 12, 'Elven Long Bow', 'I can accept that you defeated me, because after all elves are immortal while you are not, so the victory will be mine.', 'Do not forget that elves are immortal.  Mortals will likely never defeat one of the fey.', NULL, NULL, 132, 24, 24),
(13, 'Adoawyr', 13, 'Gargantuan Broad Sword', 'If I could have picked up this sword, I probably would have done better!', 'Haha, I couldn\'t even pick the sword UP and I still won!', NULL, NULL, 143, 26, 26),
(14, 'Yoresh', 14, 'Death Touch', 'Well, you evaded my touch.  I salute you!', 'Watch out for my touch next time!', NULL, NULL, 154, 28, 28);

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
