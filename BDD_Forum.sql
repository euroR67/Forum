-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum`;

-- Listage de la structure de table forum. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.categorie : ~5 rows (environ)
INSERT INTO `categorie` (`id_categorie`, `nomCategorie`) VALUES
	(4, 'Informatique'),
	(5, 'Science'),
	(7, 'Musique'),
	(8, 'Cuisine'),
	(10, 'New');

-- Listage de la structure de table forum. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `texte` text NOT NULL,
  `datePost` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `topic_id` int NOT NULL,
  `lastModified` datetime DEFAULT NULL,
  `modifiedBy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_post`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL,
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.post : ~37 rows (environ)
INSERT INTO `post` (`id_post`, `texte`, `datePost`, `user_id`, `topic_id`, `lastModified`, `modifiedBy`) VALUES
	(34, 'Ceci est un message de test 1.', '2023-09-01 08:59:32', 3, 3, NULL, NULL),
	(35, 'Ceci est un message de test 2.', '2023-09-01 08:59:32', 4, 3, NULL, NULL),
	(36, 'Ceci est un message de test 3.', '2023-09-01 08:59:32', 5, 3, NULL, NULL),
	(43, 'Réponse au sujet scientifique 1.', '2023-09-01 09:01:12', 6, 4, NULL, NULL),
	(44, 'Réponse au sujet scientifique 2.', '2023-09-01 09:01:12', NULL, 4, NULL, NULL),
	(45, 'Réponse au sujet scientifique 3.', '2023-09-01 09:01:12', 3, 4, NULL, NULL),
	(49, 'Avis sur le dernier concert 1.', '2023-09-01 09:01:12', NULL, 6, NULL, NULL),
	(50, 'Avis sur le dernier concert 2.', '2023-09-01 09:01:12', 3, 6, NULL, NULL),
	(51, 'Avis sur le dernier concert 3.', '2023-09-01 09:01:12', 4, 6, NULL, NULL),
	(52, 'Recette de cuisine 1.', '2023-09-01 09:01:12', 5, 7, NULL, NULL),
	(53, 'Recette de cuisine 2.', '2023-09-01 09:01:12', 6, 7, NULL, NULL),
	(54, 'Recette de cuisine 3.', '2023-09-01 09:01:12', NULL, 7, NULL, NULL),
	(58, 'Discussion sur l\'astronomie 1.', '2023-09-01 09:01:12', 6, 9, NULL, NULL),
	(59, 'Discussion sur l\'astronomie 2.', '2023-09-01 09:01:12', NULL, 9, NULL, NULL),
	(60, 'Discussion sur l\'astronomie 3.', '2023-09-01 09:01:12', 3, 9, NULL, NULL),
	(64, 'Critique musicale 1.', '2023-09-01 09:01:12', NULL, 11, NULL, NULL),
	(65, 'Critique musicale 2.', '2023-09-01 09:01:12', 3, 11, NULL, NULL),
	(66, 'Critique musicale 3.', '2023-09-01 09:01:12', 4, 11, NULL, NULL),
	(67, 'Recette asiatique 1.', '2023-09-01 09:01:12', 5, 12, NULL, NULL),
	(68, 'Recette asiatique 2.', '2023-09-01 09:01:12', 6, 12, NULL, NULL),
	(69, 'Recette asiatique 3.', '2023-09-01 09:01:12', NULL, 12, NULL, NULL),
	(83, '&#60;p&#62;Merci c&#38;eacute;dric&#60;/p&#62;', '2023-08-01 15:29:38', 10, 15, NULL, NULL),
	(84, 'Message de test 2... :D', '2023-09-04 10:21:08', 10, 15, NULL, NULL),
	(95, '&lt;p&gt;Sujet de ouf&lt;/p&gt;', '2023-09-08 20:06:45', 11, 15, NULL, NULL),
	(96, 'Dommage', '2023-09-08 20:10:02', 11, 20, '2023-09-11 14:36:42', 'administrateur'),
	(102, 'c important', '2023-09-09 16:30:00', NULL, 21, NULL, NULL),
	(103, '&lt;p&gt;Pourquoi ici &ccedil;a marche&lt;/p&gt;', '2023-09-09 16:30:14', NULL, 21, NULL, NULL),
	(107, '&lt;p&gt;Grave, shehh btrd&lt;/p&gt;', '2023-09-09 19:04:50', NULL, 20, '2023-09-09 19:04:59', 'wesheu'),
	(108, '&lt;p&gt;Arreter wesh&lt;/p&gt;', '2023-09-09 19:08:37', NULL, 20, NULL, NULL),
	(109, '&lt;p&gt;c pas cool wesh&lt;/p&gt;', '2023-09-09 19:08:45', NULL, 20, NULL, NULL),
	(110, '&lt;p&gt;bien fait&lt;/p&gt;', '2023-09-09 19:09:47', 13, 20, NULL, NULL),
	(112, '&lt;p&gt;++&lt;/p&gt;', '2023-09-11 15:34:01', 11, 7, NULL, NULL),
	(113, '&lt;p&gt;nnnn&lt;/p&gt;', '2023-09-11 16:03:34', 15, 20, NULL, NULL),
	(114, 'weee', '2023-09-11 16:04:25', 15, 22, NULL, NULL),
	(115, '&lt;p&gt;juree&lt;/p&gt;', '2023-09-11 16:13:38', 15, 20, NULL, NULL);

-- Listage de la structure de table forum. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateTopic` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categorie_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `categorie_id` (`categorie_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL,
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.topic : ~12 rows (environ)
INSERT INTO `topic` (`id_topic`, `closed`, `titre`, `dateTopic`, `categorie_id`, `user_id`) VALUES
	(3, 1, 'Programmation PHP', '2023-09-01 08:53:18', 4, 3),
	(4, 0, 'Nouvelles découvertes scientifiques', '2023-09-01 08:53:18', 5, 4),
	(6, 0, 'Concerts locaux', '2023-09-01 08:53:18', 7, 6),
	(7, 0, 'Recettes de cuisine', '2023-09-01 08:53:18', 8, NULL),
	(9, 0, 'Espace et astronomie', '2023-09-01 08:53:18', 5, 4),
	(11, 0, 'Critiques musicales', '2023-09-01 08:53:18', 7, 6),
	(12, 0, 'Cuisine asiatique', '2023-09-01 08:53:18', 8, 6),
	(15, 0, 'Grid en CSS', '2023-09-01 15:29:38', 4, 10),
	(20, 0, 'Zizou est ban', '2023-09-08 20:09:34', 4, 11),
	(21, 0, 'Je v&eacute;rifie un truc', '2023-09-09 16:30:00', 4, NULL),
	(22, 0, 'weee', '2023-09-11 16:04:25', 4, 15);

-- Listage de la structure de table forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateInscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `bannedUntil` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.user : ~9 rows (environ)
INSERT INTO `user` (`id_user`, `pseudo`, `password`, `dateInscription`, `role`, `email`, `bannedUntil`) VALUES
	(3, 'Alice', 'motdepasse1', '2023-09-01 08:49:16', 'utilisateur', 'alice@example.com', NULL),
	(4, 'Bob', 'motdepasse2', '2023-09-01 08:49:16', 'utilisateur', 'bob@example.com', NULL),
	(5, 'Charlie', 'motdepasse3', '2023-09-01 08:49:16', 'utilisateur', 'charlie@example.com', '2023-09-20 00:00:00'),
	(6, 'David', 'motdepasse4', '2023-09-01 08:49:16', 'utilisateur', 'david@example.com', NULL),
	(10, 'Admin', 'mdpdu67', '2023-09-01 09:05:26', 'ROLE_ADMIN', 'admin@exemple.com', NULL),
	(11, 'zizou67', '$2y$10$Ek3r8PMAyK5o9gHwaOqN.eEm5u5XFJr.kqnqdMzKxYXuFBQrkTTG.', '2023-09-07 08:44:49', 'ROLE_USER', 'zizou@gmail.com', NULL),
	(12, 'administrateur', '$2y$10$J9C2O8Jy1zx4NSs6ar6QzeffC.dfV1CQ/WYVS941xKH0X3WsY6JpW', '2023-09-07 11:50:21', 'ROLE_ADMIN', 'mansour@gmail.com', NULL),
	(13, 'Roghan', '$2y$10$w2LsZ7EA2qsMiSS1nvbVFekdWPx7LlvciBpCOJi56laEQjjNHqbO.', '2023-09-07 15:45:19', 'ROLE_USER', 'p90svborz@gmail.com', '2023-09-13 00:00:00'),
	(15, 'foued', '$2y$10$kahqk44oo6j9K4d1Qoqxjeltlf2GEmN2eBFz5uc7UZImHrhgdxlh6', '2023-09-11 15:52:56', 'ROLE_USER', 'foued@derdeche.com', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
