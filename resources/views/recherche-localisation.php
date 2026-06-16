<?php
/**
 * JobAI - Page de recherche par localisation
 * Recherche d'offres d'emploi par ville, région ou pays
 */

// Configuration de la base de données (à adapter selon votre environnement)
$db_host = 'localhost';
$db_name = 'jobai_db';
$db_user = 'root';
$db_pass = '';

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $db_error = "Erreur de connexion à la base de données.";
}

// Récupération des paramètres de recherche
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$location = htmlspecialchars($location, ENT_QUOTES, 'UTF-8');

$country_filter = isset($_GET['country']) ? trim($_GET['country']) : '';
$country_filter = htmlspecialchars($country_filter, ENT_QUOTES, 'UTF-8');

$results = [];
$results_count = 0;

// Si une localisation est fournie, effectuer la recherche
if (!empty($location) && isset($pdo)) {
    try {
        $search_term = "%$location%";
        $stmt = $pdo->prepare("
            SELECT o.*, e.nom as entreprise_nom, e.logo as entreprise_logo 
            FROM offres o 
            LEFT JOIN entreprises e ON o.entreprise_id = e.id 
            WHERE o.ville LIKE :location 
               OR o.pays LIKE :location 
               OR o.region LIKE :location
            ORDER BY o.date_publication DESC
        ");
        $stmt->execute([':location' => $search_term]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_count = count($results);
    } catch (PDOException $e) {
        $search_error = "Erreur lors de la recherche.";
    }
}

// Données de démonstration organisées par pays
$demo_jobs_by_country = [
    'FR' => [
        [
            'titre' => 'Développeur Full Stack',
            'entreprise_nom' => 'TechCorp Solutions',
            'type_contrat' => 'CDI',
            'tags' => 'React,Laravel,MySQL',
            'salaire' => '45 000',
            'devise' => '€',
            'periode' => '/an',
            'ville' => 'Paris',
            'pays' => 'France',
            'flag' => '🇫🇷',
            'date_publication' => '2026-06-10'
        ],
        [
            'titre' => 'Chef de Projet Marketing',
            'entreprise_nom' => 'Digital Agency',
            'type_contrat' => 'CDD',
            'tags' => 'SEO,Google Ads,Analytics',
            'salaire' => '38 000',
            'devise' => '€',
            'periode' => '/an',
            'ville' => 'Lyon',
            'pays' => 'France',
            'flag' => '🇫🇷',
            'date_publication' => '2026-06-11'
        ],
        [
            'titre' => 'Développeur Backend Node.js',
            'entreprise_nom' => 'Startup Paris',
            'type_contrat' => 'CDI',
            'tags' => 'Node.js,Express,MongoDB',
            'salaire' => '50 000',
            'devise' => '€',
            'periode' => '/an',
            'ville' => 'Marseille',
            'pays' => 'France',
            'flag' => '🇫🇷',
            'date_publication' => '2026-06-09'
        ]
    ],
    'SN' => [
        [
            'titre' => 'Développeur Mobile Flutter',
            'entreprise_nom' => 'Savtontine Tech',
            'type_contrat' => 'CDI',
            'tags' => 'Flutter,Dart,Firebase',
            'salaire' => '2 500',
            'devise' => '€',
            'periode' => '/mois',
            'ville' => 'Dakar',
            'pays' => 'Sénégal',
            'flag' => '🇸🇳',
            'date_publication' => '2026-06-12'
        ],
        [
            'titre' => 'Analyste Financier',
            'entreprise_nom' => 'Banque Sénégalaise',
            'type_contrat' => 'CDI',
            'tags' => 'Finance,Excel,Analyse',
            'salaire' => '1 200 000',
            'devise' => 'FCFA',
            'periode' => '/mois',
            'ville' => 'Dakar',
            'pays' => 'Sénégal',
            'flag' => '🇸🇳',
            'date_publication' => '2026-06-08'
        ]
    ],
    'CA' => [
        [
            'titre' => 'Data Scientist',
            'entreprise_nom' => 'AI Innovations',
            'type_contrat' => 'Freelance',
            'tags' => 'Python,Machine Learning,TensorFlow',
            'salaire' => '500',
            'devise' => 'CAD',
            'periode' => '/jour',
            'ville' => 'Montréal',
            'pays' => 'Canada',
            'flag' => '🇨🇦',
            'date_publication' => '2026-06-14'
        ],
        [
            'titre' => 'Développeur Frontend Vue.js',
            'entreprise_nom' => 'Tech Montréal',
            'type_contrat' => 'CDI',
            'tags' => 'Vue.js,JavaScript,CSS',
            'salaire' => '75 000',
            'devise' => 'CAD',
            'periode' => '/an',
            'ville' => 'Toronto',
            'pays' => 'Canada',
            'flag' => '🇨🇦',
            'date_publication' => '2026-06-07'
        ]
    ],
    'CM' => [
        [
            'titre' => 'UX/UI Designer',
            'entreprise_nom' => 'Creative Studio',
            'type_contrat' => 'Stage',
            'tags' => 'Figma,Adobe XD,Prototypage',
            'salaire' => '150 000',
            'devise' => 'FCFA',
            'periode' => '/mois',
            'ville' => 'Douala',
            'pays' => 'Cameroun',
            'flag' => '🇨🇲',
            'date_publication' => '2026-06-13'
        ],
        [
            'titre' => 'Développeur PHP Symfony',
            'entreprise_nom' => 'Cameroun Digital',
            'type_contrat' => 'CDI',
            'tags' => 'PHP,Symfony,MySQL',
            'salaire' => '400 000',
            'devise' => 'FCFA',
            'periode' => '/mois',
            'ville' => 'Yaoundé',
            'pays' => 'Cameroun',
            'flag' => '🇨🇲',
            'date_publication' => '2026-06-06'
        ]
    ],
    'BE' => [
        [
            'titre' => 'Ingénieur DevOps',
            'entreprise_nom' => 'Cloud Systems',
            'type_contrat' => 'CDI',
            'tags' => 'Docker,Kubernetes,AWS',
            'salaire' => '55 000',
            'devise' => '€',
            'periode' => '/an',
            'ville' => 'Bruxelles',
            'pays' => 'Belgique',
            'flag' => '🇧🇪',
            'date_publication' => '2026-06-09'
        ],
        [
            'titre' => 'Business Analyst',
            'entreprise_nom' => 'Consulting Brussels',
            'type_contrat' => 'CDI',
            'tags' => 'Analyse,Agile,SQL',
            'salaire' => '60 000',
            'devise' => '€',
            'periode' => '/an',
            'ville' => 'Anvers',
            'pays' => 'Belgique',
            'flag' => '🇧🇪',
            'date_publication' => '2026-06-05'
        ]
    ],
    'CH' => [
        [
            'titre' => 'Consultant SAP',
            'entreprise_nom' => 'ERP Consulting',
            'type_contrat' => 'CDI',
            'tags' => 'SAP,ABAP,FI/CO',
            'salaire' => '120 000',
            'devise' => 'CHF',
            'periode' => '/an',
            'ville' => 'Genève',
            'pays' => 'Suisse',
            'flag' => '🇨🇭',
            'date_publication' => '2026-06-08'
        ],
        [
            'titre' => 'Développeur Java Senior',
            'entreprise_nom' => 'Swiss Tech',
            'type_contrat' => 'CDI',
            'tags' => 'Java,Spring,Microservices',
            'salaire' => '130 000',
            'devise' => 'CHF',
            'periode' => '/an',
            'ville' => 'Zurich',
            'pays' => 'Suisse',
            'flag' => '🇨🇭',
            'date_publication' => '2026-06-04'
        ]
    ],
    'CI' => [
        [
            'titre' => 'Comptable Senior',
            'entreprise_nom' => 'Finances & Co',
            'type_contrat' => 'CDI',
            'tags' => 'Comptabilité,SAP,Audit',
            'salaire' => '1 200 000',
            'devise' => 'FCFA',
            'periode' => '/mois',
            'ville' => 'Abidjan',
            'pays' => "Côte d'Ivoire",
            'flag' => '🇨🇮',
            'date_publication' => '2026-06-07'
        ],
        [
            'titre' => 'Responsable Commercial',
            'entreprise_nom' => 'CI Business',
            'type_contrat' => 'CDI',
            'tags' => 'Ventes,Négociation,B2B',
            'salaire' => '1 500 000',
            'devise' => 'FCFA',
            'periode' => '/mois',
            'ville' => 'San-Pédro',
            'pays' => "Côte d'Ivoire",
            'flag' => '🇨🇮',
            'date_publication' => '2026-06-03'
        ]
    ],
    'GA' => [
        [
            'titre' => 'Ingénieur Pétrole',
            'entreprise_nom' => 'Gabon Oil',
            'type_contrat' => 'CDI',
            'tags' => 'Pétrole,Géologie,Analyse',
            'salaire' => '2 500 000',
            'devise' => 'FCFA',
            'periode' => '/mois',
            'ville' => 'Libreville',
            'pays' => 'Gabon',
            'flag' => '🇬🇦',
            'date_publication' => '2026-06-02'
        ]
    ],
    'US' => [
        [
            'titre' => 'Software Engineer',
            'entreprise_nom' => 'Tech Giants Inc',
            'type_contrat' => 'CDI',
            'tags' => 'React,Node.js,AWS',
            'salaire' => '120 000',
            'devise' => '$',
            'periode' => '/an',
            'ville' => 'San Francisco',
            'pays' => 'États-Unis',
            'flag' => '🇺🇸',
            'date_publication' => '2026-06-01'
        ]
    ],
    'GB' => [
        [
            'titre' => 'Full Stack Developer',
            'entreprise_nom' => 'London Tech',
            'type_contrat' => 'CDI',
            'tags' => 'React,Python,PostgreSQL',
            'salaire' => '65 000',
            'devise' => '£',
            'periode' => '/an',
            'ville' => 'Londres',
            'pays' => 'Royaume-Uni',
            'flag' => '🇬🇧',
            'date_publication' => '2026-05-30'
        ]
    ]
];

// Aplatir toutes les offres pour l'affichage
$all_demo_jobs = [];
foreach ($demo_jobs_by_country as $country => $jobs) {
    foreach ($jobs as $job) {
        $all_demo_jobs[] = $job;
    }
}

// Filtrer par localisation si un terme est fourni
$filtered_demo = [];
if (!empty($location)) {
    foreach ($all_demo_jobs as $job) {
        $search_lower = strtolower($location);
        if (
            stripos(strtolower($job['ville']), $search_lower) !== false ||
            stripos(strtolower($job['pays']), $search_lower) !== false
        ) {
            $filtered_demo[] = $job;
        }
    }
    $all_demo_jobs = $filtered_demo;
}

// Filtrer par pays si sélectionné
if (!empty($country_filter)) {
    $country_filtered = [];
    foreach ($all_demo_jobs as $job) {
        $country_codes = [
            'France' => 'FR', 'Sénégal' => 'SN', 'Canada' => 'CA', 'Cameroun' => 'CM',
            'Belgique' => 'BE', 'Suisse' => 'CH', "Côte d'Ivoire" => 'CI',
            'Gabon' => 'GA', 'États-Unis' => 'US', 'Royaume-Uni' => 'GB'
        ];
        $job_code = $country_codes[$job['pays']] ?? '';
        if ($job_code === $country_filter) {
            $country_filtered[] = $job;
        }
    }
    $all_demo_jobs = $country_filtered;
}

// Utiliser les résultats de la base de données s'ils existent, sinon utiliser la démo
$display_results = (!empty($results)) ? $results : $all_demo_jobs;
$results_count = count($display_results);

// Liste des pays pour le filtre
$countries = [
    ['code' => 'CM', 'name' => 'Cameroun', 'flag' => '🇨🇲'],
    ['code' => 'SN', 'name' => 'Sénégal', 'flag' => '🇸🇳'],
    ['code' => 'CI', 'name' => "Côte d'Ivoire", 'flag' => '🇨🇮'],
    ['code' => 'GA', 'name' => 'Gabon', 'flag' => '🇬🇦'],
    ['code' => 'FR', 'name' => 'France', 'flag' => '🇫🇷'],
    ['code' => 'CA', 'name' => 'Canada', 'flag' => '🇨🇦'],
    ['code' => 'BE', 'name' => 'Belgique', 'flag' => '🇧🇪'],
    ['code' => 'CH', 'name' => 'Suisse', 'flag' => '🇨🇭'],
    ['code' => 'DE', 'name' => 'Allemagne', 'flag' => '🇩🇪'],
    ['code' => 'GB', 'name' => 'Royaume-Uni', 'flag' => '🇬🇧'],
    ['code' => 'US', 'name' => 'États-Unis', 'flag' => '🇺🇸'],
];

// Grouper les résultats par pays pour l'affichage
$grouped_results = [];
foreach ($display_results as $job) {
    $country = $job['pays'];
    if (!isset($grouped_results[$country])) {
        $grouped_results[$country] = [];
    }
    $grouped_results[$country][] = $job;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobAI - Recherche par localisation <?= !empty($location) ? ' - ' . $location : '' ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --success: #10b981;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: var(--light);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            min-height: 40vh;
            display: flex;
            align-items: center;
            padding: 8rem 5% 3rem;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 800px;
            color: white;
            z-index: 2;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Search Box */
        .search-section {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            padding-bottom: 3rem;
        }

        .search-box {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            max-width: 1000px;
            margin: 0 auto;
        }

        .search-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .form-group input,
        .form-group select {
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: border-color 0.3s;
            background: white;
            width: 100%;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .search-btn {
            padding: 1rem 2rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .search-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Country Cards */
        .countries-section {
            padding: 3rem 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .countries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .country-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: var(--dark);
        }

        .country-card:hover,
        .country-card.active {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
            transform: translateY(-3px);
        }

        .country-card.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-color: var(--primary);
        }

        .country-flag {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .country-name {
            font-weight: 700;
            font-size: 1rem;
        }

        .country-count {
            font-size: 0.85rem;
            opacity: 0.7;
            margin-top: 0.25rem;
        }

        /* Results Section */
        .results-section {
            padding: 0 5% 6rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .results-header h2 {
            font-size: 1.5rem;
            color: var(--dark);
        }

        .results-count {
            color: var(--gray);
            font-size: 0.95rem;
        }

        .results-count strong {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* Country Section Header */
        .country-section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 2rem 0 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .country-section-header h3 {
            font-size: 1.3rem;
            color: var(--dark);
        }

        .country-section-header .flag {
            font-size: 1.8rem;
        }

        /* Job Cards */
        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .job-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
            position: relative;
        }

        .job-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .job-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .job-company {
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .job-type {
            background: #dbeafe;
            color: var(--primary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .job-type.cdi { background: #d1fae5; color: var(--success); }
        .job-type.cdd { background: #fef3c7; color: #d97706; }
        .job-type.stage { background: #ede9fe; color: #7c3aed; }
        .job-type.freelance { background: #fce7f3; color: #db2777; }

        .job-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .job-tag {
            background: #f1f5f9;
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .job-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .job-salary {
            font-weight: 700;
            color: var(--success);
            font-size: 1.1rem;
        }

        .job-location {
            color: var(--gray);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .job-country-flag {
            font-size: 1.3rem;
        }

        .job-date {
            font-size: 0.8rem;
            color: var(--gray);
            margin-top: 0.5rem;
        }

        .job-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        /* Map Section */
        .map-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .map-section h3 {
            margin-bottom: 1.5rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .map-placeholder {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 16px;
            height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            border: 2px dashed #cbd5e1;
        }

        .map-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .no-results i {
            font-size: 4rem;
            color: #e2e8f0;
            margin-bottom: 1rem;
        }

        .no-results h3 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .no-results p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        /* Popular Cities */
        .cities-section {
            margin-top: 2rem;
            padding: 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .cities-section h3 {
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .cities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
        }

        .city-tag {
            padding: 0.75rem 1rem;
            background: #f1f5f9;
            border-radius: 12px;
            color: var(--dark);
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            font-weight: 500;
        }

        .city-tag:hover {
            background: var(--primary);
            color: white;
        }

        .city-tag .city-name {
            display: block;
            font-weight: 600;
        }

        .city-tag .city-count {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 3rem 5% 2rem;
            text-align: center;
        }

        .footer p {
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .search-form {
                grid-template-columns: 1fr;
            }

            .countries-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .jobs-grid {
                grid-template-columns: 1fr;
            }

            .results-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .cities-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="<?php echo route('home'); ?>" class="logo">
            <i class="fas fa-briefcase"></i>
            JobAI
        </a>
        <div class="nav-links">
            <a href="<?php echo route('home'); ?>">Accueil</a>
            <a href="<?php echo route('search.keyword'); ?>">Offres</a>
            <a href="<?php echo route('home'); ?>#comment-ca-marche">Comment ça marche</a>
            <a href="<?php echo route('home'); ?>#contact">Contact</a>
            <a href="<?php echo route('connexion'); ?>" class="btn btn-outline btn-sm">Se connecter</a>
            <a href="<?php echo route('inscrit'); ?>" class="btn btn-primary btn-sm">S'inscrire</a>
        </div>
        <div class="mobile-menu" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1><i class="fas fa-map-marker-alt"></i> Recherche par localisation</h1>
            <p>Trouvez des emplois près de chez vous ou à l'étranger. Explorez les opportunités par ville, région ou pays.</p>
        </div>
    </section>

    <!-- Search Box -->
    <div class="search-section">
        <div class="search-box">
            <form class="search-form" method="GET" action="<?php echo route('search.location'); ?>">
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Localisation</label>
                    <input type="text" 
                           name="location" 
                           placeholder="Ville, région ou pays..." 
                           value="<?= $location ?>"
                           id="search-location"
                           autocomplete="off">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-briefcase"></i> Métier (optionnel)</label>
                    <input type="text" 
                           name="keyword" 
                           placeholder="Ex: Développeur, Marketing..." 
                           id="search-keyword">
                </div>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- Countries Section -->
    <section class="countries-section">
        <div class="results-header">
            <div>
                <h2>
                    <?php if (!empty($location)): ?>
                        Offres à <?= htmlspecialchars($location) ?>
                    <?php else: ?>
                        Explorer par pays
                    <?php endif; ?>
                </h2>
                <p class="results-count">
                    <strong><?= $results_count ?></strong> offre<?= $results_count > 1 ? 's' : '' ?> trouvée<?= $results_count > 1 ? 's' : '' ?>
                </p>
            </div>
            <a href="<?php echo route('search.keyword'); ?>" class="btn btn-outline btn-sm">
                <i class="fas fa-search"></i> Rechercher par métier
            </a>
        </div>

        <!-- Country Filter Cards -->
        <div class="countries-grid">
            <?php foreach ($countries as $country): 
                $is_active = $country_filter === $country['code'];
                $count = 0;
                foreach ($display_results as $job) {
                    if ($job['pays'] === $country['name']) $count++;
                }
            ?>
            <a href="?country=<?= $country['code'] ?>" 
               class="country-card <?= $is_active ? 'active' : '' ?>">
                <span class="country-flag"><?= $country['flag'] ?></span>
                <span class="country-name"><?= $country['name'] ?></span>
                <span class="country-count"><?= $count ?> offre<?= $count > 1 ? 's' : '' ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <?php if ($results_count === 0 && !empty($location)): ?>
            <!-- No Results -->
            <div class="no-results">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Aucune offre trouvée</h3>
                <p>Nous n'avons trouvé aucune offre à "<?= htmlspecialchars($location) ?>". Essayez une autre ville ou pays.</p>
                <a href="<?php echo route('search.location'); ?>" class="btn btn-primary">
                    <i class="fas fa-undo"></i> Voir toutes les localisations
                </a>
            </div>

            <!-- Popular Cities -->
            <div class="cities-section">
                <h3><i class="fas fa-city"></i> Villes populaires</h3>
                <div class="cities-grid">
                    <a href="?location=Paris" class="city-tag">
                        <span class="city-name">🇫🇷 Paris</span>
                        <span class="city-count">3 offres</span>
                    </a>
                    <a href="?location=Dakar" class="city-tag">
                        <span class="city-name">🇸🇳 Dakar</span>
                        <span class="city-count">2 offres</span>
                    </a>
                    <a href="?location=Douala" class="city-tag">
                        <span class="city-name">🇨🇲 Douala</span>
                        <span class="city-count">2 offres</span>
                    </a>
                    <a href="?location=Abidjan" class="city-tag">
                        <span class="city-name">🇨🇮 Abidjan</span>
                        <span class="city-count">2 offres</span>
                    </a>
                    <a href="?location=Montréal" class="city-tag">
                        <span class="city-name">🇨🇦 Montréal</span>
                        <span class="city-count">1 offre</span>
                    </a>
                    <a href="?location=Bruxelles" class="city-tag">
                        <span class="city-name">🇧🇪 Bruxelles</span>
                        <span class="city-count">2 offres</span>
                    </a>
                    <a href="?location=Genève" class="city-tag">
                        <span class="city-name">🇨🇭 Genève</span>
                        <span class="city-count">1 offre</span>
                    </a>
                    <a href="?location=Londres" class="city-tag">
                        <span class="city-name">🇬🇧 Londres</span>
                        <span class="city-count">1 offre</span>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Map Placeholder -->
            <div class="map-section">
                <h3><i class="fas fa-globe-africa"></i> Carte des opportunités</h3>
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <p>Carte interactive des offres d'emploi</p>
                    <small>Intégrez Google Maps ou Leaflet ici</small>
                </div>
            </div>

            <!-- Results Grouped by Country -->
            <div class="results-section">
                <div id="stored-offer-container"></div>
                <?php if (!empty($grouped_results)): ?>
                    <?php foreach ($grouped_results as $country_name => $country_jobs): ?>
                        <div class="country-section-header">
                            <span class="flag"><?= $country_jobs[0]['flag'] ?? '🇫🇷' ?></span>
                            <h3><?= htmlspecialchars($country_name) ?> 
                                <span style="color: var(--gray); font-size: 0.9rem;">(<?= count($country_jobs) ?> offre<?= count($country_jobs) > 1 ? 's' : '' ?>)</span>
                            </h3>
                        </div>

                        <div class="jobs-grid">
                            <?php foreach ($country_jobs as $index => $job): 
                                $type_class = strtolower($job['type_contrat'] ?? 'cdi');
                                $tags = isset($job['tags']) ? explode(',', $job['tags']) : [];
                            ?>
                            <div class="job-card fade-in">
                                <div class="job-header">
                                    <div>
                                        <div class="job-title"><?= htmlspecialchars($job['titre']) ?></div>
                                        <div class="job-company">
                                            <i class="fas fa-building"></i> 
                                            <?= htmlspecialchars($job['entreprise_nom'] ?? 'Entreprise') ?>
                                        </div>
                                    </div>
                                    <span class="job-type <?= $type_class ?>"><?= htmlspecialchars($job['type_contrat'] ?? 'CDI') ?></span>
                                </div>
                                <div class="job-tags">
                                    <?php foreach ($tags as $tag): ?>
                                        <span class="job-tag"><?= htmlspecialchars(trim($tag)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="job-footer">
                                    <span class="job-salary">
                                        <?= htmlspecialchars($job['salaire'] ?? '') ?> 
                                        <?= htmlspecialchars($job['devise'] ?? '€') ?>
                                        <?= htmlspecialchars($job['periode'] ?? '/an') ?>
                                    </span>
                                    <span class="job-location">
                                        <span class="job-country-flag"><?= $job['flag'] ?? '🇫🇷' ?></span>
                                        <?= htmlspecialchars($job['ville'] ?? '') ?>, 
                                        <?= htmlspecialchars($job['pays'] ?? '') ?>
                                    </span>
                                </div>
                                <div class="job-date">
                                    <i class="far fa-clock"></i> Publié le <?= $job['date_publication'] ?? date('Y-m-d') ?>
                                </div>
                                <div class="job-actions">
                                    <a href="/offre-detail.php?id=<?= $index + 1 ?>" class="btn btn-primary btn-sm" style="flex: 1; text-align: center;">
                                        <i class="fas fa-eye"></i> Voir l'offre
                                    </a>
                                    <a href="/postuler.php?id=<?= $index + 1 ?>" class="btn btn-outline btn-sm" style="flex: 1; text-align: center;">
                                        <i class="fas fa-paper-plane"></i> Postuler
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Popular Cities when no country filter -->
                    <div class="cities-section">
                        <h3><i class="fas fa-city"></i> Villes populaires</h3>
                        <div class="cities-grid">
                            <a href="?location=Paris" class="city-tag">
                                <span class="city-name">🇫🇷 Paris</span>
                                <span class="city-count">3 offres</span>
                            </a>
                            <a href="?location=Dakar" class="city-tag">
                                <span class="city-name">🇸🇳 Dakar</span>
                                <span class="city-count">2 offres</span>
                            </a>
                            <a href="?location=Douala" class="city-tag">
                                <span class="city-name">🇨🇲 Douala</span>
                                <span class="city-count">2 offres</span>
                            </a>
                            <a href="?location=Abidjan" class="city-tag">
                                <span class="city-name">🇨🇮 Abidjan</span>
                                <span class="city-count">2 offres</span>
                            </a>
                            <a href="?location=Montréal" class="city-tag">
                                <span class="city-name">🇨🇦 Montréal</span>
                                <span class="city-count">1 offre</span>
                            </a>
                            <a href="?location=Bruxelles" class="city-tag">
                                <span class="city-name">🇧🇪 Bruxelles</span>
                                <span class="city-count">2 offres</span>
                            </a>
                            <a href="?location=Genève" class="city-tag">
                                <span class="city-name">🇨🇭 Genève</span>
                                <span class="city-count">1 offre</span>
                            </a>
                            <a href="?location=Londres" class="city-tag">
                                <span class="city-name">🇬🇧 Londres</span>
                                <span class="city-count">1 offre</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 JobAI. Tous droits réservés.</p>
    </footer>

    <script>
        // Menu mobile
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            if (navLinks.style.display === 'flex') {
                navLinks.style.display = 'none';
            } else {
                navLinks.style.display = 'flex';
                navLinks.style.position = 'absolute';
                navLinks.style.top = '100%';
                navLinks.style.left = '0';
                navLinks.style.right = '0';
                navLinks.style.background = 'white';
                navLinks.style.flexDirection = 'column';
                navLinks.style.padding = '1rem';
                navLinks.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            }
        }

        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        function renderStoredOffer() {
            const stored = localStorage.getItem('jobai_last_offer');
            if (!stored) return;

            const offer = JSON.parse(stored);
            if (!offer || !offer.titre) return;

            const container = document.getElementById('stored-offer-container');
            if (!container) return;

            const existingTitle = document.querySelectorAll('.job-title');
            if (Array.from(existingTitle).some(el => el.textContent.trim() === offer.titre.trim())) return;

            const jobCard = document.createElement('div');
            jobCard.className = 'job-card fade-in';
            jobCard.innerHTML = `
                <div class="job-header">
                    <div>
                        <div class="job-title">${offer.titre}</div>
                        <div class="job-company"><i class="fas fa-building"></i> ${offer.entreprise_nom}</div>
                    </div>
                    <span class="job-type ${offer.type_contrat ? offer.type_contrat.toLowerCase() : 'cdi'}">${offer.type_contrat || 'CDI'}</span>
                </div>
                <div class="job-tags">
                    ${offer.tags.split(',').map(tag => `<span class="job-tag">${tag.trim()}</span>`).join('')}
                </div>
                <div class="job-footer">
                    <span class="job-salary">${offer.salaire || ''} ${offer.devise || '€'} ${offer.periode || '/mois'}</span>
                    <span class="job-location"><span class="job-country-flag">${offer.flag || '🇫🇷'}</span> ${offer.ville || ''}${offer.pays ? ', ' + offer.pays : ''}</span>
                </div>
                <div class="job-date"><i class="far fa-clock"></i> Publié le ${offer.date_publication || new Date().toISOString().split('T')[0]}</div>
                <div class="job-actions">
                    <a href="/offre-detail.php?id=last" class="btn btn-primary btn-sm" style="flex: 1; text-align: center;"><i class="fas fa-eye"></i> Voir l'offre</a>
                    <a href="/postuler.php?id=last" class="btn btn-outline btn-sm" style="flex: 1; text-align: center;"><i class="fas fa-paper-plane"></i> Postuler</a>
                </div>
            `;

            container.appendChild(jobCard);
        }

        renderStoredOffer();
    </script>

</body>
</html>