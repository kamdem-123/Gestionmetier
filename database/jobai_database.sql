-- JobAI - Base de données complète
-- Exportable pour serveur en ligne
-- Créée le 2026-06-15

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- =====================================================
-- Table : users
-- =====================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `google_id` VARCHAR(255) NULL DEFAULT NULL,
  `avatar` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table : entreprises
-- =====================================================
DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE `entreprises` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(255) NOT NULL UNIQUE,
  `secteur` VARCHAR(100),
  `email_contact` VARCHAR(255),
  `telephone` VARCHAR(20),
  `website` VARCHAR(255),
  `logo` VARCHAR(255),
  `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table : offres
-- =====================================================
DROP TABLE IF EXISTS `offres`;
CREATE TABLE `offres` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titre` VARCHAR(255) NOT NULL,
  `entreprise_id` INT NOT NULL,
  `type_contrat` VARCHAR(50),
  `mode_travail` VARCHAR(50),
  `localisation` VARCHAR(255),
  `ville` VARCHAR(100),
  `region` VARCHAR(100),
  `pays` VARCHAR(100),
  `categorie` VARCHAR(100),
  `description` LONGTEXT,
  `competences` TEXT,
  `salaire_min` DECIMAL(12, 2),
  `salaire_max` DECIMAL(12, 2),
  `devise` VARCHAR(10) DEFAULT 'EUR',
  `periode_salaire` VARCHAR(20),
  `date_limite_candidature` DATE,
  `date_publication` DATE DEFAULT CURDATE(),
  `status` VARCHAR(20) DEFAULT 'active',
  `salary_eur` DECIMAL(12, 2),
  `salary_type` VARCHAR(20),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises`(`id`) ON DELETE CASCADE,
  INDEX `idx_date_publication` (`date_publication`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Insertion des données : USERS
-- =====================================================
INSERT INTO `users` (`id`, `name`, `email`, `password`, `google_id`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Admin JobAI', 'admin@jobai.test', '$2y$10$/FEX74ghJoCE5Y7puTrJ9uGHW95wUoAegVqNRMZH/IikL1.kr28wa', NULL, NULL, NOW(), NOW());

-- =====================================================
-- Insertion des données : ENTREPRISES
-- =====================================================
INSERT INTO `entreprises` (`id`, `nom`, `secteur`, `email_contact`, `website`, `logo`) VALUES
(1, 'TechCorp Solutions', 'Informatique / Tech', 'rh@techcorp.com', 'https://www.techcorp.com', NULL),
(2, 'Digital Agency', 'Marketing / Communication', 'contact@digitalagency.com', 'https://www.digitalagency.com', NULL),
(3, 'AI Innovations', 'Informatique / Tech', 'careers@aiinnovations.com', 'https://www.aiinnovations.com', NULL),
(4, 'Creative Studio', 'Marketing / Communication', 'studio@creative.com', 'https://www.creativestudio.com', NULL),
(5, 'Cloud Systems', 'Informatique / Tech', 'jobs@cloudsystems.com', 'https://www.cloudsystems.com', NULL),
(6, 'ERP Consulting', 'Finance / Banque', 'recrutement@erpconsulting.com', 'https://www.erpconsulting.com', NULL),
(7, 'Savtontine Tech', 'Informatique / Tech', 'hiring@savtontinetech.com', 'https://www.savtontinetech.com', NULL),
(8, 'Finances & Co', 'Finance / Banque', 'rh@finances-co.com', 'https://www.finances-co.com', NULL);

-- =====================================================
-- Insertion des données : OFFRES
-- =====================================================
INSERT INTO `offres` (
  `id`, `titre`, `entreprise_id`, `type_contrat`, `mode_travail`, 
  `localisation`, `ville`, `region`, `pays`, `categorie`, `competences`, 
  `salaire_min`, `salaire_max`, `devise`, `periode_salaire`, 
  `date_limite_candidature`, `date_publication`, `status`, 
  `salary_eur`, `salary_type`
) VALUES
(1, 'Développeur Full Stack', 1, 'CDI', 'Hybride', 'Paris, France', 'Paris', 'Île-de-France', 'France', 'Informatique', 'React,Laravel,MySQL', 40000.00, 50000.00, 'EUR', '/an', '2026-07-15', '2026-06-10', 'active', 45000.00, 'year'),
(2, 'Chef de Projet Marketing', 2, 'CDD', 'Présentiel', 'Lyon, France', 'Lyon', 'Auvergne-Rhône-Alpes', 'France', 'Marketing', 'SEO,Google Ads,Analytics', 33000.00, 40000.00, 'EUR', '/an', '2026-07-10', '2026-06-11', 'active', 38000.00, 'year'),
(3, 'Data Scientist', 3, 'Freelance', 'Télétravail', 'Montréal, Canada', 'Montréal', 'Québec', 'Canada', 'Data Science', 'Python,Machine Learning,TensorFlow', 400.00, 600.00, 'CAD', '/jour', '2026-07-20', '2026-06-14', 'active', 500.00, 'day'),
(4, 'UX/UI Designer', 4, 'Stage', 'Présentiel', 'Douala, Cameroun', 'Douala', 'Littoral', 'Cameroun', 'Design', 'Figma,Adobe XD,Prototypage', 100000.00, 200000.00, 'XAF', '/mois', '2026-07-05', '2026-06-13', 'active', 229.00, 'month'),
(5, 'Ingénieur DevOps', 5, 'CDI', 'Hybride', 'Bruxelles, Belgique', 'Bruxelles', 'Région de Bruxelles-Capitale', 'Belgique', 'Infrastructure', 'Docker,Kubernetes,AWS', 50000.00, 60000.00, 'EUR', '/an', '2026-07-25', '2026-06-09', 'active', 55000.00, 'year'),
(6, 'Consultant SAP', 6, 'CDI', 'Hybride', 'Genève, Suisse', 'Genève', 'Genève', 'Suisse', 'ERP', 'SAP,ABAP,FI/CO', 100000.00, 130000.00, 'CHF', '/an', '2026-07-12', '2026-06-08', 'active', 112800.00, 'year'),
(7, 'Développeur Mobile Flutter', 7, 'CDI', 'Télétravail', 'Dakar, Sénégal', 'Dakar', 'Dakar', 'Sénégal', 'Informatique', 'Flutter,Dart,Firebase', 2000.00, 3000.00, 'EUR', '/mois', '2026-07-18', '2026-06-12', 'active', 2500.00, 'month'),
(8, 'Comptable Senior', 8, 'CDI', 'Présentiel', 'Abidjan, Côte d\'Ivoire', 'Abidjan', 'Lagunes', 'Côte d\'Ivoire', 'Finance', 'Comptabilité,SAP,Audit', 1000000.00, 1500000.00, 'XOF', '/mois', '2026-07-08', '2026-06-07', 'active', 1830.00, 'month');

-- =====================================================
-- Vérification
-- =====================================================
SELECT COUNT(*) as total_entreprises FROM `entreprises`;
SELECT COUNT(*) as total_offres FROM `offres`;

-- =====================================================
-- FIN DU SCRIPT
-- =====================================================
