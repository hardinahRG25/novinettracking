-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 15 mars 2022 à 13:36
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `network_novity`
--

-- --------------------------------------------------------

--
-- Structure de la table `network`
--

DROP TABLE IF EXISTS `network`;
CREATE TABLE IF NOT EXISTS `network` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `effecive_network_type` varchar(45) DEFAULT NULL,
  `current_download_speed` decimal(4,2) DEFAULT NULL,
  `round_trip_time` decimal(5,3) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `create` timestamp NULL DEFAULT current_timestamp(),
  `speed` decimal(4,2) DEFAULT NULL,
  `uuid_date` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `ldap` varchar(45) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `profil` text DEFAULT NULL,
  `access` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `create` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `first_name`, `ldap`, `mail`, `tel`, `profil`, `access`, `password`, `create`) VALUES
(1, 'admin', NULL, 'admin', 'admin@admin.io', NULL, NULL, 'admin', 'b9acb8164cb71891e6300ae04e7ce307', '2022-03-15 13:27:26'),
(2, 'RAJAONA', 'Hardinah', 'hardinah', 'hardinah@novity.io', '', NULL, 'admin', '0cc175b9c0f1b6a831c399e269772661', '2022-03-08 12:09:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
