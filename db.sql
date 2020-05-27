-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 21 mai 2020 à 13:48
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_ges`
--

-- --------------------------------------------------------

--
-- Structure de la table `ge_accuser_reception`
--

DROP TABLE IF EXISTS `ge_accuser_reception`;
CREATE TABLE IF NOT EXISTS `ge_accuser_reception` (
  `NoPersonne` int(11) NOT NULL,
  `Annee` int(11) NOT NULL,
  `NoEvenement` int(11) NOT NULL,
  PRIMARY KEY (`NoPersonne`,`Annee`,`NoEvenement`),
  KEY `I_FK_GE_ACCUSER_RECEPTION_GE_PERS_PARENT` (`NoPersonne`),
  KEY `I_FK_GE_ACCUSER_RECEPTION_GE_EV_NON_MARCHAND` (`Annee`,`NoEvenement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_accuser_reception`
--

INSERT INTO `ge_accuser_reception` (`NoPersonne`, `Annee`, `NoEvenement`) VALUES
(1, 2018, 12),
(1, 2019, 11),
(1, 2019, 12),
(2, 2018, 12),
(2, 2019, 11),
(2, 2019, 12),
(3, 2018, 12),
(3, 2019, 11),
(3, 2019, 12),
(6, 2018, 12),
(6, 2019, 11),
(6, 2019, 12),
(7, 2018, 12),
(7, 2019, 11),
(7, 2019, 12),
(8, 2018, 12),
(8, 2019, 11),
(8, 2019, 12);

-- --------------------------------------------------------

--
-- Structure de la table `ge_administrateur`
--

DROP TABLE IF EXISTS `ge_administrateur`;
CREATE TABLE IF NOT EXISTS `ge_administrateur` (
  `Email` varchar(30) NOT NULL,
  `Mdp` varchar(40) NOT NULL,
  `Profil` varchar(30) NOT NULL,
  PRIMARY KEY (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_administrateur`
--

