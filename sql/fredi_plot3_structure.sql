-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 20 mars 2018 à 16:50
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fredi_plot3`
--
CREATE DATABASE IF NOT EXISTS `fredi_plot3` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `fredi_plot3`;

DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `strToDate` (`p_str` VARCHAR(25)) RETURNS DATE RETURN str_to_date(p_str,"%Y-%m-%d")$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

CREATE TABLE IF NOT EXISTS `adherent` (
  `numLicence` int(11) DEFAULT NULL,
  `Nom` varchar(25) DEFAULT NULL,
  `Prenom` varchar(25) DEFAULT NULL,
  `Sexe` varchar(25) DEFAULT NULL,
  `DateNaissance` date DEFAULT NULL,
  `AdresseAdh` varchar(30) DEFAULT NULL,
  `CP` char(5) DEFAULT NULL,
  `Ville` varchar(25) DEFAULT NULL,
  `Id_Demandeur` int(11) NOT NULL,
  `id_adherent` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_adherent`),
  KEY `FK_ADHERENT_Id_Demandeur` (`Id_Demandeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `avancer`
--

CREATE TABLE IF NOT EXISTS `avancer` (
  `Id_Demandeur` int(11) NOT NULL,
  `id_Ligne` int(11) NOT NULL,
  `Id_NoteDeFrais` int(11) NOT NULL,
  PRIMARY KEY (`Id_Demandeur`,`id_Ligne`,`Id_NoteDeFrais`),
  KEY `FK_Avancer_idLigne` (`id_Ligne`),
  KEY `FK_Avancer_Id_NoteDeFrais` (`Id_NoteDeFrais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `Id_Club` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(25) NOT NULL,
  `AdresseClub` varchar(30) DEFAULT NULL,
  `Cp` char(5) NOT NULL,
  `Ville` varchar(25) DEFAULT NULL,
  `Sigle` varchar(25) DEFAULT NULL,
  `NomPresident` varchar(25) DEFAULT NULL,
  `Id_Ligue` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_Club`),
  KEY `FK_CLUB_Id_Ligue` (`Id_Ligue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `demandeur`
--

CREATE TABLE IF NOT EXISTS `demandeur` (
  `Id_Demandeur` int(11) NOT NULL AUTO_INCREMENT,
  `AdresseMail` varchar(50) DEFAULT NULL,
  `MotDePasse` varchar(60) DEFAULT NULL,
  `Id_Club` int(11) DEFAULT NULL,
  `isRepresentant` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_Demandeur`),
  KEY `FK_DEMANDEUR_idClub` (`Id_Club`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `indemnite`
--

CREATE TABLE IF NOT EXISTS `indemnite` (
  `Annee` year(4) NOT NULL,
  `tarifKilometrique` float NOT NULL,
  PRIMARY KEY (`Annee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lignefrais`
--

CREATE TABLE IF NOT EXISTS `lignefrais` (
  `id_Ligne` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date DEFAULT NULL,
  `Km` float DEFAULT NULL,
  `CoutPeage` decimal(25,0) DEFAULT '0',
  `CoutRepas` decimal(25,0) DEFAULT '0',
  `CoutHebergement` decimal(25,0) DEFAULT '0',
  `Trajet` varchar(25) DEFAULT NULL,
  `Annee` year(4) DEFAULT NULL,
  `id_Motif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Ligne`),
  KEY `FK_LIGNEFRAIS_Annee` (`Annee`),
  KEY `FK_LIGNEFRAIS_idMotif` (`id_Motif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déclencheurs `lignefrais`
--
DELIMITER $$
CREATE TRIGGER `before_insert_ligneFrais` BEFORE INSERT ON `lignefrais` FOR EACH ROW BEGIN

DECLARE newDate date;

  select strToDate(NEW.Date) INTO newDate;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

CREATE TABLE IF NOT EXISTS `ligue` (
  `Id_Ligue` int(11) NOT NULL AUTO_INCREMENT,
  `Nom_ligue` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`Id_Ligue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

CREATE TABLE IF NOT EXISTS `motif` (
  `id_Motif` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Motif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notedefrais`
--

CREATE TABLE IF NOT EXISTS `notedefrais` (
  `Id_NoteDeFrais` int(11) NOT NULL,
  `isValidate` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_NoteDeFrais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `representant`
--

CREATE TABLE IF NOT EXISTS `representant` (
  `Nom` varchar(25) NOT NULL,
  `Prenom` varchar(25) NOT NULL,
  `Rue` varchar(25) NOT NULL,
  `Cp` char(5) NOT NULL,
  `Ville` varchar(25) NOT NULL,
  `Id_Demandeur` int(11) NOT NULL,
  `id_representant` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_representant`),
  KEY `FK_Representant_Id_Demandeur` (`Id_Demandeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avancer`
--
ALTER TABLE `avancer`
  ADD CONSTRAINT `FK_Avancer_Id_NoteDeFrais` FOREIGN KEY (`Id_NoteDeFrais`) REFERENCES `notedefrais` (`Id_NoteDeFrais`),
  ADD CONSTRAINT `FK_Avancer_idDemandeur` FOREIGN KEY (`Id_Demandeur`) REFERENCES `demandeur` (`Id_Demandeur`),
  ADD CONSTRAINT `FK_Avancer_idLigne` FOREIGN KEY (`id_Ligne`) REFERENCES `lignefrais` (`id_Ligne`) ON DELETE CASCADE;

--
-- Contraintes pour la table `club`
--
ALTER TABLE `club`
  ADD CONSTRAINT `FK_CLUB_Id_Ligue` FOREIGN KEY (`Id_Ligue`) REFERENCES `ligue` (`Id_Ligue`);

--
-- Contraintes pour la table `demandeur`
--
ALTER TABLE `demandeur`
  ADD CONSTRAINT `FK_DEMANDEUR_idClub` FOREIGN KEY (`Id_Club`) REFERENCES `club` (`Id_Club`);

--
-- Contraintes pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  ADD CONSTRAINT `FK_LIGNEFRAIS_Annee` FOREIGN KEY (`Annee`) REFERENCES `indemnite` (`Annee`),
  ADD CONSTRAINT `FK_LIGNEFRAIS_idMotif` FOREIGN KEY (`id_Motif`) REFERENCES `motif` (`id_Motif`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
