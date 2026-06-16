<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une offre – JobAI</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --success: #10b981;
            --error: #ef4444;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--light);
            color: var(--dark);
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        .logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .back-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray);
            text-decoration: none;
            font-weight: 500;
            transition: color .25s;
        }
        .back-link:hover { color: var(--primary); }

        /* ── Hero Banner ── */
        .page-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 6.5rem 5% 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .page-banner::before {
            content: '';
            position: absolute;
            top: -60%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .banner-content {
            max-width: 700px;
            position: relative;
            z-index: 2;
        }
        .banner-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }
        .page-banner h1 {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }
        .page-banner p {
            font-size: 1.1rem;
            opacity: 0.88;
        }

        /* ── Progress Steps ── */
        .progress-bar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 0 5%;
        }
        .steps-row {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 1rem 0;
            flex: 1;
            position: relative;
        }
        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 40%;
            height: 2px;
            background: var(--border);
        }
        .step-item.active:not(:last-child)::after { background: var(--primary); }
        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            flex-shrink: 0;
            background: var(--border);
            color: var(--gray);
            transition: all .3s;
        }
        .step-item.active .step-dot,
        .step-item.done .step-dot {
            background: var(--primary);
            color: white;
        }
        .step-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--gray);
            white-space: nowrap;
        }
        .step-item.active .step-label { color: var(--primary); }

        /* ── Main Layout ── */
        .main {
            max-width: 900px;
            margin: 0 auto;
            padding: 2.5rem 5% 5rem;
        }

        /* ── Form Card ── */
        .form-card {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .form-section {
            padding: 2rem 2.5rem;
            border-bottom: 1px solid var(--border);
        }
        .form-section:last-of-type { border-bottom: none; }
        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
        }
        .section-title .icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        /* ── Fields ── */
        .field-row {
            display: grid;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .field-row.two   { grid-template-columns: 1fr 1fr; }
        .field-row.three { grid-template-columns: 1fr 1fr 1fr; }
        .field-row.one   { grid-template-columns: 1fr; }
        .field-row:last-child { margin-bottom: 0; }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }
        .field label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .field label .req { color: var(--error); font-size: 0.75rem; }
        .field label .tip {
            margin-left: auto;
            font-size: 0.75rem;
            font-weight: 400;
            color: var(--gray);
        }

        .field input,
        .field select,
        .field textarea {
            padding: 0.85rem 1rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--dark);
            background: white;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }
        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.08);
        }
        .field input.error,
        .field select.error,
        .field textarea.error {
            border-color: var(--error);
        }
        .field textarea { resize: vertical; min-height: 110px; line-height: 1.6; }
        .field-hint { font-size: 0.78rem; color: var(--gray); }
        .field-error { font-size: 0.78rem; color: var(--error); display: none; }
        .field-error.show { display: block; }

        /* Compétences tags */
        .tags-container {
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 0.6rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            cursor: text;
            transition: border-color .2s, box-shadow .2s;
            min-height: 52px;
            align-items: flex-start;
        }
        .tags-container:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.08);
        }
        .tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: #ede9fe;
            color: var(--primary);
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
        }
        .tag-chip button {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--primary);
            font-size: 0.9rem;
            line-height: 1;
            padding: 0;
        }
        .tag-chip button:hover { color: var(--error); }
        .tags-input {
            border: none !important;
            outline: none !important;
            padding: 0.3rem 0.4rem !important;
            font-size: 0.92rem !important;
            flex: 1;
            min-width: 120px;
            box-shadow: none !important;
        }

        /* Salaire optionnel */
        .salary-row {
            display: grid;
            grid-template-columns: 1fr 1fr 140px;
            gap: 1rem;
        }

        /* Date min via JS */
        input[type="date"] { cursor: pointer; }

        /* ── Sidebar Info ── */
        .layout-split {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2rem;
            align-items: start;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 1.75rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            position: sticky;
            top: 90px;
        }
        .info-card h4 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--dark);
        }
        .tip-item {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.1rem;
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.5;
        }
        .tip-item i {
            color: var(--primary);
            width: 16px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .tip-item strong { color: var(--dark); display: block; margin-bottom: 0.15rem; }

        .preview-card {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }
        .preview-card h4 { font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem; }
        .preview-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }
        .preview-company { font-size: 0.85rem; color: var(--gray); margin-bottom: 0.75rem; }
        .preview-tags { display: flex; gap: 0.4rem; flex-wrap: wrap; }
        .preview-tag {
            background: #f1f5f9;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.78rem;
            color: var(--gray);
        }
        .preview-type-badge {
            display: inline-block;
            background: #dbeafe;
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.65rem;
            border-radius: 20px;
            margin-bottom: 0.6rem;
        }

        /* ── Submit area ── */
        .form-footer {
            padding: 1.75rem 2.5rem;
            background: var(--light);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .form-footer-note {
            font-size: 0.82rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .form-footer-note i { color: var(--success); }
        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            color: white;
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .3s;
            box-shadow: 0 4px 15px rgba(79,70,229,0.35);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79,70,229,0.45);
        }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .btn-draft {
            background: white;
            border: 2px solid var(--border);
            color: var(--dark);
            padding: 0.9rem 1.5rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .25s;
        }
        .btn-draft:hover { border-color: var(--primary); color: var(--primary); }

        /* ── Success Modal ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.show { display: flex; }
        .modal {
            background: white;
            border-radius: 24px;
            padding: 3rem 2.5rem;
            max-width: 440px;
            width: 90%;
            text-align: center;
            animation: popIn .4s cubic-bezier(.34,1.56,.64,1);
        }
        @keyframes popIn {
            from { transform: scale(.8); opacity: 0; }
            to   { transform: scale(1);  opacity: 1; }
        }
        .modal-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--success), #34d399);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.2rem;
            color: white;
        }
        .modal h2 { font-size: 1.6rem; font-weight: 800; margin-bottom: 0.75rem; }
        .modal p { color: var(--gray); line-height: 1.6; margin-bottom: 2rem; }
        .modal-id {
            background: var(--light);
            border: 1px dashed var(--border);
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-family: monospace;
            font-size: 1rem;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 1.75rem;
        }
        .modal-actions { display: flex; gap: 1rem; justify-content: center; }
        .btn-modal-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.75rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s;
            font-size: 0.95rem;
        }
        .btn-modal-primary:hover { background: var(--primary-dark); }
        .btn-modal-secondary {
            background: white;
            color: var(--gray);
            border: 2px solid var(--border);
            padding: 0.75rem 1.75rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            font-size: 0.95rem;
        }
        .btn-modal-secondary:hover { border-color: var(--gray); }

        /* ── Toast ── */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--dark);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            font-weight: 500;
            z-index: 9998;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transform: translateY(100px);
            opacity: 0;
            transition: all .35s cubic-bezier(.34,1.56,.64,1);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast i { font-size: 1.1rem; }
        .toast.success i { color: var(--success); }
        .toast.error i { color: var(--error); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .layout-split { grid-template-columns: 1fr; }
            .info-card { position: static; }
            .field-row.two, .field-row.three { grid-template-columns: 1fr; }
            .salary-row { grid-template-columns: 1fr 1fr; }
            .page-banner h1 { font-size: 1.75rem; }
            .form-section { padding: 1.5rem; }
            .form-footer { flex-direction: column; align-items: stretch; }
            .btn-submit { justify-content: center; }
            .steps-row { gap: 0; }
            .step-label { display: none; }
        }
        @media (max-width: 480px) {
            .salary-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <a href="<?php echo route('home'); ?>" class="logo">
        <i class="fas fa-briefcase"></i> JobAI
    </a>
    <a href="<?php echo route('home'); ?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à l'accueil
    </a>
</nav>

<!-- Banner -->
<div class="page-banner">
    <div class="banner-content">
        <div class="banner-eyebrow">
            <i class="fas fa-building"></i> Espace Employeur
        </div>
        <h1>Publiez votre offre d'emploi</h1>
        <p>Atteignez des milliers de candidats qualifiés grâce à notre plateforme alimentée par l'IA.</p>
    </div>
</div>

<!-- Progress -->
<div class="progress-bar">
    <div class="steps-row">
        <div class="step-item active" id="step1">
            <div class="step-dot"><i class="fas fa-pen"></i></div>
            <span class="step-label">Détails du poste</span>
        </div>
        <div class="step-item" id="step2">
            <div class="step-dot">2</div>
            <span class="step-label">Coordonnées</span>
        </div>
        <div class="step-item" id="step3">
            <div class="step-dot">3</div>
            <span class="step-label">Publication</span>
        </div>
    </div>
</div>

<!-- Main -->
<main class="main">
    <div class="layout-split">

        <!-- FORMULAIRE -->
        <div>
            <form id="jobForm" novalidate>

                <!-- Section 1 : Poste -->
                <div class="form-card">
                    <div class="form-section">
                        <div class="section-title">
                            <div class="icon"><i class="fas fa-file-alt"></i></div>
                            Informations sur le poste
                        </div>

                        <div class="field-row one">
                            <div class="field">
                                <label for="jobTitle">
                                    Titre du poste <span class="req">*</span>
                                </label>
                                <input type="text" id="jobTitle" placeholder="Ex : Développeur Full Stack React/Node.js" maxlength="100">
                                <span class="field-error" id="err-jobTitle">Ce champ est obligatoire.</span>
                            </div>
                        </div>

                        <div class="field-row two">
                            <div class="field">
                                <label for="contractType">
                                    Type de contrat <span class="req">*</span>
                                </label>
                                <select id="contractType">
                                    <option value="">— Sélectionner —</option>
                                    <option>CDI</option>
                                    <option>CDD</option>
                                    <option>Freelance / Mission</option>
                                    <option>Stage</option>
                                    <option>Alternance</option>
                                    <option>Temps partiel</option>
                                    <option>Intérim</option>
                                    <option>Bénévolat</option>
                                </select>
                                <span class="field-error" id="err-contractType">Veuillez choisir un type.</span>
                            </div>
                            <div class="field">
                                <label for="workMode">Mode de travail</label>
                                <select id="workMode">
                                    <option value="">— Sélectionner —</option>
                                    <option>Présentiel</option>
                                    <option>Télétravail</option>
                                    <option>Hybride</option>
                                </select>
                            </div>
                        </div>

                        <div class="field-row one">
                            <div class="field">
                                <label for="location">
                                    Lieu de travail <span class="req">*</span>
                                </label>
                                <input type="text" id="location" placeholder="Ex : Douala, Cameroun">
                                <span class="field-error" id="err-location">Veuillez indiquer le lieu.</span>
                            </div>
                        </div>

                        <div class="field-row one">
                            <div class="field">
                                <label for="description">
                                    Description du poste <span class="req">*</span>
                                    <span class="tip" id="desc-counter">0 / 2000</span>
                                </label>
                                <textarea id="description" placeholder="Décrivez les responsabilités, l'environnement de travail, les avantages…" maxlength="2000" style="min-height:150px;"></textarea>
                                <span class="field-error" id="err-description">Une description est requise (min. 50 caractères).</span>
                            </div>
                        </div>

                        <div class="field-row one">
                            <div class="field">
                                <label>
                                    Compétences requises <span class="req">*</span>
                                    <span class="tip">Appuyer Entrée ou virgule pour ajouter</span>
                                </label>
                                <div class="tags-container" id="tagsContainer" onclick="focusTagInput()">
                                    <input class="field tags-input" type="text" id="tagInput" placeholder="Ex: Flutter, MySQL…">
                                </div>
                                <input type="hidden" id="skills">
                                <span class="field-error" id="err-skills">Ajoutez au moins une compétence.</span>
                            </div>
                        </div>

                    </div>

                    <!-- Section 2 : Salaire & date -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="icon"><i class="fas fa-coins"></i></div>
                            Rémunération &amp; Calendrier
                        </div>

                        <div class="salary-row field-row" style="margin-bottom:1.25rem">
                            <div class="field">
                                <label for="salaryMin">Salaire min.</label>
                                <input type="number" id="salaryMin" placeholder="0" min="0">
                            </div>
                            <div class="field">
                                <label for="salaryMax">Salaire max.</label>
                                <input type="number" id="salaryMax" placeholder="0" min="0">
                            </div>
                            <div class="field">
                                <label for="salaryPeriod">Période</label>
                                <select id="salaryPeriod">
                                    <option value="month">/ mois</option>
                                    <option value="year">/ an</option>
                                    <option value="day">/ jour</option>
                                    <option value="hour">/ heure</option>
                                </select>
                            </div>
                        </div>

                        <div class="field-row two">
                            <div class="field">
                                <label for="currency">Devise</label>
                                <select id="currency">
                                    <option value="XAF">FCFA (XAF)</option>
                                    <option value="XOF">FCFA (XOF)</option>
                                    <option value="EUR">Euro (€)</option>
                                    <option value="USD">Dollar US ($)</option>
                                    <option value="CAD">Dollar CA (CA$)</option>
                                    <option value="GBP">Livre sterling (£)</option>
                                    <option value="CHF">Franc suisse (CHF)</option>
                                    <option value="MAD">Dirham (DH)</option>
                                    <option value="NGN">Naira (₦)</option>
                                    <option value="GHS">Cedi (GH₵)</option>
                                </select>
                            </div>
                            <div class="field">
                                <label for="deadline">
                                    Date limite de candidature <span class="req">*</span>
                                </label>
                                <input type="date" id="deadline">
                                <span class="field-error" id="err-deadline">Choisissez une date dans le futur.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3 : Entreprise & coordonnées -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="icon"><i class="fas fa-building"></i></div>
                            Entreprise &amp; Coordonnées
                        </div>

                        <div class="field-row two">
                            <div class="field">
                                <label for="companyName">
                                    Nom de l'entreprise <span class="req">*</span>
                                </label>
                                <input type="text" id="companyName" placeholder="Ex : TechCorp Solutions">
                                <span class="field-error" id="err-companyName">Ce champ est obligatoire.</span>
                            </div>
                            <div class="field">
                                <label for="sector">Secteur d'activité</label>
                                <select id="sector">
                                    <option value="">— Sélectionner —</option>
                                    <option>Informatique / Tech</option>
                                    <option>Finance / Banque</option>
                                    <option>Santé / Médical</option>
                                    <option>Éducation</option>
                                    <option>Commerce / Vente</option>
                                    <option>Marketing / Communication</option>
                                    <option>BTP / Construction</option>
                                    <option>Industrie / Fabrication</option>
                                    <option>Agriculture</option>
                                    <option>Transport / Logistique</option>
                                    <option>Télécommunications</option>
                                    <option>Énergie</option>
                                    <option>Autre</option>
                                </select>
                            </div>
                        </div>

                        <div class="field-row two">
                            <div class="field">
                                <label for="contactEmail">
                                    Email de contact <span class="req">*</span>
                                </label>
                                <input type="email" id="contactEmail" placeholder="rh@entreprise.com">
                                <span class="field-error" id="err-contactEmail">Email invalide.</span>
                            </div>
                            <div class="field">
                                <label for="contactPhone">Téléphone</label>
                                <input type="tel" id="contactPhone" placeholder="+237 6XX XXX XXX">
                            </div>
                        </div>

                        <div class="field-row one">
                            <div class="field">
                                <label for="website">Site web de l'entreprise</label>
                                <input type="url" id="website" placeholder="https://www.entreprise.com">
                                <span class="field-hint">Optionnel – apparaît sur la fiche de l'offre.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer boutons -->
                    <div class="form-footer">
                        <div class="form-footer-note">
                            <i class="fas fa-lock"></i>
                            Vos données sont protégées et ne seront jamais revendues.
                        </div>
                        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
                            <button type="button" class="btn-draft" onclick="saveDraft()">
                                <i class="fas fa-save"></i> Brouillon
                            </button>
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <i class="fas fa-paper-plane"></i> Publier l'offre
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- SIDEBAR -->
        <aside>
            <div class="info-card">
                <h4><i class="fas fa-lightbulb" style="color:var(--accent)"></i> Conseils pour votre offre</h4>
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <div><strong>Titre précis</strong> Indiquez le niveau (junior/senior) et la techno principale pour attirer les bons profils.</div>
                </div>
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <div><strong>Description complète</strong> Les offres avec 200+ mots reçoivent 3× plus de candidatures.</div>
                </div>
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <div><strong>Salaire visible</strong> Afficher la fourchette augmente les candidatures qualifiées de 40%.</div>
                </div>
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <div><strong>Compétences ciblées</strong> Limitez à 5–8 compétences clés pour ne pas décourager les candidats.</div>
                </div>

                <div class="preview-card">
                    <h4><i class="fas fa-eye" style="color:var(--primary)"></i> Aperçu de la carte</h4>
                    <div class="preview-type-badge" id="prev-type">CDI</div>
                    <div class="preview-title" id="prev-title">Titre du poste</div>
                    <div class="preview-company" id="prev-company"><i class="fas fa-building"></i> Nom de l'entreprise</div>
                    <div class="preview-tags" id="prev-tags">
                        <span class="preview-tag">Compétence 1</span>
                        <span class="preview-tag">Compétence 2</span>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</main>

<!-- Modal succès -->
<div class="modal-overlay" id="successModal">
    <div class="modal">
        <div class="modal-icon"><i class="fas fa-check"></i></div>
        <h2>Offre publiée !</h2>
        <p>Votre offre est maintenant en ligne et visible par des milliers de candidats sur JobAI.</p>
        <div class="modal-id" id="offerRef">REF-JOBAI-0000</div>
        <div class="modal-actions">
            <button class="btn-modal-primary" onclick="goHome()">
                <i class="fas fa-home"></i> Accueil
            </button>
            <button class="btn-modal-secondary" onclick="viewAllOffers()">
                <i class="fas fa-list"></i> Voir toutes les offres
            </button>
            <button class="btn-modal-secondary" onclick="newOffer()">
                <i class="fas fa-plus"></i> Nouvelle offre
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast">
    <i class="fas fa-info-circle"></i>
    <span id="toast-msg"></span>
</div>

<script>
// ── Initialisation date min ──
const deadlineInput = document.getElementById('deadline');
const today = new Date();
today.setDate(today.getDate() + 1);
deadlineInput.min = today.toISOString().split('T')[0];

// ── Compteur description ──
const descArea = document.getElementById('description');
const descCounter = document.getElementById('desc-counter');
descArea.addEventListener('input', () => {
    const len = descArea.value.length;
    descCounter.textContent = `${len} / 2000`;
    if (len > 1800) descCounter.style.color = 'var(--error)';
    else descCounter.style.color = 'var(--gray)';
});

// ── Système de tags compétences ──
const tagsContainer = document.getElementById('tagsContainer');
const tagInput = document.getElementById('tagInput');
const skillsHidden = document.getElementById('skills');
const tags = [];

function focusTagInput() { tagInput.focus(); }

function addTag(val) {
    const v = val.trim().replace(/,/g, '');
    if (!v || tags.includes(v) || tags.length >= 10) return;
    tags.push(v);
    renderTags();
}

function removeTag(idx) {
    tags.splice(idx, 1);
    renderTags();
    updatePreview();
}

function renderTags() {
    tagsContainer.querySelectorAll('.tag-chip').forEach(el => el.remove());
    tags.forEach((t, i) => {
        const chip = document.createElement('span');
        chip.className = 'tag-chip';
        chip.innerHTML = `${t}<button type="button" onclick="removeTag(${i})" title="Supprimer">×</button>`;
        tagsContainer.insertBefore(chip, tagInput);
    });
    skillsHidden.value = tags.join(',');
    updatePreview();
}

tagInput.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        addTag(tagInput.value);
        tagInput.value = '';
    } else if (e.key === 'Backspace' && !tagInput.value && tags.length) {
        removeTag(tags.length - 1);
    }
});
tagInput.addEventListener('blur', () => {
    if (tagInput.value.trim()) { addTag(tagInput.value); tagInput.value = ''; }
});