INSERT INTO `ge_administrateur` (`Email`, `Mdp`, `Profil`) VALUES
('derriensebastien@wanandoo.fr', 'ok', '1'),
('1587108445', 'sebastien@hotmail.com', 'admin'),
('1586932609', 'sebastien@hotmail.com', 'admin'),
('1586932526', 'sebastien@hotmail.com', 'admin'),
('1586931279', 'sebastien@hotmail.com', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `ge_appartenir`
--

DROP TABLE IF EXISTS `ge_appartenir`;
CREATE TABLE IF NOT EXISTS `ge_appartenir` (
  `NoEnfant` int(11) NOT NULL,
  `NoClasse` int(11) NOT NULL,
  `DateDebut` date NOT NULL,
  `DateFin` date DEFAULT NULL,
  PRIMARY KEY (`NoEnfant`,`NoClasse`,`DateDebut`),
  KEY `I_FK_GE_APPARTENIR_GE_ENFANT` (`NoEnfant`),
  KEY `I_FK_GE_APPARTENIR_GE_CLASSE` (`NoClasse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_appartenir`
--

INSERT INTO `ge_appartenir` (`NoEnfant`, `NoClasse`, `DateDebut`, `DateFin`) VALUES
(1, 7, '2017-09-01', NULL),
(2, 2, '2018-09-01', NULL),
(3, 2, '2018-09-01', NULL),
(4, 7, '2018-09-01', NULL),
(5, 1, '2018-09-01', NULL),
(3, 7, '2020-05-20', '2020-05-20');

-- --------------------------------------------------------

--
-- Structure de la table `ge_classe`
--

DROP TABLE IF EXISTS `ge_classe`;
CREATE TABLE IF NOT EXISTS `ge_classe` (
  `NoClasse` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(60) NOT NULL,
  PRIMARY KEY (`NoClasse`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_classe`
--

INSERT INTO `ge_classe` (`NoClasse`, `Nom`) VALUES
(1, 'petite section'),
(2, 'grande section'),
(6, 'CE 2'),
(7, 'CM 1');

-- --------------------------------------------------------

--
-- Structure de la table `ge_commande`
--

DROP TABLE IF EXISTS `ge_commande`;
CREATE TABLE IF NOT EXISTS `ge_commande` (
  `NoCommande` int(11) NOT NULL AUTO_INCREMENT,
  `NoPersonne` int(11) NOT NULL,
  `DateCommande` datetime NOT NULL,
  `MontantTotal` decimal(10,2) NOT NULL,
  `Payer` decimal(10,2) NOT NULL,
  `ResteAPayer` decimal(10,2) NOT NULL,
  `ModePaiement` varchar(30) NOT NULL,
  `CommentaireAcheteur` varchar(255) DEFAULT NULL,
  `CommentaireAdministrateur` varchar(255) DEFAULT NULL,
  `DateValidation` datetime DEFAULT NULL,
  PRIMARY KEY (`NoCommande`),
  KEY `I_FK_GE_COMMANDE_GE_PERSONNE` (`NoPersonne`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_commande`
--

INSERT INTO `ge_commande` (`NoCommande`, `NoPersonne`, `DateCommande`, `MontantTotal`, `Payer`, `ResteAPayer`, `ModePaiement`, `CommentaireAcheteur`, `CommentaireAdministrateur`, `DateValidation`) VALUES
(1, 1, '2019-12-03 00:00:00', '59.95', '59.95', '0.00', 'banque', 'RAS', 'Valide', '2019-12-04 12:00:00'),
(2, 2, '2019-12-01 15:00:00', '59.95', '0.00', '59.95', 'cheque', 'RAS', 'par cheque à reception', NULL),
(3, 7, '2019-12-02 18:00:00', '299.90', '100.00', '199.90', 'banque', 'RAS', 'une partie payer par la banque le reste à la livraison', NULL);

--
-- Déclencheurs `ge_commande`
--
DROP TRIGGER IF EXISTS `resteAPayer`;
DELIMITER $$
CREATE TRIGGER `resteAPayer` BEFORE UPDATE ON `ge_commande` FOR EACH ROW set new.ResteAPayer=new.MontantTotal-new.Payer
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `ge_concerner`
--

DROP TABLE IF EXISTS `ge_concerner`;
CREATE TABLE IF NOT EXISTS `ge_concerner` (
  `Annee` int(11) NOT NULL,
  `NoEvenement` int(11) NOT NULL,
  `NoClasse` int(11) NOT NULL,
  PRIMARY KEY (`Annee`,`NoEvenement`,`NoClasse`),
  KEY `I_FK_GE_CONCERNER_GE_EVENEMENT` (`Annee`,`NoEvenement`),
  KEY `I_FK_GE_CONCERNER_GE_CLASSE` (`NoClasse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_concerner`
--

INSERT INTO `ge_concerner` (`Annee`, `NoEvenement`, `NoClasse`) VALUES
(2018, 12, 1),
(2018, 12, 2),
(2018, 12, 6),
(2018, 12, 7),
(2019, 11, 1),
(2019, 11, 2),
(2019, 11, 6),
(2019, 11, 7),
(2019, 12, 1),
(2019, 12, 2),
(2019, 12, 6),
(2019, 12, 7);

-- --------------------------------------------------------

--
-- Structure de la table `ge_contenir`
--

DROP TABLE IF EXISTS `ge_contenir`;
CREATE TABLE IF NOT EXISTS `ge_contenir` (
  `NoCommande` int(11) NOT NULL,
  `NoEvenement` int(11) NOT NULL,
  `Annee` int(11) NOT NULL,
  `NoProduit` int(11) NOT NULL,
  `Quantite` int(11) DEFAULT NULL,
  `Remis` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`NoCommande`,`NoEvenement`,`Annee`,`NoProduit`),
  KEY `I_FK_GE_CONTENIR_GE_COMMANDE` (`NoCommande`),
  KEY `I_FK_GE_CONTENIR_GE_PRODUIT` (`NoEvenement`,`Annee`,`NoProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_contenir`
--

INSERT INTO `ge_contenir` (`NoCommande`, `NoEvenement`, `Annee`, `NoProduit`, `Quantite`, `Remis`) VALUES
(1, 12, 2019, 2, 5, 0),
(2, 12, 2019, 2, 5, 0),
(3, 12, 2019, 3, 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ge_enfant`
--

DROP TABLE IF EXISTS `ge_enfant`;
CREATE TABLE IF NOT EXISTS `ge_enfant` (
  `NoEnfant` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(40) NOT NULL,
  `Prenom` varchar(40) NOT NULL,
  `DateNaissance` date DEFAULT NULL,
  PRIMARY KEY (`NoEnfant`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_enfant`
--

INSERT INTO `ge_enfant` (`NoEnfant`, `Nom`, `Prenom`, `DateNaissance`) VALUES
(1, 'Aston', 'Baratin', '2006-03-16'),
(2, 'Aston', 'Mélissa', '2010-04-25'),
(3, 'Aston/LeRoux', 'André', '2011-09-20'),
(4, 'Dupont', 'Alexis', '2009-06-01'),
(5, 'Dupont', 'Achille', '2011-08-08');

-- --------------------------------------------------------

--
-- Structure de la table `ge_evenement`
--

DROP TABLE IF EXISTS `ge_evenement`;
CREATE TABLE IF NOT EXISTS `ge_evenement` (
  `Annee` int(11) NOT NULL,
  `NoEvenement` int(11) NOT NULL,
  `DateMiseEnLigne` date DEFAULT NULL,
  `DateMiseHorsLigne` date DEFAULT NULL,
  `TxtHTMLEntete` text,
  `TxtHTMLCorps` text NOT NULL,
  `TxtHTMLPiedDePage` text,
  `ImgEntete` varchar(60) DEFAULT NULL,
  `ImgPiedDePage` varchar(60) DEFAULT NULL,
  `EmailInformationHTML` text,
  `EnCours` tinyint(1) NOT NULL,
  PRIMARY KEY (`Annee`,`NoEvenement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_evenement`
--

INSERT INTO `ge_evenement` (`Annee`, `NoEvenement`, `DateMiseEnLigne`, `DateMiseHorsLigne`, `TxtHTMLEntete`, `TxtHTMLCorps`, `TxtHTMLPiedDePage`, `ImgEntete`, `ImgPiedDePage`, `EmailInformationHTML`, `EnCours`) VALUES
(2018, 12, '2018-12-01', '2018-12-12', 'Vente des Sapins - 2018', 'Comme chaque année nous organisons une vente de sapin pour les fêtes de fin d\'année.\r\n\r\n          Veuillez trouvez ci-joint la liste de nos produits', 'En espérant que vous soyez nombreux', 'sapin1.jpg', 'bandeau_noel_pdp.jpg', 'Bonjour, ci-joint veuillez trouver le lien de notre site pour...', 1),
(2019, 11, '2019-11-01', '2019-11-30', 'Vente de Couscous', 'Comme chaque année nous organisons une vente de couscous pour le plaisir de la bouche.\r\n\r\n\r\nVeuillez trouvez ci-joint la liste de nos produits.', 'En espérant que vous soyez nombreux a manger', 'couscous.jpg', 'logo.png', 'Bonjour, ci-joint veuillez trouver le lien de notre site pour...', 1),
(2019, 12, '2019-12-01', '2019-12-05', 'Vente des Sapins - 2019', 'Comme chaque année nous organisons une vente de sapin pour les fêtes de fin d\'année.\r\n\r\nVeuillez trouver ci-joint la liste de nos produits.', 'En espérant que vous soyez nombreux', 'sapin1.jpg', 'bandeau_noel_pdp.jpg', 'Bonjour, ci-joint veuillez trouver le lien de notre site pour...', 0),
(2019, 20, '2019-10-30', '2019-12-30', 'Repas crêpes', 'A la salle des fêtes le week end du 11/05 nous organisons un repas crepes\r\n\r\nAfin d\'accuser réception de ce mail et d\'éviter une relande papier Merci de cliquer \r\n<a href=\"\">ici</a>', 'soyez nombreux', 'crepes.jpg', '', 'Bonjour, ci-joint veuillez trouver le lien de notr..', 0),
(2019, 5, '2019-10-30', '2019-12-25', 'Election des représentants', 'Vous voulez suivre votre enfant de manière plus investie, rejoignez nous en vous présentant comme parents délégués\r\n\r\n\"Afin d\'accuser réception de ce mail et d\'éviter une relande papier Merci de cliquer ici\"', 'soyez nombreux', 'vote.jpg', '', 'Bonjour, ci-joint veuillez trouver le lien de notr..', 0),
(2020, 0, NULL, NULL, 'Evenement non definie', 'Evenement non definie', NULL, NULL, NULL, NULL, 0),
(2020, 21, '2020-05-21', '2020-06-15', '<p>Cochon grillé<br></p>', '<p>Nous vous proposons un cochon grillé à venir chercher sur place le 19-06-2020<br></p>', '<p>En espérant que vous soyez nombeux.<br></p>', 'cochon1.jpg', '800px-Capdepera_-_Torre_de_Canyamel_09_ies.jpg', '<p>Venez nous voir<br></p>', 1),
(2020, 22, '2020-05-21', '2020-05-27', '<p>dfv<br></p>', '<p>erf<br></p>', '<p>fere<br></p>', '', '', '<p>ferf<br></p>', 0),
(2020, 23, '2020-05-28', '2020-05-29', '', '<p>bts<br></p>', '<p>bts<br></p>', NULL, NULL, '<p>bts<br></p>', 0),
(2020, 24, '0000-00-00', '2020-05-22', '<p>if<br></p>', '<p>else<br></p>', '<p>if<br></p>', '', '', '', 0),
(2020, 25, '2020-05-21', '2020-05-22', '<p>if<br></p>', '<p>else<br></p>', '<p>if<br></p>', NULL, NULL, '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ge_ev_marchand`
--

DROP TABLE IF EXISTS `ge_ev_marchand`;
CREATE TABLE IF NOT EXISTS `ge_ev_marchand` (
  `Annee` int(11) NOT NULL,
  `NoEvenement` int(11) NOT NULL,
  `DateRemiseProduit` datetime DEFAULT NULL,
  PRIMARY KEY (`Annee`,`NoEvenement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_ev_marchand`
--

INSERT INTO `ge_ev_marchand` (`Annee`, `NoEvenement`, `DateRemiseProduit`) VALUES
(2018, 12, '2018-12-30 00:00:00'),
(2019, 11, '2018-12-30 00:00:00'),
(2019, 12, '2019-12-30 00:00:00'),
(2020, 21, '0000-00-00 00:00:00'),
(2020, 22, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `ge_ev_non_marchand`
--

DROP TABLE IF EXISTS `ge_ev_non_marchand`;
CREATE TABLE IF NOT EXISTS `ge_ev_non_marchand` (
  `Annee` int(11) NOT NULL,
  `NoEvenement` int(11) NOT NULL,
  PRIMARY KEY (`Annee`,`NoEvenement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_ev_non_marchand`
--

INSERT INTO `ge_ev_non_marchand` (`Annee`, `NoEvenement`) VALUES
(2018, 5),
(2018, 20),
(2019, 5),
(2019, 20),
(2020, 23),
(2020, 24),
(2020, 25),
(2024, 21);

-- --------------------------------------------------------

--
-- Structure de la table `ge_identifiants_site`
--

DROP TABLE IF EXISTS `ge_identifiants_site`;
CREATE TABLE IF NOT EXISTS `ge_identifiants_site` (
  `NoIdentifiant` int(11) NOT NULL AUTO_INCREMENT,
  `Site` varchar(20) DEFAULT NULL,
  `Rang` varchar(128) DEFAULT NULL,
  `Identifiant` varchar(20) DEFAULT NULL,
  `CleHMAC` varchar(255) DEFAULT NULL,
  `SiteEnProduction` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`NoIdentifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ge_personne`
--

DROP TABLE IF EXISTS `ge_personne`;
CREATE TABLE IF NOT EXISTS `ge_personne` (
  `NoPersonne` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `Prenom` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Adresse` varchar(128) DEFAULT NULL,
  `Ville` varchar(50) DEFAULT NULL,
  `CodePostal` int(11) DEFAULT NULL,
  `TelPortable` varchar(16) DEFAULT NULL,
  `TelFixe` varchar(16) DEFAULT NULL,
  `Actif` tinyint(1) DEFAULT NULL,
  `MotDePasse` char(32) DEFAULT NULL,
  `profil` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`NoPersonne`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_personne`
--

INSERT INTO `ge_personne` (`NoPersonne`, `Nom`, `Prenom`, `Email`, `Adresse`, `Ville`, `CodePostal`, `TelPortable`, `TelFixe`, `Actif`, `MotDePasse`, `profil`) VALUES
(1, 'Francois', 'claude', 'astonmartin@gmail.com', 'rue des lilas', 'VANNES', 56000, '06.63.15.12.11', '02.97.56.00.02', 1, 'ok', 'membre'),
(2, '', '', 'astonmartine@hotmail.com', 'rue des reprouvés', 'LAMBALLE', 22600, '06.00.01.02.03', '02.96.70.80.90', 1, 'singsong', NULL),
(3, '', '', 'dupontfelix@gmail.fr', 'impasse des martyrs', 'SAINT-MALO', 35800, '07.01.02.03.04', '02.99.35.80.02', 0, 'mingmong', NULL),
(6, '', '', 'kerhirrenan@gmail.com', 'rue de la bibine', 'SAINT-BRIEUC', 22000, '06.60.22.00.22', '02.96.88.25.35', 0, 'zingzong', 'admin'),
(23, 'Derrien', 'sebastien', 'sebastien@hotmail.com', '15', 'SaintBrieuc', 22470, '060102004', '', NULL, 'oui', 'admin'),
(8, '', '', 'lemheeduane@laposte.fr', '29 bis toutek', 'SAINT-BRIEUC', 22000, '06.55.55.55.55', '02.97.69.69.69', 0, NULL, 'membre'),
(22, 'bla', 'bli', 'blalblz@hotmail.fr', '', '', 0, '', '', NULL, 'coucou', NULL),
(25, '', '', 'sc@fr.fr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin'),
(26, '', '', 'ded@kui.jy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '', '', 'fr@fr.ggt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '', '', '', '', '', 0, '', '', NULL, NULL, NULL),
(24, '', '', 'max@ht.fr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'membre'),
(28, '', '', 'de@ki.mp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'pierre', '', 'btf@ju.com', '', '', 0, '', '', 1, 'ok', 'membre'),
(30, '', '', 'derriensebastien@wanandoo.fr', NULL, NULL, NULL, NULL, NULL, NULL, 'ok', NULL),
(34, '', '', 'alain@gmail.fr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '', '', 'toto@hotmail.fr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '', '', 'titi@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '', '', 'jean@hotmail.fr', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'membre'),
(37, NULL, NULL, 'fsez@fzefze.vo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'membre'),
(36, NULL, NULL, 'dede@go.fr', NULL, NULL, NULL, NULL, NULL, 1, 'fr', 'membre'),
(35, NULL, NULL, 'dada@hoh.fr', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'membre');

-- --------------------------------------------------------

--
-- Structure de la table `ge_pers_parent`
--

DROP TABLE IF EXISTS `ge_pers_parent`;
CREATE TABLE IF NOT EXISTS `ge_pers_parent` (
  `NoPersonne` int(11) NOT NULL,
  `Etre_Correspondant` tinyint(1) NOT NULL,
  PRIMARY KEY (`NoPersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_pers_parent`
--

INSERT INTO `ge_pers_parent` (`NoPersonne`, `Etre_Correspondant`) VALUES
(1, 0),
(2, 1),
(3, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ge_produit`
--

DROP TABLE IF EXISTS `ge_produit`;
CREATE TABLE IF NOT EXISTS `ge_produit` (
  `NoEvenement` int(11) NOT NULL,
  `Annee` int(11) NOT NULL,
  `NoProduit` int(11) NOT NULL,
  `LibelleHTML` text NOT NULL,
  `LibelleCourt` varchar(128) NOT NULL,
  `Prix` decimal(10,2) NOT NULL,
  `Img_Produit` varchar(60) DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `NumeroOrdreApparition` smallint(6) NOT NULL,
  `Etre_Ticket` tinyint(1) DEFAULT NULL,
  `ImgTicket` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`NoEvenement`,`Annee`,`NoProduit`),
  KEY `I_FK_GE_PRODUIT_GE_EV_MARCHAND` (`Annee`,`NoEvenement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_produit`
--

INSERT INTO `ge_produit` (`NoEvenement`, `Annee`, `NoProduit`, `LibelleHTML`, `LibelleCourt`, `Prix`, `Img_Produit`, `Stock`, `NumeroOrdreApparition`, `Etre_Ticket`, `ImgTicket`) VALUES
(12, 2018, 1, 'Sapin de noel nordmann', 'Sapin', '11.99', 'sapin1.jpg', 10, 2, 1, 'ticket1.jpg'),
(12, 2018, 2, 'Sapin de noel explorer', 'Sapin 2', '29.99', 'sapin2.jpg', 150, 1, 0, 'ticket3.jpg'),
(12, 2019, 1, 'Sapin de noel nordmann', 'Sapin', '11.99', 'sapin1.jpg', 10, 2, 1, 'ticket1.jpg'),
(12, 2019, 2, 'Sapin de noel explorer', 'Sapin2', '29.99', 'sapin2.jpg', 150, 1, 0, 'ticket1.jpg'),
(11, 2019, 1, 'couscous garbit', 'couscous', '8.00', 'couscous.jpg', 1000, 1, 1, 'ticket1.jpg'),
(11, 2019, 2, 'Pizza chorizo', 'pizza', '9.99', 'pizza.jpg', 500, 2, 1, 'ticket1.jpg'),
(21, 2020, 1, '<p>cochon&nbsp;&nbsp;&nbsp;&nbsp;<br></p>', '2part', '10.00', 'cochon11.jpg', 100, 1, 1, ''),
(21, 2020, 2, '<p>cochon<br></p>', '5parts', '500.00', NULL, 10000, 1, 0, NULL),
(21, 2020, 3, '<p>cochon<br></p>', '5parts', '500.00', NULL, 10000, 1, 0, NULL),
(21, 2020, 4, '<p>cochon<br></p>', '1500 part pour les gros mangeur1', '100000.00', '800px-Capdepera_-_Torre_de_Canyamel_09_ies1.jpg', 500, 2, 0, NULL),
(21, 2020, 5, '<p>cochon grillade<br></p>', '1 cochon', '1.50', '800px-Capdepera_-_Torre_de_Canyamel_09_ies2.jpg', 1000, 7, 0, NULL),
(21, 2020, 6, '<p>cochon<br></p>', '0.5part', '1500.00', '800px-Capdepera_-_Torre_de_Canyamel_09_ies3.jpg', 1, 1, 0, NULL),
(24, 2020, 1, '<p>hythrth<br></p>', 'hrtthr', '150.00', '', 1000, 1, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `ge_scolariser`
--

DROP TABLE IF EXISTS `ge_scolariser`;
CREATE TABLE IF NOT EXISTS `ge_scolariser` (
  `NoPersonne` int(11) NOT NULL,
  `NoEnfant` int(11) NOT NULL,
  PRIMARY KEY (`NoPersonne`,`NoEnfant`),
  KEY `I_FK_GE_SCOLARISER_GE_PERS_PARENT` (`NoPersonne`),
  KEY `I_FK_GE_SCOLARISER_GE_ENFANT` (`NoEnfant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ge_scolariser`
--

INSERT INTO `ge_scolariser` (`NoPersonne`, `NoEnfant`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 3),
(3, 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
