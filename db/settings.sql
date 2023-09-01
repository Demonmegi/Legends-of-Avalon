-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 01:02 AM
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
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting` varchar(20) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting`, `value`) VALUES
('addexp', '5'),
('allowclans', '1'),
('allowcreation', '1'),
('allowfeed', '0'),
('allowgoldtransfer', '0'),
('allowoddadminrenames', '0'),
('allowpackofmonsters', '1'),
('allowspecialswitch', '1'),
('autofight', '0'),
('autofightfull', '0'),
('automaster', '1'),
('bard', '`^Seth'),
('barkeep', '`tCedrik'),
('barmaid', '`%Violet'),
('beta', '0'),
('betaperplayer', '1'),
('blockdupeemail', '0'),
('borrowperlevel', '20'),
('cachetranslations', '0'),
('charset', 'ISO-8859-1'),
('clanregistrar', '`%Karissa'),
('collecttexts', ''),
('companionsallowed', '1'),
('companionslevelup', '1'),
('curltimeout', '5'),
('daysperday', '4'),
('deathoverlord', '`$Ramius'),
('defaultlanguage', 'en'),
('defaultskin', 'jade.htm'),
('defaultsuperuser', '0'),
('dictionary', '/usr/share/dict/words'),
('disablebonuses', '1'),
('displaymasternews', '1'),
('dropmingold', '0'),
('edittitles', '1'),
('emailpetitions', '0'),
('enablecompanions', '1'),
('enabletranslation', '1'),
('expirecontent', '180'),
('expirenewacct', '10'),
('expireoldacct', '45'),
('expiretrashacct', '1'),
('fightsforinterest', '4'),
('forestchance', '15'),
('forestexploss', '10'),
('forestgemchance', '25'),
('gameadminemail', 'postmaster@localhost.com'),
('gameoffsetseconds', '0'),
('game_epoch', '2023-08-02 00:00:00 +0000'),
('gardenchance', '0'),
('gemstostartclan', '15'),
('goldtostartclan', '10000'),
('gravechance', '0'),
('gravefightsperday', '10'),
('homecurtime', '1'),
('homenewdaytime', '1'),
('homenewestplayer', '1'),
('homeskinselect', '1'),
('impressum', ''),
('inboxlimit', '50'),
('innchance', '0'),
('innfee', '5%'),
('innname', 'The Boar\'s Head Inn'),
('installer_version', '1.1.2 Dragonprime Edition'),
('instantexp', ''),
('lastdboptimize', '23-09-02 12:45:48'),
('last_char_expire', '0000-00-00 00:00:00'),
('logdnet', '0'),
('logdnetserver', 'http://logdnet.logd.com/'),
('loginbanner', '*BETA* This is a BETA of this website, things are likely to change now and again, as it is under active development *BETA*'),
('LOGINTIMEOUT', '900'),
('mailsizelimit', '1024'),
('maxattacks', '4'),
('maxcolors', '10'),
('maxgoldforinterest', '100000'),
('maxinterest', '10'),
('maxlistsize', '100'),
('maxonline', '0'),
('maxrestartgems', '10'),
('maxrestartgold', '300'),
('maxtransferout', '25'),
('mininterest', '1'),
('mintransferlev', '3'),
('motditems', '5'),
('multibasemax', '3'),
('multibasemin', '2'),
('multichance', '25'),
('multifightdk', '10'),
('multimaster', '1'),
('multislummax', '1'),
('multislummin', '0'),
('multisuimax', '4'),
('multisuimin', '2'),
('multithrillmax', '2'),
('multithrillmin', '1'),
('newdaycron', '0'),
('newdaySemaphore', '0000-00-00 00:00:00'),
('newestplayer', ''),
('newplayerstartgold', '50'),
('notify_address', ''),
('notify_every', '30'),
('notify_on_error', '0'),
('notify_on_warn', '0'),
('officermoderate', '0'),
('oldmail', '14'),
('OnlineCount', '0'),
('OnlineCountLast', '1693608355'),
('onlyunreadmails', '1'),
('paypalcountry-code', 'us'),
('paypalcurrency', 'USD'),
('paypalemail', ''),
('paypaltext', 'legend of the green dragon site donation from'),
('permacollect', '0'),
('postinglimit', '1'),
('pvp', '1'),
('pvpattgain', '10'),
('pvpattlose', '10'),
('pvpday', '3'),
('pvpdefgain', '10'),
('pvpdeflose', '5'),
('pvpimmunity', '5'),
('pvpminexp', '1500'),
('pvptimeout', '600'),
('refereraward', '25'),
('referminlevel', '4'),
('requireemail', '0'),
('requirevalidemail', '0'),
('resurrectionturns', '-6'),
('selfdelete', '0'),
('serverdesc', 'Another LoGD Server'),
('serverlanguages', 'en,English,fr,Franï¿½ais,dk,Danish,de,Deutsch,es,Espaï¿½ol,it,Italian'),
('serverurl', 'http://loa.bplaced.net/'),
('soap', '1'),
('spaceinname', '0'),
('suicide', '0'),
('suicidedk', '10'),
('superuseryommessage', 'Asking an admin for gems, gold, weapons, armor, or anything else which you have not earned will not be honored.  If you are experiencing problems with the game, please use the \'Petition for Help\' link instead of contacting an admin directly.'),
('tl_maxallowed', '0'),
('transferperlevel', '25'),
('transferreceive', '3'),
('turns', '10'),
('villagechance', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