// ── Aperçu live ──
document.getElementById('jobTitle').addEventListener('input', updatePreview);
document.getElementById('companyName').addEventListener('input', updatePreview);
document.getElementById('contractType').addEventListener('change', updatePreview);

function updatePreview() {
    const title = document.getElementById('jobTitle').value || 'Titre du poste';
    const company = document.getElementById('companyName').value || 'Nom de l\'entreprise';
    const type = document.getElementById('contractType').value || 'CDI';
    document.getElementById('prev-title').textContent = title;
    document.getElementById('prev-company').innerHTML = `<i class="fas fa-building"></i> ${company}`;
    document.getElementById('prev-type').textContent = type;
    const prevTags = document.getElementById('prev-tags');
    if (tags.length) {
        prevTags.innerHTML = tags.slice(0,4).map(t => `<span class="preview-tag">${t}</span>`).join('');
    } else {
        prevTags.innerHTML = '<span class="preview-tag">Compétence 1</span><span class="preview-tag">Compétence 2</span>';
    }
}

// ── Validation ──
function validate() {
    let valid = true;
    const rules = [
        { id: 'jobTitle', errId: 'err-jobTitle', check: v => v.trim().length >= 3 },
        { id: 'contractType', errId: 'err-contractType', check: v => v !== '' },
        { id: 'location', errId: 'err-location', check: v => v.trim().length >= 2 },
        { id: 'description', errId: 'err-description', check: v => v.trim().length >= 50 },
        { id: 'companyName', errId: 'err-companyName', check: v => v.trim().length >= 2 },
        { id: 'contactEmail', errId: 'err-contactEmail', check: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) },
        { id: 'deadline', errId: 'err-deadline', check: v => v && new Date(v) > new Date() },
    ];
    rules.forEach(r => {
        const el = document.getElementById(r.id);
        const err = document.getElementById(r.errId);
        if (!r.check(el.value)) {
            el.classList.add('error');
            err.classList.add('show');
            valid = false;
        } else {
            el.classList.remove('error');
            err.classList.remove('show');
        }
    });
    // Skills
    const skillErr = document.getElementById('err-skills');
    const skillCont = document.getElementById('tagsContainer');
    if (!tags.length) {
        skillCont.style.borderColor = 'var(--error)';
        skillErr.classList.add('show');
        valid = false;
    } else {
        skillCont.style.borderColor = '';
        skillErr.classList.remove('show');
    }
    return valid;
}

