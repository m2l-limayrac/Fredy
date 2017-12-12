-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 12 déc. 2017 à 14:55
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

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
CREATE DATABASE IF NOT EXISTS `fredi_plot3` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fredi_plot3`;

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`numLicence`, `Nom`, `Prenom`, `Sexe`, `DateNaissance`, `AdresseAdh`, `CP`, `Ville`, `Id_Demandeur`, `Id_Club`, `id_adherent`) VALUES
(170540010, 'Bamdiela', 'Clement', 'M', '2017-09-03', '2 rue widrick', '3000', 'Toulouse', 1, 1, 1),
(170540011, 'Javel', 'Aude', 'F', '2017-09-12', '5 rue a cot?® de ', '25660', 'A droite de ', 2, 2, 2),
(170540010, 'berbier', 'clement', 'H', '2017-12-18', '12 rue de machin', '31000', 'toulouse', 1, 1, 3),
(1758957875, 'Roma', 'nichel', 'H', '2017-12-04', 'caravane', '0', 'partout', 1, 2, 4);

--
-- Déchargement des données de la table `avancer`
--

INSERT INTO `avancer` (`Id_Demandeur`, `id_Ligne`, `Id_NoteDeFrais`) VALUES
(1, 1, 1),
(1, 3, 1),
(1, 4, 1),
(2, 2, 2);

--
-- Déchargement des données de la table `club`
--

INSERT INTO `club` (`Id_Club`, `Nom`, `AdresseClub`, `Cp`, `Ville`, `Sigle`, `NomPresident`, `Id_Ligue`) VALUES
(1, 'lapinrou', '3 rue du honk-honk', '31000', 'lapinville', NULL, 'Bugs Bunny', 1),
(2, 'pinsella', '8 rue de la grotte', '32000', 'lascaux', NULL, 'BlobFish', 2);

--
-- Déchargement des données de la table `demandeur`
--

INSERT INTO `demandeur` (`Id_Demandeur`, `AdresseMail`, `MotDePasse`, `isRepresentant`) VALUES
(1, 'tutu@monmail.fr', '$2y$10$2gTVcXJ9ddxyioWiw91c3eVHfJhlmZhZUFF8QoRYolKn5ADHWWGtW', 1),
(2, 'tata@sonmail.fr', '$2y$10$das67oKRGIUYANcIgtpujuTeCz2MvtJSYxm9MDJiuJD/gU.M.okGC', 0),
(8, 'test', '$2y$10$58SP/.zWx8LYA4bJCHBpE.A8hY78W06YoUs56CDQG7rqNdHMDQDeq', 1);

--
-- Déchargement des données de la table `indemnite`
--

INSERT INTO `indemnite` (`Annee`, `tarifKilometrique`) VALUES
(2009, 0.28),
(2012, 0.52),
(2017, 0.64);

--
-- Déchargement des données de la table `lignefrais`
--

INSERT INTO `lignefrais` (`id_Ligne`, `Date`, `Km`, `CoutPeage`, `CoutRepas`, `CoutHebergement`, `Trajet`, `Annee`, `Id_Motif`) VALUES
(1, '2009-10-08', 1235, 100, 100, 100, 'Toulouse-cugnaux', 2009, 2),
(2, '2012-09-11', 2884, 215, 1500, 5000, 'toulouse-?«le-Maurice', 2012, 2),
(3, '2017-12-11', 500, 250, 50, 50, 'paris-marseille', 2009, 2),
(4, '2009-09-15', 896, 230, 258, 695, 'toulouse-poudlard', 2009, 3);

--
-- Déchargement des données de la table `ligue`
--

INSERT INTO `ligue` (`Id_Ligue`, `Nom_ligue`) VALUES
(1, 'foot'),
(2, 'rugby');

--
-- Déchargement des données de la table `motif`
--

INSERT INTO `motif` (`Id_Motif`, `Libelle`) VALUES
(1, 'match de quidditch'),
(2, 'match de pole dance'),
(3, 'p?®tanque'),
(4, 'test');

--
-- Déchargement des données de la table `notedefrais`
--

INSERT INTO `notedefrais` (`Id_NoteDeFrais`) VALUES
(1),
(2);

--
-- Déchargement des données de la table `representant`
--

INSERT INTO `representant` (`Nom`, `Prenom`, `Rue`, `Cp`, `Ville`, `Id_Demandeur`, `id_representant`) VALUES
('number2', 'prenom e', 'rue efez2', '2', 'two', 1, 1),
('Coptere', 'Lili', '4 Rue de l\'?®lice', '1200', 'SuperCopter', 2, 2);
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
