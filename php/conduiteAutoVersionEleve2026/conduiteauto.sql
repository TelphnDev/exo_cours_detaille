-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 11 jan. 2023 à 17:44
-- Version du serveur : 10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdscharlot1`
--

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `code` int(11) NOT NULL,
  `nom` varchar(35) NOT NULL,
  `prenom` varchar(35) NOT NULL,
  `dateNaissance` date NOT NULL,
  `dateInscription` date NOT NULL,
  `adresseRue` varchar(100) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `codePostal` varchar(5) NOT NULL,
  `nbHeuresConduite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`code`, `nom`, `prenom`, `dateNaissance`, `dateInscription`, `adresseRue`, `ville`, `codePostal`, `nbHeuresConduite`) VALUES
(1, 'Branchu', 'Sophie', '2004-07-15', '2023-01-09', 'Rue du zoo', 'Les Sables d\'Olonne', '85100', NULL),
(2, 'Meza', 'Kim', '2004-10-01', '2022-12-12', '8, rue de la mer', 'Les Sables d\'Olonne', '85100', 22),
(3, 'Kang', 'Léo', '2002-05-25', '2020-08-27', '6, rue du canal', 'Les Sables d\'Olonne', '85100', 21),
(4, 'Hamon', 'Charles', '2003-04-10', '2022-09-08', '1, rue du pain', 'Coex', '85220', 25),
(5, 'Sanchez', 'Roméo', '2005-02-18', '2022-09-19', 'Rue de la corniche', 'Jard sur Mer', '85520', 20),
(6, 'Baroin', 'Alice', '2004-11-05', '2022-09-21', 'Rue du lycée', 'Les Sables d\'Olonne', '85000', 20);

-- --------------------------------------------------------

--
-- Structure de la table `lecon`
--

CREATE TABLE `lecon` (
  `id` int(11) NOT NULL,
  `dateLecon` date NOT NULL,
  `codeEleve` int(11) NOT NULL,
  `heureDebut` time NOT NULL,
  `duree` int(11) NOT NULL,
  `effectuee` tinyint(1) NOT NULL,
  `numImmatVehicule` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `lecon`
--

INSERT INTO `lecon` (`id`, `dateLecon`, `codeEleve`, `heureDebut`, `duree`, `effectuee`, `numImmatVehicule`) VALUES
(1, '2022-09-29', 1, '16:00:00', 1, 1, 'AZ634XW'),
(2, '2022-09-29', 3, '12:00:00', 1, 1, 'CD543TR'),
(3, '2022-10-02', 4, '14:00:00', 1, 1, 'AZ634XW'),
(4, '2022-10-03', 2, '10:30:00', 2, 1, 'CD543TR'),
(5, '2022-12-03', 5, '09:00:00', 1, 1, 'CD543TR'),
(6, '2022-12-06', 6, '10:30:00', 2, 1, 'CD543TR'),
(7, '2023-02-21', 6, '14:30:00', 1, 0, 'CD543TR'),
(8, '2023-02-23', 3, '12:30:00', 1, 0, 'AZ634XW'),
(9, '2023-03-24', 1, '10:00:00', 2, 0, 'AZ634XW');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `lecon`
--
ALTER TABLE `lecon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codeEleve` (`codeEleve`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `lecon`
--
ALTER TABLE `lecon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lecon`
--
ALTER TABLE `lecon`
  ADD CONSTRAINT `lecon_ibfk_1` FOREIGN KEY (`codeEleve`) REFERENCES `eleve` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
