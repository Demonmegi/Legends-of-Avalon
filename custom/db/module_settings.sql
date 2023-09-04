-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2023 at 09:00 PM
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
-- Table structure for table `module_settings`
--

CREATE TABLE `module_settings` (
  `modulename` varchar(50) NOT NULL,
  `setting` varchar(50) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `module_settings`
--

INSERT INTO `module_settings` (`modulename`, `setting`, `value`) VALUES
('alignment', 'display-num', '1'),
('alignment', 'evilalign', '-30'),
('alignment', 'goodalign', '30'),
('alignment', 'max-num', '100'),
('alignment', 'min-num', '-100'),
('alignment', 'pvp', '0'),
('alignment', 'reset', '0'),
('alignment', 'shead', 'Vital Info'),
('alignmentevents', 'alignbad', '1'),
('alignmentevents', 'aligngood', '1'),
('bladder', 'inntoilet', '1'),
('bladder', 'newday', '10'),
('cities', 'allowance', '65000'),
('cities', 'coward', '1'),
('cities', 'dangerchance', '66'),
('cities', 'safechance', '0'),
('cities', 'travelspecialchance', '0'),
('city_weather', 'shadeswx', '`#Leiden unter saurem Regen'),
('city_weather', 'shadeswx1', '`7aEine dicke, bittere Nebel'),
('city_weather', 'shadeswx2', '`QEs regnet Feuer und Schwefel'),
('city_weather', 'shadeswx3', '`7dark, dank and depressingly dismal'),
('city_weather', 'shadeswx4', '`#Leiden unter saurem Regen'),
('city_weather', 'shadeswx5', '`#Zugefroren'),
('city_weather', 'shadeswx6', '`qAnfällig für wirbelnde Staubteufel'),
('city_weather', 'shadeswx7', '`6Drückend heiss und unangenehm schwül'),
('city_weather', 'shadeswx8', '`^Höllische Feuerwinde wehen'),
('city_weather', 'shadeswxreport', 'Die Atmosphäre in Astralebene ist derzeit `%s`.'),
('city_weather', 'weather', 'starker Wind mit vereinzelten Schauern'),
('city_weather', 'weather1', 'bedeckt und kühl, mit sonnigen Phasen'),
('city_weather', 'weather2', 'warm und sonnig'),
('city_weather', 'weather3', 'regnerisch'),
('city_weather', 'weather4', 'nebelig'),
('city_weather', 'weather5', 'kühl mit blauem Himmel'),
('city_weather', 'weather6', 'heiss und sonnig'),
('city_weather', 'weather7', 'starker Wind mit vereinzelten Schauern'),
('city_weather', 'weather8', 'Gewitterschauer'),
('city_weather', 'wxreport', 'Heute wird das Wetter in den meisten Teilen des Reiches voraussichtlich %s sein.'),
('crazyaudrey', 'animal', 'Kätzchen'),
('crazyaudrey', 'animals', 'Kätzchen'),
('crazyaudrey', 'buffname', 'Warm Fuzzies'),
('crazyaudrey', 'cost', '5'),
('crazyaudrey', 'defaultanimal', 'Kätzchen'),
('crazyaudrey', 'defaultanimals', 'Kätzchen'),
('crazyaudrey', 'defaultbuffname', 'Warme Gefühle'),
('crazyaudrey', 'defaultsound', 'Miau'),
('crazyaudrey', 'gamedaysremaining', '-1'),
('crazyaudrey', 'lanimal', 'Kätzchen'),
('crazyaudrey', 'lanimals', 'Kätzchen'),
('crazyaudrey', 'profit', '5'),
('crazyaudrey', 'sound', 'Miau'),
('crazyaudrey', 'villagepercent', '20'),
('darkhorse', 'tavernname', 'Dark Horse Tavern'),
('dpafterdk', 'maxdp1', '20'),
('dpafterdk', 'maxdp2', '35'),
('dpafterdk', 'maxdp3', '75'),
('expbar', 'showbar', '1'),
('expbar', 'showexpnumber', '1'),
('expbar', 'shownextgoal', '1'),
('fairy', 'carrydk', '1'),
('fairy', 'fftoaward', '1'),
('fairy', 'hptoaward', '1'),
('findgold', 'maxgold', '50'),
('findgold', 'mingold', '10'),
('goldmine', 'alwaystether', '10'),
('goldmine', 'percentgemloss', '0'),
('goldmine', 'percentgoldloss', '0'),
('healthbar', 'showbar', '1'),
('healthbar', 'showcurrent', '1'),
('healthbar', 'showmax', '1'),
('house', 'appon', '1'),
('house', 'dgemperlevel', '10'),
('house', 'dgoldperlevel', '1000'),
('house', 'doncost', '0'),
('house', 'enablegems', '1'),
('house', 'enablekeys', '1'),
('house', 'enabletreasure', '1'),
('house', 'gemcosts', '30'),
('house', 'gemkeycost', '5'),
('house', 'gemperlevel', '10'),
('house', 'gemwith', '100'),
('house', 'goldcosts', '20000'),
('house', 'goldkeycost', '5000'),
('house', 'goldperlevel', '1000'),
('house', 'goldrec', '100'),
('house', 'goldwith', '100'),
('house', 'housesperpage', '10'),
('house', 'hpgain', '10'),
('house', 'maxgems', '500'),
('house', 'maxkeys', '8'),
('house', 'maxsize', '10'),
('house', 'mindks', '0'),
('house', 'multiplicator', '0.2'),
('house', 'mystery', '2'),
('house', 'pidgeon', '5'),
('house', 'renamecostsgems', '1'),
('house', 'renamecostsgold', '1000'),
('house', 'resetgems', '0'),
('house', 'resettreasure', '0'),
('house', 'sleepon', '1'),
('house', 'slmas', '0'),
('house', 'tpturn', '2'),
('house', 'treasuresize', '50000'),
('housebathroom', 'toiletname', 'MusteliCo MusTEK'),
('housebedroomvault', 'blockbed', '1'),
('housekitchen', 'pcookiedie', '3'),
('housekitchen', 'pcookieon', '1'),
('housekitchen', 'pcookieturn', '8'),
('houseloungekeys', 'brand', 'MusteliCo MusTEK'),
('houseloungekeys', 'race', 'Mustelids'),
('houserooms', 'bathbuild', '0'),
('houserooms', 'bedbuild', '0'),
('houserooms', 'buildingco', 'MusteliCo Mercantilics - Copious Condo ConstructiCo Division'),
('houserooms', 'cellarbuild', '0'),
('houserooms', 'gardenbuild', '0'),
('houserooms', 'kitchbuild', '0'),
('houserooms', 'loungebuild', '0'),
('moons', 'moon1', '1'),
('moons', 'moon1cycle', '23'),
('moons', 'moon1name', 'Mundil'),
('moons', 'moon1place', '15'),
('moons', 'moon2', '0'),
('moons', 'moon2cycle', '43'),
('moons', 'moon2name', 'Ay'),
('moons', 'moon2place', '23'),
('moons', 'moon3', '0'),
('moons', 'moon3cycle', '37'),
('moons', 'moon3name', 'Lurani'),
('moons', 'moon3place', '4'),
('odor', 'attackeffect', '10'),
('odor', 'defenseeffect', '10'),
('odor', 'newday', '1'),
('odor', 'roundsleft', '100'),
('odor', 'titlenew', 'Schweinebacke'),
('oldchurch', 'belltoll', '74'),
('oldchurch', 'oldchurchplace', 'Dorf von Avalon'),
('oldchurch', 'ritualenergy', '0'),
('oldman', 'carrydk', '0'),
('outhouse', 'badmusthit', '50'),
('outhouse', 'cost', '5'),
('outhouse', 'giveback', '3'),
('outhouse', 'givegempercent', '25'),
('outhouse', 'giveturnchance', '0'),
('outhouse', 'goldinhand', '1'),
('outhouse', 'goodmusthit', '60'),
('outhouse', 'takeback', '1'),
('specialtyarcher', 'mindk', '0'),
('specialtyfighter', 'cost', '0'),
('specialtyfighter', 'mindk', '0'),
('titlechange', 'blank', '1'),
('titlechange', 'bold', '1'),
('titlechange', 'extrapoints', '0'),
('titlechange', 'initialpoints', '500'),
('titlechange', 'italics', '1'),
('titlechange', 'spaceinname', '1'),
('titlechange', 'take', '1'),
('translationwizard', 'autoscan', '0'),
('translationwizard', 'blockcentral', '0'),
('translationwizard', 'blocktrans', '0'),
('translationwizard', 'lookuppath', 'http://translations.nb-core.org'),
('translationwizard', 'page', '20'),
('translationwizard', 'query', '0'),
('translationwizard', 'restricted', '0'),
('translationwizard', 'translationdelete', '0'),
('usechow', 'battle', '1'),
('usechow', 'newday', '10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module_settings`
--
ALTER TABLE `module_settings`
  ADD PRIMARY KEY (`modulename`,`setting`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
