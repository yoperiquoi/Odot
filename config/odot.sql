-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 25 déc. 2020 à 08:07
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `odot`
--

-- --------------------------------------------------------

--
-- Structure de la table `listespublique`
--

DROP TABLE IF EXISTS `listespublique`;
CREATE TABLE IF NOT EXISTS `listespublique` (
  `IdListePublique` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`IdListePublique`),
  UNIQUE KEY `Titre` (`Titre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `listespublique`
--

INSERT INTO `listespublique` (`IdListePublique`, `Titre`) VALUES
(1, 'Artistique');

-- --------------------------------------------------------

--
-- Structure de la table `listestaches`
--

DROP TABLE IF EXISTS `listestaches`;
CREATE TABLE IF NOT EXISTS `listestaches` (
  `IdListeTache` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `Titre` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`IdListeTache`,`Email`),
  KEY `FKEY5` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `listestaches`
--

INSERT INTO `listestaches` (`IdListeTache`, `Email`, `Titre`) VALUES
(2, 'yoann_63115@hotmail.fr', 'Artistique'),
(3, 'patrick.periquoi@wanadoo.fr', 'Artistique');

-- --------------------------------------------------------

--
-- Structure de la table `listetacheprivee`
--

DROP TABLE IF EXISTS `listetacheprivee`;
CREATE TABLE IF NOT EXISTS `listetacheprivee` (
  `IdListeTachesPrivee` int(11) NOT NULL,
  `IdTache` int(11) NOT NULL,
  PRIMARY KEY (`IdListeTachesPrivee`,`IdTache`),
  KEY `FKEY10` (`IdTache`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `listetacheprivee`
--

INSERT INTO `listetacheprivee` (`IdListeTachesPrivee`, `IdTache`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `listetachepublic`
--

DROP TABLE IF EXISTS `listetachepublic`;
CREATE TABLE IF NOT EXISTS `listetachepublic` (
  `IdListePublique` int(11) NOT NULL,
  `IdTache` int(11) NOT NULL,
  PRIMARY KEY (`IdListePublique`,`IdTache`),
  KEY `FKEY` (`IdTache`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

DROP TABLE IF EXISTS `tache`;
CREATE TABLE IF NOT EXISTS `tache` (
  `IdTache` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `Effectue` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdTache`),
  UNIQUE KEY `Nom` (`Nom`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `tacheprivee`
--

DROP TABLE IF EXISTS `tacheprivee`;
CREATE TABLE IF NOT EXISTS `tacheprivee` (
  `IdTache` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `Effectue` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdTache`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `tacheprivee`
--

INSERT INTO `tacheprivee` (`IdTache`, `Nom`, `Effectue`) VALUES
(1, 'Passer aspirateur', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Email` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `Pseudonyme` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  `Mdp` varchar(80) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Email`, `Pseudonyme`, `Mdp`) VALUES
('patrick.periquoi@wanadoo.fr', 'papafayo2', '$2y$10$iwF1k8teIP2d8s6m6uVjSuSVtCZGBc3ERoWFrrGphRZilPy2sPduu'),
('yoann_63115@hotmail.fr', 'papafayo', '$2y$10$MyKczd3ND3z54.P7qf784e3nbBsrOMFrNnCvLG3xehbQlEhh56Oxm');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `listestaches`
--
ALTER TABLE `listestaches`
  ADD CONSTRAINT `FKEY5` FOREIGN KEY (`Email`) REFERENCES `utilisateur` (`Email`);

--
-- Contraintes pour la table `listetacheprivee`
--
ALTER TABLE `listetacheprivee`
  ADD CONSTRAINT `FKEY10` FOREIGN KEY (`IdTache`) REFERENCES `tacheprivee` (`IdTache`),
  ADD CONSTRAINT `FKEY9` FOREIGN KEY (`IdListeTachesPrivee`) REFERENCES `listestaches` (`IdListeTache`);

--
-- Contraintes pour la table `listetachepublic`
--
ALTER TABLE `listetachepublic`
  ADD CONSTRAINT `FKEY` FOREIGN KEY (`IdTache`) REFERENCES `tache` (`IdTache`),
  ADD CONSTRAINT `FKEY1` FOREIGN KEY (`IdListePublique`) REFERENCES `listespublique` (`IdListePublique`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
