<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobAI - Tous les CV et Réalisations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            --card-bg: #ffffff;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow-x: hidden;
            padding-bottom: 40px;
        }

        body::before {
            content: '';
            position: fixed;
            top: -30%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: float 25s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-20px, -20px) rotate(180deg); }
        }

        .header {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .logo i {
            font-size: 1.5rem;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-back {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-back:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        }

        .search-section {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            max-width: 500px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 14px 20px 14px 45px;
            border: none;
            border-radius: 50px;
            background: rgba(255,255,255,0.95);
            font-size: 0.95rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .search-box input:focus {
            outline: none;
            box-shadow: 0 4px 25px rgba(79, 70, 229, 0.2);
        }

        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 1rem;
        }

        .filter-btn {
            padding: 14px 25px;
            border: none;
            border-radius: 50px;
            background: rgba(255,255,255,0.95);
            color: var(--dark);
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        .section-title {
            text-align: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .section-subtitle {
            text-align: center;
            color: rgba(255,255,255,0.8);
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: all 0.4s ease;
            animation: fadeInUp 0.6s ease backwards;
            position: relative;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

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

        .card-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .avatar-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            border: 3px solid white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
        }

        .card-info h3 {
            font-size: 1.1rem;
            color: var(--dark);
            font-weight: 700;
        }

        .card-info p {
            font-size: 0.85rem;
            color: var(--gray);
            margin-top: 2px;
        }

        .card-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 6px;
        }

        .badge-dev { background: #dbeafe; color: #1e40af; }
        .badge-design { background: #fce7f3; color: #9d174d; }
        .badge-marketing { background: #d1fae5; color: #065f46; }
        .badge-data { background: #fef3c7; color: #92400e; }
        .badge-new { background: #e0e7ff; color: #3730a3; }

        .card-body {
            padding: 20px;
        }

        .cv-section {
            margin-bottom: 15px;
        }

        .cv-section h4 {
            font-size: 0.8rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cv-section h4 i {
            color: var(--primary);
        }

        .cv-file {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
            cursor: pointer;
        }

        .cv-file:hover {
            background: #f0f4ff;
            border-color: var(--primary);
        }

        .cv-file i {
            font-size: 1.3rem;
            color: #e74c3c;
        }

        .cv-file span {
            font-size: 0.85rem;
            color: var(--dark);
            font-weight: 500;
        }

        .cv-file .size {
            margin-left: auto;
            font-size: 0.75rem;
            color: var(--gray);
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 8px;
        }

        .photo-item {
            aspect-ratio: 1;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
        }

        .photo-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s;
        }

        .photo-item:hover img {
            transform: scale(1.1);
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(79, 70, 229, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s;
        }

        .photo-item:hover .photo-overlay {
            opacity: 1;
        }

        .photo-overlay i {
            color: white;
            font-size: 1.2rem;
        }

        .photo-more {
            aspect-ratio: 1;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-more:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .card-footer {
            padding: 15px 20px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-date {
            font-size: 0.8rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #f1f5f9;
            color: var(--gray);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            max-width: 900px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 30px;
            position: relative;
            transform: scale(0.8);
            transition: all 0.3s;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: #f1f5f9;
            color: var(--dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: #e2e8f0;
            transform: rotate(90deg);
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
        }

        .modal-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .modal-gallery img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .modal-gallery img:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .lightbox.active {
            opacity: 1;
            visibility: visible;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 30px;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .lightbox-close:hover {
            transform: scale(1.2);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: white;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }
            .logo {
                font-size: 1.4rem;
            }
            .cards-grid {
                grid-template-columns: 1fr;
            }
            .section-title {
                font-size: 1.5rem;
            }
            .search-section {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box {
                max-width: 100%;
            }
            .modal-content {
                padding: 20px;
                width: 95%;
            }
            .modal-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
<base target="_blank">
</head>
<body>

    <header class="header">
        <a href="/" class="logo">
            <i class="fas fa-briefcase"></i>
            JobAI
        </a>
        <div class="header-actions">
            <a href="<?php echo url('/b'); ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </header>

    <div class="search-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Rechercher par nom, métier..." onkeyup="filterCards()">
        </div>
        <button class="filter-btn active" onclick="filterCategory('all', this)">
            <i class="fas fa-layer-group"></i>
            Tous
        </button>
        <button class="filter-btn" onclick="filterCategory('dev', this)">
            <i class="fas fa-code"></i>
            Développement
        </button>
        <button class="filter-btn" onclick="filterCategory('design', this)">
            <i class="fas fa-palette"></i>
            Design
        </button>
        <button class="filter-btn" onclick="filterCategory('marketing', this)">
            <i class="fas fa-bullhorn"></i>
            Marketing
        </button>
    </div>

    <div class="container">
        <h1 class="section-title">📋 Tous les CV et Réalisations</h1>
        <p class="section-subtitle">Découvrez les profils et les portfolios de nos candidats</p>

        <div class="cards-grid" id="cardsGrid">
            <!-- Les cartes seront générées dynamiquement -->
        </div>

        <div class="empty-state" id="emptyState" style="display: none;">
            <i class="fas fa-folder-open"></i>
            <h3>Aucun résultat trouvé</h3>
            <p>Essayez une autre recherche ou catégorie</p>
        </div>
    </div>

    <div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
            <div id="modalBody"></div>
        </div>
    </div>

    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <i class="fas fa-times lightbox-close" onclick="closeLightbox()"></i>
        <img src="" alt="Full size" id="lightboxImg">
    </div>

    <script>
        // Données par défaut (profils existants)
        const defaultProfiles = [
            {
                name: "Marie Dupont",
                role: "Développeuse Full-Stack",
                category: "Développement",
                badgeClass: "badge-dev",
                initials: "MD",
                cv: "Marie_Dupont_CV.pdf",
                cvSize: "2.4 Mo",
                date: "12 juin 2026",
                description: "Développeuse passionnée avec 5 ans d'expérience en développement web. Spécialisée en React, Node.js et bases de données PostgreSQL.",
                skills: ["React", "Node.js", "PostgreSQL", "TypeScript", "Docker"],
                photos: [
                    "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1555421689-d68471e189f2?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551033406-611cf9a28f67?w=300&h=300&fit=crop"
                ]
            },
            {
                name: "Jean Martin",
                role: "Designer UI/UX",
                category: "Design",
                badgeClass: "badge-design",
                initials: "JM",
                cv: "Jean_Martin_CV.pdf",
                cvSize: "1.8 Mo",
                date: "10 juin 2026",
                description: "Designer créatif avec une expertise en design d'interface et expérience utilisateur. Maîtrise de Figma, Adobe XD et Sketch.",
                skills: ["Figma", "Adobe XD", "Sketch", "Prototypage", "Design System"],
                photos: [
                    "https://images.unsplash.com/photo-1561070791-2526d30994b5?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1542744094-3a31f272c490?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1618005198919-d3c4a5c94f13?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1561070791-36c11767b26a?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1545235617-9465d2a55698?w=300&h=300&fit=crop"
                ]
            },
            {
                name: "Sophie Bernard",
                role: "Responsable Marketing Digital",
                category: "Marketing",
                badgeClass: "badge-marketing",
                initials: "SB",
                cv: "Sophie_Bernard_CV.pdf",
                cvSize: "3.1 Mo",
                date: "8 juin 2026",
                description: "Experte en stratégie marketing digital avec 7 ans d'expérience. Spécialisée en SEO, SEA et campagnes social media.",
                skills: ["SEO", "SEA", "Social Media", "Analytics", "Content Marketing"],
                photos: [
                    "https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1557804506-669a67965ba0?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1557838923-2985c318be8e?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=300&h=300&fit=crop"
                ]
            },
            {
                name: "Lucas Petit",
                role: "Développeur Mobile Flutter",
                category: "Développement",
                badgeClass: "badge-dev",
                initials: "LP",
                cv: "Lucas_Petit_CV.pdf",
                cvSize: "1.5 Mo",
                date: "5 juin 2026",
                description: "Développeur mobile spécialisé en Flutter et Dart. 3 ans d'expérience dans la création d'applications iOS et Android performantes.",
                skills: ["Flutter", "Dart", "Firebase", "iOS", "Android"],
                photos: [
                    "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551650975-87deedd944c3?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1526498460520-4c246339dccb?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1555774698-0b77e0d5fac6?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551650992-ee4fd47df41f?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1555421689-d68471e189f2?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=300&h=300&fit=crop"
                ]
            },
            {
                name: "Emma Rousseau",
                role: "Data Scientist",
                category: "Data",
                badgeClass: "badge-data",
                initials: "ER",
                cv: "Emma_Rousseau_CV.pdf",
                cvSize: "2.7 Mo",
                date: "3 juin 2026",
                description: "Data Scientist avec une solide formation en mathématiques et statistiques. Experte en machine learning et analyse prédictive.",
                skills: ["Python", "Machine Learning", "TensorFlow", "SQL", "Tableau"],
                photos: [
                    "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=300&h=300&fit=crop"
                ]
            },
            {
                name: "Thomas Moreau",
                role: "Graphiste & Illustrateur",
                category: "Design",
                badgeClass: "badge-design",
                initials: "TM",
                cv: "Thomas_Moreau_CV.pdf",
                cvSize: "4.2 Mo",
                date: "1 juin 2026",
                description: "Graphiste talentueux avec 6 ans d'expérience. Spécialisé en branding, illustration et motion design.",
                skills: ["Illustrator", "Photoshop", "After Effects", "Branding", "Motion Design"],
                photos: [
                    "https://images.unsplash.com/photo-1626785774573-4b799315345d?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1561998338-13ad7883b20f?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1572044162444-ad60f128bdea?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1618005198919-d3c4a5c94f13?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1561070791-36c11767b26a?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1545235617-9465d2a55698?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1542744094-3a31f272c490?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1561070791-2526d30994b5?w=300&h=300&fit=crop",
                    "https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=300&h=300&fit=crop"
                ]
            }
        ];

        // Charger les candidats depuis localStorage ou utiliser les données par défaut
        function loadCandidats() {
            const stored = localStorage.getItem('jobai_candidats');
            if (stored) {
                const storedCandidats = JSON.parse(stored);
                // Fusionner : d'abord les nouveaux, puis les profils par défaut qui ne sont pas déjà là
                const storedIds = storedCandidats.map(c => c.id);
                const defaultNotStored = defaultProfiles.filter(p => !storedIds.includes(p.id));
                return [...storedCandidats, ...defaultNotStored];
            }
            return defaultProfiles;
        }

        let profiles = loadCandidats();

        // Générer les cartes HTML dynamiquement
        function generateCards() {
            const grid = document.getElementById('cardsGrid');
            grid.innerHTML = '';

            profiles.forEach((p, index) => {
                const initials = p.initials || (p.nom || p.name).split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                const badgeClass = p.badgeClass || 'badge-new';
                const category = p.category || 'Nouveau';
                const displayName = p.nom || p.name;
                const displayRole = p.role || 'Candidat';
                const displayCv = p.cv || 'CV.pdf';
                const displayCvSize = p.cvSize || 'N/A';
                const displayDate = p.date || new Date().toLocaleDateString('fr-FR');
                const displayDesc = p.description || 'Nouveau candidat.';
                const displaySkills = p.skills || ['À définir'];
                const displayPhotos = p.photos || [];

                // Générer la grille de photos
                let photosHTML = '';
                if (displayPhotos.length > 0) {
                    const visiblePhotos = displayPhotos.slice(0, 5);
                    const remaining = displayPhotos.length - 5;

                    visiblePhotos.forEach((photo, i) => {
                        // Gérer les deux formats : chaîne (pour les anciennes données) et objet {name, size, data}
                        const photoSrc = typeof photo === 'string' ? photo : (photo.data || photo);
                        photosHTML += `
                            <div class="photo-item" onclick="openLightbox(this)">
                                <img src="${photoSrc}" alt="Réalisation ${i+1}">
                                <div class="photo-overlay"><i class="fas fa-expand"></i></div>
                            </div>`;
                    });

                    if (remaining > 0) {
                        photosHTML += `<div class="photo-more" onclick="openModal(${index})">+${remaining}</div>`;
                    }
                } else {
                    photosHTML = `
                        <div style="grid-column: 1/-1; text-align: center; padding: 20px; color: var(--gray); font-size: 0.85rem;">
                            <i class="fas fa-image" style="font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                            Aucune photo de réalisation
                        </div>`;
                }

                const cardHTML = `
                    <div class="card" data-category="${category.toLowerCase()}" data-name="${displayName.toLowerCase()}">
                        <div class="card-header">
                            <div class="avatar-placeholder">${initials}</div>
                            <div class="card-info">
                                <h3>${displayName}</h3>
                                <p>${displayRole}</p>
                                <span class="card-badge ${badgeClass}">${category}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="cv-section">
                                <h4><i class="fas fa-file-pdf"></i> CV</h4>
                                <div class="cv-file" onclick="downloadCV('${displayCv}')">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>${displayCv}</span>
                                    <span class="size">${displayCvSize}</span>
                                </div>
                            </div>
                            <div class="cv-section">
                                <h4><i class="fas fa-images"></i> Réalisations</h4>
                                <div class="photos-grid">
                                    ${photosHTML}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="card-date">
                                <i class="fas fa-calendar-alt"></i>
                                ${displayDate}
                            </span>
                            <div class="card-actions">
                                <button class="action-btn" onclick="openModal(${index})" title="Voir le profil">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn" onclick="downloadCV('${displayCv}')" title="Télécharger le CV">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                grid.innerHTML += cardHTML;
            });

            // Réinitialiser les animations
            document.querySelectorAll('.card').forEach((card, i) => {
                card.style.animationDelay = (i * 0.1) + 's';
            });
        }

        // Générer les cartes au chargement
        generateCards();

        // Filter by category
        function filterCategory(category, btn) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const cards = document.querySelectorAll('.card');
            let visibleCount = 0;

            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            document.getElementById('emptyState').style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Search filter
        function filterCards() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.dataset.name;
                const category = card.dataset.category;
                const role = card.querySelector('.card-info p').textContent.toLowerCase();

                if (name.includes(searchTerm) || category.includes(searchTerm) || role.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            document.getElementById('emptyState').style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Open modal
        function openModal(index) {
            const p = profiles[index];
            const initials = p.initials || (p.nom || p.name).split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            const badgeClass = p.badgeClass || 'badge-new';
            const category = p.category || 'Nouveau';
            const displayName = p.nom || p.name;
            const displayRole = p.role || 'Candidat';
            const displayCv = p.cv || 'CV.pdf';
            const displayCvSize = p.cvSize || 'N/A';
            const displayDate = p.date || new Date().toLocaleDateString('fr-FR');
            const displayDesc = p.description || 'Nouveau candidat.';
            const displaySkills = p.skills || ['À définir'];
            const displayPhotos = p.photos || [];

            const modalBody = document.getElementById('modalBody');

            modalBody.innerHTML = `
                <div class="modal-header">
                    <div class="avatar-placeholder" style="width:80px;height:80px;font-size:2rem;">${initials}</div>
                    <div>
                        <h2 style="font-size:1.5rem;color:var(--dark);margin-bottom:5px;">${displayName}</h2>
                        <p style="color:var(--gray);font-size:1rem;">${displayRole}</p>
                        <span class="card-badge ${badgeClass}" style="margin-top:8px;">${category}</span>
                    </div>
                </div>
                <div style="margin-bottom:20px;">
                    <h3 style="font-size:1.1rem;color:var(--dark);margin-bottom:10px;"><i class="fas fa-user" style="color:var(--primary);margin-right:8px;"></i>À propos</h3>
                    <p style="color:var(--gray);line-height:1.6;">${displayDesc}</p>
                </div>
                <div style="margin-bottom:20px;">
                    <h3 style="font-size:1.1rem;color:var(--dark);margin-bottom:10px;"><i class="fas fa-tools" style="color:var(--primary);margin-right:8px;"></i>Compétences</h3>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        ${displaySkills.map(skill => `<span style="padding:6px 14px;background:#f0f4ff;color:var(--primary);border-radius:20px;font-size:0.85rem;font-weight:600;">${skill}</span>`).join('')}
                    </div>
                </div>
                <div class="cv-section" style="margin-bottom:20px;">
                    <h4><i class="fas fa-file-pdf"></i> CV</h4>
                    <div class="cv-file" onclick="downloadCV('${displayCv}')">
                        <i class="fas fa-file-pdf"></i>
                        <span>${displayCv}</span>
                        <span class="size">${displayCvSize}</span>
                    </div>
                </div>
                <div>
                    <h3 style="font-size:1.1rem;color:var(--dark);margin-bottom:15px;"><i class="fas fa-images" style="color:var(--primary);margin-right:8px;"></i>Toutes les réalisations (${displayPhotos.length} photos)</h3>
                    <div class="modal-gallery">
                        ${displayPhotos.length > 0 
                            ? displayPhotos.map(photo => `<img src="${photo}" alt="Réalisation" onclick="openLightboxFromSrc('${photo}')">`).join('')
                            : '<p style="color:var(--gray);">Aucune photo de réalisation pour ce candidat.</p>'
                        }
                    </div>
                </div>
            `;

            document.getElementById('modalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal(event) {
            if (!event || event.target === document.getElementById('modalOverlay')) {
                document.getElementById('modalOverlay').classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        // Open lightbox from element
        function openLightbox(element) {
            const img = element.querySelector('img');
            const src = img.src.replace('w=300&h=300', 'w=1200&h=800');
            document.getElementById('lightboxImg').src = src;
            document.getElementById('lightbox').classList.add('active');
        }

        // Open lightbox from src
        function openLightboxFromSrc(src) {
            const fullSrc = src.replace('w=300&h=300', 'w=1200&h=800');
            document.getElementById('lightboxImg').src = fullSrc;
            document.getElementById('lightbox').classList.add('active');
        }

        // Close lightbox
        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
        }

        // Download CV
        function downloadCV(filename) {
            alert('Téléchargement du CV : ' + filename + '\n(Dans une vraie application, le fichier serait téléchargé ici)');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
                closeLightbox();
            }
        });
    </script>

</body>
</html>