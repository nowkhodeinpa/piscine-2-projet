-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 18 fév. 2020 à 06:50
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test-tech-ibonia`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nom_admin` varchar(70) NOT NULL,
  `mail_admin` varchar(80) NOT NULL,
  `pwd_admin` varchar(80) NOT NULL,
  `date_admin` date NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `mail_admin` (`mail_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom_admin`, `mail_admin`, `pwd_admin`, `date_admin`) VALUES
(1, 'Laila', 'laila@vente.com', 'PZOAURIAY', '2020-01-27'),
(2, 'vaivavy', 'vaivavy@vente.com', 'Psh£yahHH', '2020-01-07');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commandes` int(11) NOT NULL AUTO_INCREMENT,
  `id_trans` int(11) NOT NULL,
  `nbr_bt` varchar(70) NOT NULL,
  `ref_commande` varchar(70) NOT NULL,
  `date_commande` date NOT NULL,
  PRIMARY KEY (`id_commandes`),
  KEY `id_trans` (`id_trans`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commandes`, `id_trans`, `nbr_bt`, `ref_commande`, `date_commande`) VALUES
(1, 1, '77II', 'POIUI77', '2020-01-01'),
(2, 1, '99II', 'OPJuuY', '2020-01-02'),
(3, 2, '99IO', 'PO689', '2020-01-27'),
(4, 2, '90OI', 'UI-77', '2020-01-28'),
(5, 1, '09IIEO', 'TTRFKK8976', '2020-01-28'),
(6, 1, '9907KKO78', '000UYT55T', '2020-01-28'),
(7, 2, '445T', 'RREZ42Z', '2020-01-29'),
(8, 1, 'OP09OO009', '87YUHN-YYT', '2020-01-30'),
(9, 1, '407UYOH77', 'FT-989601', '2020-01-09'),
(10, 2, '407UYOH99', 'KT-989602', '2020-01-19'),
(11, 2, '407UYOH99', 'KT-989603', '2020-01-19'),
(12, 1, '09UJJSYT', 'TC889U89U', '2020-02-01'),
(13, 2, 'IOE889Y', 'NHY6YYYT', '2020-02-01'),
(14, 1, '57497', 'UR-TYET', '2020-02-14'),
(15, 2, 'RE98Z6', 'OX-YST77865', '2020-02-15'),
(16, 2, '776TUZT', 'k_453UIT', '2020-02-14'),
(17, 2, '89YUU7', 'UYE6YYG', '2020-02-25'),
(18, 1, '1RY64', 'JJGGYT', '2020-02-17'),
(19, 2, '4REEE', 'RREZDZ', '2020-02-25'),
(20, 2, 'RREZFVG', 'REEZSS', '2020-02-17');

-- --------------------------------------------------------

--
-- Structure de la table `incident`
--

DROP TABLE IF EXISTS `incident`;
CREATE TABLE IF NOT EXISTS `incident` (
  `id_incident` int(11) NOT NULL AUTO_INCREMENT,
  `id_comm` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `statut_gestion` tinyint(1) UNSIGNED DEFAULT '0',
  `dossier_transporteur` varchar(70) DEFAULT NULL,
  `statut_remboursement` tinyint(1) DEFAULT '0',
  `doc_gestion` varchar(70) DEFAULT NULL,
  `date_decl_incident` date DEFAULT NULL,
  `date_remboursement` timestamp NULL DEFAULT NULL,
  `montant_remboursement` decimal(13,2) DEFAULT NULL,
  `statut_mail` tinyint(1) DEFAULT '0',
  `statut_document` tinyint(1) DEFAULT '0',
  `statut_scanner` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_incident`),
  UNIQUE KEY `id_comm_2` (`id_comm`),
  KEY `id_comm` (`id_comm`),
  KEY `id_adm` (`id_adm`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `incident`
--

INSERT INTO `incident` (`id_incident`, `id_comm`, `id_adm`, `statut_gestion`, `dossier_transporteur`, `statut_remboursement`, `doc_gestion`, `date_decl_incident`, `date_remboursement`, `montant_remboursement`, `statut_mail`, `statut_document`, `statut_scanner`) VALUES
(1, 1, 1, 2, '090UDG', 1, '1-TNT.pdf', '2020-01-02', '2020-02-13 14:30:14', '100.00', 1, 1, 1),
(4, 2, 2, 1, 'RRE', 0, '4-TNT.pdf', '2020-01-27', NULL, NULL, 0, 1, 1),
(5, 4, 1, 0, '', 0, NULL, '2020-01-28', NULL, NULL, 0, 0, 0),
(6, 3, 1, 1, '90J889YYZ', 0, NULL, '2020-01-28', NULL, NULL, 0, 0, 0),
(7, 5, 2, 0, NULL, 0, NULL, '2020-01-28', NULL, NULL, 0, 0, 0),
(8, 6, 2, 1, '98D6YYTST', 0, NULL, '2020-01-29', NULL, NULL, 0, 0, 0),
(9, 7, 1, 2, 'RTE', 1, '9-Colissimo.pdf', '2020-01-30', '2020-02-14 10:49:09', '90.00', 1, 1, 1),
(10, 9, 1, 0, NULL, 0, NULL, '2020-02-20', NULL, NULL, 0, 0, 0),
(11, 10, 1, 2, '0977UUG667', 1, '11-Colissimo.pdf', '2020-02-03', '2020-02-14 10:39:40', '2300.78', 1, 1, 1),
(12, 11, 1, 0, NULL, 0, NULL, '2020-02-01', NULL, NULL, 0, 0, 0),
(14, 12, 1, 2, '0U7755FGGJK', 1, '14-TNT.pdf', '2020-02-03', '2020-02-14 11:18:55', '1.55', 1, 1, 1),
(15, 13, 1, 2, '89TYU8633333', 1, '15-Colissimo.pdf', '2020-02-04', '2020-02-14 10:46:17', '455.00', 1, 1, 1),
(18, 14, 1, 2, '5456', 1, '18-TNT.pdf', '2020-02-14', '2020-02-14 11:04:47', '75.00', 1, 1, 1),
(19, 15, 1, 2, 'YT674FR5', 1, '19-Colissimo.pdf', '2020-02-14', '2020-02-14 11:02:30', '98.00', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `transporteur`
--

DROP TABLE IF EXISTS `transporteur`;
CREATE TABLE IF NOT EXISTS `transporteur` (
  `id_transporteur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_transporteur` varchar(70) NOT NULL,
  `ref_transporteur` varchar(70) NOT NULL,
  `email_transporteur` varchar(70) NOT NULL,
  `tel_transporteur` varchar(16) DEFAULT NULL,
  `date_ajout_transporteur` date NOT NULL,
  PRIMARY KEY (`id_transporteur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transporteur`
--

INSERT INTO `transporteur` (`id_transporteur`, `nom_transporteur`, `ref_transporteur`, `email_transporteur`, `tel_transporteur`, `date_ajout_transporteur`) VALUES
(1, 'TNT', 'UI99UKHG', 'nonohcode@gmail.com', NULL, '2020-01-27'),
(2, 'Colissimo', 'qHH75LLO', 'nonohcode@gmail.com', NULL, '2020-01-17');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_trans`) REFERENCES `transporteur` (`id_transporteur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `incident`
--
ALTER TABLE `incident`
  ADD CONSTRAINT `incident_ibfk_1` FOREIGN KEY (`id_comm`) REFERENCES `commande` (`id_commandes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `incident_ibfk_2` FOREIGN KEY (`id_adm`) REFERENCES `admin` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