// ── Soumission ──
document.getElementById('jobForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (!validate()) {
        showToast('Veuillez corriger les erreurs du formulaire.', 'error');
        return;
    }

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Publication en cours…';

    const payload = {
        title:        document.getElementById('jobTitle').value.trim(),
        contractType: document.getElementById('contractType').value,
        workMode:     document.getElementById('workMode').value,
        location:     document.getElementById('location').value.trim(),
        description:  document.getElementById('description').value.trim(),
        skills:       tags,
        salaryMin:    document.getElementById('salaryMin').value,
        salaryMax:    document.getElementById('salaryMax').value,
        salaryPeriod: document.getElementById('salaryPeriod').value,
        currency:     document.getElementById('currency').value,
        deadline:     document.getElementById('deadline').value,
        company:      document.getElementById('companyName').value.trim(),
        sector:       document.getElementById('sector').value,
        email:        document.getElementById('contactEmail').value.trim(),
        phone:        document.getElementById('contactPhone').value.trim(),
        website:      document.getElementById('website').value.trim(),
        postedAt:     new Date().toISOString()
    };

    try {
        // Remplacer l'URL par l'endpoint réel de votre backend
        const res = await fetch('/api/offres', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        if (res.ok) {
            const data = await res.json().catch(() => ({}));
            const ref = data.id ? `REF-JOBAI-${String(data.id).padStart(4,'0')}` : `REF-JOBAI-${Math.floor(Math.random()*9000+1000)}`;
            document.getElementById('offerRef').textContent = ref;
            addStoredOffer({
                id: `offer-${Date.now()}`,
                titre: payload.title,
                entreprise_nom: payload.company || 'Mon entreprise',
                type_contrat: payload.contractType,
                tags: payload.skills.join(','),
                salaire: payload.salaryMax || payload.salaryMin || '',
                devise: payload.currency || '€',
                periode: payload.salaryPeriod || '/mois',
                ville: payload.location || '',
                pays: '',
                flag: '🇫🇷',
                date_publication: new Date().toISOString().split('T')[0],
                description: payload.description,
                email: payload.email,
                phone: payload.phone,
                website: payload.website,
            });
            document.getElementById('successModal').classList.add('show');
            // Progression
            document.getElementById('step1').classList.add('done');
            document.getElementById('step2').classList.add('done','active');
            document.getElementById('step3').classList.add('active');
        } else {
            throw new Error('Erreur serveur');
        }
    } catch {
        // Mode démo : si le backend n'est pas encore connecté, simulation
        const ref = `REF-JOBAI-${Math.floor(Math.random()*9000+1000)}`;
        document.getElementById('offerRef').textContent = ref;
        addStoredOffer({
            id: `offer-${Date.now()}`,
            titre: payload.title,
            entreprise_nom: payload.company || 'Mon entreprise',
            type_contrat: payload.contractType,
            tags: payload.skills.join(','),
            salaire: payload.salaryMax || payload.salaryMin || '',
            devise: payload.currency || '€',
            periode: payload.salaryPeriod || '/mois',
            ville: payload.location || '',
            pays: '',
            flag: '🇫🇷',
            date_publication: new Date().toISOString().split('T')[0],
            description: payload.description,
            email: payload.email,
            phone: payload.phone,
            website: payload.website,
        });
        document.getElementById('successModal').classList.add('show');
        document.getElementById('step1').classList.add('done');
        document.getElementById('step2').classList.add('active');
        document.getElementById('step3').classList.add('active');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Publier l\'offre';
    }
});

