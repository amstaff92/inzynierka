-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `sobczak`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dokumenty`
--

CREATE TABLE IF NOT EXISTS `dokumenty` (
  `dok_id` int(11) NOT NULL AUTO_INCREMENT,
  `dok_ob_id` int(11) DEFAULT NULL,
  `dok_data_utw` date NOT NULL,
  `dok_data_akt` date DEFAULT NULL,
  `dok_rodzaj_id` int(11) NOT NULL,
  `dok_plik` varchar(150) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`dok_id`),
  KEY `dok_ob_id` (`dok_ob_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `dokumenty`
--

INSERT INTO `dokumenty` (`dok_id`, `dok_ob_id`, `dok_data_utw`, `dok_data_akt`, `dok_rodzaj_id`, `dok_plik`) VALUES
(1, 3, '2014-12-08', '2015-12-06', 3, 'dokument323.pdf'),
(3, 2, '2015-11-10', '2015-12-01', 1, 'd9fb-c81e-calendar.css'),
(4, 3, '2015-12-05', '0000-00-00', 1, 'b58c-eccb-piesel-wow.png'),
(5, 2, '2015-12-07', '2016-01-08', 1, '191b-c81e-autocad2.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obiekty`
--

CREATE TABLE IF NOT EXISTS `obiekty` (
  `ob_id` int(11) NOT NULL AUTO_INCREMENT,
  `ob_uzy_id` int(11) DEFAULT NULL,
  `ob_nazwa` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ob_adres` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ob_rodzaj` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`ob_id`),
  KEY `ob_uzy_id` (`ob_uzy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `obiekty`
--

INSERT INTO `obiekty` (`ob_id`, `ob_uzy_id`, `ob_nazwa`, `ob_adres`, `ob_rodzaj`) VALUES
(2, 2, 'Hotel 51', 'Powstańców 4/85, Toruń', 'hotel'),
(3, 1, 'Pensjonat Atrius', 'Szosa lubińska 78/11, Warszawa', 'pensjonat');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przypomnienia`
--

CREATE TABLE IF NOT EXISTS `przypomnienia` (
  `przyp_id` int(11) NOT NULL AUTO_INCREMENT,
  `przyp_ob_id` int(11) DEFAULT NULL,
  `przyp_data_wys` date NOT NULL,
  `przyp_data_odczyt` date DEFAULT NULL,
  PRIMARY KEY (`przyp_id`),
  KEY `przyp_ob_id` (`przyp_ob_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `przypomnienia`
--

INSERT INTO `przypomnienia` (`przyp_id`, `przyp_ob_id`, `przyp_data_wys`, `przyp_data_odczyt`) VALUES
(4, 3, '2015-12-01', '2015-12-03'),
(7, 2, '2015-11-29', '2015-12-07'),
(8, 2, '2015-12-07', '2015-12-07');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzaje_dok`
--

CREATE TABLE IF NOT EXISTS `rodzaje_dok` (
  `rodz_id` int(11) NOT NULL AUTO_INCREMENT,
  `rodz_nazwa` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`rodz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Zrzut danych tabeli `rodzaje_dok`
--

INSERT INTO `rodzaje_dok` (`rodz_id`, `rodz_nazwa`) VALUES
(1, 'IBP'),
(2, 'OZW'),
(3, 'ASOP'),
(4, 'Ekspertyza tech.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE IF NOT EXISTS `uzytkownicy` (
  `uzy_id` int(11) NOT NULL AUTO_INCREMENT,
  `uzy_mail` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `uzy_haslo` varchar(32) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `uzy_adres` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `uzy_typ` int(11) NOT NULL COMMENT '0 - zwykly user, 1 - admin',
  `uzy_imie_nazw` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `uzy_tel` varchar(15) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`uzy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`uzy_id`, `uzy_mail`, `uzy_haslo`, `uzy_adres`, `uzy_typ`, `uzy_imie_nazw`, `uzy_tel`) VALUES
(1, 'admin@admin.pl', '21232f297a57a5a743894a0e4a801fc3', 'Bursztynowa 1442, Łeba', 1, 'Mateusz Sobczak', '11111111'),
(2, 'test@test.pl', '098f6bcd4621d373cade4e832627b4f6', 'Klonowa 64/2, 34-400 Wadowice', 0, 'Adam Nowaczek', '512875621'),
(5, 'test2@test.pl', '098f6bcd4621d373cade4e832627b4f6', 'Testowska 2/20, 52-578 Testowo', 0, 'Test Testowski', '123456789');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
