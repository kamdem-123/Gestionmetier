<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres d'emploi — JobAI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; }

        /* Navbar */
        .navbar { background: #1e293b; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .navbar .logo { color: #818cf8; font-size: 1.4rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; }
        .navbar .nav-links { display: flex; align-items: center; gap: 1.25rem; }
        .navbar a { color: #94a3b8; text-decoration: none; font-size: 0.9rem; transition: color .2s; }
        .navbar a:hover { color: white; }
        .navbar .btn-connexion { background: #4f46e5; color: white !important; padding: 0.5rem 1.1rem; border-radius: 8px; font-weight: 600; }
        .navbar .btn-connexion:hover { background: #4338ca; }

        /* Hero / Search */
        .hero { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 3rem 2rem; text-align: center; color: white; }
        .hero h1 { font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; }
        .hero p  { font-size: 1rem; opacity: 0.85; margin-bottom: 2rem; }

        .search-bar { max-width: 780px; margin: 0 auto; background: white; border-radius: 16px; padding: 0.6rem; display: flex; gap: 0.5rem; flex-wrap: wrap; box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
        .search-bar input, .search-bar select {
            flex: 1; min-width: 160px; padding: 0.75rem 1rem; border: none; outline: none;
            font-size: 0.9rem; color: #1e293b; font-family: inherit; background: transparent;
        }
        .search-bar .sep { width: 1px; background: #e2e8f0; margin: 0.3rem 0; }
        .search-btn { background: #4f46e5; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; }
        .search-btn:hover { background: #4338ca; }

        /* Container */
        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }

        /* Stats bar */
        .results-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
        .results-count { font-size: 0.9rem; color: #64748b; }
        .results-count strong { color: #1e293b; }
        .active-filters { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .filter-chip { display: inline-flex; align-items: center; gap: 0.4rem; background: #ede9fe; color: #4f46e5; padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .filter-chip a { color: inherit; text-decoration: none; font-size: 0.85rem; }

        /* Grille offres */
        .offres-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem; }

        /* Carte offre */
        .offre-card { background: white; border-radius: 18px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; transition: all .25s; display: flex; flex-direction: column; }
        .offre-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,0.1); border-color: #e0e7ff; }

        .card-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem; }
        .entreprise-logo { width: 46px; height: 46px; border-radius: 12px; background: linear-gradient(135deg, #ede9fe, #dbeafe); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: 800; color: #4f46e5; flex-shrink: 0; text-transform: uppercase; }
        .badge-contrat { font-size: 0.75rem; font-weight: 700; padding: 0.3rem 0.75rem; border-radius: 20px; white-space: nowrap; }
        .badge-contrat.cdi        { background: #d1fae5; color: #065f46; }
        .badge-contrat.cdd        { background: #dbeafe; color: #1e40af; }
        .badge-contrat.stage      { background: #fef3c7; color: #92400e; }
        .badge-contrat.alternance { background: #f3e8ff; color: #6b21a8; }
        .badge-contrat.freelance  { background: #ffedd5; color: #9a3412; }
        .badge-contrat.default    { background: #f1f5f9; color: #475569; }

        .offre-titre     { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.25rem; line-height: 1.35; }
        .offre-entreprise { font-size: 0.85rem; color: #64748b; margin-bottom: 1rem; }

        .offre-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; }
        .tag { background: #f8fafc; border: 1px solid #e2e8f0; color: #475569; font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 6px; }

        .offre-meta { display: flex; flex-wrap: wrap; gap: 0.75rem; font-size: 0.8rem; color: #94a3b8; margin-bottom: 1.25rem; }
        .offre-meta span { display: flex; align-items: center; gap: 0.3rem; }

        .offre-salaire { font-size: 0.88rem; font-weight: 700; color: #059669; margin-bottom: 1.25rem; }

        .card-footer { margin-top: auto; display: flex; gap: 0.75rem; }
        .btn-postuler { flex: 1; background: #4f46e5; color: white; border: none; padding: 0.75rem; border-radius: 10px; font-weight: 700; font-size: 0.9rem; cursor: pointer; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.4rem; transition: all .2s; }
        .btn-postuler:hover { background: #4338ca; transform: translateY(-1px); }
        .btn-postuler.disabled { background: #e2e8f0; color: #94a3b8; cursor: default; transform: none; }

        /* Aucun résultat */
        .empty { text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px; }
        .empty i { font-size: 3rem; color: #e2e8f0; display: block; margin-bottom: 1rem; }
        .empty h3 { font-size: 1.2rem; font-weight: 700; color: #64748b; margin-bottom: 0.5rem; }
        .empty p { color: #94a3b8; font-size: 0.9rem; }

        /* Badge match IA */
        .badge-match { display:inline-flex;align-items:center;gap:0.3rem;padding:0.3rem 0.75rem;border-radius:20px;font-size:0.75rem;font-weight:700; }
        .match-high { background:#d1fae5;color:#065f46; }
        .match-mid  { background:#fef3c7;color:#92400e; }
        .match-low  { background:#f1f5f9;color:#64748b; }

        /* Carte mise en avant si bon match */
        .offre-card.card-highlight { border-color:#818cf8;box-shadow:0 4px 20px rgba(79,70,229,0.12); }

        /* Pagination */
        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem; flex-wrap: wrap; }
        .pagination a, .pagination span {
            padding: 0.55rem 1rem; border-radius: 8px; font-size: 0.88rem; font-weight: 600;
            text-decoration: none; border: 1px solid #e2e8f0; color: #475569; background: white;
        }
        .pagination a:hover { background: #f1f5f9; border-color: #4f46e5; color: #4f46e5; }
        .pagination .active { background: #4f46e5; color: white; border-color: #4f46e5; }
        .pagination .disabled { opacity: 0.4; cursor: default; }

        /* Bouton retour */
        .btn-retour { display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-size: 0.88rem; font-weight: 600; padding: 0.5rem 1rem; border-radius: 8px; background: white; border: 1px solid #e2e8f0; transition: all .2s; margin-bottom: 1.5rem; }
        .btn-retour:hover { border-color: #4f46e5; color: #4f46e5; }

        @media(max-width: 600px) {
            .offres-grid { grid-template-columns: 1fr; }
            .hero h1 { font-size: 1.5rem; }
            .search-bar { flex-direction: column; }
            .search-bar .sep { display: none; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <a href="/" class="logo"><i class="fas fa-briefcase"></i> JobAI</a>
    <div class="nav-links">
        <a href="<?= route('offres.index') ?>" style="color:white;font-weight:600"><i class="fas fa-list"></i> Offres</a>
        <?php if (auth()->check()): ?>
            <?php if (auth()->user()->isAdmin()): ?>
                <a href="/admin"><i class="fas fa-cog"></i> Admin</a>
            <?php elseif (auth()->user()->isEmployeur()): ?>
                <a href="/employeur"><i class="fas fa-building"></i> Mon espace</a>
            <?php else: ?>
                <a href="/dashboard"><i class="fas fa-user"></i> Mon espace</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?= route('demande-employeur.form') ?>"><i class="fas fa-building"></i> Espace employeur</a>
            <a href="<?= route('connexion') ?>" class="btn-connexion"><i class="fas fa-sign-in-alt"></i> Connexion</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Hero + Recherche -->
<div class="hero">
    <h1><i class="fas fa-search"></i> Trouvez votre prochain emploi</h1>
    <p><?= $totalActif ?> offre<?= $totalActif > 1 ? 's' : '' ?> disponible<?= $totalActif > 1 ? 's' : '' ?> en ce moment</p>

    <form method="GET" action="<?= route('offres.index') ?>">
        <div class="search-bar">
            <input type="text" name="q" value="<?= e(request('q')) ?>"
                placeholder="Titre, compétence, entreprise…">
            <div class="sep"></div>
            <input type="text" name="lieu" value="<?= e(request('lieu')) ?>"
                placeholder="Ville ou pays…">
            <div class="sep"></div>
            <select name="type_contrat">
                <option value="">Tous les contrats</option>
                <?php foreach (['CDI','CDD','Stage','Alternance','Freelance','Temps partiel'] as $t): ?>
                    <option <?= request('type_contrat') === $t ? 'selected' : '' ?>><?= $t ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="search-btn"><i class="fas fa-search"></i> Rechercher</button>
        </div>
    </form>
</div>

<div class="container">

    <!-- Bouton retour -->
    <a href="/" class="btn-retour"><i class="fas fa-arrow-left"></i> Retour à l'accueil</a>

    <!-- Bandeau IA si candidat connecté avec profil -->
    <?php if ($candidatConnecte && !request()->hasAny(['q', 'type_contrat', 'lieu'])): ?>
    <div style="background:linear-gradient(135deg,#ede9fe,#dbeafe);border:1px solid #c7d2fe;border-radius:14px;padding:1rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.75rem;">
        <div style="background:#4f46e5;color:white;border-radius:10px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-robot"></i>
        </div>
        <div>
            <div style="font-weight:700;color:#3730a3;font-size:0.9rem;">Tri personnalisé par l'IA</div>
            <div style="font-size:0.8rem;color:#4338ca;">Les offres sont classées selon votre profil. Le badge <strong>% match</strong> indique la correspondance avec vos compétences.</div>
        </div>
        <a href="<?= route('offres.index') ?>?q=" style="margin-left:auto;font-size:0.8rem;color:#6366f1;white-space:nowrap;text-decoration:none;font-weight:600;">Voir par date →</a>
    </div>
    <?php endif; ?>

    <!-- Barre résultats -->
    <div class="results-bar">
        <div class="results-count">
            <strong><?= $offres->total() ?></strong> offre<?= $offres->total() > 1 ? 's' : '' ?> trouvée<?= $offres->total() > 1 ? 's' : '' ?>
            <?php if (request('q') || request('lieu') || request('type_contrat')): ?>
                — <a href="<?= route('offres.index') ?>" style="color:#4f46e5;text-decoration:none;font-weight:600">Effacer les filtres</a>
            <?php endif; ?>
        </div>
        <div class="active-filters">
            <?php if (request('q')): ?>
                <span class="filter-chip"><i class="fas fa-search"></i> <?= e(request('q')) ?></span>
            <?php endif; ?>
            <?php if (request('lieu')): ?>
                <span class="filter-chip"><i class="fas fa-map-marker-alt"></i> <?= e(request('lieu')) ?></span>
            <?php endif; ?>
            <?php if (request('type_contrat')): ?>
                <span class="filter-chip"><i class="fas fa-file-contract"></i> <?= e(request('type_contrat')) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Grille des offres -->
    <?php if ($offres->isEmpty()): ?>
        <div class="empty">
            <i class="fas fa-search"></i>
            <h3>Aucune offre trouvée</h3>
            <p>Essayez d'autres mots-clés ou supprimez les filtres.</p>
        </div>
    <?php else: ?>
        <div class="offres-grid">
            <?php foreach ($offres as $offre): ?>
            <?php
                $ent     = $offre->entreprise;
                $initial = strtoupper(substr($ent?->nom ?? $offre->titre, 0, 2));
                $tags    = array_filter(array_map('trim', explode(',', $offre->competences ?? '')));
                $badgeClass = match(strtolower($offre->type_contrat ?? '')) {
                    'cdi'        => 'cdi',
                    'cdd'        => 'cdd',
                    'stage'      => 'stage',
                    'alternance' => 'alternance',
                    'freelance'  => 'freelance',
                    default      => 'default',
                };
            ?>
            <?php
                $score = $offre->match_score ?? null;
                $scoreClass = '';
                if ($score !== null) {
                    $scoreClass = $score >= 60 ? 'match-high' : ($score >= 30 ? 'match-mid' : 'match-low');
                }
            ?>
            <div class="offre-card <?= $score !== null && $score >= 60 ? 'card-highlight' : '' ?>">
                <div class="card-top">
                    <div class="entreprise-logo"><?= $initial ?></div>
                    <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;justify-content:flex-end;">
                        <?php if ($score !== null): ?>
                        <span class="badge-match <?= $scoreClass ?>">
                            <i class="fas fa-robot"></i> <?= $score ?>% match
                        </span>
                        <?php endif; ?>
                        <span class="badge-contrat <?= $badgeClass ?>"><?= e($offre->type_contrat) ?></span>
                    </div>
                </div>

                <div class="offre-titre"><?= e($offre->titre) ?></div>
                <div class="offre-entreprise">
                    <i class="fas fa-building"></i> <?= e($ent?->nom ?? '—') ?>
                </div>

                <?php if (!empty($tags)): ?>
                <div class="offre-tags">
                    <?php foreach (array_slice($tags, 0, 4) as $tag): ?>
                        <span class="tag"><?= e($tag) ?></span>
                    <?php endforeach; ?>
                    <?php if (count($tags) > 4): ?>
                        <span class="tag">+<?= count($tags) - 4 ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="offre-meta">
                    <span><i class="fas fa-map-marker-alt"></i> <?= e($offre->ville) ?><?= $offre->pays ? ', '.e($offre->pays) : '' ?></span>
                    <?php if ($offre->mode_travail): ?>
                        <span><i class="fas fa-laptop-house"></i> <?= e($offre->mode_travail) ?></span>
                    <?php endif; ?>
                    <span><i class="fas fa-calendar"></i> <?= $offre->date_publication?->diffForHumans() ?></span>
                </div>

                <?php if ($offre->salaire_max || $offre->salaire_min): ?>
                <div class="offre-salaire">
                    <i class="fas fa-money-bill-wave"></i>
                    <?php
                        $sal = $offre->salaire_max ?: $offre->salaire_min;
                        $per = match($offre->salary_type) { 'year' => '/an', 'day' => '/jour', default => '/mois' };
                        echo number_format($sal, 0, ',', ' ') . ' ' . e($offre->devise) . ' ' . $per;
                    ?>
                </div>
                <?php endif; ?>

                <div class="card-footer">
                    <?php if (!auth()->check()): ?>
                        <a href="<?= route('connexion') ?>" class="btn-postuler">
                            <i class="fas fa-sign-in-alt"></i> Se connecter pour postuler
                        </a>
                    <?php elseif (auth()->user()->isCandidat()): ?>
                        <a href="<?= route('offer.apply', ['id' => $offre->id]) ?>" class="btn-postuler">
                            <i class="fas fa-paper-plane"></i> Postuler
                        </a>
                    <?php else: ?>
                        <span class="btn-postuler disabled">
                            <i class="fas fa-info-circle"></i> Réservé aux candidats
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($offres->hasPages()): ?>
        <div class="pagination">
            <?php if ($offres->onFirstPage()): ?>
                <span class="disabled"><i class="fas fa-chevron-left"></i></span>
            <?php else: ?>
                <a href="<?= $offres->previousPageUrl() ?>"><i class="fas fa-chevron-left"></i></a>
            <?php endif; ?>

            <?php foreach ($offres->getUrlRange(1, $offres->lastPage()) as $page => $url): ?>
                <?php if ($page === $offres->currentPage()): ?>
                    <span class="active"><?= $page ?></span>
                <?php else: ?>
                    <a href="<?= $url ?>"><?= $page ?></a>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($offres->hasMorePages()): ?>
                <a href="<?= $offres->nextPageUrl() ?>"><i class="fas fa-chevron-right"></i></a>
            <?php else: ?>
                <span class="disabled"><i class="fas fa-chevron-right"></i></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
</body>
</html>
