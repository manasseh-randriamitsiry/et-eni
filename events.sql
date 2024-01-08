-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 08 Janvier 2024 à 20:21
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `et_eni`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `salle` varchar(10) NOT NULL,
  `enseignant` varchar(50) NOT NULL,
  `niveau` varchar(10) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `color` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `events`
--

INSERT INTO `events` (`id`, `title`, `salle`, `enseignant`, `niveau`, `start`, `end`, `color`) VALUES
(19, 'Initiation en C', '102', 'Mr cyprien', '', '2024-01-08 03:05:00', '2024-01-08 04:04:00', '#5a35c0'),
(20, 'aaaa', 'sss', 'bbb', 'ccc', '2024-01-01 02:03:00', '2024-01-01 03:05:00', '#000000'),
(21, 'zeqerqzr', 'sqrqsr', 'zrqrz', 'SSSSS', '2024-01-08 00:00:00', '2024-01-09 00:00:00', '#000000'),
(22, 'zrRQS', 'SQRQSR', 'RSDRQSR', 'RSDRQSR', '2024-01-08 00:00:00', '2024-01-09 00:00:00', '#b64949');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
