-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Généré le : Lun 19 Juillet 2021 à 16:20
-- Version du serveur: 5.0.83
-- Version de PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `john_doe`
--

-- --------------------------------------------------------

--
-- Structure de la table `ldc_articles`
--

CREATE TABLE IF NOT EXISTS `ldc_articles` (
  `ID` int(50) NOT NULL auto_increment,
  `designation` varchar(50) NOT NULL,
  `unite` varchar(50) NOT NULL,
  `ID_rayon` int(50) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=781 ;

-- --------------------------------------------------------

--
-- Structure de la table `ldc_liste`
--

CREATE TABLE IF NOT EXISTS `ldc_liste` (
  `ID` int(11) NOT NULL auto_increment,
  `quantite` double NOT NULL,
  `ID_article` int(11) NOT NULL,
  `checked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5846 ;

-- --------------------------------------------------------

--
-- Structure de la table `ldc_rayons`
--

CREATE TABLE IF NOT EXISTS `ldc_rayons` (
  `ID` int(50) NOT NULL auto_increment,
  `designation` varchar(50) NOT NULL,
  `ordre` int(50) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Structure de la table `mds_instructions`
--

CREATE TABLE IF NOT EXISTS `mds_instructions` (
  `ID_item_menu` int(50) NOT NULL,
  `ordre` int(11) NOT NULL,
  `texte` text collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mds_items_menu`
--

CREATE TABLE IF NOT EXISTS `mds_items_menu` (
  `ID` int(50) NOT NULL auto_increment,
  `designation` text NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=302 ;

-- --------------------------------------------------------

--
-- Structure de la table `mds_items_menu_types_repas`
--

CREATE TABLE IF NOT EXISTS `mds_items_menu_types_repas` (
  `ID_item_menu` int(50) NOT NULL,
  `ID_type_repas` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mds_materiel`
--

CREATE TABLE IF NOT EXISTS `mds_materiel` (
  `ID_item_menu` int(50) NOT NULL,
  `quantite` double unsigned NOT NULL,
  `ID_article` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mds_recettes`
--

CREATE TABLE IF NOT EXISTS `mds_recettes` (
  `ID_item_menu` int(50) NOT NULL,
  `quantite` double unsigned NOT NULL,
  `ID_article` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mds_repas_prevus`
--

CREATE TABLE IF NOT EXISTS `mds_repas_prevus` (
  `ID` int(50) NOT NULL auto_increment,
  `date` date NOT NULL,
  `type_repas` int(50) NOT NULL,
  `item_menu` int(50) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6366 ;

-- --------------------------------------------------------

--
-- Structure de la table `mds_types_repas`
--

CREATE TABLE IF NOT EXISTS `mds_types_repas` (
  `ID` int(50) NOT NULL,
  `designation` text character set utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `login` varchar(16) collate latin1_general_ci NOT NULL,
  `pass` varchar(32) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
