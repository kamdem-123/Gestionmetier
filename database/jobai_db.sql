-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 19 juin 2026 à 07:49
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jobai_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

DROP TABLE IF EXISTS `candidatures`;
CREATE TABLE IF NOT EXISTS `candidatures` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `offre_id` bigint UNSIGNED NOT NULL,
  `score_matching` decimal(5,2) DEFAULT NULL,
  `statut` enum('en_attente','vue','acceptee','refusee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `notif_recruteur_envoyee` tinyint(1) NOT NULL DEFAULT '0',
  `notif_candidat_envoyee` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `candidatures_user_id_offre_id_unique` (`user_id`,`offre_id`),
  KEY `candidatures_offre_id_foreign` (`offre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `candidatures`
--

INSERT INTO `candidatures` (`id`, `user_id`, `offre_id`, `score_matching`, `statut`, `notif_recruteur_envoyee`, `notif_candidat_envoyee`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 72.36, 'vue', 0, 0, '2026-06-17 20:18:10', '2026-06-17 20:24:35'),
(2, 3, 8, NULL, 'en_attente', 0, 0, '2026-06-17 21:01:29', '2026-06-17 21:01:29');

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE IF NOT EXISTS `entreprises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secteur` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `nom`, `secteur`, `email_contact`, `telephone`, `website`, `logo`, `date_creation`, `created_at`, `updated_at`) VALUES
(1, 'TechCorp Solutions', 'Informatique / Tech', 'rh@techcorp.com', NULL, 'https://www.techcorp.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(2, 'Digital Agency', 'Marketing / Communication', 'contact@digitalagency.com', NULL, 'https://www.digitalagency.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(3, 'AI Innovations', 'Informatique / Tech', 'careers@aiinnovations.com', NULL, 'https://www.aiinnovations.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(4, 'Creative Studio', 'Marketing / Communication', 'studio@creative.com', NULL, 'https://www.creativestudio.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(5, 'Cloud Systems', 'Informatique / Tech', 'jobs@cloudsystems.com', NULL, 'https://www.cloudsystems.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(6, 'ERP Consulting', 'Finance / Banque', 'recrutement@erpconsulting.com', NULL, 'https://www.erpconsulting.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(7, 'Savtontine Tech', 'Informatique / Tech', 'hiring@savtontinetech.com', NULL, 'https://www.savtontinetech.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(8, 'Finances & Co', 'Finance / Banque', 'rh@finances-co.com', NULL, 'https://www.finances-co.com', NULL, '2026-06-17 21:59:44', '2026-06-17 21:59:44', '2026-06-17 21:59:44');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"23350053-aae2-4517-b546-f7c0a5e5a25f\",\"displayName\":\"App\\\\Jobs\\\\NotifierRecruteurJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"5\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\NotifierRecruteurJob\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\NotifierRecruteurJob\\\":1:{s:11:\\\"candidature\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Candidature\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\",\"batchId\":null},\"createdAt\":1781734693,\"delay\":null}', 0, NULL, 1781734693, 1781734693),
(2, 'default', '{\"uuid\":\"fa36fdf0-1fe5-4c05-b5f1-aa7accb231ba\",\"displayName\":\"App\\\\Notifications\\\\NouvelleOffreMatchNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:2;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:48:\\\"App\\\\Notifications\\\\NouvelleOffreMatchNotification\\\":3:{s:5:\\\"offre\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Offre\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:10:\\\"entreprise\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"score\\\";d:72.36;s:2:\\\"id\\\";s:36:\\\"42d9ec95-353d-419f-86cc-f420a2014e32\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\",\"batchId\":null},\"createdAt\":1781734713,\"delay\":null}', 0, NULL, 1781734713, 1781734713),
(3, 'default', '{\"uuid\":\"2ab2a357-5f8b-4c8f-a695-ca8176bd1042\",\"displayName\":\"App\\\\Notifications\\\\NouvelleOffreMatchNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:2;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:48:\\\"App\\\\Notifications\\\\NouvelleOffreMatchNotification\\\":3:{s:5:\\\"offre\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Offre\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:10:\\\"entreprise\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:5:\\\"score\\\";d:72.36;s:2:\\\"id\\\";s:36:\\\"42d9ec95-353d-419f-86cc-f420a2014e32\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\",\"batchId\":null},\"createdAt\":1781734713,\"delay\":null}', 0, NULL, 1781734713, 1781734713),
(4, 'default', '{\"uuid\":\"15789105-6254-42de-ae08-07fcc5fe7287\",\"displayName\":\"App\\\\Jobs\\\\AnalyserMatchingJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"10\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\AnalyserMatchingJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\AnalyserMatchingJob\\\":1:{s:11:\\\"candidature\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Candidature\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\",\"batchId\":null},\"createdAt\":1781737289,\"delay\":null}', 0, NULL, 1781737289, 1781737289);

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_28_152700_add_google_id_to_users_table', 1),
(5, '2026_06_15_000001_add_is_admin_to_users_table', 1),
(6, '2026_06_17_135419_add_profil_candidat_to_users_table', 1),
(7, '2026_06_17_135424_create_candidatures_table', 1),
(8, '2026_06_17_140402_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offres`
--

DROP TABLE IF EXISTS `offres`;
CREATE TABLE IF NOT EXISTS `offres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entreprise_id` int NOT NULL,
  `type_contrat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode_travail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pays` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categorie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `competences` text COLLATE utf8mb4_unicode_ci,
  `salaire_min` decimal(12,2) DEFAULT NULL,
  `salaire_max` decimal(12,2) DEFAULT NULL,
  `devise` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'EUR',
  `periode_salaire` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_limite_candidature` date DEFAULT NULL,
  `date_publication` date DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `salary_eur` decimal(12,2) DEFAULT NULL,
  `salary_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `entreprise_id` (`entreprise_id`),
  KEY `idx_date_publication` (`date_publication`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `offres`
--

INSERT INTO `offres` (`id`, `titre`, `entreprise_id`, `type_contrat`, `mode_travail`, `localisation`, `ville`, `region`, `pays`, `categorie`, `description`, `competences`, `salaire_min`, `salaire_max`, `devise`, `periode_salaire`, `date_limite_candidature`, `date_publication`, `status`, `salary_eur`, `salary_type`, `created_at`, `updated_at`) VALUES
(1, 'Développeur Full Stack', 1, 'CDI', 'Hybride', 'Paris, France', 'Paris', 'Île-de-France', 'France', 'Informatique', NULL, 'React,Laravel,MySQL', 40000.00, 50000.00, 'EUR', '/an', '2026-07-15', '2026-06-10', 'active', 45000.00, 'year', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(2, 'Chef de Projet Marketing', 2, 'CDD', 'Présentiel', 'Lyon, France', 'Lyon', 'Auvergne-Rhône-Alpes', 'France', 'Marketing', NULL, 'SEO,Google Ads,Analytics', 33000.00, 40000.00, 'EUR', '/an', '2026-07-10', '2026-06-11', 'active', 38000.00, 'year', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(3, 'Data Scientist', 3, 'Freelance', 'Télétravail', 'Montréal, Canada', 'Montréal', 'Québec', 'Canada', 'Data Science', NULL, 'Python,Machine Learning,TensorFlow', 400.00, 600.00, 'CAD', '/jour', '2026-07-20', '2026-06-14', 'active', 500.00, 'day', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(4, 'UX/UI Designer', 4, 'Stage', 'Présentiel', 'Douala, Cameroun', 'Douala', 'Littoral', 'Cameroun', 'Design', NULL, 'Figma,Adobe XD,Prototypage', 100000.00, 200000.00, 'XAF', '/mois', '2026-07-05', '2026-06-13', 'active', 229.00, 'month', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(5, 'Ingénieur DevOps', 5, 'CDI', 'Hybride', 'Bruxelles, Belgique', 'Bruxelles', 'Région de Bruxelles-Capitale', 'Belgique', 'Infrastructure', NULL, 'Docker,Kubernetes,AWS', 50000.00, 60000.00, 'EUR', '/an', '2026-07-25', '2026-06-09', 'active', 55000.00, 'year', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(6, 'Consultant SAP', 6, 'CDI', 'Hybride', 'Genève, Suisse', 'Genève', 'Genève', 'Suisse', 'ERP', NULL, 'SAP,ABAP,FI/CO', 100000.00, 130000.00, 'CHF', '/an', '2026-07-12', '2026-06-08', 'active', 112800.00, 'year', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(7, 'Développeur Mobile Flutter', 7, 'CDI', 'Télétravail', 'Dakar, Sénégal', 'Dakar', 'Dakar', 'Sénégal', 'Informatique', NULL, 'Flutter,Dart,Firebase', 2000.00, 3000.00, 'EUR', '/mois', '2026-07-18', '2026-06-12', 'active', 2500.00, 'month', '2026-06-17 21:59:44', '2026-06-17 21:59:44'),
(8, 'Comptable Senior', 8, 'CDI', 'Présentiel', 'Abidjan, Côte d\'Ivoire', 'Abidjan', 'Lagunes', 'Côte d\'Ivoire', 'Finance', NULL, 'Comptabilité,SAP,Audit', 1000000.00, 1500000.00, 'XOF', '/mois', '2026-07-08', '2026-06-07', 'active', 1830.00, 'month', '2026-06-17 21:59:44', '2026-06-17 21:59:44');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Rxvow7hS2jAabJwC5rZ76UT3ZNWX6qR5NTqltzOP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDdFcXpLam16THpDS3FGelNTRk15RFNXWkd1OU5BWGI0a1d1YkpKSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZWNoZXJjaGUtbWV0aWVyLnBocCI7czo1OiJyb3V0ZSI7czoxNDoic2VhcmNoLmtleXdvcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781851531);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre_poste` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `competences` text COLLATE utf8mb4_unicode_ci,
  `cv_texte` text COLLATE utf8mb4_unicode_ci,
  `cv_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `titre_poste`, `competences`, `cv_texte`, `cv_path`, `email`, `email_verified_at`, `password`, `remember_token`, `is_admin`, `google_id`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Admin JobAI', NULL, NULL, NULL, NULL, 'admin@jobai.test', NULL, '$2y$12$C80p5QutHBGysLNFLJCnw.G6xO72qhrmJUdf0mjXsQNsyYBAJdZ0a', NULL, 1, NULL, NULL, '2026-06-17 21:59:44', '2026-06-17 20:17:43'),
(2, 'Test User', 'Développeur Full Stack Web', 'React, Laravel, PHP, MySQL, JavaScript, HTML, CSS', 'Développeur passionné avec 3 ans d\'expérience sur PHP, Laravel et React.', NULL, 'test@example.com', '2026-06-17 20:17:41', '$2y$12$68ZHNwYmsK/lpQOixngF2u6lPsHlnw2/eaybW.2H0rFxgVnyUxrK6', '8vWPqUivIl', 0, NULL, NULL, '2026-06-17 20:17:41', '2026-06-17 20:18:10'),
(3, 'Admin JobAI', NULL, NULL, NULL, NULL, 'admin@example.com', NULL, '$2y$12$C.qvrYqJNZC7tDC0e3zOz.gd1OWLEc7.JW3aFUqlpqK6W.JeWmZLy', NULL, 1, NULL, NULL, '2026-06-17 20:17:42', '2026-06-17 20:17:42');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `offres`
--
ALTER TABLE `offres`
  ADD CONSTRAINT `offres_ibfk_1` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
