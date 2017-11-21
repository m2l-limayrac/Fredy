-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 21 Novembre 2017 à 17:04
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

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

CREATE TABLE `adherent` (
  `numLicence` int(11) DEFAULT NULL,
  `Nom` varchar(25) DEFAULT NULL,
  `Prenom` varchar(25) DEFAULT NULL,
  `Sexe` varchar(25) DEFAULT NULL,
  `DateNaissance` date DEFAULT NULL,
  `AdresseAdh` varchar(30) DEFAULT NULL,
  `CP` char(5) DEFAULT NULL,
  `Ville` varchar(25) DEFAULT NULL,
  `Id_Demandeur` int(11) NOT NULL,
  `Id_Club` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `avancer`
--

CREATE TABLE `avancer` (
  `Id_Demandeur` int(11) NOT NULL,
  `id_Ligne` int(11) NOT NULL,
  `Id_NoteDeFrais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE `club` (
  `Id_Club` int(11) NOT NULL,
  `Nom` varchar(25) NOT NULL,
  `AdresseClub` varchar(30) DEFAULT NULL,
  `Cp` char(5) NOT NULL,
  `Ville` varchar(25) DEFAULT NULL,
  `Sigle` varchar(25) DEFAULT NULL,
  `NomPresident` varchar(25) DEFAULT NULL,
  `Id_Ligue` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `demandeur`
--

CREATE TABLE `demandeur` (
  `Id_Demandeur` int(11) NOT NULL,
  `AdresseMail` varchar(50) DEFAULT NULL,
  `MotDePasse` varchar(60) DEFAULT NULL,
  `isRepresentant` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `indemnite`
--

CREATE TABLE `indemnite` (
  `Annee` year(4) NOT NULL,
  `tarifKilometrique` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lignefrais`
--

CREATE TABLE `lignefrais` (
  `id_Ligne` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Km` float DEFAULT NULL,
  `CoutPeage` decimal(25,0) DEFAULT NULL,
  `CoutRepas` decimal(25,0) DEFAULT NULL,
  `CoutHebergement` decimal(25,0) DEFAULT NULL,
  `Trajet` varchar(25) DEFAULT NULL,
  `Annee` year(4) NOT NULL,
  `Id_Motif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

CREATE TABLE `ligue` (
  `Id_Ligue` int(11) NOT NULL,
  `Nom_ligue` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

CREATE TABLE `motif` (
  `Id_Motif` int(11) NOT NULL,
  `Libelle` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `notedefrais`
--

CREATE TABLE `notedefrais` (
  `Id_NoteDeFrais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `representant`
--

CREATE TABLE `representant` (
  `Nom` varchar(25) NOT NULL,
  `Prenom` varchar(25) NOT NULL,
  `Rue` varchar(25) NOT NULL,
  `Cp` char(5) NOT NULL,
  `Ville` varchar(25) NOT NULL,
  `Id_Demandeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`Id_Demandeur`),
  ADD KEY `FK_ADHERENT_Id_Club` (`Id_Club`);

--
-- Index pour la table `avancer`
--
ALTER TABLE `avancer`
  ADD PRIMARY KEY (`Id_Demandeur`,`id_Ligne`,`Id_NoteDeFrais`),
  ADD KEY `FK_Avancer_id_Ligne` (`id_Ligne`),
  ADD KEY `FK_Avancer_Id_NoteDeFrais` (`Id_NoteDeFrais`);

--
-- Index pour la table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`Id_Club`),
  ADD KEY `FK_CLUB_Id_Ligue` (`Id_Ligue`);

--
-- Index pour la table `demandeur`
--
ALTER TABLE `demandeur`
  ADD PRIMARY KEY (`Id_Demandeur`);

--
-- Index pour la table `indemnite`
--
ALTER TABLE `indemnite`
  ADD PRIMARY KEY (`Annee`);

--
-- Index pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  ADD PRIMARY KEY (`id_Ligne`),
  ADD KEY `FK_LIGNEFRAIS_Annee` (`Annee`),
  ADD KEY `FK_LIGNEFRAIS_Id_Motif` (`Id_Motif`);

--
-- Index pour la table `ligue`
--
ALTER TABLE `ligue`
  ADD PRIMARY KEY (`Id_Ligue`);

--
-- Index pour la table `motif`
--
ALTER TABLE `motif`
  ADD PRIMARY KEY (`Id_Motif`);

--
-- Index pour la table `notedefrais`
--
ALTER TABLE `notedefrais`
  ADD PRIMARY KEY (`Id_NoteDeFrais`);

--
-- Index pour la table `representant`
--
ALTER TABLE `representant`
  ADD PRIMARY KEY (`Id_Demandeur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `club`
--
ALTER TABLE `club`
  MODIFY `Id_Club` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `demandeur`
--
ALTER TABLE `demandeur`
  MODIFY `Id_Demandeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  MODIFY `id_Ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `ligue`
--
ALTER TABLE `ligue`
  MODIFY `Id_Ligue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `motif`
--
ALTER TABLE `motif`
  MODIFY `Id_Motif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD CONSTRAINT `FK_ADHERENT_Id_Club` FOREIGN KEY (`Id_Club`) REFERENCES `club` (`Id_Club`),
  ADD CONSTRAINT `FK_ADHERENT_Id_Demandeur` FOREIGN KEY (`Id_Demandeur`) REFERENCES `demandeur` (`Id_Demandeur`);

--
-- Contraintes pour la table `avancer`
--
ALTER TABLE `avancer`
  ADD CONSTRAINT `FK_Avancer_Id_Demandeur` FOREIGN KEY (`Id_Demandeur`) REFERENCES `demandeur` (`Id_Demandeur`),
  ADD CONSTRAINT `FK_Avancer_Id_NoteDeFrais` FOREIGN KEY (`Id_NoteDeFrais`) REFERENCES `notedefrais` (`Id_NoteDeFrais`),
  ADD CONSTRAINT `FK_Avancer_id_Ligne` FOREIGN KEY (`id_Ligne`) REFERENCES `lignefrais` (`id_Ligne`);

--
-- Contraintes pour la table `club`
--
ALTER TABLE `club`
  ADD CONSTRAINT `FK_CLUB_Id_Ligue` FOREIGN KEY (`Id_Ligue`) REFERENCES `ligue` (`Id_Ligue`);

--
-- Contraintes pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  ADD CONSTRAINT `FK_LIGNEFRAIS_Annee` FOREIGN KEY (`Annee`) REFERENCES `indemnite` (`Annee`),
  ADD CONSTRAINT `FK_LIGNEFRAIS_Id_Motif` FOREIGN KEY (`Id_Motif`) REFERENCES `motif` (`Id_Motif`);

--
-- Contraintes pour la table `representant`
--
ALTER TABLE `representant`
  ADD CONSTRAINT `FK_Representant_Id_Demandeur` FOREIGN KEY (`Id_Demandeur`) REFERENCES `demandeur` (`Id_Demandeur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
