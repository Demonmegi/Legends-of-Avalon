-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2023 at 04:50 PM
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
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `cityid` tinyint(3) NOT NULL,
  `cityname` varchar(30) NOT NULL,
  `citytype` varchar(30) NOT NULL,
  `cityauthor` varchar(30) DEFAULT NULL,
  `cityactive` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `citychat` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `citytravel` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `citytext` text DEFAULT NULL,
  `stabletext` text DEFAULT NULL,
  `armortext` text DEFAULT NULL,
  `weaponstext` text DEFAULT NULL,
  `mercenarycamptext` text DEFAULT NULL,
  `cityblockmods` text DEFAULT NULL,
  `cityblocknavs` text DEFAULT NULL,
  `module` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`cityid`, `cityname`, `citytype`, `cityauthor`, `cityactive`, `citychat`, `citytravel`, `citytext`, `stabletext`, `armortext`, `weaponstext`, `mercenarycamptext`, `cityblockmods`, `cityblocknavs`, `module`) VALUES
(1, 'Dorf von Avalon', 'Village', 'Eric Stevens', 1, 0, 0, '', '', '', '', '', '', 'a:12:{s:5:\"train\";s:1:\"1\";s:5:\"lodge\";s:1:\"1\";s:7:\"weapons\";s:1:\"1\";s:5:\"armor\";s:1:\"1\";s:4:\"bank\";s:1:\"1\";s:5:\"gypsy\";s:1:\"1\";s:7:\"stables\";s:1:\"1\";s:7:\"gardens\";s:1:\"1\";s:4:\"rock\";s:1:\"1\";s:4:\"clan\";s:1:\"1\";s:3:\"hof\";s:1:\"1\";s:5:\"other\";s:407:\"runmodule.php?module=cities&op=travel,runmodule.php?module=cities&op=travel&city=Dorf von Avalon,runmodule.php?module=cities&op=travel&city=Aussenhof,runmodule.php?module=cities&op=travel&city=Hof%20der%20Bauern,runmodule.php?module=cities&op=travel&city=Aussenburg,runmodule.php?module=cities&op=travel&city=Innenhof,runmodule.php?module=cities&op=travel&city=Innenburg,runmodule.php?module=usechow&op=inn,\";}', 'city_creator'),
(2, 'Suedtor', 'City', 'Yakut', 1, 0, 0, 'a:4:{s:5:\"title\";s:6:\"Südtor\";s:4:\"text\";s:1105:\"Die prächtige Südtor der Zitadelle Avalon erzählt eine Geschichte von Widerstand, Stärke und Wiederaufbau. Einst von den verheerenden Angriffen der Sha\\\'ahoul im Zuge der Belagerung von Avalon gezeichnet, zeigt es heute stolz seine wiederhergestellte Pracht.`n`n\r\n\r\nDie sichtbaren Narben vergangener Schlachten erzählen von den heldenhaften Bemühungen der tapferen Verteidiger der Zitadelle. Der Ansturm der Sha\\\'ahoul hinterließ deutliche Spuren auf den massiven Toren und den umliegenden Mauern. Doch selbst in der Dunkelheit des Krieges behielten die Verteidiger ihren Glauben an die Schutz gewährenden Mauern der Zitadelle.`n`n\r\n\r\nHeute ist das Südtor der Zitadelle Avalon ein Ort des Stolzes und der Verehrung. Reisende und Bewohner gleichermaßen passieren es mit Ehrfurcht vor der Geschichte, die es verkörpert. Es erinnert daran, dass selbst in den dunkelsten Stunden die Menschen von Avalon ihre Entschlossenheit bewahrten, ihre Heimat zu schützen und wiederaufzubauen - ein ewiges Zeichen der Standhaftigkeit und des Triumphs über die Herausforderungen, die das Schicksal ihnen auferlegt hat.`n`n\";s:5:\"clock\";s:1:\" \";s:7:\"gatenav\";s:4:\"Tore\";}', '', '', '', '', '', 'a:17:{s:6:\"forest\";s:1:\"1\";s:3:\"pvp\";s:1:\"1\";s:13:\"mercenarycamp\";s:1:\"1\";s:5:\"train\";s:1:\"1\";s:5:\"lodge\";s:1:\"1\";s:7:\"weapons\";s:1:\"1\";s:5:\"armor\";s:1:\"1\";s:4:\"bank\";s:1:\"1\";s:5:\"gypsy\";s:1:\"1\";s:3:\"inn\";s:1:\"1\";s:7:\"stables\";s:1:\"1\";s:7:\"gardens\";s:1:\"1\";s:4:\"rock\";s:1:\"1\";s:4:\"clan\";s:1:\"1\";s:4:\"news\";s:1:\"1\";s:3:\"hof\";s:1:\"1\";s:5:\"other\";s:459:\"login.php?op=logout,runmodule.php?module=cities&op=travel,runmodule.php?module=cities&op=travel&city=Suedtor,runmodule.php?module=cities&op=travel&city=Hof%20der%20Bauern,runmodule.php?module=cities&op=travel&city=Aussenburg,runmodule.php?module=cities&op=travel&city=Innenhof,runmodule.php?module=cities&op=travel&city=Innenburg,runmodule.php?module=usechow&op=inn,runmodule.php?module=odor,runmodule.php?module=house,runmodule.php?module=crazyaudrey&op=pet,\";}', 'city_creator'),
(3, 'Aussenhof', 'City', 'Yakut', 1, 0, 0, 'a:8:{s:5:\"title\";s:9:\"Aussenhof\";s:4:\"text\";s:1911:\"Der Außenhof der Zitadelle Avalon erzählt von einer epischen Schlacht. Hier, wo Mithras und seine gefürchtete Sha\\\'ahoul-Armee das Südtor durchbrachen, entfaltete sich das Hauptgeschehen der Schlacht, die den Lauf der Geschichte für immer verändern sollte.`n`n\r\n\r\nDer Außenhof, einst ein Ort der Ausbildung und des Handels, wurde zum Schauplatz eines erbitterten Kampfes, als die Sha\\\'ahoul in einem verzweifelten Versuch, die Zitadelle zu erobern, ihre Kräfte gegen die Ritter von Avalon entfesselten. Sir Roth, ein tapferer Ritter, führte die Verteidigung an, während Mithras, der Anführer der Sha\\\'ahoul, persönlich auf dem Schlachtfeld erschien. Die Ställe, einst ein Ort des Friedens für die Pferde, wurden zum Zeugen von Krieg und Konflikt.`n`n\r\n\r\nDoch die Legende erzählt von einem heldenhaften Eingreifen, das das Schicksal der Schlacht wenden sollte. Ein Ritter aus dem Königreich Elythria, der Bruder von Corvus, dem Anführer von Avalon, trat vor und stellte sich Mithras mutig entgegen. Mit Schwert und Schild kämpfte er gegen die Dunkelheit, die Mithras verkörperte, und triumphierte schließlich über den Anführer der Sha\\\'ahoul. Dieser Akt der Tapferkeit und Entschlossenheit ließ den Außenhof in einem ganz besonderen Licht erstrahlen.`n`n\r\n\r\nHeute erinnert der Außenhof der Zitadelle Avalon an die heldenhaften Taten jener Tage. Die Stallungen beherbergen wieder ruhige Pferde, der Trainingsplatz dient der Ausbildung der neuen Generation von Rittern, und die Händler bieten ihre Waren an, während die Tore des Außenhofs zu anderen Teilen der Zitadelle führen: zur Aussenburg, wo die Macht der Führung ruht, zum Hof der Bauern, der das Herz der Versorgung bildet, und zum Südtor, das einst die Wut der Sha\\\'ahoul ertrug und nun stolz wiederhergestellt ist - ein Symbol für die unaufhaltsame Entschlossenheit der Bewohner von Avalon, ihre Heimat zu verteidigen und ihre Geschichte zu bewahren.`n`n\";s:5:\"clock\";s:1:\" \";s:7:\"gatenav\";s:4:\"Tore\";s:8:\"fightnav\";s:10:\"Kampfplatz\";s:9:\"tavernnav\";s:7:\"Laufweg\";s:10:\"stablename\";s:13:\"Tracys Ställe\";s:10:\"weaponshop\";s:25:\"Freeman der Waffenschmied\";}', 'a:1:{s:5:\"title\";s:13:\"Tracys Ställe\";}', '', '', '', '', 'a:13:{s:6:\"forest\";s:1:\"1\";s:3:\"pvp\";s:1:\"1\";s:13:\"mercenarycamp\";s:1:\"1\";s:5:\"lodge\";s:1:\"1\";s:5:\"armor\";s:1:\"1\";s:5:\"gypsy\";s:1:\"1\";s:3:\"inn\";s:1:\"1\";s:7:\"gardens\";s:1:\"1\";s:4:\"rock\";s:1:\"1\";s:4:\"clan\";s:1:\"1\";s:4:\"news\";s:1:\"1\";s:3:\"hof\";s:1:\"1\";s:5:\"other\";s:404:\"login.php?op=logout,runmodule.php?module=cities&op=travel,runmodule.php?module=cities&op=travel&city=Dorf von Avalon,runmodule.php?module=cities&op=travel&city=Aussenhof,runmodule.php?module=cities&op=travel&city=Innenhof,runmodule.php?module=cities&op=travel&city=Innenburg,runmodule.php?module=usechow&op=inn,runmodule.php?module=odor,runmodule.php?module=house,runmodule.php?module=crazyaudrey&op=pet,\";}', 'city_creator'),
(4, 'Hof der Bauern', 'City', 'Yakut', 1, 0, 0, 'a:4:{s:5:\"title\";s:14:\"Hof der Bauern\";s:4:\"text\";s:1752:\"Der Hof der Bauern, erreichbar über den Außenhof, trägt die Erinnerung an eine Zeit des Leids und der Hoffnung gleichermaßen. Einst ein Zufluchtsort für Flüchtlinge vor den Schrecken des Krieges, wurde dieser Ort während der Belagerung von Avalon von einer verheerenden Krankheit heimgesucht, die ihn zwang, sich unter Quarantäne zu stellen. Doch heute, in der Gegenwart, erstrahlt der Hof der Bauern in einem neuen Licht.`n`n\r\n\r\nDie Zelte, die einst Zuflucht vor der Dunkelheit des Krieges boten, sind nun Heimat für jene Bauern, die ihre Lebensmittel und Güter den Bewohnern der Burg anbieten. Das gedämpfte Muhen des Viehs und das geschäftige Treiben der Bauern erzählen von einem Ort, der sich von den Wunden der Vergangenheit erholt hat. Die Umgebung, einst gezeichnet von Krankheit und Verzweiflung, ist heute erfüllt von Leben und leuchtender Hoffnung.`n`n\r\n\r\nDie Geschichte des Hofes der Bauern ist eine Geschichte des Überlebens und der Gemeinschaft. Die Bewohner von Avalon haben gezeigt, dass sie in den dunkelsten Stunden zusammenstehen und sich gegenseitig unterstützen können. Die Bauern, die einst in Angst vor der Krankheit lebten, sind nun stolze Verkäufer ihrer Erzeugnisse, die die Burgbevölkerung mit Nahrung versorgen.`n`n\r\n\r\nWenn man heute durch den Hof der Bauern geht, kann man die Vergangenheit zwar noch erahnen, aber die Gegenwart überwiegt. Die Zelte sind Zeugen von Hingabe und Wiederaufbau, das Vieh symbolisiert die Lebenskraft, die nie erlischt, und die Bauern, die ihre Waren verkaufen, sind ein Symbol für die Entschlossenheit und den Glauben an eine bessere Zukunft. Der Hof der Bauern bleibt ein Ort der Erinnerung, der Veränderung und der Hoffnung, eingebettet in die Mauern der majestätischen Zitadelle Avalon.`n`n\";s:5:\"clock\";s:1:\" \";s:7:\"gatenav\";s:4:\"Tore\";}', '', '', '', '', '', 'a:16:{s:6:\"forest\";s:1:\"1\";s:3:\"pvp\";s:1:\"1\";s:13:\"mercenarycamp\";s:1:\"1\";s:5:\"train\";s:1:\"1\";s:5:\"lodge\";s:1:\"1\";s:7:\"weapons\";s:1:\"1\";s:5:\"armor\";s:1:\"1\";s:4:\"bank\";s:1:\"1\";s:3:\"inn\";s:1:\"1\";s:7:\"stables\";s:1:\"1\";s:7:\"gardens\";s:1:\"1\";s:4:\"rock\";s:1:\"1\";s:4:\"clan\";s:1:\"1\";s:4:\"news\";s:1:\"1\";s:3:\"hof\";s:1:\"1\";s:5:\"other\";s:518:\"login.php?op=logout,runmodule.php?module=cities&op=travel,runmodule.php?module=cities&op=travel&city=Dorf von Avalon,runmodule.php?module=cities&op=travel&city=Suedtor,runmodule.php?module=cities&op=travel&city=Hof%20der%20Bauern,runmodule.php?module=cities&op=travel&city=Aussenburg,runmodule.php?module=cities&op=travel&city=Innenhof,runmodule.php?module=cities&op=travel&city=Innenburg,runmodule.php?module=usechow&op=inn,runmodule.php?module=odor,runmodule.php?module=house,runmodule.php?module=crazyaudrey&op=pet,\";}', 'city_creator'),
(5, 'Aussenburg', 'City', 'Yakut', 1, 0, 0, 'a:5:{s:5:\"title\";s:10:\"Aussenburg\";s:4:\"text\";s:2179:\"Die Aussenburg der Zitadelle Avalon erhebt sich majestätisch im Herzen der Festung und trägt die Geschichten vergangener Zeiten in sich. Dieser Teil der Zitadelle, erreichbar über den Außenhof, atmet den Geist von Glauben, Zusammenhalt und Ritterlichkeit.`n`n\r\n\r\nDie Kapelle in der Aussenburg der Zitadelle Avalon birgt nicht nur Gebete und Andacht, sondern auch ein heiliges Symbol von unermesslicher Bedeutung. Stolz präsentiert, ruht der Kelch des Lebens in einem Schrein, der von den Gläubigen mit Ehrfurcht betrachtet wird. Dieser heilige religiöse Gegenstand hat einst den Lauf des Krieges in der Belagerung von Avalon verändert und symbolisiert den Glauben, der die Herzen der Ritter und Bewohner der Zitadelle Avalon erfüllt.`n`n\r\n\r\nDie Küche, in der die Aromen von Speisen und Gerichten aus vergangenen Jahrhunderten noch immer in der Luft hängen, ist ein Ort des Gemeinschaftsgefühls. Hier wurden Mahlzeiten zubereitet, die nicht nur den Leib, sondern auch die Seele nährten. Der Duft von Kräutern und Gewürzen vermengt sich mit den Erinnerungen an lange Tafeln, an denen Ritter und Gefolgsleute sich versammelten.`n`n\r\n\r\nDer große Saal, geschmückt mit den stolzen Fahnen des Königreichs Eurale, erzählt von der Geschichte und den Allianzen, die diese Lande geprägt haben. Hier wurden Abkommen besiegelt, Allianzen geschmiedet und Siege gefeiert. Die Farben der Flaggen wehen im Wind und erinnern daran, dass die Aussenburg nicht nur ein Ort der Verteidigung, sondern auch des diplomatischen Geschicks war.`n`n\r\n\r\nDie oberen Stockwerke beherbergen die Wohnräume und Quartiere der Ritter, die in der Aussenburg ihren Sitz hatten. Hier wurden Pläne geschmiedet, Strategien entwickelt und Geschichten von vergangenen Schlachten ausgetauscht. Die Zimmer sind stiller Zeuge von Mut und Hingabe, die die Ritter von Avalon antrieben.`n`n\r\n\r\nDie Aussenburg der Zitadelle Avalon ist mehr als nur eine Ansammlung von Gebäuden. Sie ist ein Ort, an dem die Essenz von Avalons Ritterlichkeit, Glauben und Gemeinschaft in den Stein gemeißelt ist. Hier vermischen sich Geschichte und Gegenwart, Ritterlichkeit und Glaube zu einem lebendigen Erbe, das durch die Jahrhunderte trägt.`n`n\";s:5:\"clock\";s:1:\" \";s:7:\"gatenav\";s:4:\"Tore\";s:9:\"tavernnav\";s:13:\"Einrichtungen\";}', '', '', '', '', 'a:1:{s:5:\"other\";s:15:\"moons,moons.php\";}', 'a:16:{s:6:\"forest\";s:1:\"1\";s:3:\"pvp\";s:1:\"1\";s:13:\"mercenarycamp\";s:1:\"1\";s:5:\"train\";s:1:\"1\";s:5:\"lodge\";s:1:\"1\";s:7:\"weapons\";s:1:\"1\";s:5:\"armor\";s:1:\"1\";s:4:\"bank\";s:1:\"1\";s:5:\"gypsy\";s:1:\"1\";s:3:\"inn\";s:1:\"1\";s:7:\"stables\";s:1:\"1\";s:7:\"gardens\";s:1:\"1\";s:4:\"rock\";s:1:\"1\";s:4:\"news\";s:1:\"1\";s:3:\"hof\";s:1:\"1\";s:5:\"other\";s:430:\"login.php?op=logout,runmodule.php?module=cities&op=travel,runmodule.php?module=cities&op=travel&city=Dorf von Avalon,runmodule.php?module=cities&op=travel&city=Suedtor,runmodule.php?module=cities&op=travel&city=Hof%20der%20Bauern,runmodule.php?module=cities&op=travel&city=Aussenburg,runmodule.php?module=cities&op=travel&city=Innenburg,runmodule.php?module=odor,runmodule.php?module=house,runmodule.php?module=crazyaudrey&op=pet,\";}', 'city_creator'),
(6, 'Innenhof', 'City', 'Yakut', 1, 0, 0, 'a:7:{s:5:\"title\";s:8:\"Innenhof\";s:4:\"text\";s:2083:\"Der Innenhof der Zitadelle Avalon ist ein Ort der Vielfalt, der Geschäftigkeit und der Ruhe, eingebettet im Herzen der mächtigen Festungsmauern. Hier, geschützt auf allen Seiten von den massiven Mauern, findet man eine Oase der Sicherheit und des Lebens.`n`n\r\n\r\nDie Taverne, die stolz am Eingang des Innenhofs steht, ist ein Ort der Zusammenkunft und der Geselligkeit. Hier teilen Reisende, Ritter und Bewohner von Avalon Geschichten, Erlebnisse und vielleicht sogar das ein oder andere Lied. Das Gemurmel der Gäste, das Klirren von Bechern und das fröhliche Lachen füllen die Luft und verleihen der Taverne eine lebendige Atmosphäre.`n`n\r\n\r\nDie verschiedenen Händler, die ihre Waren im Innenhof feilbieten, verwandeln diesen Ort in einen Marktplatz der Träume. Von kunstvollen Handwerksstücken bis hin zu exotischen Gewürzen und edlen Stoffen findet man hier eine Fülle von Schätzen, die die Sinne ansprechen. Die Händler sind stolz auf ihre Angebote und die Vielfalt spiegelt die Offenheit von Avalon für die Welt wider.`n`n\r\n\r\nDoch der wahre Höhepunkt des Innenhofs ist der prächtige Garten, der sich in seiner ganzen Schönheit entfaltet. Blumen in leuchtenden Farben, duftende Kräuter und schattenspendende Bäume schaffen einen Ort der Erholung und des Friedens. Hier können die Bewohner von Avalon Momente der Stille genießen, die Gedanken schweifen lassen oder sich einfach dem Anblick der blühenden Pracht hingeben.`n`n\r\n\r\nDie dicken Festungsmauern, die den Innenhof auf allen Seiten umgeben, verleihen diesem Ort ein Gefühl der Sicherheit und Geborgenheit. Die Mauern erinnern daran, dass die Bewohner von Avalon seit jeher ihre Heimat beschützen und verteidigen. Und doch öffnen die Tore des Innenhofs auch die Möglichkeit zur Begegnung mit der Welt jenseits der Mauern.`n`n\r\n\r\nDer Innenhof der Zitadelle Avalon ist ein Ort der Kontraste - von geschäftiger Betriebsamkeit bis hin zur stillen Kontemplation, von Sicherheit bis hin zu Offenheit. Hier verschmelzen Vergangenheit und Gegenwart zu einem lebendigen Zentrum des Lebens, das die Essenz von Avalon widerspiegelt.`n`n\";s:5:\"clock\";s:1:\" \";s:7:\"gatenav\";s:4:\"Tore\";s:8:\"fightnav\";s:6:\"Ostweg\";s:9:\"tavernnav\";s:9:\"Gartenweg\";s:9:\"armorshop\";s:17:\"Astrids Rüstungen\";}', '', 'a:1:{s:5:\"title\";s:17:\"Astrids Rüstungen\";}', '', '', '', 'a:13:{s:6:\"forest\";s:1:\"1\";s:3:\"pvp\";s:1:\"1\";s:13:\"mercenarycamp\";s:1:\"1\";s:5:\"train\";s:1:\"1\";s:7:\"weapons\";s:1:\"1\";s:4:\"bank\";s:1:\"1\";s:5:\"gypsy\";s:1:\"1\";s:3:\"inn\";s:1:\"1\";s:7:\"stables\";s:1:\"1\";s:4:\"clan\";s:1:\"1\";s:4:\"news\";s:1:\"1\";s:3:\"hof\";s:1:\"1\";s:5:\"other\";s:464:\"login.php?op=logout,runmodule.php?module=cities&op=travel,runmodule.php?module=cities&op=travel&city=Dorf von Avalon,runmodule.php?module=cities&op=travel&city=Suedtor,runmodule.php?module=cities&op=travel&city=Aussenhof,runmodule.php?module=cities&op=travel&city=Hof%20der%20Bauern,runmodule.php?module=cities&op=travel&city=Innenhof,runmodule.php?module=usechow&op=inn,runmodule.php?module=odor,runmodule.php?module=house,runmodule.php?module=crazyaudrey&op=pet,\";}', 'city_creator'),
(7, 'Innenburg', 'City', 'Yakut', 1, 0, 0, 'a:4:{s:5:\"title\";s:9:\"Innenburg\";s:4:\"text\";s:1955:\"Die Innenburg der Zitadelle Avalon ist das Herzstück der Festung, ein Ort von Macht, Wissen und Versammlung. Hier, wo die massiven Mauern die Geschichten vergangener Tage tragen, findet man die Essenz von Avalons Führung und Geschichte.`n`n\r\n\r\nDie beeindruckende Bibliothek in der Innenburg ist ein Schatz an Wissen und Weisheit. Die Regale sind gefüllt mit alten Schriften, magischen Grimoiren und historischen Aufzeichnungen. Hier können Gelehrte und Neugierige gleichermaßen in den Seiten der Vergangenheit stöbern und Erkenntnisse entdecken, die das Wesen von Eurale formten.`n`n\r\n\r\nDie Küche und der Speisesaal, die den Duft von köstlichen Speisen tragen, sind ein Ort der Gemeinschaft. Hier versammeln sich die Bewohner von Avalon, um sich zu stärken und Geschichten auszutauschen. Die Tische sind Zeugen von gelachten Witzen, tiefen Diskussionen und wichtigen Verhandlungen.`n`n\r\n\r\nDer prächtige Flur, der zum Thronsaal führt, erzählt von der Macht und dem Erbe von Eurale. Die sieben Thronen der Königreiche von Eurale stehen in majestätischer Reihe und symbolisieren die Einheit und den Zusammenhalt der Länder. Hier wurden wichtige Entscheidungen getroffen, Bündnisse geschlossen und Gerechtigkeit gesprochen.`n`n\r\n\r\nDie oberen Stockwerke beherbergen die Quartiere der Ritter, Zauberer und Alchemisten von Oriam. In Zeiten des Krieges diente die Innenburg auch als Rückzugsort für die Diplomaten der Königreiche von Eurale, die hier um Frieden und Allianzen rangen. König Ryence, der einst die Innenburg bewohnte, trat zurück zugunsten von Olon, der nun König von Oriam ist und eine neue Ära in der wiederaufgebauten Hauptstadt von Oriam fernab von hier einläutet.`n`n\r\n\r\nDie Innenburg der Zitadelle Avalon trägt die Last der Vergangenheit und die Verheißung der Zukunft. Hier vereinen sich Führung, Geschichte und Schicksal zu einem lebendigen Zentrum, das die Identität von Eurale aufrecht erhält und den Geist von Avalon fortdauern lässt.`n`n\";s:5:\"clock\";s:29:\"Die Uhr im Thronsaal zeigt %s\";s:7:\"gatenav\";s:4:\"Tore\";}', '', '', '', '', '', 'a:16:{s:6:\"forest\";s:1:\"1\";s:3:\"pvp\";s:1:\"1\";s:13:\"mercenarycamp\";s:1:\"1\";s:5:\"train\";s:1:\"1\";s:5:\"lodge\";s:1:\"1\";s:7:\"weapons\";s:1:\"1\";s:5:\"armor\";s:1:\"1\";s:4:\"bank\";s:1:\"1\";s:5:\"gypsy\";s:1:\"1\";s:3:\"inn\";s:1:\"1\";s:7:\"stables\";s:1:\"1\";s:7:\"gardens\";s:1:\"1\";s:4:\"rock\";s:1:\"1\";s:4:\"clan\";s:1:\"1\";s:4:\"news\";s:1:\"1\";s:5:\"other\";s:519:\"login.php?op=logout,runmodule.php?module=cities&op=travel,runmodule.php?module=cities&op=travel&city=Dorf von Avalon,runmodule.php?module=cities&op=travel&city=Suedtor,runmodule.php?module=cities&op=travel&city=Aussenhof,runmodule.php?module=cities&op=travel&city=Hof%20der%20Bauern,runmodule.php?module=cities&op=travel&city=Aussenburg,runmodule.php?module=cities&op=travel&city=Innenburg,runmodule.php?module=usechow&op=inn,runmodule.php?module=odor,runmodule.php?module=house,runmodule.php?module=crazyaudrey&op=pet,\";}', 'city_creator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`cityid`),
  ADD KEY `cityid` (`cityid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `cityid` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
