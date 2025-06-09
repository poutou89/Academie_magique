-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : dim. 08 juin 2025 à 15:51
-- Version du serveur : 8.0.42
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Academie`
--

-- --------------------------------------------------------

--
-- Structure de la table `bestiaire`
--

CREATE TABLE `bestiaire` (
  `id_bestiaire` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `createur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bestiaire`
--

INSERT INTO `bestiaire` (`id_bestiaire`, `nom`, `description`, `type`, `createur`) VALUES
(10, 'élémentaire d&#039;eau', 'esprit de l&#039;eau', 'Aquatique', 41),
(11, 'Kappa', 'Yokai d&#039;eau', 'Aquatique', 41),
(12, 'kirin', 'animal composite fabuleux issu de la mythologie chinoise possédant plusieurs apparences.', 'Aquatique', 41),
(13, 'cerbere', 'Chien légendaire gardien des enfer.', 'Démoniaque', 1),
(14, 'Seigneur des abimes', 'son nom est assez explicite', 'Démoniaque', 1),
(15, 'succube', 'Démon femelle qui s&#039;introduit dans les rêves des hommes pour les séduire.', 'Démoniaque', 1),
(16, 'tourmenteur', 'il fait des potits tourment', 'Démoniaque', 1),
(17, 'centaure', 'Créature mi-homme, mi-cheval', 'mi-bêtes', 1),
(18, 'cyclope', 'Ce sont des monstres géants n&#039;ayant qu&#039;un œil au milieu du front. ', 'mi-bêtes', 1),
(19, 'harpie', 'tête de femme et à corps de rapace', 'mi-bêtes', 1),
(20, 'minotaure', 'monstre fabuleux au corps d&#039;un homme et à tête d&#039;un taureau ou mi-homme et mi-taureau', 'mi-bêtes', 1),
(21, 'fantome', 'Bouh', 'mort-vivant', 1),
(22, 'lamasu', 'créatures à tête humaine avec un corps de taureau (ou de lion) et des ailes d&#039;aigle qui gardaient les temples et les palais', 'mort-vivant', 1),
(23, 'liche', 'un sorcier mort qui se maintient dans un état mort-vivant grâce à ses pouvoirs magiques', 'mort-vivant', 1),
(24, 'squelette', 'personnage mort-vivant qui a perdu sa chair putréfiée', 'mort-vivant', 1);

-- --------------------------------------------------------

--
-- Structure de la table `codex`
--

CREATE TABLE `codex` (
  `id_codex` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `element` int NOT NULL,
  `id_createur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `codex`
--

