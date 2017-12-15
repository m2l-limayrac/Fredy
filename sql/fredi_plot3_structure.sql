-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 12 déc. 2017 à 14:54
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
  `Id_Club` int(11) DEFAULT NULL,
  `id_adherent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `CoutPeage` float(25,0) NOT NULL DEFAULT '0',
  `CoutRepas` float(25,0) NOT NULL DEFAULT '0',
  `CoutHebergement` float(25,0) NOT NULL DEFAULT '0',
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
  `Id_Demandeur` int(11) NOT NULL,
  `id_representant` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`id_adherent`),
  ADD KEY `FK_ADHERENT_Id_Club` (`Id_Club`),
  ADD KEY `FK_ADHERENT_Id_Demandeur` (`Id_Demandeur`);

--
-- Index pour la table `avancer`
--
ALTER TABLE `avancer`
  ADD PRIMARY KEY (`Id_Demandeur`,`id_Ligne`,`Id_NoteDeFrais`),
  ADD KEY `FK_Avancer_Id_NoteDeFrais` (`Id_NoteDeFrais`),
  ADD KEY `FK_Avancer_id_Ligne` (`id_Ligne`);

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
  ADD PRIMARY KEY (`id_representant`),
  ADD KEY `FK_Representant_Id_Demandeur` (`Id_Demandeur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adherent`
--
ALTER TABLE `adherent`
  MODIFY `id_adherent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `club`
--
ALTER TABLE `club`
  MODIFY `Id_Club` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `demandeur`
--
ALTER TABLE `demandeur`
  MODIFY `Id_Demandeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `lignefrais`
--
ALTER TABLE `lignefrais`
  MODIFY `id_Ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `ligue`
--
ALTER TABLE `ligue`
  MODIFY `Id_Ligue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `motif`
--
ALTER TABLE `motif`
  MODIFY `Id_Motif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `representant`
--
ALTER TABLE `representant`
  MODIFY `id_representant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `notedefrais`
--
ALTER TABLE `notedefrais`
  MODIFY `Id_NoteDeFrais` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avancer`
--
ALTER TABLE `avancer`
  ADD CONSTRAINT `FK_Avancer_Id_Demandeur` FOREIGN KEY (`Id_Demandeur`) REFERENCES `demandeur` (`Id_Demandeur`),
  ADD CONSTRAINT `FK_Avancer_Id_NoteDeFrais` FOREIGN KEY (`Id_NoteDeFrais`) REFERENCES `notedefrais` (`Id_NoteDeFrais`),
  ADD CONSTRAINT `FK_Avancer_id_Ligne` FOREIGN KEY (`id_Ligne`) REFERENCES `lignefrais` (`id_Ligne`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;