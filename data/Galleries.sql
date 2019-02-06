-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Version du serveur :  5.6.39-log
-- Version de PHP :  5.6.38-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Structure de la table `t_galleries`
--

CREATE TABLE `t_galleries` (
  `gallery_id` int(11) NOT NULL,
  `gallery_title` varchar(255) NOT NULL,
  `gallery_desc` text NOT NULL,
  `gallery_cover` int(11) NOT NULL,
  `gallery_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gallery_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `tj_media_gallery`
--

CREATE TABLE `tj_media_gallery` (
 `media_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
 `gallery_id` int(11) NOT NULL,
 `media_id` int(11) NOT NULL,
 PRIMARY KEY (`media_gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1353 DEFAULT CHARSET=utf8

--
-- Index pour la table `tj_media_gallery`
--
ALTER TABLE `tj_media_gallery`
  ADD PRIMARY KEY (`media_gallery_id`);

--
-- Index pour la table `t_galleries`
--
ALTER TABLE `t_galleries`
  ADD PRIMARY KEY (`gallery_id`);

--
-- AUTO_INCREMENT pour la table `tj_media_gallery`
--
ALTER TABLE `tj_media_gallery`
  MODIFY `media_gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `t_galleries`
--
ALTER TABLE `t_galleries`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