INSERT INTO `codex` (`id_codex`, `nom`, `element`, `id_createur`) VALUES
(13, 'Armure céleste', 1, 41),
(14, 'élémentaire de lumière', 1, 41),
(15, 'Purification', 1, 0),
(16, 'Retribution', 1, 0),
(17, 'Soin', 1, 0),
(19, 'Boule de feu', 2, 0),
(21, 'Immolation', 2, 0),
(23, 'éclair', 3, 0),
(24, 'élémentaire d&#039;air', 3, 0),
(25, 'Vent violent', 3, 0),
(26, 'Armure de glace', 4, 0),
(27, 'Blizzard', 4, 0),
(28, 'élémentaire d&#039;eau', 4, 0),
(29, 'Mur de glaces', 4, 0),
(31, 'Bouclier de feu', 2, 1),
(32, 'élémentaire de feu', 2, 1),
(33, 'Tempête de feu', 2, 1),
(34, 'Cercles d&#039;hiver', 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

CREATE TABLE `element` (
  `id_element` int NOT NULL,
  `element` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `element`
--

INSERT INTO `element` (`id_element`, `element`) VALUES
(1, 'lumière'),
(2, 'feu'),
(3, 'air'),
(4, 'eau'),
(35, 'Obscurité');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id_image` int NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `id_codex` int DEFAULT NULL,
  `id_bestiaire` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id_image`, `nom_fichier`, `id_codex`, `id_bestiaire`) VALUES
(6, '6841b0a12c91a.png', NULL, 7),
(7, '6841b0a84f3b8.png', NULL, 8),
(8, '6841b11c61575.png', NULL, 9),
(9, '6842951be5749.jpg', NULL, 10),
(10, '6842955f073b5.jpg', NULL, 11),
(11, '6842958e38e7a.jpg', NULL, 12),
(12, '684295bdcb3fe.jpg', NULL, 13),
(13, '684295ecc2b4f.jpg', NULL, 14),
(14, '6842960f74b22.jpg', NULL, 15),
(15, '68429678cd81e.jpg', NULL, 16),
(16, '6842969fbf993.jpg', NULL, 17),
(17, '684296e705ce2.jpg', NULL, 18),
(18, '6842971c37ecf.jpg', NULL, 19),
(19, '68429758bbc8c.png', NULL, 20),
(20, '6842978823cf5.jpg', NULL, 21),
(21, '684297ac120fa.jpg', NULL, 22),
(22, '684297d495c95.jpg', NULL, 23),
(23, '68429800c6339.jpg', NULL, 24),
(24, '684299f28f8ca.webp', 13, NULL),
(25, '68429a0b87596.webp', 14, NULL),
(26, '68429a1cba0d0.webp', 15, NULL),
(27, '68429a2e8a94d.webp', 16, NULL),
(28, '68429a39cb883.webp', 17, NULL),
(30, '68429a650dda3.webp', 19, NULL),
(32, '68429a8c667c8.webp', 21, NULL),
(34, '68429aca70c8f.webp', 23, NULL),
(35, '68429ade96931.webp', 24, NULL),
(36, '68429af0364b1.webp', 25, NULL),
(37, '68429b10f28dc.webp', 26, NULL),
(38, '68429b1d06179.webp', 27, NULL),
(39, '68429b2e35081.webp', 28, NULL),
(40, '68429b3e9658d.webp', 29, NULL),
(42, '68457d0b9e6de.webp', 31, NULL),
(43, '68457d4415bc8.webp', 32, NULL),
(44, '68457d5eb09c8.webp', 33, NULL),
(45, '68457da1b74ce.webp', 34, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `role`, `mdp`) VALUES
(1, 'Catherine', 'admin', 'ce11cd5bb406cdec290f9cff9c967a31d84b5d0c'),
(40, 'Anastasya', 'utilisateur', 'ce11cd5bb406cdec290f9cff9c967a31d84b5d0c'),
(41, 'Kiril', 'utilisateur', 'ce11cd5bb406cdec290f9cff9c967a31d84b5d0c'),
(42, 'Anton', 'utilisateur', 'ce11cd5bb406cdec290f9cff9c967a31d84b5d0c'),
(43, 'Irina', 'utilisateur', 'ce11cd5bb406cdec290f9cff9c967a31d84b5d0c'),
(44, 'Jorgen', 'utilisateur', 'ce11cd5bb406cdec290f9cff9c967a31d84b5d0c'),
(45, 'Kalindra', 'utilisateur', 'ce11cd5bb406cdec290f9cff9c967a31d84b5d0c');

-- --------------------------------------------------------

--
-- Structure de la table `user_element`
--

CREATE TABLE `user_element` (
  `id_user` int NOT NULL,
  `id_element` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_element`
--

INSERT INTO `user_element` (`id_user`, `id_element`) VALUES
(1, 1),
(41, 1),
(42, 1),
(1, 2),
(41, 2),
(44, 2),
(1, 3),
(43, 3),
(45, 3),
(1, 4),
(40, 4),
(42, 4),
(43, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bestiaire`
--
ALTER TABLE `bestiaire`
  ADD PRIMARY KEY (`id_bestiaire`);

--
-- Index pour la table `codex`
--
ALTER TABLE `codex`
  ADD PRIMARY KEY (`id_codex`);

--
-- Index pour la table `element`
--
ALTER TABLE `element`
  ADD PRIMARY KEY (`id_element`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `id_codex` (`id_codex`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `user_element`
--
ALTER TABLE `user_element`
  ADD PRIMARY KEY (`id_user`,`id_element`),
  ADD KEY `id_element` (`id_element`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bestiaire`
--
ALTER TABLE `bestiaire`
  MODIFY `id_bestiaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `codex`
--
ALTER TABLE `codex`
  MODIFY `id_codex` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `element`
--
ALTER TABLE `element`
  MODIFY `id_element` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`id_codex`) REFERENCES `codex` (`id_codex`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_element`
--
ALTER TABLE `user_element`
  ADD CONSTRAINT `user_element_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_element_ibfk_2` FOREIGN KEY (`id_element`) REFERENCES `element` (`id_element`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
