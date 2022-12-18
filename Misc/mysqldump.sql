-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 18 déc. 2022 à 19:48
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mapexa`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id_account` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `encrypted_password` text NOT NULL,
  PRIMARY KEY (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`id_account`, `name`, `email`, `encrypted_password`) VALUES
(20, 'Ben', 'benjamin.borello@gmail.com', '202cb962ac59075b964b07152d234b70'),
(21, 'Laurie', 'Laurie.otarie@gmail.com', 'e19d5cd5af0378da05f63f891c7467af'),
(22, 'Margot', 'Margot.abricot@gmail.com', 'e19d5cd5af0378da05f63f891c7467af'),
(23, 'Ayfri', 'Pierrot.leveau@gmail.com', '8d89e2a368473c2a59243a02e2c08b54'),
(24, 'Kheir', 'Kheir.oui@gmail.com', '79cfeb94595de33b3326c06ab1c7dbda');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `id_account` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_comment_Comments` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `Comments_Accounts0_FK` (`id_account`),
  KEY `Comments_Posts1_FK` (`id_post`),
  KEY `Comments_Comments2_FK` (`id_comment_Comments`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comment`, `content`, `id_account`, `id_post`, `id_comment_Comments`) VALUES
(14, 'Oui', 24, 124, NULL),
(15, 'T\'es pas sympa', 20, 122, NULL),
(16, 'Je sais', 21, 122, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `id_account_1` int(11) NOT NULL,
  `id_account_2` int(11) NOT NULL,
  PRIMARY KEY (`id_account_1`,`id_account_2`),
  KEY `friends_Accounts1_FK` (`id_account_2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `friends`
--

INSERT INTO `friends` (`id_account_1`, `id_account_2`) VALUES
(21, 20);

-- --------------------------------------------------------

--
-- Structure de la table `has_pending_request`
--

DROP TABLE IF EXISTS `has_pending_request`;
CREATE TABLE IF NOT EXISTS `has_pending_request` (
  `id_account_1` int(11) NOT NULL,
  `id_account_2` int(11) NOT NULL,
  `statue` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_account_1`,`id_account_2`),
  KEY `has_pending_request_Accounts1_FK` (`id_account_2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `has_pending_request`
--

INSERT INTO `has_pending_request` (`id_account_1`, `id_account_2`, `statue`) VALUES
(22, 20, 1),
(22, 21, 0),
(23, 20, 0),
(23, 21, 0);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `media_path` text,
  `id_account` int(11) NOT NULL,
  `post_date` date DEFAULT NULL,
  PRIMARY KEY (`id_post`),
  KEY `Posts_Accounts0_FK` (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id_post`, `title`, `content`, `media_path`, `id_account`, `post_date`) VALUES
(111, 'Ma photo', 'Bonjour, voici ma nouvelle photo  ', 'u20_639f5e98ab2b7.png', 20, '2022-12-18'),
(112, 'J\'adore giroud', 'OUE GIROUD', 'u20_639f5ec0263f7.jpg', 20, '2022-12-18'),
(113, 'Mateo', 'Mateo encore entrain de manger', 'u20_639f5ee171947.jpg', 20, '2022-12-18'),
(114, 'Moi après la défaite de la France', 'Je suis dévasté', 'u20_639f5efe0f857.jpg', 20, '2022-12-18'),
(115, 'Bonjour je vend une table', '300 euros, très bonne état, demandé moi en amis pour plus d\'info', NULL, 20, '2022-12-18'),
(116, 'Notre site est bien fait non ?', 'S\'il vous plait, une bonne note', NULL, 20, '2022-12-18'),
(117, 'Les jeux de couleurs sont incroyable ', 'Tout est dans le titre', NULL, 20, '2022-12-18'),
(118, 'Oui', 'Oui', 'u20_639f5f69174c1.jpg', 20, '2022-12-18'),
(119, 'AAAAA', 'AAAAAA', 'u20_639f5fcf7f3d6.jpg', 20, '2022-12-18'),
(120, 'Mon idole', 'Mon idole', 'u20_639f601492b79.jpg', 20, '2022-12-18'),
(121, 'Oui pepe', 'Oui pepe', 'u20_639f60354a35a.jpg', 20, '2022-12-18'),
(122, 'Ben devant le projet', 'tout est dans le titre', 'u21_639f60afc8e18.jpg', 21, '2022-12-18'),
(123, 'Oui j\'aime les animaux', 'Oui', 'u23_639f61d15fbb8.jpg', 23, '2022-12-18'),
(124, 'J\'ai pas d\'idée', 'Oue', NULL, 24, '2022-12-18');

-- --------------------------------------------------------

--
-- Structure de la table `reactions`
--

DROP TABLE IF EXISTS `reactions`;
CREATE TABLE IF NOT EXISTS `reactions` (
  `id_reaction` int(11) NOT NULL AUTO_INCREMENT,
  `thumb_up` tinyint(1) NOT NULL,
  `thumb_down` tinyint(1) NOT NULL,
  `sad` tinyint(1) NOT NULL,
  `love` tinyint(1) NOT NULL,
  `laugh` tinyint(1) NOT NULL,
  `id_account` int(11) NOT NULL,
  `id_comment` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reaction`),
  KEY `Reactions_Accounts0_FK` (`id_account`),
  KEY `Reactions_Comments1_FK` (`id_comment`),
  KEY `Reactions_Posts2_FK` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reactions`
--

INSERT INTO `reactions` (`id_reaction`, `thumb_up`, `thumb_down`, `sad`, `love`, `laugh`, `id_account`, `id_comment`, `id_post`) VALUES
(10, 0, 0, 0, 0, 1, 20, NULL, 111),
(11, 0, 0, 0, 1, 0, 24, NULL, 124),
(12, 0, 1, 0, 0, 0, 20, NULL, 122),
(13, 1, 0, 0, 0, 0, 20, 15, 122),
(14, 1, 0, 0, 0, 0, 21, NULL, 122),
(15, 0, 1, 0, 0, 0, 21, 15, 122),
(16, 0, 0, 0, 0, 1, 21, NULL, 120);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comments_Accounts0_FK` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `Comments_Comments2_FK` FOREIGN KEY (`id_comment_Comments`) REFERENCES `comments` (`id_comment`),
  ADD CONSTRAINT `Comments_Posts1_FK` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`);

--
-- Contraintes pour la table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_Accounts0_FK` FOREIGN KEY (`id_account_1`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `friends_Accounts1_FK` FOREIGN KEY (`id_account_2`) REFERENCES `accounts` (`id_account`);

--
-- Contraintes pour la table `has_pending_request`
--
ALTER TABLE `has_pending_request`
  ADD CONSTRAINT `has_pending_request_Accounts0_FK` FOREIGN KEY (`id_account_1`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `has_pending_request_Accounts1_FK` FOREIGN KEY (`id_account_2`) REFERENCES `accounts` (`id_account`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `Posts_Accounts0_FK` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`);

--
-- Contraintes pour la table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `Reactions_Accounts0_FK` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`),
  ADD CONSTRAINT `Reactions_Comments1_FK` FOREIGN KEY (`id_comment`) REFERENCES `comments` (`id_comment`),
  ADD CONSTRAINT `Reactions_Posts2_FK` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
