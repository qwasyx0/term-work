-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 19. led 2019, 17:49
-- Verze serveru: 10.1.37-MariaDB
-- Verze PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `iwww1`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `ciselpod`
--

CREATE TABLE `ciselpod` (
  `IDCISELPOD` int(11) NOT NULL,
  `FIRMA` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `ULICE` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `PSC` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `MESTO` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `ciselpod`
--

INSERT INTO `ciselpod` (`IDCISELPOD`, `FIRMA`, `ULICE`, `PSC`, `MESTO`) VALUES
(6, 'Doležal Tomáš', 'Nová 55', '50143', 'Hradec Králové'),
(7, 'Macháček Jiří', 'Masarykovo náměstí 864', '51736', 'Olešnice'),
(8, 'Holý Jan', 'Sokolská 5', '54928', 'Sněžné'),
(9, 'Koblása Milan', 'U hasičárny 54', '87945', 'Podvraty'),
(10, 'Koblásová Jana', 'Okres 58', '58727', 'Olomouc'),
(11, 'Modrý Radek', 'Smrček 6', '58123', 'Neratovice'),
(12, 'Ducháček Vladimír', 'Velos 124', '47823', 'Doly'),
(13, 'Stark Eddard', 'Zimohrad 1', '78912', 'Zimohrad'),
(14, 'Hlaváček Ota', 'Školská 7', '58936', 'České Budějovice'),
(15, 'Osman Turek', 'Blízký východ 1', '12365', 'Praha'),
(59, 'Novy Uzivatel', 'adsf', '563', 'Nový Hrádek'),
(63, 'bbbbbbbbbb', 'U Stadionu 354', '452', 'Nový Hrádek'),
(65, 'Novy Uzivatel', 'U Stadionu 354', '452', 'Nový Hrádek'),
(66, 'Novy Uzivatel', 'U Stadionu 354', '254', 'Nový Hrádek');

-- --------------------------------------------------------

--
-- Struktura tabulky `importodectu`
--

CREATE TABLE `importodectu` (
  `ID` int(11) NOT NULL,
  `IDCISELPOD` int(11) NOT NULL,
  `CODECET` int(11) DEFAULT NULL,
  `FOTKA` longblob,
  `DATUM_ODECTU` date NOT NULL,
  `STAV` float NOT NULL,
  `KOMENTAR` mediumtext COLLATE utf8_czech_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `importodectu`
--

INSERT INTO `importodectu` (`ID`, `IDCISELPOD`, `CODECET`, `FOTKA`, `DATUM_ODECTU`, `STAV`, `KOMENTAR`) VALUES
(5001, 11, 2001, NULL, '2018-12-21', 458, NULL),
(5002, 12, 2002, NULL, '2018-12-02', 257, NULL),
(5003, 13, 2003, NULL, '2018-12-31', 985, NULL),
(5004, 14, 2004, NULL, '2018-12-03', 245, NULL),
(5005, 15, 2005, NULL, '2018-12-12', 102, NULL),
(5006, 6, 2006, NULL, '2019-01-16', 452, NULL),
(5007, 7, 2007, NULL, '2018-12-17', 786, NULL),
(5008, 8, 2008, NULL, '2018-12-09', 745, NULL),
(5009, 9, 2009, NULL, '2018-12-05', 254, NULL),
(5010, 10, 2010, NULL, '2018-12-25', 986, NULL),
(5033, 6, NULL, NULL, '2019-01-16', 4529, NULL),
(5036, 12, NULL, NULL, '2019-01-19', 245, ''),
(5037, 13, NULL, '', '2019-01-19', 1, ''),
(5041, 13, NULL, NULL, '2019-01-19', 125, '5143,512,3'),
(5042, 13, NULL, NULL, '2019-01-19', 45, ''),
(5043, 13, NULL, NULL, '2019-01-19', 74582, ''),
(5044, 13, NULL, NULL, '2019-01-19', 542, '452');

-- --------------------------------------------------------

--
-- Struktura tabulky `kontakty`
--

CREATE TABLE `kontakty` (
  `ID` int(11) NOT NULL,
  `IDCISELPOD` int(11) NOT NULL,
  `KONTAKT` varchar(64) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `kontakty`
--

INSERT INTO `kontakty` (`ID`, `IDCISELPOD`, `KONTAKT`) VALUES
(1, 6, '785965874'),
(2, 7, '123654789'),
(3, 8, '741258963'),
(4, 9, '369852147'),
(5, 10, '123987456'),
(6, 11, '159874236'),
(7, 12, '987456123'),
(8, 13, '258963147'),
(9, 14, '147896325'),
(10, 15, '12369745');

-- --------------------------------------------------------

--
-- Struktura tabulky `odbernamista`
--

CREATE TABLE `odbernamista` (
  `ID` int(11) NOT NULL,
  `IDCISELPOD` int(11) DEFAULT NULL,
  `ID_VODOMER` int(11) DEFAULT NULL,
  `ODBERMISTO` int(11) DEFAULT NULL,
  `TYP_SAZBY` int(11) DEFAULT NULL,
  `OBEC` int(5) DEFAULT NULL,
  `ULICE` int(5) DEFAULT NULL,
  `CP_CE` char(1) COLLATE utf8_czech_ci DEFAULT NULL,
  `CISLODOMU` char(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `PARCELA` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `odbernamista`
--

INSERT INTO `odbernamista` (`ID`, `IDCISELPOD`, `ID_VODOMER`, `ODBERMISTO`, `TYP_SAZBY`, `OBEC`, `ULICE`, `CP_CE`, `CISLODOMU`, `PARCELA`) VALUES
(3001, 11, 1001, 3001, 1, 101, 1, 'C', '25', '123/456'),
(3002, 12, 1002, 3002, 2, 101, 1, 'C', '44', '147/852'),
(3003, 13, 1003, 3003, 3, 101, 1, 'C', '53', '123/789'),
(3004, 14, 1004, 3004, 4, 101, 1, 'C', '75', '159/753'),
(3005, 15, 1005, 3005, 4, 756, 2, 'C', '45', '158/785'),
(3006, 6, 1006, 3006, 4, 756, 2, 'C', '25', '987/158'),
(3007, 7, 1007, 3007, 3, 756, 2, 'C', '87', '369/789'),
(3008, 8, 1008, 3008, 2, 258, 3, 'C', '38', '158/157'),
(3009, 9, 1009, 3009, 1, 258, 3, 'C', '85', '684/153'),
(3010, 10, 1010, 3010, 1, 258, 3, 'C', '45', '179/632');

-- --------------------------------------------------------

--
-- Struktura tabulky `odectyvodomeru`
--

CREATE TABLE `odectyvodomeru` (
  `CODECET` int(11) NOT NULL,
  `ID_VODOMER` int(11) NOT NULL,
  `IDCISELPOD` int(11) NOT NULL,
  `ID_ODBERMISTO` int(11) NOT NULL,
  `ID_VODOMERYPOHYBY` int(11) NOT NULL,
  `TYP_SAZBY` int(11) NOT NULL,
  `OBDOBI_OD` date NOT NULL,
  `OBDOBI_DO` date NOT NULL,
  `NOVY_STAV` decimal(12,2) NOT NULL,
  `PREDCHOZI_STAV` decimal(12,2) DEFAULT NULL,
  `CASTKA_BEZ_DPH` decimal(12,2) NOT NULL,
  `CASTKA_VCETNE_DPH` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `odectyvodomeru`
--

INSERT INTO `odectyvodomeru` (`CODECET`, `ID_VODOMER`, `IDCISELPOD`, `ID_ODBERMISTO`, `ID_VODOMERYPOHYBY`, `TYP_SAZBY`, `OBDOBI_OD`, `OBDOBI_DO`, `NOVY_STAV`, `PREDCHOZI_STAV`, `CASTKA_BEZ_DPH`, `CASTKA_VCETNE_DPH`) VALUES
(2001, 1001, 11, 3001, 4001, 1, '2018-01-01', '2019-12-31', '213.00', '187.00', '138.00', '158.00'),
(2002, 1002, 12, 3002, 4002, 2, '2018-01-01', '2019-12-31', '238.00', '220.00', '970.00', '1060.00'),
(2003, 1003, 13, 3003, 4003, 3, '2018-01-01', '2019-12-31', '450.00', '380.00', '2354.00', '2590.00'),
(2004, 1004, 14, 3004, 4004, 4, '2018-01-01', '2019-12-31', '502.00', '481.00', '1489.00', '1698.00'),
(2005, 1005, 15, 3005, 4005, 4, '2018-01-01', '2019-12-31', '258.00', '246.00', '69.00', '79.00'),
(2006, 1006, 6, 3006, 4006, 4, '2018-01-01', '2016-12-31', '780.00', '759.00', '-155.00', '-178.25'),
(2007, 1007, 7, 3007, 4007, 3, '2018-01-01', '2019-12-31', '352.00', '311.00', '63.00', '70.00'),
(2008, 1008, 8, 3008, 4008, 2, '2018-01-01', '2019-12-31', '561.00', '500.00', '1836.00', '2093.00'),
(2009, 1009, 9, 3009, 4009, 1, '2018-01-01', '2019-12-31', '147.00', '123.00', '900.00', '1027.00'),
(2010, 1010, 10, 3010, 4010, 1, '2018-01-01', '2019-12-31', '589.00', '541.00', '866.00', '987.00'),
(2014, 1006, 6, 3006, 4006, 4, '2016-12-31', '2019-01-16', '800.00', '780.00', '620.00', '713.00'),
(2015, 1006, 6, 3006, 4006, 4, '2019-01-16', '2019-01-17', '801.00', '800.00', '31.00', '35.65'),
(2016, 1006, 6, 3006, 4006, 4, '2019-01-17', '2019-01-16', '4529.00', '801.00', '115568.00', '132903.20');

-- --------------------------------------------------------

--
-- Struktura tabulky `sazby`
--

CREATE TABLE `sazby` (
  `TYP_SAZBY` int(11) NOT NULL,
  `CENA` decimal(12,2) NOT NULL,
  `OBDOBI_OD` date NOT NULL,
  `OBDOBI_DO` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `sazby`
--

INSERT INTO `sazby` (`TYP_SAZBY`, `CENA`, `OBDOBI_OD`, `OBDOBI_DO`) VALUES
(1, '34.00', '2018-01-01', '2019-12-31'),
(2, '34.00', '2018-01-01', '2019-12-31'),
(3, '31.00', '2018-01-01', '2019-12-31'),
(4, '31.00', '2018-01-01', '2019-12-31'),
(5, '28.00', '2019-01-16', '2019-01-16');

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE `uzivatele` (
  `EMAIL` varchar(55) COLLATE utf8_czech_ci NOT NULL,
  `IDCISELPOD` int(11) DEFAULT NULL,
  `PASSWORD` varchar(512) COLLATE utf8_czech_ci NOT NULL,
  `ROLE` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`EMAIL`, `IDCISELPOD`, `PASSWORD`, `ROLE`) VALUES
('ag@b.cz', 59, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('bb@bb.cz', 63, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('dolezal.tomas@seznam.cz', 6, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('dolezal@seznam.cz', 65, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('duchacek.vladimir@seznam.cz', 12, '5267768822ee624d48fce15ec5ca79cbd602cb7f4c2157a516556991f22ef8c7b5ef7b18d1ff41c59370efb0858651d44a936c11b7b144c48fe04df3c6a3e8da', 0),
('greas@aa.cz', 66, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('hlavacek.ota@seznam.cz', 14, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('holy.jan@seznam.cz', 8, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('koblasa.milan@seznam.cz', 9, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('koblasova.jana@seznam.cz', 10, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('machacek.jiri@seznam.cz', 7, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('modry.radek@seznam.cz', 11, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 0),
('osman.turek@seznam.cz', 15, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 1),
('stark.eddard@seznam.cz', 13, '1f40fc92da241694750979ee6cf582f2d5d7d28e18335de05abc54d0560e0f5302860c652bf08d560252aa5e74210546f369fbbbce8c12cfc7957b2652fe9a75', 1);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `viewodbernamista`
-- (See below for the actual view)
--
CREATE TABLE `viewodbernamista` (
`ODBERMISTO` int(11)
,`OBEC` int(5)
,`ULICE_ODBERNAMISTA` int(5)
,`CP_CE` char(1)
,`CISLODOMU` char(10)
,`PARCELA` varchar(20)
,`IDCISELPOD` int(11)
,`FIRMA` varchar(40)
,`ULICE_CISELPOD` varchar(30)
,`PSC` varchar(10)
,`MESTO` varchar(30)
,`CISLO_VODOMERU` int(11)
,`DATUM_MONTAZ` date
,`DRUH_VODOMERU` varchar(45)
);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `viewodecty`
-- (See below for the actual view)
--
CREATE TABLE `viewodecty` (
`OBDOBI_OD` date
,`OBDOBI_DO` date
,`NOVY_STAV` decimal(12,2)
,`PREDCHOZI_STAV` decimal(12,2)
,`CASTKA_BEZ_DPH` decimal(12,2)
,`CASTKA_VCETNE_DPH` decimal(12,2)
,`CISLO_VODOMERU` int(11)
,`ROK_PRISTI_REVIZE` int(11)
,`DRUH_VODOMERU` varchar(45)
,`IDCISELPOD` int(11)
,`FIRMA` varchar(40)
,`ULICE_CISELPOD` varchar(30)
,`PSC` varchar(10)
,`MESTO` varchar(30)
,`ODBERMISTO` int(11)
,`TYP_SAZBY` int(11)
,`OBEC` int(5)
,`ULICE_ODBERNAMISTA` int(5)
,`CP_CE` char(1)
,`CISLODOMU` char(10)
,`PARCELA` varchar(20)
);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `viewpohyby`
-- (See below for the actual view)
--
CREATE TABLE `viewpohyby` (
`DATUM_POHYBU` date
,`DRUH_POHYBU` int(11)
,`POPIS_POHYBU` varchar(255)
,`CISLO_VODOMERU` int(11)
,`DRUH_VODOMERU` varchar(45)
,`IDCISELPOD` int(11)
,`ODBERMISTO` int(11)
);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `viewvodomery`
-- (See below for the actual view)
--
CREATE TABLE `viewvodomery` (
`CISLO_VODOMERU` int(11)
,`ROK_PRISTI_REVIZE` int(11)
,`DATUM_MONTAZ` date
,`DRUH_VODOMERU` varchar(45)
,`OBEC` int(5)
,`ULICE_ODBERNAMISTA` int(5)
,`CP_CE` char(1)
,`CISLODOMU` char(10)
,`ODBERMISTO` int(11)
,`PARCELA` varchar(20)
,`IDCISELPOD` int(11)
,`FIRMA` varchar(40)
,`ULICE_CISELPOD` varchar(30)
,`PSC` varchar(10)
,`MESTO` varchar(30)
);

-- --------------------------------------------------------

--
-- Struktura tabulky `vodomery`
--

CREATE TABLE `vodomery` (
  `ID` int(11) NOT NULL,
  `ID_ODBERMISTO` int(11) DEFAULT NULL,
  `IDCISELPOD` int(11) DEFAULT NULL,
  `CISLO_VODOMERU` int(11) NOT NULL,
  `ROK_PRISTI_REVIZE` int(11) NOT NULL,
  `DATUM_MONTAZ` date NOT NULL,
  `DRUH_VODOMERU` varchar(45) CHARACTER SET cp1250 COLLATE cp1250_czech_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `vodomery`
--

INSERT INTO `vodomery` (`ID`, `ID_ODBERMISTO`, `IDCISELPOD`, `CISLO_VODOMERU`, `ROK_PRISTI_REVIZE`, `DATUM_MONTAZ`, `DRUH_VODOMERU`) VALUES
(1001, 3001, 11, 567508, 2019, '2014-03-07', '24'),
(1002, 3002, 12, 457, 2019, '2014-12-07', '45'),
(1003, 3003, 13, 2301593, 2019, '2013-02-08', '45'),
(1004, 3004, 14, 3, 2019, '2017-12-16', '45'),
(1005, 3005, 15, 457, 2019, '2018-04-08', '45'),
(1006, 3006, 6, 543544, 2019, '2015-12-01', '45'),
(1007, 3007, 7, 875678, 2020, '2012-07-05', '45'),
(1008, 3008, 8, 8755, 2020, '2015-05-15', '45'),
(1009, 3009, 9, 452578, 2020, '2016-07-14', '45'),
(1010, 3010, 10, 45345, 2020, '2017-10-12', '45'),
(1011, NULL, NULL, 50, 2019, '2018-11-20', '452'),
(1012, NULL, NULL, 452, 2019, '2019-01-15', '785'),
(1013, NULL, NULL, 542254, 2019, '2019-01-16', '452');

-- --------------------------------------------------------

--
-- Struktura tabulky `vodomerypohyby`
--

CREATE TABLE `vodomerypohyby` (
  `ID` int(11) NOT NULL,
  `ID_VODOMERY` int(11) NOT NULL,
  `ID_ODBERMISTO` int(11) NOT NULL,
  `DATUM_POHYBU` date NOT NULL,
  `DRUH_POHYBU` int(11) NOT NULL,
  `POPIS_POHYBU` varchar(255) CHARACTER SET cp1250 COLLATE cp1250_czech_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `vodomerypohyby`
--

INSERT INTO `vodomerypohyby` (`ID`, `ID_VODOMERY`, `ID_ODBERMISTO`, `DATUM_POHYBU`, `DRUH_POHYBU`, `POPIS_POHYBU`) VALUES
(4001, 1001, 3001, '2018-06-09', 1, 'Nákup'),
(4002, 1002, 3002, '2016-12-01', 1, 'Nákup'),
(4003, 1003, 3003, '2014-09-20', 1, 'Nákup'),
(4004, 1004, 3004, '2016-10-08', 1, 'Nákup'),
(4005, 1005, 3005, '2014-04-18', 1, 'Nákup'),
(4006, 1006, 3006, '2016-02-13', 2, 'Prodej'),
(4007, 1007, 3007, '2014-09-25', 2, 'Prodej'),
(4008, 1008, 3008, '2015-10-03', 2, 'Prodej'),
(4009, 1009, 3009, '2014-08-16', 2, 'Prodej'),
(4010, 1010, 3010, '2015-07-05', 2, 'Prodej');

-- --------------------------------------------------------

--
-- Struktura pro pohled `viewodbernamista`
--
DROP TABLE IF EXISTS `viewodbernamista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewodbernamista`  AS  select `d`.`ODBERMISTO` AS `ODBERMISTO`,`d`.`OBEC` AS `OBEC`,`d`.`ULICE` AS `ULICE_ODBERNAMISTA`,`d`.`CP_CE` AS `CP_CE`,`d`.`CISLODOMU` AS `CISLODOMU`,`d`.`PARCELA` AS `PARCELA`,`c`.`IDCISELPOD` AS `IDCISELPOD`,`c`.`FIRMA` AS `FIRMA`,`c`.`ULICE` AS `ULICE_CISELPOD`,`c`.`PSC` AS `PSC`,`c`.`MESTO` AS `MESTO`,`v`.`CISLO_VODOMERU` AS `CISLO_VODOMERU`,`v`.`DATUM_MONTAZ` AS `DATUM_MONTAZ`,`v`.`DRUH_VODOMERU` AS `DRUH_VODOMERU` from ((`odbernamista` `d` left join `ciselpod` `c` on((`c`.`IDCISELPOD` = `d`.`IDCISELPOD`))) left join `vodomery` `v` on((`v`.`ID` = `d`.`ID_VODOMER`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `viewodecty`
--
DROP TABLE IF EXISTS `viewodecty`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewodecty`  AS  select `o`.`OBDOBI_OD` AS `OBDOBI_OD`,`o`.`OBDOBI_DO` AS `OBDOBI_DO`,`o`.`NOVY_STAV` AS `NOVY_STAV`,`o`.`PREDCHOZI_STAV` AS `PREDCHOZI_STAV`,`o`.`CASTKA_BEZ_DPH` AS `CASTKA_BEZ_DPH`,`o`.`CASTKA_VCETNE_DPH` AS `CASTKA_VCETNE_DPH`,`v`.`CISLO_VODOMERU` AS `CISLO_VODOMERU`,`v`.`ROK_PRISTI_REVIZE` AS `ROK_PRISTI_REVIZE`,`v`.`DRUH_VODOMERU` AS `DRUH_VODOMERU`,`c`.`IDCISELPOD` AS `IDCISELPOD`,`c`.`FIRMA` AS `FIRMA`,`c`.`ULICE` AS `ULICE_CISELPOD`,`c`.`PSC` AS `PSC`,`c`.`MESTO` AS `MESTO`,`d`.`ODBERMISTO` AS `ODBERMISTO`,`d`.`TYP_SAZBY` AS `TYP_SAZBY`,`d`.`OBEC` AS `OBEC`,`d`.`ULICE` AS `ULICE_ODBERNAMISTA`,`d`.`CP_CE` AS `CP_CE`,`d`.`CISLODOMU` AS `CISLODOMU`,`d`.`PARCELA` AS `PARCELA` from (((`odectyvodomeru` `o` left join `vodomery` `v` on((`v`.`ID` = `o`.`ID_VODOMER`))) left join `ciselpod` `c` on((`c`.`IDCISELPOD` = `o`.`IDCISELPOD`))) left join `odbernamista` `d` on((`d`.`ID` = `o`.`ID_ODBERMISTO`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `viewpohyby`
--
DROP TABLE IF EXISTS `viewpohyby`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpohyby`  AS  select `p`.`DATUM_POHYBU` AS `DATUM_POHYBU`,`p`.`DRUH_POHYBU` AS `DRUH_POHYBU`,`p`.`POPIS_POHYBU` AS `POPIS_POHYBU`,`v`.`CISLO_VODOMERU` AS `CISLO_VODOMERU`,`v`.`DRUH_VODOMERU` AS `DRUH_VODOMERU`,`c`.`IDCISELPOD` AS `IDCISELPOD`,`m`.`ODBERMISTO` AS `ODBERMISTO` from (((`vodomerypohyby` `p` left join `vodomery` `v` on((`v`.`ID` = `p`.`ID_VODOMERY`))) left join `ciselpod` `c` on((`c`.`IDCISELPOD` = `v`.`IDCISELPOD`))) left join `odbernamista` `m` on((`p`.`ID_ODBERMISTO` = `m`.`ID`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `viewvodomery`
--
DROP TABLE IF EXISTS `viewvodomery`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewvodomery`  AS  select `v`.`CISLO_VODOMERU` AS `CISLO_VODOMERU`,`v`.`ROK_PRISTI_REVIZE` AS `ROK_PRISTI_REVIZE`,`v`.`DATUM_MONTAZ` AS `DATUM_MONTAZ`,`v`.`DRUH_VODOMERU` AS `DRUH_VODOMERU`,`o`.`OBEC` AS `OBEC`,`o`.`ULICE` AS `ULICE_ODBERNAMISTA`,`o`.`CP_CE` AS `CP_CE`,`o`.`CISLODOMU` AS `CISLODOMU`,`o`.`ODBERMISTO` AS `ODBERMISTO`,`o`.`PARCELA` AS `PARCELA`,`c`.`IDCISELPOD` AS `IDCISELPOD`,`c`.`FIRMA` AS `FIRMA`,`c`.`ULICE` AS `ULICE_CISELPOD`,`c`.`PSC` AS `PSC`,`c`.`MESTO` AS `MESTO` from ((`vodomery` `v` left join `odbernamista` `o` on((`o`.`ID` = `v`.`ID_ODBERMISTO`))) left join `ciselpod` `c` on((`c`.`IDCISELPOD` = `v`.`IDCISELPOD`))) ;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `ciselpod`
--
ALTER TABLE `ciselpod`
  ADD PRIMARY KEY (`IDCISELPOD`);

--
-- Klíče pro tabulku `importodectu`
--
ALTER TABLE `importodectu`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_IMPORTODECTU_CISELPOD` (`IDCISELPOD`),
  ADD KEY `FK_IMPORTODECTU_ODECTYVODOMERU` (`CODECET`);

--
-- Klíče pro tabulku `kontakty`
--
ALTER TABLE `kontakty`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_KONTAKTY_CISELPOD` (`IDCISELPOD`);

--
-- Klíče pro tabulku `odbernamista`
--
ALTER TABLE `odbernamista`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ODBERNAMISTA_CISELPOD` (`IDCISELPOD`),
  ADD KEY `FK_ODBERNAMISTA_VODOMERY` (`ID_VODOMER`);

--
-- Klíče pro tabulku `odectyvodomeru`
--
ALTER TABLE `odectyvodomeru`
  ADD PRIMARY KEY (`CODECET`),
  ADD KEY `FK_ODECTYVODOMERU_VODOMERY` (`ID_VODOMER`),
  ADD KEY `FK_ODECTYVODOMERU_CISELPOD` (`IDCISELPOD`),
  ADD KEY `FK_ODECTYVODOMERU_ODBERNAMISTA` (`ID_ODBERMISTO`),
  ADD KEY `FK_ODECTYVODOMERU_VODOMERYPOHYBY` (`ID_VODOMERYPOHYBY`),
  ADD KEY `FK_ODECTYVODOMERU_SAZBY` (`TYP_SAZBY`);

--
-- Klíče pro tabulku `sazby`
--
ALTER TABLE `sazby`
  ADD PRIMARY KEY (`TYP_SAZBY`),
  ADD UNIQUE KEY `TYP_SAZBY` (`TYP_SAZBY`);

--
-- Klíče pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`EMAIL`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD KEY `FK_UZIVATELE_CISELPOD` (`IDCISELPOD`);

--
-- Klíče pro tabulku `vodomery`
--
ALTER TABLE `vodomery`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_VODOMERY_ODBERNAMISTA` (`ID_ODBERMISTO`);

--
-- Klíče pro tabulku `vodomerypohyby`
--
ALTER TABLE `vodomerypohyby`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_VODOMERY_POHYBY_VODOMERY` (`ID_VODOMERY`),
  ADD KEY `FK_VODOMERY_POHYBY_ODBERNAMISTA` (`ID_ODBERMISTO`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `ciselpod`
--
ALTER TABLE `ciselpod`
  MODIFY `IDCISELPOD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT pro tabulku `importodectu`
--
ALTER TABLE `importodectu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5045;

--
-- AUTO_INCREMENT pro tabulku `kontakty`
--
ALTER TABLE `kontakty`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pro tabulku `odbernamista`
--
ALTER TABLE `odbernamista`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3011;

--
-- AUTO_INCREMENT pro tabulku `odectyvodomeru`
--
ALTER TABLE `odectyvodomeru`
  MODIFY `CODECET` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2017;

--
-- AUTO_INCREMENT pro tabulku `vodomery`
--
ALTER TABLE `vodomery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1014;

--
-- AUTO_INCREMENT pro tabulku `vodomerypohyby`
--
ALTER TABLE `vodomerypohyby`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4011;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `importodectu`
--
ALTER TABLE `importodectu`
  ADD CONSTRAINT `FK_IMPORTODECTU_CISELPOD` FOREIGN KEY (`IDCISELPOD`) REFERENCES `ciselpod` (`IDCISELPOD`),
  ADD CONSTRAINT `FK_IMPORTODECTU_ODECTYVODOMERU` FOREIGN KEY (`CODECET`) REFERENCES `odectyvodomeru` (`CODECET`);

--
-- Omezení pro tabulku `kontakty`
--
ALTER TABLE `kontakty`
  ADD CONSTRAINT `FK_KONTAKTY_CISELPOD` FOREIGN KEY (`IDCISELPOD`) REFERENCES `ciselpod` (`IDCISELPOD`);

--
-- Omezení pro tabulku `odbernamista`
--
ALTER TABLE `odbernamista`
  ADD CONSTRAINT `FK_ODBERNAMISTA_CISELPOD` FOREIGN KEY (`IDCISELPOD`) REFERENCES `ciselpod` (`IDCISELPOD`),
  ADD CONSTRAINT `FK_ODBERNAMISTA_VODOMERY` FOREIGN KEY (`ID_VODOMER`) REFERENCES `vodomery` (`ID`);

--
-- Omezení pro tabulku `odectyvodomeru`
--
ALTER TABLE `odectyvodomeru`
  ADD CONSTRAINT `FK_ODECTYVODOMERU_CISELPOD` FOREIGN KEY (`IDCISELPOD`) REFERENCES `ciselpod` (`IDCISELPOD`),
  ADD CONSTRAINT `FK_ODECTYVODOMERU_ODBERNAMISTA` FOREIGN KEY (`ID_ODBERMISTO`) REFERENCES `odbernamista` (`ID`),
  ADD CONSTRAINT `FK_ODECTYVODOMERU_SAZBY` FOREIGN KEY (`TYP_SAZBY`) REFERENCES `sazby` (`TYP_SAZBY`),
  ADD CONSTRAINT `FK_ODECTYVODOMERU_VODOMERY` FOREIGN KEY (`ID_VODOMER`) REFERENCES `vodomery` (`ID`),
  ADD CONSTRAINT `FK_ODECTYVODOMERU_VODOMERYPOHYBY` FOREIGN KEY (`ID_VODOMERYPOHYBY`) REFERENCES `vodomerypohyby` (`ID`);

--
-- Omezení pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD CONSTRAINT `FK_UZIVATELE_CISELPOD` FOREIGN KEY (`IDCISELPOD`) REFERENCES `ciselpod` (`IDCISELPOD`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `vodomery`
--
ALTER TABLE `vodomery`
  ADD CONSTRAINT `FK_VODOMERY_ODBERNAMISTA` FOREIGN KEY (`ID_ODBERMISTO`) REFERENCES `odbernamista` (`ID`);

--
-- Omezení pro tabulku `vodomerypohyby`
--
ALTER TABLE `vodomerypohyby`
  ADD CONSTRAINT `FK_VODOMERY_POHYBY_ODBERNAMISTA` FOREIGN KEY (`ID_ODBERMISTO`) REFERENCES `odbernamista` (`ID`),
  ADD CONSTRAINT `FK_VODOMERY_POHYBY_VODOMERY` FOREIGN KEY (`ID_VODOMERY`) REFERENCES `vodomery` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
