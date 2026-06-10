<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobAI - Trouvez le métier de vos rêves</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --success: #10b981;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
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

        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8rem 5% 5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-30px, -30px) rotate(180deg); }
        }

        .hero-content {
            max-width: 600px;
            color: white;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 3rem;
            animation: fadeInUp 1s ease 0.6s both;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Search Box */
        .search-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding-bottom: 4rem;
        }

        .search-box {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            position: relative;
            z-index: 10;
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
        }

        .search-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Features Section */
        .features {
            padding: 6rem 5%;
            background: var(--light);
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .section-header p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid #e2e8f0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            color: white;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--gray);
        }

        /* How It Works */
        .how-it-works {
            padding: 6rem 5%;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
        }

        .step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 auto 1.5rem;
            position: relative;
            z-index: 2;
        }

        .step h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .step p {
            color: var(--gray);
        }

        /* Jobs Section */
        .jobs {
            padding: 6rem 5%;
            background: var(--light);
        }

        .jobs-filter {
            max-width: 1200px;
            margin: 0 auto 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-group label {
            font-weight: 600;
            color: var(--dark);
            white-space: nowrap;
        }

        .filter-group select {
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            min-width: 220px;
            cursor: pointer;
            background: white;
        }

        .filter-group select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .currency-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
        }

        .currency-badge i {
            font-size: 1.2rem;
        }

        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .job-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
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
        }

        .job-type {
            background: #dbeafe;
            color: var(--primary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .job-company {
            color: var(--gray);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

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

        /* CTA Section */
        .cta {
            padding: 6rem 5%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            text-align: center;
            color: white;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn-white {
            background: white;
            color: var(--primary);
        }

        .btn-white:hover {
            background: var(--light);
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 4rem 5% 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto 3rem;
        }

        .footer-section h4 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .footer-section p {
            color: #94a3b8;
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        .footer-section a {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            margin-bottom: 0.75rem;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #334155;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #334155;
            color: #94a3b8;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
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
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-stats {
                gap: 1.5rem;
            }

            .search-form {
                grid-template-columns: 1fr;
            }

            .features-grid,
            .jobs-grid {
                grid-template-columns: 1fr;
            }

            .jobs-filter {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
            }

            .filter-group select {
                width: 100%;
            }

            .cta h2 {
                font-size: 1.8rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="#" class="logo">
            <i class="fas fa-briefcase"></i>
            JobAI
        </a>
        <div class="nav-links">
            <a href="#accueil">Accueil</a>
            <a href="#offres">Offres</a>
            <a href="#comment-ca-marche">Comment ça marche</a>
            <a href="#contact">Contact</a>
            <a href="/connexion" class="btn btn-outline">Se connecter</a>
            <a href="/inscrit" class="btn btn-primary">S'inscrire</a>
        </div>
        <div class="mobile-menu" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <div class="hero-content">
            <h1>Trouvez le métier qui vous correspond grâce à l'IA</h1>
            <p>Notre intelligence artificielle analyse votre profil et vous propose les meilleures opportunités professionnelles adaptées à vos compétences.</p>
            <div class="hero-buttons">
                <a href="/register" class="btn btn-primary">
                    <i class="fas fa-rocket"></i> Commencer gratuitement
                </a>
                <a href="#comment-ca-marche" class="btn btn-outline" style="color: white; border-color: white;">
                    <i class="fas fa-play-circle"></i> Voir comment ça marche
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-number" id="stat-offres">10,000+</span>
                    <span class="stat-label">Offres disponibles</span>
                </div>
                <div class="stat">
                    <span class="stat-number" id="stat-candidats">5,000+</span>
                    <span class="stat-label">Candidats placés</span>
                </div>
                <div class="stat">
                    <span class="stat-number" id="stat-entreprises">500+</span>
                    <span class="stat-label">Entreprises partenaires</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Box -->
    <div class="search-section">
        <div class="search-box">
            <form class="search-form" onsubmit="return searchJobs(event)">
                <div class="form-group">
                    <label><i class="fas fa-search"></i> Métier recherché</label>
                    <input type="text" placeholder="Ex: Développeur, Marketing..." id="search-keyword">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Localisation</label>
                    <input type="text" placeholder="Ville ou région" id="search-location">
                </div>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features">
        <div class="section-header fade-in">
            <h2>Pourquoi choisir JobAI ?</h2>
            <p>Notre technologie d'intelligence artificielle révolutionne la recherche d'emploi</p>
        </div>
        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3>Matching Intelligent</h3>
                <p>Notre IA analyse votre profil, vos compétences et vos préférences pour trouver les offres parfaitement adaptées à votre parcours.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Recherche Rapide</h3>
                <p>Recevez des suggestions personnalisées en quelques secondes. Plus besoin de parcourir des milliers d'annonces inutiles.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>100% Gratuit</h3>
                <p>Inscription et utilisation totalement gratuites pour les candidats. Trouvez votre emploi idéal sans dépenser un centime.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Suivi en Temps Réel</h3>
                <p>Suivez l'avancement de vos candidatures et recevez des notifications instantanées dès qu'un employeur vous contacte.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Réseau Professionnel</h3>
                <p>Connectez-vous avec des professionnels de votre secteur et développez votre réseau pour accéder à plus d'opportunités.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Accessible Partout</h3>
                <p>Application responsive accessible sur tous vos appareils. Postulez à vos offres préférées depuis votre smartphone.</p>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="comment-ca-marche">
        <div class="section-header fade-in">
            <h2>Comment ça marche ?</h2>
            <p>Trois étapes simples pour trouver votre prochain emploi</p>
        </div>
        <div class="steps">
            <div class="step fade-in">
                <div class="step-number">1</div>
                <h3>Créez votre profil</h3>
                <p>Inscrivez-vous gratuitement et complétez votre profil avec vos compétences, expériences et aspirations professionnelles.</p>
            </div>
            <div class="step fade-in">
                <div class="step-number">2</div>
                <h3>Laissez l'IA travailler</h3>
                <p>Notre algorithme analyse votre profil et compare avec des milliers d'offres pour trouver les meilleures correspondances.</p>
            </div>
            <div class="step fade-in">
                <div class="step-number">3</div>
                <h3>Postulez en un clic</h3>
                <p>Recevez des suggestions personnalisées et postulez directement aux offres qui vous intéressent le plus.</p>
            </div>
        </div>
    </section>

    <!-- Latest Jobs -->
    <section class="jobs" id="offres">
        <div class="section-header fade-in">
            <h2>Dernières offres d'emploi</h2>
            <p>Découvrez les opportunités les plus récentes ajoutées sur notre plateforme</p>
        </div>

        <!-- Filtre par pays avec devises - CORRIGÉ -->
        <div class="jobs-filter fade-in">
            <div class="filter-group">
                <label for="country-select"><i class="fas fa-globe"></i> Pays :</label>
                <select id="country-select" onchange="updateCountryDisplay()">
                    <option value="CM" data-currency="XAF" data-symbol="FCFA" data-flag="🇨🇲" data-name="Cameroun">🇨🇲 Cameroun</option>
                    <option value="SN" data-currency="XOF" data-symbol="FCFA" data-flag="🇸🇳" data-name="Sénégal">🇸🇳 Sénégal</option>
                    <option value="CI" data-currency="XOF" data-symbol="FCFA" data-flag="🇨🇮" data-name="Côte d'Ivoire">🇨🇮 Côte d'Ivoire</option>
                    <option value="GA" data-currency="XAF" data-symbol="FCFA" data-flag="🇬🇦" data-name="Gabon">🇬🇦 Gabon</option>
                    <option value="GH" data-currency="GHS" data-symbol="GH₵" data-flag="🇬🇭" data-name="Ghana">🇬🇭 Ghana</option>
                    <option value="NG" data-currency="NGN" data-symbol="₦" data-flag="🇳🇬" data-name="Nigéria">🇳🇬 Nigéria</option>
                    <option value="FR" data-currency="EUR" data-symbol="€" data-flag="🇫🇷" data-name="France">🇫🇷 France</option>
                    <option value="CA" data-currency="CAD" data-symbol="$" data-flag="🇨🇦" data-name="Canada">🇨🇦 Canada</option>
                    <option value="BE" data-currency="EUR" data-symbol="€" data-flag="🇧🇪" data-name="Belgique">🇧🇪 Belgique</option>
                    <option value="CH" data-currency="CHF" data-symbol="CHF" data-flag="🇨🇭" data-name="Suisse">🇨🇭 Suisse</option>
                    <option value="LU" data-currency="EUR" data-symbol="€" data-flag="🇱🇺" data-name="Luxembourg">🇱🇺 Luxembourg</option>
                    <option value="DE" data-currency="EUR" data-symbol="€" data-flag="🇩🇪" data-name="Allemagne">🇩🇪 Allemagne</option>
                    <option value="GB" data-currency="GBP" data-symbol="£" data-flag="🇬🇧" data-name="Royaume-Uni">🇬🇧 Royaume-Uni</option>
                    <option value="US" data-currency="USD" data-symbol="$" data-flag="🇺🇸" data-name="États-Unis">🇺🇸 États-Unis</option>
                    <option value="CG" data-currency="XAF" data-symbol="FCFA" data-flag="🇨🇬" data-name="Congo">🇨🇬 Congo</option>
                    <option value="TG" data-currency="XOF" data-symbol="FCFA" data-flag="🇹🇬" data-name="Togo">🇹🇬 Togo</option>
                    <option value="BJ" data-currency="XOF" data-symbol="FCFA" data-flag="🇧🇯" data-name="Bénin">🇧🇯 Bénin</option>
                    <option value="BF" data-currency="XOF" data-symbol="FCFA" data-flag="🇧🇫" data-name="Burkina Faso">🇧🇫 Burkina Faso</option>
                    <option value="ML" data-currency="XOF" data-symbol="FCFA" data-flag="🇲🇱" data-name="Mali">🇲🇱 Mali</option>
                    <option value="NE" data-currency="XOF" data-symbol="FCFA" data-flag="🇳🇪" data-name="Niger">🇳🇪 Niger</option>
                    <option value="GQ" data-currency="XAF" data-symbol="FCFA" data-flag="🇬🇶" data-name="Guinée Éq.">🇬🇶 Guinée Équatoriale</option>
                    <option value="TD" data-currency="XAF" data-symbol="FCFA" data-flag="🇹🇩" data-name="Tchad">🇹🇩 Tchad</option>
                    <option value="CF" data-currency="XAF" data-symbol="FCFA" data-flag="🇨🇫" data-name="Centrafrique">🇨🇫 Centrafrique</option>
                    <option value="MA" data-currency="MAD" data-symbol="DH" data-flag="🇲🇦" data-name="Maroc">🇲🇦 Maroc</option>
                    <option value="TN" data-currency="TND" data-symbol="DT" data-flag="🇹🇳" data-name="Tunisie">🇹🇳 Tunisie</option>
                    <option value="DZ" data-currency="DZD" data-symbol="DA" data-flag="🇩🇿" data-name="Algérie">🇩🇿 Algérie</option>
                    <option value="RW" data-currency="RWF" data-symbol="FR" data-flag="🇷🇼" data-name="Rwanda">🇷🇼 Rwanda</option>
                    <option value="KE" data-currency="KES" data-symbol="KSh" data-flag="🇰🇪" data-name="Kenya">🇰🇪 Kenya</option>
                </select>
            </div>
            <div class="currency-badge" id="currency-display">
                <i class="fas fa-coins"></i>
                <span id="current-currency">FCFA (XAF)</span>
            </div>
        </div>

        <div class="jobs-grid" id="jobs-container">
            <!-- Les offres avec data-salary pour conversion -->
            <div class="job-card fade-in" data-salary-eur="943.15" data-salary-type="year">
                <div class="job-header">
                    <div>
                        <div class="job-title">Développeur Full Stack</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> TechCorp Solutions
                        </div>
                    </div>
                    <span class="job-type">CDI</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">React</span>
                    <span class="job-tag">Laravel</span>
                    <span class="job-tag">MySQL</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="943.15">943.15 €/an</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇫🇷</span> 
                        <span class="job-country-name">Paris, France</span>
                    </span>
                </div>
            </div>

            <div class="job-card fade-in" data-salary-eur="943.15" data-salary-type="year">
                <div class="job-header">
                    <div>
                        <div class="job-title">Chef de Projet Marketing</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> Digital Agency
                        </div>
                    </div>
                    <span class="job-type">CDD</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">SEO</span>
                    <span class="job-tag">Google Ads</span>
                    <span class="job-tag">Analytics</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="943.15">943.15€/an</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇫🇷</span> 
                        <span class="job-country-name">Lyon, France</span>
                    </span>
                </div>
            </div>

            <div class="job-card fade-in" data-salary-eur="10,908.00" data-salary-type="day">
                <div class="job-header">
                    <div>
                        <div class="job-title">Data Scientist</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> AI Innovations
                        </div>
                    </div>
                    <span class="job-type">Freelance</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">Python</span>
                    <span class="job-tag">Machine Learning</span>
                    <span class="job-tag">TensorFlow</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="10,908.00">10,908.00 €/jour</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇨🇦</span> 
                        <span class="job-country-name">Montréal, Canada</span>
                    </span>
                </div>
            </div>

            <div class="job-card fade-in" data-salary-eur="10,908.00" data-salary-type="month">
                <div class="job-header">
                    <div>
                        <div class="job-title">UX/UI Designer</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> Creative Studio
                        </div>
                    </div>
                    <span class="job-type">Stage</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">Figma</span>
                    <span class="job-tag">Adobe XD</span>
                    <span class="job-tag">Prototypage</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="10,908.00">10,908.00 €/mois</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇨🇲</span> 
                        <span class="job-country-name">Douala, Cameroun</span>
                    </span>
                </div>
            </div>

            <div class="job-card fade-in" data-salary-eur="943.1 " data-salary-type="year">
                <div class="job-header">
                    <div>
                        <div class="job-title">Ingénieur DevOps</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> Cloud Systems
                        </div>
                    </div>
                    <span class="job-type">CDI</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">Docker</span>
                    <span class="job-tag">Kubernetes</span>
                    <span class="job-tag">AWS</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="943.1 ">943.1 €/an</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇧🇪</span> 
                        <span class="job-country-name">Bruxelles, Belgique</span>
                    </span>
                </div>
            </div>

            <div class="job-card fade-in" data-salary-eur="943.1 " data-salary-type="year">
                <div class="job-header">
                    <div>
                        <div class="job-title">Consultant SAP</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> ERP Consulting
                        </div>
                    </div>
                    <span class="job-type">CDI</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">SAP</span>
                    <span class="job-tag">ABAP</span>
                    <span class="job-tag">FI/CO</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="943.1 ">943.1  €/an</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇨🇭</span> 
                        <span class="job-country-name">Genève, Suisse</span>
                    </span>
                </div>
            </div>

            <div class="job-card fade-in" data-salary-eur="2500" data-salary-type="month">
                <div class="job-header">
                    <div>
                        <div class="job-title">Développeur Mobile Flutter</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> Savtontine Tech
                        </div>
                    </div>
                    <span class="job-type">CDI</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">Flutter</span>
                    <span class="job-tag">Dart</span>
                    <span class="job-tag">Firebase</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="2500">2 500 €/mois</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇸🇳</span> 
                        <span class="job-country-name">Dakar, Sénégal</span>
                    </span>
                </div>
            </div>

            <div class="job-card fade-in" data-salary-eur="1800" data-salary-type="month">
                <div class="job-header">
                    <div>
                        <div class="job-title">Comptable Senior</div>
                        <div class="job-company">
                            <i class="fas fa-building"></i> Finances & Co
                        </div>
                    </div>
                    <span class="job-type">CDI</span>
                </div>
                <div class="job-tags">
                    <span class="job-tag">Comptabilité</span>
                    <span class="job-tag">SAP</span>
                    <span class="job-tag">Audit</span>
                </div>
                <div class="job-footer">
                    <span class="job-salary" data-base-salary="1800">1 800 €/mois</span>
                    <span class="job-location">
                        <span class="job-country-flag">🇨🇮</span> 
                        <span class="job-country-name">Abidjan, Côte d'Ivoire</span>
                    </span>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 3rem;">
            <a href="/offres" class="btn btn-primary">
                <i class="fas fa-list"></i> Voir toutes les offres
            </a>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <h2 class="fade-in">Prêt à trouver votre emploi idéal ?</h2>
        <p class="fade-in">Rejoignez plus de 5 000 candidats qui ont déjà trouvé leur bonheur grâce à JobAI</p>
        <div class="cta-buttons fade-in">
            <a href="/inscrit" class="btn btn-white">
                <i class="fas fa-user-plus"></i> Créer un compte candidat
            </a>
            <a href="/register?type=employeur" class="btn btn-outline" style="color: white; border-color: white;">
                <i class="fas fa-building"></i> Publier une offre
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-grid">
            <div class="footer-section">
                <h4><i class="fas fa-briefcase"></i> JobAI</h4>
                <p>
                    La plateforme de placement intelligente qui connecte les talents avec les meilleures opportunités professionnelles.
                </p>
                <div class="social-links">
                    <a href="https://m.facebook.com/DeviaTechnology/" target="_blank" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/%20Borice%20Kamdem?_l=en_US" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/kamdemborice" target="_blank" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="mailto:kamdemborice@gmail.com" title="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Candidats</h4>
                <a href="/offres">Rechercher un emploi</a>
                <a href="/inscrit">Créer un profil</a>
                <a href="/matching">Matching IA</a>
                <a href="/conseils">Conseils carrière</a>
            </div>
            <div class="footer-section">
                <h4>Employeurs</h4>
                <a href="/register?type=employeur">Publier une offre</a>
                <a href="/tarifs">Nos tarifs</a>
                <a href="/cvtheque">CVthèque</a>
                <a href="/solutions">Solutions RH</a>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p><i class="fas fa-user"></i> <strong>Borice Kamdem</strong></p>
                <a href="mailto:kamdemborice@gmail.com">
                    <i class="fas fa-envelope"></i> kamdemborice@gmail.com
                </a>
                <a href="tel:+237673430541">
                    <i class="fas fa-phone"></i> +237 673 430 541
                </a>
                <p style="margin-top: 0.5rem;">
                    <i class="fas fa-map-marker-alt"></i> Logpom - Douala, Cameroun
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 JobAI. Tous droits réservés. | <a href="/confidentialite" style="display: inline; color: #94a3b8;">Politique de confidentialité</a> | <a href="/cgv" style="display: inline; color: #94a3b8;">CGV</a></p>
        </div>
    </footer>

    <script>
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

        // Animation des nombres
        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            const range = end - start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            let current = start;
            
            const timer = setInterval(() => {
                current += increment * Math.ceil(range / 100);
                if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                    current = end;
                    clearInterval(timer);
                }
                obj.textContent = current.toLocaleString() + (id === 'stat-offres' ? '+' : '+');
            }, stepTime);
        }

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateValue('stat-offres', 0, 10000, 2000);
                    animateValue('stat-candidats', 0, 5000, 2000);
                    animateValue('stat-entreprises', 0, 500, 2000);
                    statsObserver.unobserve(entry.target);
                }
            });
        });

        const statsSection = document.querySelector('.hero-stats');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }

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

        // Recherche d'emploi
        function searchJobs(event) {
            event.preventDefault();
            const keyword = document.getElementById('search-keyword').value;
            const location = document.getElementById('search-location').value;
            window.location.href = `/offres?keyword=${encodeURIComponent(keyword)}&location=${encodeURIComponent(location)}`;
        }

        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar transparente au scroll
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
            }
            
            lastScroll = currentScroll;
        });

        // ============================================================
        // SYSTÈME DE DEVISES ET PAYS - CORRIGÉ ET COMPLÉT
        // ============================================================

        const exchangeRates = {
            'EUR': 1,
            'XAF': 655.957, 
            'XOF': 655.957,
            'CAD': 1.47,
            'CHF': 0.94,
            'MAD': 10.8,
            'TND': 3.3,
            'DZD': 145,
            'GBP': 0.85,
            'USD': 1.08,
            'GHS': 15.5,      // Cedi ghanéen
            'NGN': 1650,      // Naira nigérian
            'RWF': 1400,      // Franc rwandais
            'KES': 140        // Shilling kenyan
        };

        const salaryPeriods = {
            'year': '/an',
            'month': '/mois',
            'day': '/jour'
        };

        // Villes par pays pour l'affichage dynamique
        const citiesByCountry = {
            'CM': ['Douala', 'Yaoundé', 'Bafoussam'],
            'SN': ['Dakar', 'Thiès', 'Saint-Louis'],
            'CI': ['Abidjan', 'Bouaké', 'San-Pédro'],
            'GA': ['Libreville', 'Port-Gentil', 'Franceville'],
            'GH': ['Accra', 'Kumasi', 'Tamale'],
            'NG': ['Lagos', 'Abuja', 'Kano'],
            'FR': ['Paris', 'Lyon', 'Marseille'],
            'CA': ['Montréal', 'Toronto', 'Vancouver'],
            'BE': ['Bruxelles', 'Anvers', 'Gand'],
            'CH': ['Genève', 'Zurich', 'Bâle'],
            'LU': ['Luxembourg', 'Esch-sur-Alzette'],
            'DE': ['Berlin', 'Munich', 'Hambourg'],
            'GB': ['Londres', 'Manchester', 'Birmingham'],
            'US': ['New York', 'San Francisco', 'Chicago'],
            'CG': ['Brazzaville', 'Pointe-Noire'],
            'TG': ['Lomé', 'Sokodé'],
            'BJ': ['Cotonou', 'Porto-Novo'],
            'BF': ['Ouagadougou', 'Bobo-Dioulasso'],
            'ML': ['Bamako', 'Ségou'],
            'NE': ['Niamey', 'Zinder'],
            'GQ': ['Malabo', 'Bata'],
            'TD': ['N\'Djamena', 'Moundou'],
            'CF': ['Bangui', 'Bimbo'],
            'MA': ['Casablanca', 'Rabat', 'Marrakech'],
            'TN': ['Tunis', 'Sfax', 'Sousse'],
            'DZ': ['Alger', 'Oran', 'Constantine'],
            'RW': ['Kigali', 'Butare'],
            'KE': ['Nairobi', 'Mombasa', 'Kisumu']
        };

        function updateCountryDisplay() {
            const select = document.getElementById('country-select');
            const selectedOption = select.options[select.selectedIndex];
            
            // Récupérer les données du pays sélectionné
            const currency = selectedOption.getAttribute('data-currency');
            const symbol = selectedOption.getAttribute('data-symbol');
            const flag = selectedOption.getAttribute('data-flag');
            const countryName = selectedOption.getAttribute('data-name');
            const countryCode = selectedOption.value;

            // 1. Mettre à jour le badge de devise en haut
            const currencyDisplay = document.getElementById('currency-display');
            currencyDisplay.innerHTML = `<i class="fas fa-coins"></i> <span id="current-currency">${symbol} (${currency})</span>`;

            // 2. Mettre à jour chaque carte d'offre
            const jobCards = document.querySelectorAll('.job-card');
            jobCards.forEach((card, index) => {
                const salaryElement = card.querySelector('.job-salary');
                const flagElement = card.querySelector('.job-country-flag');
                const nameElement = card.querySelector('.job-country-name');
                
                const baseSalaryEur = parseFloat(salaryElement.getAttribute('data-base-salary'));
                const salaryType = card.getAttribute('data-salary-type');

                // --- CONVERSION DU SALAIRE ---
                if (baseSalaryEur && currency) {
                    let convertedSalary;
                    
                    // Pour les devises fortes (EUR, USD, CAD, GBP, CHF), on divise
                    // Pour les devises locales africaines, on multiplie
                    const strongCurrencies = ['EUR', 'USD', 'CAD', 'GBP', 'CHF'];
                    
                    if (strongCurrencies.includes(currency)) {
                        convertedSalary = (baseSalaryEur / exchangeRates[currency]).toFixed(0);
                    } else {
                        convertedSalary = Math.round(baseSalaryEur * exchangeRates[currency]).toLocaleString('fr-FR');
                    }

                    const period = salaryPeriods[salaryType] || '';
                    salaryElement.textContent = `${convertedSalary} ${symbol}${period}`;
                }

                // --- CHANGEMENT DU PAYS (drapeau + nom) ---
                if (flagElement && nameElement) {
                    // Choisir une ville du pays sélectionné
                    const cities = citiesByCountry[countryCode] || ['Ville principale'];
                    const city = cities[index % cities.length]; // Rotation des villes
                    
                    flagElement.textContent = flag;
                    nameElement.textContent = `${city}, ${countryName}`;
                }
            });
        }

        // Initialiser au chargement de la page
        document.addEventListener('DOMContentLoaded', updateCountryDisplay);
    </script>

</body>
</html>