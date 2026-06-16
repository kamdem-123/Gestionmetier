<?php
/**
 * JobAI - Page de recherche par métier
 * Recherche d'offres d'emploi par mot-clé métier
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

// Récupération du mot-clé de recherche
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');

$results = [];
$results_count = 0;

// Si un mot-clé est fourni, effectuer la recherche
if (!empty($keyword) && isset($pdo)) {
    try {
        $search_term = "%$keyword%";
        $stmt = $pdo->prepare("
            SELECT o.*, e.nom as entreprise_nom, e.logo as entreprise_logo 
            FROM offres o 
            LEFT JOIN entreprises e ON o.entreprise_id = e.id 
            WHERE o.titre LIKE :keyword 
               OR o.description LIKE :keyword 
               OR o.tags LIKE :keyword 
               OR o.categorie LIKE :keyword
            ORDER BY o.date_publication DESC
        ");
        $stmt->execute([':keyword' => $search_term]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results_count = count($results);
    } catch (PDOException $e) {
        $search_error = "Erreur lors de la recherche.";
    }
}

// Données de démonstration si pas de base de données
$demo_jobs = [
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
        'titre' => 'Data Scientist',
        'entreprise_nom' => 'AI Innovations',
        'type_contrat' => 'Freelance',
        'tags' => 'Python,Machine Learning,TensorFlow',
        'salaire' => '500',
        'devise' => '€',
        'periode' => '/jour',
        'ville' => 'Montréal',
        'pays' => 'Canada',
        'flag' => '🇨🇦',
        'date_publication' => '2026-06-14'
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
        'titre' => 'UX/UI Designer',
        'entreprise_nom' => 'Creative Studio',
        'type_contrat' => 'Stage',
        'tags' => 'Figma,Adobe XD,Prototypage',
        'salaire' => '800',
        'devise' => '€',
        'periode' => '/mois',
        'ville' => 'Douala',
        'pays' => 'Cameroun',
        'flag' => '🇨🇲',
        'date_publication' => '2026-06-13'
    ],
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
        'titre' => 'Consultant SAP',
        'entreprise_nom' => 'ERP Consulting',
        'type_contrat' => 'CDI',
        'tags' => 'SAP,ABAP,FI/CO',
        'salaire' => '70 000',
        'devise' => 'CHF',
        'periode' => '/an',
        'ville' => 'Genève',
        'pays' => 'Suisse',
        'flag' => '🇨🇭',
        'date_publication' => '2026-06-08'
    ],
    [
        'titre' => 'Comptable Senior',
        'entreprise_nom' => 'Finances & Co',
        'type_contrat' => 'CDI',
        'tags' => 'Comptabilité,SAP,Audit',
        'salaire' => '1 800',
        'devise' => '€',
        'periode' => '/mois',
        'ville' => 'Abidjan',
        'pays' => "Côte d'Ivoire",
        'flag' => '🇨🇮',
        'date_publication' => '2026-06-07'
    ]
];

// Filtrer les résultats de démo si un mot-clé est fourni
$filtered_demo = [];
if (!empty($keyword)) {
    foreach ($demo_jobs as $job) {
        $search_lower = strtolower($keyword);
        if (
            stripos(strtolower($job['titre']), $search_lower) !== false ||
            stripos(strtolower($job['tags']), $search_lower) !== false ||
            stripos(strtolower($job['entreprise_nom']), $search_lower) !== false
        ) {
            $filtered_demo[] = $job;
        }
    }
    $demo_jobs = $filtered_demo;
}

// Utiliser les résultats de la base de données s'ils existent, sinon utiliser la démo
$display_results = (!empty($results)) ? $results : $demo_jobs;
if (!empty($results)) {
    $results_count = count($results);
} else {
    $results_count = count($demo_jobs);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobAI - Recherche par métier <?= !empty($keyword) ? ' - ' . $keyword : '' ?></title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        /* Results Section */
        .results-section {
            padding: 3rem 5% 6rem;
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

        /* Filters Bar */
        .filters-bar {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-chip {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: 2px solid #e2e8f0;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
            color: var(--dark);
        }

        .filter-chip:hover,
        .filter-chip.active {
            border-color: var(--primary);
            background: #eef2ff;
            color: var(--primary);
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

        .job-card.featured {
            border: 2px solid var(--primary);
        }

        .job-card.featured::before {
            content: 'À la une';
            position: absolute;
            top: -1px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0 0 8px 8px;
            font-size: 0.75rem;
            font-weight: 600;
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

        /* Suggestions */
        .suggestions {
            margin-top: 2rem;
            padding: 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .suggestions h3 {
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .suggestion-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .suggestion-tag {
            padding: 0.5rem 1rem;
            background: #f1f5f9;
            border-radius: 50px;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .suggestion-tag:hover {
            background: var(--primary);
            color: white;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }

        .page-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
        }

        .page-btn:hover,
        .page-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
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

            .jobs-grid {
                grid-template-columns: 1fr;
            }

            .results-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filters-bar {
                overflow-x: auto;
                flex-wrap: nowrap;
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
            <h1><i class="fas fa-search"></i> Recherche par métier</h1>
            <p>Trouvez l'emploi de vos rêves parmi des milliers d'offres disponibles sur JobAI.</p>
        </div>
    </section>

    <!-- Search Box -->
    <div class="search-section">
        <div class="search-box">
            <form class="search-form" method="GET" action="<?php echo route('search.keyword'); ?>">
                <div class="form-group">
                    <label><i class="fas fa-search"></i> Métier recherché</label>
                    <input type="text" 
                           name="keyword" 
                           placeholder="Ex: Développeur, Marketing, Comptable..." 
                           value="<?= $keyword ?>"
                           id="search-keyword"
                           autocomplete="off">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Localisation</label>
                    <input type="text" 
                           name="location" 
                           placeholder="Ville ou pays (optionnel)" 
                           id="search-location">
                </div>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <section class="results-section">
        <div class="results-header">
            <div>
                <h2>
                    <?php if (!empty($keyword)): ?>
                        Résultats pour "<?= $keyword ?>"
                    <?php else: ?>
                        Toutes les offres d'emploi
                    <?php endif; ?>
                </h2>
                <p class="results-count">
                    <strong><?= $results_count ?></strong> offre<?= $results_count > 1 ? 's' : '' ?> trouvée<?= $results_count > 1 ? 's' : '' ?>
                </p>
            </div>
            <a href="/recherche-localisation.php" class="btn btn-outline btn-sm">
                <i class="fas fa-map-marker-alt"></i> Rechercher par localisation
            </a>
        </div>

        <!-- Filters -->
        <div class="filters-bar">
            <span style="font-weight: 600; color: var(--dark);"><i class="fas fa-filter"></i> Filtrer :</span>
            <button class="filter-chip active">Tous</button>
            <button class="filter-chip">CDI</button>
            <button class="filter-chip">CDD</button>
            <button class="filter-chip">Stage</button>
            <button class="filter-chip">Freelance</button>
            <button class="filter-chip">Temps plein</button>
            <button class="filter-chip">Temps partiel</button>
        </div>

        <?php if ($results_count === 0 && !empty($keyword)): ?>
            <!-- No Results -->
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>Aucune offre trouvée</h3>
                <p>Nous n'avons trouvé aucune offre correspondant à "<?= $keyword ?>". Essayez avec d'autres termes.</p>
                <a href="<?php echo route('search.keyword'); ?>" class="btn btn-primary">
                    <i class="fas fa-undo"></i> Voir toutes les offres
                </a>
            </div>

            <!-- Suggestions -->
            <div class="suggestions">
                <h3><i class="fas fa-lightbulb"></i> Métiers populaires</h3>
                <div class="suggestion-tags">
                    <a href="?keyword=Développeur" class="suggestion-tag">Développeur</a>
                    <a href="?keyword=Marketing" class="suggestion-tag">Marketing</a>
                    <a href="?keyword=Data" class="suggestion-tag">Data</a>
                    <a href="?keyword=Design" class="suggestion-tag">Design</a>
                    <a href="?keyword=Comptable" class="suggestion-tag">Comptable</a>
                    <a href="?keyword=RH" class="suggestion-tag">RH</a>
                    <a href="?keyword=DevOps" class="suggestion-tag">DevOps</a>
                    <a href="?keyword=Flutter" class="suggestion-tag">Flutter</a>
                    <a href="?keyword=Python" class="suggestion-tag">Python</a>
                    <a href="?keyword=SAP" class="suggestion-tag">SAP</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Jobs Grid -->
            <div class="jobs-grid" id="jobs-container">
                <?php foreach ($display_results as $index => $job): 
                    $type_class = strtolower($job['type_contrat'] ?? 'cdi');
                    $tags = isset($job['tags']) ? explode(',', $job['tags']) : [];
                    $is_featured = $index < 2;
                ?>
                <div class="job-card fade-in <?= $is_featured ? 'featured' : '' ?>">
                    <div class="job-header">
                        <div>
                            <div class="job-title"><?= htmlspecialchars($job['titre'] ?? $job['titre']) ?></div>
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

            <!-- Pagination -->
            <div class="pagination">
                <a href="#" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <span style="padding: 0.5rem;">...</span>
                <a href="#" class="page-btn">10</a>
                <a href="#" class="page-btn"><i class="fas fa-chevron-right"></i></a>
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

        // Filtres interactifs
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Afficher l'offre récemment publiée en localStorage
        function renderStoredOffer() {
            const stored = localStorage.getItem('jobai_last_offer');
            if (!stored) return;

            const offer = JSON.parse(stored);
            if (!offer || !offer.titre) return;

            const jobsContainer = document.getElementById('jobs-container');
            if (!jobsContainer) return;

            const existing = Array.from(jobsContainer.querySelectorAll('.job-title')).some(el => el.textContent.trim() === offer.titre.trim());
            if (existing) return;

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

            jobsContainer.insertAdjacentElement('afterbegin', jobCard);

            const countEl = document.querySelector('.results-count strong');
            const countText = document.querySelector('.results-count');
            if (countEl && countText) {
                const newCount = parseInt(countEl.textContent, 10) + 1;
                countEl.textContent = newCount;
                countText.innerHTML = `<strong>${newCount}</strong> offre${newCount > 1 ? 's' : ''} trouvée${newCount > 1 ? 's' : ''}`;
            }
        }

        renderStoredOffer();
    </script>

</body>
</html>