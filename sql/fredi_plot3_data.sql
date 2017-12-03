-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 03 Décembre 2017 à 23:28
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fredi_plot3`
--
CREATE DATABASE IF NOT EXISTS `fredi_plot3` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fredi_plot3`;

DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `strToDate` (`p_str` VARCHAR(25)) RETURNS DATE RETURN str_to_date(p_str,"%Y-%m-%d")$$

DELIMITER ;

--
-- Contenu de la table `adherent`
--

INSERT INTO `adherent` (`numLicence`, `Nom`, `Prenom`, `Sexe`, `DateNaissance`, `AdresseAdh`, `CP`, `Ville`, `Id_Demandeur`, `Id_Club`) VALUES
(170540010, 'Bamdiela', 'Clement', 'M', '2017-09-03', '2 rue widrick', '3000', 'Toulouse', 1, 1),
(170540011, 'Javel', 'Aude', 'F', '2017-09-12', '5 rue a coté de ', '25660', 'A droite de ', 2, 2);

--
-- Contenu de la table `avancer`
--

INSERT INTO `avancer` (`Id_Demandeur`, `id_Ligne`, `Id_NoteDeFrais`) VALUES
(1, 1, 1),
(2, 2, 2),
(1, 3, 1),
(1, 4, 1);

--
-- Contenu de la table `club`
--

INSERT INTO `club` (`Id_Club`, `Nom`, `AdresseClub`, `Cp`, `Ville`, `Sigle`, `NomPresident`, `Id_Ligue`) VALUES
(1, 'lapinrou', '3 rue du honk-honk', '31000', 'lapinville', NULL, 'Bugs Bunny', 1),
(2, 'pinsella', '8 rue de la grotte', '32000', 'lascaux', NULL, 'BlobFish', 2);

--
-- Contenu de la table `demandeur`
--

INSERT INTO `demandeur` (`Id_Demandeur`, `AdresseMail`, `MotDePasse`, `isRepresentant`) VALUES
(1, 'tutu@monmail.fr', '$2y$10$yGefDCE8Gxea1mmbxojJGOes4FtBMHOE9QET.6ONvea4RX0cuje0i', 1),
(2, 'tata@sonmail.fr', '1234', 0);

--
-- Contenu de la table `indemnite`
--

INSERT INTO `indemnite` (`Annee`, `tarifKilometrique`) VALUES
(2009, 0.28),
(2012, 0.52);

--
-- Contenu de la table `lignefrais`
--

INSERT INTO `lignefrais` (`id_Ligne`, `Date`, `Km`, `CoutPeage`, `CoutRepas`, `CoutHebergement`, `Trajet`, `Annee`, `Id_Motif`) VALUES
(1, '2009-10-08', 1235, 562, 555, 522, 'Toulouse-cugnaux !', 2009, 2),
(2, '2012-09-11', 2884, 215, 1500, 5000, 'toulouse-île-Maurice', 2012, 2),
(3, '2017-12-11', 500, 250, 0, 0, 'paris-marseille', 2009, 1),
(4, '2017-12-04', 896, 230, 258, 695, 'toulouse-poudlard', 2009, 3);

--
-- Contenu de la table `ligue`
--

INSERT INTO `ligue` (`Id_Ligue`, `Nom_ligue`) VALUES
(1, 'foot'),
(2, 'rugby');

--
-- Contenu de la table `motif`
--

INSERT INTO `motif` (`Id_Motif`, `Libelle`) VALUES
(1, 'match de quidditch'),
(2, 'match de pole dance'),
(3, 'pétanque');

--
-- Contenu de la table `notedefrais`
--

INSERT INTO `notedefrais` (`Id_NoteDeFrais`) VALUES
(1),
(2);

--
-- Contenu de la table `representant`
--

INSERT INTO `representant` (`Nom`, `Prenom`, `Rue`, `Cp`, `Ville`, `Id_Demandeur`) VALUES
('Coptere', 'Lili', '4 Rue de l\'élice', '1200', 'SuperCopter', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