// ── Brouillon ──
function saveDraft() {
    const draft = {
        title:       document.getElementById('jobTitle').value,
        company:     document.getElementById('companyName').value,
        description: document.getElementById('description').value,
        skills:      tags,
        savedAt:     new Date().toLocaleString('fr-FR')
    };
    localStorage.setItem('jobai_draft', JSON.stringify(draft));
    showToast('Brouillon sauvegardé localement.', 'success');
}

// Restaurer brouillon
window.addEventListener('DOMContentLoaded', () => {
    const draft = localStorage.getItem('jobai_draft');
    if (draft) {
        try {
            const d = JSON.parse(draft);
            if (d.title) document.getElementById('jobTitle').value = d.title;
            if (d.company) document.getElementById('companyName').value = d.company;
            if (d.description) { document.getElementById('description').value = d.description; descArea.dispatchEvent(new Event('input')); }
            if (d.skills && d.skills.length) { d.skills.forEach(addTag); }
            updatePreview();
            showToast(`Brouillon restauré (${d.savedAt}).`, 'success');
        } catch {}
    }
});

// ── Toast ──
function showToast(msg, type='success') {
    const t = document.getElementById('toast');
    t.querySelector('i').className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    t.className = `toast ${type}`;
    document.getElementById('toast-msg').textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3500);
}

// ── LocalStorage helper ──
function addStoredOffer(offer) {
    try {
        const stored = JSON.parse(localStorage.getItem('jobai_offers') || '[]');
        stored.unshift(offer);
        localStorage.setItem('jobai_offers', JSON.stringify(stored));
        localStorage.setItem('jobai_last_offer', JSON.stringify(offer));
    } catch {
        localStorage.setItem('jobai_offers', JSON.stringify([offer]));
        localStorage.setItem('jobai_last_offer', JSON.stringify(offer));
    }
}

// ── Modal actions ──
function goHome() { window.location.href = '/welcomP.php'; }
function viewAllOffers() { window.location.href = '/recherche-metier.php'; }
function newOffer() {
    document.getElementById('successModal').classList.remove('show');
    document.getElementById('jobForm').reset();
    tags.length = 0;
    renderTags();
    updatePreview();
    localStorage.removeItem('jobai_draft');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── Supprimer erreur au changement ──
document.querySelectorAll('input, select, textarea').forEach(el => {
    el.addEventListener('input', () => el.classList.remove('error'));
    el.addEventListener('change', () => el.classList.remove('error'));
});
</script>
</body>
</html>