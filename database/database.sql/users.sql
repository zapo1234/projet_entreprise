-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 17 fév. 2022 à 10:35
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `entreprise`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `is_admin`, `date`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'martial', 'souame', 'martial@elyamaje.com', NULL, 1, '2022-02-16 07:31:01', '$2y$10$LOsvB1lz5b82MVWnqPsCp.pZtbp4R1M/y.f0hFoxzeHbBxfsT7TAW', 'KmRTmCYLR0FttZ2WfNxCFavbuwyJNFyBrCQwtHYct0zrChzauffxIHekEkUB', '2022-02-16 07:31:01', '2022-02-16 07:31:01'),
(2, 'mourad', 'souame', 'mourad@elyamaje.com', NULL, 2, '2022-02-16 14:41:47', '$2y$10$csBRw6osMd0BNr1PbklHnu6k0qtXNxFvlKYywwX3yDhrp/XwuOu3y', 'BRewf7fVewM853c8B1hG5Pd7nqFgT0Ikn6HuVvUtQtctM8oswJwy1Z34pI5q', '2022-02-16 14:41:48', '2022-02-16 14:41:48'),
(3, 'samir', 'souame', 'samir@elyamaje.com', NULL, 3, '2022-02-17 07:39:17', '$2y$10$iGbax00JSyrcCAWOBLwuW.Zf8oPwWBWCd4ZpCWg.PLKV15E98W5Iu', 'hvSfVlkSLCdLH8kp1tqOX1TB9sMn9EpuVPerVR0IRZjinNbsU7rlkGNESDSw', '2022-02-17 07:39:17', '2022-02-17 07:39:17');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
