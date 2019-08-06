-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 06 août 2019 à 16:28
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `accounts`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(125) NOT NULL,
  `email` varchar(125) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_users`, `username`, `email`, `password`, `firstname`, `name`, `phone`) VALUES
(12, 'Gollum', 'mon.precieux@anneau.fr', '$2y$10$DKvIgBeymLaoZRpnoUzjhOYbX55kBlEEVIP07u2exoGRoLdlbyn82', '', '', ''),
(13, 'Sauron', 'sauron@malefique.fr', '$2y$10$AfdPKaK84/HsXKm8oAPZxewT2e0MmZBZh3eqCrlPEw.KA08TKtk9C', '', '', ''),
(14, 'John', 'johnshepard@normandy.fr', '$2y$10$YUH/n8XHqSgqQ3BSnOXO2Or.2vHNgWZ6fe/cU65YNEIYONMBei.Dq', '', '', ''),
(15, 'Licorne', 'licorne@mignone.fr', '$2y$10$wD1dWgFc3Yx.lU0O8OyiZ.LvTJSAYP91Z8lpxPpFySQVZarwfqf3u', '', '', ''),
(16, 'leComique', 'mathi@camp.fr', '$2y$10$so8eBj89zb0A.XES4f79AOPhYFt7WMm88sF5OsvhU.CFNU6IAw0/6', 'Mathoeil', 'Capdecampagne', '0123456789'),
(18, 'jplemmerdeur', 'simon.webforce3@gmail.com', '$2y$10$eY0asuHEqrZy5l/AAlke/OuX3Ae7GRJKJhmoMcMGkfvGrwBdJbyRq', 'Jean-Marie', 'Lepen', '0123456789');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
