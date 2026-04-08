-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 31 jan. 2022 à 12:04
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `transcite`
--

-- --------------------------------------------------------
use transcite;


--
-- Structure de la table `Critere`
--

DROP TABLE IF EXISTS `Critere`;
CREATE TABLE IF NOT EXISTS `Critere`
(
    `id`      int NOT NULL,
    `libelle` varchar(150) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `Critere`
--

INSERT INTO `Critere` (`id`, `libelle`)
VALUES (1, 'Fréquence des bus'),
       (2, 'Itinéraire des lignes et les stations desservies'),
       (3, 'Information sur le trafic'),
       (4, 'Lieux des points de ventes des tickets et de recharges des cartes d\'abonnemment');

-- --------------------------------------------------------

--
-- Structure de la table `Ligne`
--

DROP TABLE IF EXISTS `Ligne`;
CREATE TABLE IF NOT EXISTS `Ligne`
(
    `id`             int NOT NULL,
    `communeDepart`  varchar(50) DEFAULT NULL,
    `communeArrivee` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `Ligne`
--

INSERT INTO `Ligne` (`id`, `communeDepart`, `communeArrivee`)
VALUES (1, 'Les Sables', 'Vairé'),
       (2, 'Les Sables', 'Coex'),
       (3, 'Les Sables', 'Olonne');

-- --------------------------------------------------------

--
-- Structure de la table `satisfaction`
--

DROP TABLE IF EXISTS `Satisfaction`;
CREATE TABLE IF NOT EXISTS `Satisfaction`
(
    `id`    int NOT NULL,
    `degre` varchar(14) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `satisfaction`
--

INSERT INTO `Satisfaction` (`id`, `degre`)
VALUES (1, 'Très satisfait'),
       (2, 'Satisfait'),
       (3, 'Réservé'),
       (4, 'Insatisfait');

-- --------------------------------------------------------

--
-- Structure de la table `Station`
--

DROP TABLE IF EXISTS `Station`;
CREATE TABLE IF NOT EXISTS `Station`
(
    `id`           varchar(5) NOT NULL,
    `nomStation`   varchar(10) DEFAULT NULL,
    `pointDeVente` tinyint(1)  DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `Station`
--

INSERT INTO `Station` (`id`, `nomStation`, `pointDeVente`)
VALUES ('STA11', 'Stations11', 1),
       ('STA12', 'Stations12', 0),
       ('STA14', 'Stations14', 1),
       ('STA15', 'Stations15', 0),
       ('STA22', 'Stations22', 0),
       ('STA23', 'Stations23', 1),
       ('STA24', 'Stations24', 0),
       ('STA25', 'Stations25', 1),
       ('STA26', 'Stations26', 1),
       ('STA27', 'Stations27', 0),
       ('STA50', 'Stations50', 1),
       ('STA56', 'Stations56', 0);
--
-- Structure de la table `se_situer`
--

DROP TABLE IF EXISTS `Se_situer`;
CREATE TABLE IF NOT EXISTS `Se_situer`
(
    `numStation` varchar(5) NOT NULL,
    `numLigne`   int        NOT NULL,
    PRIMARY KEY (`numStation`, `numLigne`),
    KEY `fk1_Se_Situer` (`numStation`),
    KEY `fk2_Se_Situer` (`numLigne`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `Se_situer`
--

INSERT INTO `Se_situer` (`numStation`, `numLigne`)
VALUES ('STA11', 1),
       ('STA12', 1),
       ('STA14', 1),
       ('STA15', 1),
       ('STA25', 1),
       ('STA23', 2),
       ('STA24', 2),
       ('STA25', 2),
       ('STA26', 2),
       ('STA27', 2),
       ('STA12', 3),
       ('STA22', 3),
       ('STA50', 3),
       ('STA56', 3);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `Commentaire`;
CREATE TABLE IF NOT EXISTS `Commentaire`
(
    `id`              int NOT NULL AUTO_INCREMENT,
    `numCritere`      int          DEFAULT NULL,
    `numLigne`        int          DEFAULT NULL,
    `numStation`      varchar(5)   DEFAULT NULL,
    `numSatisfaction` int          DEFAULT NULL,
    `commentaire`     varchar(200) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `fk1_Commentaire` (`numCritere`),
    KEY `fk2_Commentaire` (`numLigne`),
    KEY `fk3_Commentaire` (`numStation`),
    KEY `fk4_Commentaire` (`numSatisfaction`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 19
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `Commentaire` (`id`, `numCritere`, `numLigne`, `numStation`, `numSatisfaction`, `commentaire`)
VALUES (1, 1, 2, 'STA23', 4, 'Moins de fréquence suite à l’ouverture de la nouvelle ligne de tram'),
       (2, 3, 3, 'STA56', 2, 'Les panneaux d’information mis en place permettent de connaître en temps réel le trafic'),
       (3, 1, 1, 'STA15', 1,
        'Je suis satisfait qu’il y ait plus de bus le matin et le soir pour me rendre sur mon lieu de travail et revenir à mon domicile.'),
       (4, 3, 2, 'STA24', 4, 'Panneau d’affichage en panne'),
       (5, 3, 2, 'STA26', 3, 'Guichet trop souvent fermé'),
       (6, 3, 3, 'STA12', 1, 'Informations à jour'),
       (7, 3, 1, 'STA11', 4, 'Pas d’affichage'),
       (8, 3, 1, 'STA25', 2, 'Sur le panneau d’affichage'),
       (9, 1, 2, 'STA23', 4, 'Moins de fréquence suite à l’ouverture de la nouvelle ligne de tram'),
       (10, 3, 1, 'STA14', 4, 'Moins de fréquence suite à l’ouverture de la nouvelle ligne de tram'),
       (11, 4, 3, 'STA50', 3, 'Guichet trop souvent fermé'),
       (12, 3, 3, 'STA56', 4, 'Panneau d’affichage en panne'),
       (13, 1, 1, 'STA15', 1,
        'Je suis satisfait qu’il y ait plus de bus le matin et le soir pour me rendre sur mon lieu de travail et revenir à mon domicile.'),
       (14, 3, 3, 'STA12', 3, 'Ligne lente'),
       (15, 4, 1, 'STA25', 1, 'Nombre de point de vente satisfaisant'),
       (16, 1, 2, 'STA27', 4, 'Pas assez de passages'),
       (17, 1, 1, 'STA15', 2, 'ok bien'),
       (18, 1, 3, 'STA14', 3, 'moyen');

-- --------------------------------------------------------

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `Commentaire`
    ADD CONSTRAINT `fk1_Commentaire` FOREIGN KEY (`numCritere`) REFERENCES `Critere` (`id`),
    ADD CONSTRAINT `fk2_Commentaire` FOREIGN KEY (`numLigne`) REFERENCES `Ligne` (`id`),
    ADD CONSTRAINT `fk3_Commentaire` FOREIGN KEY (`numStation`) REFERENCES `Station` (`id`),
    ADD CONSTRAINT `fk4_Commentaire` FOREIGN KEY (`numSatisfaction`) REFERENCES `Satisfaction` (`id`);

--
-- Contraintes pour la table `se_situer`
--
ALTER TABLE `Se_situer`
    ADD CONSTRAINT `fk1_Se_Situer` FOREIGN KEY (`numStation`) REFERENCES `Station` (`id`),
    ADD CONSTRAINT `fk2_Se_Situer` FOREIGN KEY (`numLigne`) REFERENCES `Ligne` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
