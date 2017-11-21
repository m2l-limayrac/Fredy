-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 25 Octobre 2017 à 10:56
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogmvc`
--
USE `blogmvc`;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `login`, `password`, `is_admin`) VALUES
(1, 'jef', 'jef', 1),
(2, 'bill', 'bill', 0),
(3, 'bob', 'bob', 0),
(4, 'donald', 'donald', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Contenu de la table `billet`
--

INSERT INTO `billet` (`id_billet`, `titre`, `contenu`, `date`) VALUES
(1, 'Premier billet', 'blablabla1', '2017-10-23 17:20:18'),
(2, 'Second billet', 'blablabla2', '2017-10-23 17:25:06'),
(3, 'Troisième billet', 'blablabla3', '2017-10-23 18:39:12');

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_billet`, `id_utilisateur`, `contenu`, `date`) VALUES
(1, 1, 1, 'Commentaire 1', '2017-10-25 10:53:28'),
(2, 1, 1, 'Commentaire 2', '2017-10-25 10:53:39'),
(3, 2, 1, 'Commentaire 1', '2017-10-25 10:53:48'),
(4, 2, 1, 'Commentaire 2', '2017-10-25 10:53:59');

