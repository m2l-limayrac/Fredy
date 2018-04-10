-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 20 mars 2018 à 15:06
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
USE `fredi_plot3AlexsiLapeze`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fredi_plot3AlexsiLapeze`
--

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`numLicence`, `Nom`, `Prenom`, `Sexe`, `DateNaissance`, `AdresseAdh`, `CP`, `Ville`, `Id_Demandeur`, `id_adherent`) VALUES
(1259875, 'Berbier', 'Stephane', 'M', '2003-12-25', '5 passage rouliou', '35200', 'Nancy', 1, 1),
(1259894, 'Berbier', 'Lucie', 'F', '2011-12-05', '5 passage rouliou', '35200', 'Nancy', 1, 2),
(1459274, 'Diolo', 'Corentin', 'M', '1994-09-19', '8 place gironde', '35200', 'Nancy', 2, 3);

--
-- Déchargement des données de la table `avancer`
--

INSERT INTO `avancer` (`Id_Demandeur`, `id_Ligne`, `Id_NoteDeFrais`) VALUES
(1, 5, 1),
(1, 6, 1),
(1, 1, 2),
(1, 2, 2),
(1, 3, 2),
(2, 7, 3),
(2, 8, 3),
(1, 9, 4),
(1, 10, 4);
--
-- Déchargement des données de la table `club`
--

INSERT INTO `club` (`Id_Club`, `Nom`, `AdresseClub`, `Cp`, `Ville`, `Sigle`, `NomPresident`, `Id_Ligue`) VALUES
(1, 'Nancy Football Club', '3 rue du foot', '54200', 'nancy', 'NFC', 'Pichon', 1),
(2, 'Nancy Rugby Club', '5 rue du rugby', '35200', 'Nancy', 'NRC', 'Benjamin Rolin', 2),
(3, 'Nancy Badminton Club', '8 rue du volant', '32500', 'Nancy', 'NBC', 'Gérard Plodon', 3);

--
-- Déchargement des données de la table `demandeur`
--

INSERT INTO `demandeur` (`Id_Demandeur`, `AdresseMail`, `MotDePasse`, `isRepresentant`, `Id_Club`) VALUES
(1, 'simon.berbier@gmail.com', '$2y$10$Q9P.gaJKZc4scIDzHKMwguBuMaQzAoBdp6F5xYELer7mt4RFJvUyG', 1, 2),
(2, 'corentin.diolo@gmail.com', '$2y$10$pkhApG8zUvK0jXmZC0J89eFLFmCW55mfqjcgmK870dNIlHknFN1Mm', 0, 3);

--
-- Déchargement des données de la table `indemnite`
--

INSERT INTO `indemnite` (`Annee`, `tarifKilometrique`) VALUES
(2016, 0.56),
(2017, 0.57),
(2018, 0.58);

--
-- Déchargement des données de la table `lignefrais`
--

INSERT INTO `lignefrais` (`id_Ligne`, `Date`, `Km`, `CoutPeage`, `CoutRepas`, `CoutHebergement`, `Trajet`, `Annee`, `Id_Motif`) VALUES
(1, '2017-09-05', 5, 34, 0, 0, 'Nancy - tourcoin', 2017, 1),
(2, '2017-10-03', 5, 5, 0, 0, 'Nancy - Maxeville', 2017, 2),
(3, '2017-11-13', 250, 75, 58, 120, 'Nancy - Paris', 2017, 3),
(5, '2016-04-12', 25, 15, 28, 0, 'Nancy - Eulmont', 2016, 1),
(6, '2016-08-15', 22, 25, 63, 0, 'Nancy - Tomblaine', 2016, 1),
(7, '2017-12-19', 42, 57, 25, 34, 'Nancy - Paris', 2017, 3),
(8, '2017-09-03', 24, 22, 0, 24, 'Nancy - Maxeville', 2017, 2),
(9, '2018-03-13', 44, 4, 4, 4, 'Nancy - Paris', 2018, 1),
(10, '2018-03-11', 22, 22, 22, 22, 'Nancy - Lyon', 2018, 3);

--
-- Déchargement des données de la table `ligue`
--

INSERT INTO `ligue` (`Id_Ligue`, `Nom_ligue`) VALUES
(1, 'Football'),
(2, 'Rugby'),
(3, 'Badminton');

--
-- Déchargement des données de la table `motif`
--

INSERT INTO `motif` (`Id_Motif`, `Libelle`) VALUES
(1, 'Match'),
(2, 'Entrainement'),
(3, 'Tournoi');

--
-- Déchargement des données de la table `notedefrais`
--

INSERT INTO `notedefrais` (`Id_NoteDeFrais`, `isValidate`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0);

--
-- Déchargement des données de la table `representant`
--

INSERT INTO `representant` (`Nom`, `Prenom`, `Rue`, `Cp`, `Ville`, `Id_Demandeur`, `id_representant`) VALUES
('Berbier', 'Simon', '5 passage rouliou', '32500', 'Nancy', 1, 1);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
