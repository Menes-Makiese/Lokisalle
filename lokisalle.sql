-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 25 sep. 2024 à 09:25
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lokisalle`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int NOT NULL AUTO_INCREMENT,
  `id_membre` int NOT NULL,
  `id_salle` int NOT NULL,
  `commentaire` text NOT NULL,
  `note` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_avis`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_membre` int NOT NULL,
  `id_produit` int NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f','','') NOT NULL,
  `statut` varchar(6) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(9, 'menes', '35d7fad976fb3508e1ea7ae0ee3d5d91', 'menes', 'menes', 'men@esfr', 'm', 'membre', '2024-09-11 14:42:54'),
(8, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'ad@min.fr', 'm', 'admin', '2024-09-10 18:20:10'),
(17, 'azerty', 'f2ddc8bfae285afedb15507b7d06a87e', 'aze', 'aze', 'aze@aze.fr', 'f', 'membre', '2024-09-13 20:21:24');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `id_salle` int NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` int NOT NULL,
  `etat` enum('libre','reserver') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(19, 5, '2024-10-01 09:00:00', '2024-10-06 09:00:00', 600, 'reserver'),
(18, 4, '2024-10-08 09:00:00', '2024-10-13 09:00:00', 500, 'reserver'),
(24, 10, '2024-10-14 09:00:00', '2024-10-20 09:00:00', 550, 'reserver'),
(23, 9, '2024-10-21 09:00:00', '2024-10-27 09:00:00', 620, 'libre'),
(22, 8, '2024-10-28 09:00:00', '2024-11-03 09:00:00', 550, 'reserver'),
(21, 7, '2024-11-04 09:00:00', '2024-11-10 09:00:00', 600, 'libre'),
(20, 6, '2024-11-11 09:00:00', '2024-11-17 09:00:00', 500, 'libre'),
(17, 3, '2024-11-18 09:00:00', '2024-11-24 09:00:00', 600, 'libre'),
(15, 1, '2024-11-25 09:00:00', '2024-12-01 09:00:00', 500, 'reserver'),
(16, 2, '2024-12-02 09:00:00', '2024-12-08 09:00:00', 600, 'libre'),
(25, 11, '2024-12-09 09:00:00', '2024-12-15 09:00:00', 560, 'libre'),
(26, 12, '2024-12-30 09:00:00', '2025-01-05 09:00:00', 450, 'reserver');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int NOT NULL,
  `capacite` int NOT NULL,
  `categorie` enum('reunion','bureau','formation') NOT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(1, 'Salle STARK', 'Profitez de notre salle modernes à Paris, équipées de technologies avancées, parfaites pour vos réunions et séminaires d\'affaires.', '/evaluation_backend_menes_makiese/photo/1725880123_salle_baron.png', 'France', 'Paris', 'Avenue de la Grande Armée', 75008, 12, 'reunion'),
(2, 'Salle GREYJOY', 'Organisez vos formations à Lyon dans notre salle moderne, équipée pour offrir un environnement propice à l\'enseignement.', '/evaluation_backend_menes_makiese/photo/1725880561_salle_duvernais.png', 'France', 'Lyon', '467 avenue Mitterand ', 69018, 20, 'formation'),
(3, 'Salle BARATHEON', 'Profitez de notre salle modernes à Paris, équipées de technologies avancées, parfaites pour vos réunions et séminaires d\'affaires.', '/evaluation_backend_menes_makiese/photo/1725880849_salle_baratheon.jpg', 'France', 'Paris', '578 avenue du Cap', 75006, 14, 'reunion'),
(4, 'Salle MARTEL', 'Profitez de notre salle modernes à Paris, équipées de technologies avancées, parfaites pour vos réunions et séminaires d\'affaires.', '/evaluation_backend_menes_makiese/photo/1725881038_salle_martel.jpg', 'France', 'Paris', '32 rue de la Libération', 75018, 26, 'reunion'),
(5, 'Salle TULLY', 'Organisez vos formations à Lyon dans notre salle moderne, équipée pour offrir un environnement propice à l\'enseignement.', '/evaluation_backend_menes_makiese/photo/1725881160_salle_tully.jpg', 'France', 'Lyon', '79 rue des Etables', 69089, 30, 'formation'),
(6, 'Bureau TARGARYEN', 'Découvrez notre salle de bureau lumineuse à Paris, idéale pour vos sessions de travail collaboratives dans un cadre inspirant.', '/evaluation_backend_menes_makiese/photo/1725881320_Bureau_targaryen.jpg', 'France', 'Paris', '86 Boulevard Saint-George', 75006, 6, 'bureau'),
(7, 'Salle FREY', 'Réservez notre salle de réunion à Marseille, idéales pour des rencontres professionnelles, avec des équipements modernes.', '/evaluation_backend_menes_makiese/photo/1725881457_salle_frey.jpg', 'France', 'Marseille', '15 rue Sebastopol', 13034, 12, 'reunion'),
(8, 'Salle TYRELL', 'Espace conçu pour la formation à Paris, avec tout le matériel nécessaire pour favoriser un apprentissage interactif et fluide.', '/evaluation_backend_menes_makiese/photo/1725881646_salle_tyrell.jpg', 'France', 'Paris', '87 rue Dr Tremblay', 75012, 30, 'formation'),
(9, 'Salle LANNISTER', 'Réservez notre salle de réunion à Marseille, idéales pour des rencontres professionnelles, avec des équipements modernes.', '/evaluation_backend_menes_makiese/photo/1725881837_salle_lannister.jpg', 'France', 'Marseille', '55 avenue blanquette', 13024, 20, 'reunion'),
(10, 'Salle ARYN', 'Espace conçu pour la formation à Paris, avec tout le matériel nécessaire pour favoriser un apprentissage interactif et fluide.', '/evaluation_backend_menes_makiese/photo/1725881987_salle_aryn.jpg', 'France', 'Paris', '65 rue du Coeur', 75008, 40, 'formation'),
(11, 'Bureau UMBER', 'Bureau privé à Lyon, offrant un cadre calme et professionnel, idéal pour travailler efficacement selon vos besoins.', '/evaluation_backend_menes_makiese/photo/1725882117_salle_umber.jpg', 'France', 'Lyon', '86 rue des Rosiers', 69015, 10, 'bureau'),
(12, 'Salle BOLTON', 'Espace conçu pour la formation à Paris, avec tout le matériel nécessaire pour favoriser un apprentissage interactif et fluide.', '/evaluation_backend_menes_makiese/photo/1725882369_salle_bolton.jpg', 'France', 'Paris', '20 rue Tigane', 75014, 36, 'formation');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
