-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 14 jan 2017 om 16:58
-- Serverversie: 5.7.9
-- PHP-versie: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kartcentrum`
--
CREATE DATABASE IF NOT EXISTS `kartcentrum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `kartcentrum`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `activiteiten`
--

DROP TABLE IF EXISTS `activiteiten`;
CREATE TABLE IF NOT EXISTS `activiteiten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `soort_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `soort_id` (`soort_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `activiteiten`
--

INSERT INTO `activiteiten` (`id`, `datum`, `tijd`, `soort_id`) VALUES
(1, '2015-05-31', '09:00:00', 1),
(2, '2016-05-31', '11:00:00', 1),
(7, '2015-06-14', '12:30:00', 2),
(8, '2015-06-14', '14:00:00', 1),
(9, '2015-06-26', '17:30:00', 3),
(11, '2016-06-19', '10:00:00', 3),
(12, '2015-06-21', '14:00:00', 1),
(13, '2017-04-22', '23:34:00', 2),
(15, '2017-04-22', '20:00:00', 2),
(16, '2016-11-03', '19:01:00', 3),
(20, '2016-11-26', '23:00:00', 4),
(21, '2016-11-10', '00:00:00', 2),
(22, '2017-01-07', '22:00:00', 1),
(23, '2017-03-31', '22:22:00', 2),
(24, '2018-01-09', '15:45:00', 2),
(25, '2017-01-18', '09:45:00', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `deelnames`
--

DROP TABLE IF EXISTS `deelnames`;
CREATE TABLE IF NOT EXISTS `deelnames` (
  `activiteit_id` int(11) NOT NULL,
  `deelnemer_id` int(11) NOT NULL,
  PRIMARY KEY (`activiteit_id`,`deelnemer_id`),
  KEY `cursistcursussen_ibfk_1` (`deelnemer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `deelnames`
--

INSERT INTO `deelnames` (`activiteit_id`, `deelnemer_id`) VALUES
(23, 9),
(7, 10),
(9, 10),
(12, 10),
(20, 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

DROP TABLE IF EXISTS `gebruikers`;
CREATE TABLE IF NOT EXISTS `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `voorletters` varchar(10) NOT NULL,
  `tussenvoegsel` varchar(10) DEFAULT NULL,
  `achternaam` varchar(25) NOT NULL,
  `adres` varchar(25) NOT NULL,
  `postcode` varchar(7) NOT NULL,
  `woonplaats` varchar(20) NOT NULL,
  `telefoon` varchar(15) DEFAULT NULL,
  `gebruikersnaam` varchar(20) NOT NULL,
  `wachtwoord` varchar(64) NOT NULL DEFAULT 'qwerty',
  `recht` enum('deelnemer','medewerker') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gebruikersnaam` (`gebruikersnaam`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `email`, `voorletters`, `tussenvoegsel`, `achternaam`, `adres`, `postcode`, `woonplaats`, `telefoon`, `gebruikersnaam`, `wachtwoord`, `recht`) VALUES
(5, 'max@kartcentrum.nl', 'M.', '', 'Verstappen', 'de kruif 7', '3456HJ', 'Delft', '', 'mverstappen', 'qwerty', 'medewerker'),
(6, 'bart@kartcentrum.nl', 'B.', 'de', 'Jong', 'kaasplank 7', '3456JK', 'De Lier', '', 'bjong', 'qwerty', 'medewerker'),
(9, 'pvliet@hotmail.com', 'P.', '', 'Vliet', 'Bosrand 7', '2324DF', 'Delft', '', 'pvliet', 'qwerty', 'deelnemer'),
(10, 'telst@hotmail.com', 'T.', 'van der', 'Elst', 'platenenhof 7', '2980GH', 'Vlaardingen', '067345234', 'telst', 'qwerty123', 'deelnemer');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `soortactiviteiten`
--

DROP TABLE IF EXISTS `soortactiviteiten`;
CREATE TABLE IF NOT EXISTS `soortactiviteiten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(25) NOT NULL,
  `min_leeftijd` int(11) NOT NULL,
  `tijdsduur` int(11) NOT NULL,
  `prijs` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `soortactiviteiten`
--

INSERT INTO `soortactiviteiten` (`id`, `naam`, `min_leeftijd`, `tijdsduur`, `prijs`) VALUES
(1, 'Vrije training', 12, 15, '15.00'),
(2, 'Grand Prix', 12, 60, '50.00'),
(3, 'Endurance race', 16, 90, '65.00'),
(4, 'Kinder race', 8, 10, '18.00');

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `activiteiten`
--
ALTER TABLE `activiteiten`
  ADD CONSTRAINT `activiteiten_ibfk_1` FOREIGN KEY (`soort_id`) REFERENCES `soortactiviteiten` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `deelnames`
--
ALTER TABLE `deelnames`
  ADD CONSTRAINT `deelnames_ibfk_1` FOREIGN KEY (`activiteit_id`) REFERENCES `activiteiten` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deelnames_ibfk_2` FOREIGN KEY (`deelnemer_id`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
