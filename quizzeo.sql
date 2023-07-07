-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 06 juil. 2023 à 09:18
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `quizzeo`
--

-- --------------------------------------------------------

--
-- Structure de la table `choix`
--

DROP TABLE IF EXISTS `choix`;
CREATE TABLE IF NOT EXISTS `choix` (
  `id_choix` int NOT NULL AUTO_INCREMENT,
  `reponse_choix` varchar(255) NOT NULL,
  `bonneReponse_choix` tinyint(1) NOT NULL,
  `id_question` int NOT NULL,
  PRIMARY KEY (`id_choix`),
  KEY `id_question` (`id_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id_question` int NOT NULL AUTO_INCREMENT,
  `intitule_question` varchar(255) NOT NULL,
  `difficulte_question` int NOT NULL,
  `date_creation_question` int NOT NULL,
  PRIMARY KEY (`id_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quizz`
--

DROP TABLE IF EXISTS `quizz`;
CREATE TABLE IF NOT EXISTS `quizz` (
  `id_quizz` int NOT NULL AUTO_INCREMENT,
  `titre_quizz` varchar(255) NOT NULL,
  `difficulte_quizz` int NOT NULL,
  `date_creation_quizz` date NOT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_quizz`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quizz_question`
--

DROP TABLE IF EXISTS `quizz_question`;
CREATE TABLE IF NOT EXISTS `quizz_question` (
  `id_quizz` int NOT NULL,
  `id_question` int NOT NULL,
  KEY `id_quizz` (`id_quizz`),
  KEY `id_question` (`id_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `pseudo_utilisateur` varchar(255) NOT NULL,
  `email_utilisateur` varchar(255) NOT NULL,
  `mdp_utilisateur` varchar(255) NOT NULL,
  `role_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `pseudo_utilisateur`, `email_utilisateur`, `mdp_utilisateur`, `role_utilisateur`) VALUES
(1, 'admin', 'admin@quizzeo.com', '$2y$10$MSMp6Cp4Ja3CNJAfvuzyRuNBj820oTaUzSvxbuAD1KjOye8Npq/VW', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_quizz`
--

DROP TABLE IF EXISTS `utilisateur_quizz`;
CREATE TABLE IF NOT EXISTS `utilisateur_quizz` (
  `id_utilisateur` int NOT NULL,
  `id_quizz` int NOT NULL,
  `score` int NOT NULL,
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_quizz` (`id_quizz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `choix`
--
ALTER TABLE `choix`
  ADD CONSTRAINT `choix_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `question` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD CONSTRAINT `quizz_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `quizz_question`
--
ALTER TABLE `quizz_question`
  ADD CONSTRAINT `quizz_question_ibfk_1` FOREIGN KEY (`id_quizz`) REFERENCES `quizz` (`id_quizz`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quizz_question_ibfk_2` FOREIGN KEY (`id_question`) REFERENCES `question` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur_quizz`
--
ALTER TABLE `utilisateur_quizz`
  ADD CONSTRAINT `utilisateur_quizz_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_quizz_ibfk_2` FOREIGN KEY (`id_quizz`) REFERENCES `quizz` (`id_quizz`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
