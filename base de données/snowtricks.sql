-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 13 oct. 2022 à 14:07
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `tricks_id_id` int(11) NOT NULL,
  `date_time` date NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `tricks_id_id`, `date_time`, `content`, `users_id`) VALUES
(1, 1, '2022-08-08', 'beau trick', 13),
(2, 2, '2022-09-10', 'Génial ce trick !', 2),
(3, 3, '2022-10-07', 'super trick !', 13),
(4, 2, '2022-10-13', 'super', 13),
(5, 3, '2022-10-13', 'top !', 13),
(6, 3, '2022-10-13', 'Génial ce trick !!', 13);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220428123247', '2022-05-13 08:55:45', 85),
('DoctrineMigrations\\Version20220429090701', '2022-05-13 08:55:45', 19),
('DoctrineMigrations\\Version20220513074553', '2022-05-13 08:55:45', 65),
('DoctrineMigrations\\Version20220520083837', '2022-05-20 08:38:52', 153),
('DoctrineMigrations\\Version20220520091850', '2022-05-20 09:19:26', 122),
('DoctrineMigrations\\Version20220624072900', '2022-06-24 07:29:18', 161),
('DoctrineMigrations\\Version20220707141214', '2022-07-07 14:13:14', 171),
('DoctrineMigrations\\Version20220715071223', '2022-07-15 07:15:58', 118),
('DoctrineMigrations\\Version20220715092611', '2022-07-15 09:26:50', 140),
('DoctrineMigrations\\Version20220715123635', '2022-07-15 12:37:20', 73),
('DoctrineMigrations\\Version20220731123608', '2022-07-31 12:39:36', 156),
('DoctrineMigrations\\Version20220808070335', '2022-08-08 07:03:58', 116),
('DoctrineMigrations\\Version20220808070536', '2022-08-08 07:05:54', 95),
('DoctrineMigrations\\Version20220916083953', '2022-09-16 08:40:34', 142),
('DoctrineMigrations\\Version20221013083115', '2022-10-13 08:32:21', 102);

-- --------------------------------------------------------

--
-- Structure de la table `tricks`
--

CREATE TABLE `tricks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `header` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tricks`
--

INSERT INTO `tricks` (`id`, `name`, `description`, `type`, `photo`, `video`, `created_at`, `updated_at`, `header`) VALUES
(1, 'Mute', 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.', 'Grab', 'mute.jpg', 'https://www.youtube.com/embed/jm19nEvmZgM', '2022-05-06', '2022-09-23', 'muteHeader-632d5db69209a.jpg'),
(2, 'Sad', 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant. ', 'Grab', 'sad.jpg', 'https://www.youtube.com/embed/KEdFwJ4SWq4', '2022-05-06', '2022-05-06', 'sadHeader.jpg'),
(3, 'Indy', 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.', 'Grab', 'indy.jpg', 'https://www.youtube.com/embed/TvRBTCnyLAw', '2022-05-06', '2022-05-06', 'indyHeader.jpg'),
(4, '180', 'Désigne un demi-tour, soit 180 degrés d\'angle.', 'Rotation', '180.jpg', 'https://www.youtube.com/embed/WHLu1rSMEvQ', '2022-05-06', '2022-05-06', '180Header.jpg'),
(5, '360', 'Trois six pour un tour complet', 'Rotation', '360.jpg', 'https://www.youtube.com/embed/JJy39dO_PPE', '2022-05-12', '2022-07-15', '360Header.jpg'),
(6, '540', 'Cinq quatre pour un tour et demi.', 'Rotation', '540.jpg', 'https://www.youtube.com/embed/_hJX9HrdkeA', '2022-05-12', '2022-05-12', '540Header.jpg'),
(7, 'Front flip', 'Rotation verticale en avant.', 'Flip', 'frontflip.jpg', 'https://www.youtube.com/embed/9_zC7CdvYu4', '2022-05-12', '2022-05-12', 'front-flipHeader.jpeg'),
(8, 'Back flip', 'Rotation verticale en arrière.', 'Flip', 'backflip.jpg', 'https://www.youtube.com/embed/W853WVF5AqI', '2022-05-13', '2022-05-13', 'back-flipHeader.jpg'),
(9, 'Frontside boardslide', 'Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Le board slide est front side si le rider se présente face au rail ou à la boxe.', 'Slide', 'frontslide.jpg', 'https://www.youtube.com/embed/WRjNFodnOHk', '2022-05-13', '2022-05-13', 'frontside-boardslideHeader.jpg'),
(11, 'Backside boardslide', 'Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Le board slide est back side si le rider se présente dos au rail ou à la boxe.', 'slide', 'backslide-62ac326b13437.jpg', 'https://www.youtube.com/embed/R3OG9rNDIcs', '2022-05-13', '2022-05-13', 'backside-boardslideHeader.jpg'),
(17, 'trick test2', 'test2', 'test2', 'zinedine-zidane-60586c1fc711d-632474a37ccf6-633f0de5bcf25.jpg', 'etrthhcvbvcbvcb', '2022-09-16', '2022-10-06', '30061-dds-summer-of-drizzt-begins-with-tv-show-rumors-magic-cards-and-benedict-cumberbatch-scaled-632473d881233-633f0dd7a3b07.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validate` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `photo`, `name`, `token`, `validate`) VALUES
(2, 'edouard.liegeon@outlook.fr', '$2y$13$ANVL1fkFNhiHDEjEl5iNQezmiRohwMgRSj22J298jnO5pBrBImRfi', 'bitmoji-Ed-62a366d650b61.png', 'Ed39', NULL, NULL),
(13, 'edouard.liegeon@gmail.com', '$2y$13$b0NeJF/EW3GZIRJWbYq4we4rcj65Mgo3GUdOdCOPVzk7Rqd.emP4K', 'photoEd-62b81cdbd3195.png', 'Ed84', '', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962AA674A03E` (`tricks_id_id`),
  ADD KEY `IDX_5F9E962A67B3B43D` (`users_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `tricks`
--
ALTER TABLE `tricks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962A67B3B43D` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_5F9E962AA674A03E` FOREIGN KEY (`tricks_id_id`) REFERENCES `tricks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
