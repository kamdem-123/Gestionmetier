<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Employeur — JobAI</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; color: #1e293b; }

        /* Navbar */
        .navbar { background: #1e293b; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { color: #818cf8; font-size: 1.4rem; font-weight: 800; text-decoration: none; }
        .navbar .nav-right { display: flex; gap: 1rem; align-items: center; }
        .navbar a, .navbar button { color: #94a3b8; text-decoration: none; font-size: 0.9rem; background: none; border: none; cursor: pointer; font-family: inherit; }
        .navbar a:hover, .navbar button:hover { color: white; }

        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }

        /* Flash */
        .flash { padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; }
        .flash.success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .flash.info    { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .flash.error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* Stats */
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
        .stat-card .num { font-size: 2rem; font-weight: 800; color: #4f46e5; }
        .stat-card.green .num { color: #059669; }
        .stat-card.orange .num { color: #d97706; }
        .stat-card .label { font-size: 0.82rem; color: #64748b; margin-top: 0.25rem; }

        /* Section header */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
        .section-title { font-size: 1.05rem; font-weight: 700; color: #1e293b; }

        /* Offre card */
        .offre-card { background: white; border-radius: 16px; padding: 1.5rem; margin-bottom: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.04); border-left: 4px solid #e2e8f0; transition: border-color .2s; }
        .offre-card.active  { border-left-color: #10b981; }
        .offre-card.pending { border-left-color: #f59e0b; }
        .offre-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; }
        .offre-titre { font-size: 1.05rem; font-weight: 700; color: #1e293b; }
        .offre-meta  { font-size: 0.82rem; color: #64748b; margin-top: 0.35rem; display: flex; gap: 1rem; flex-wrap: wrap; }
        .offre-actions { display: flex; gap: 0.5rem; align-items: center; flex-shrink: 0; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
        .badge.active   { background: #d1fae5; color: #065f46; }
        .badge.pending  { background: #fef3c7; color: #92400e; }
        .badge.inactive { background: #fee2e2; color: #991b1b; }
        .badge.candidat_en_attente { background: #fef9c3; color: #854d0e; }
        .badge.candidat_vue        { background: #e0f2fe; color: #0369a1; }
        .badge.candidat_entretien  { background: #d1fae5; color: #065f46; }
        .badge.candidat_refus      { background: #fee2e2; color: #991b1b; }

        /* Candidats */
        .candidats-section { margin-top: 1.25rem; border-top: 1px solid #f1f5f9; padding-top: 1.25rem; display: none; }
        .candidats-section.open { display: block; }
        .candidat-row { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 0.75rem; flex-wrap: wrap; }
        .candidat-name { font-weight: 700; font-size: 0.95rem; }
        .candidat-info { font-size: 0.82rem; color: #64748b; margin-top: 0.2rem; }
        .candidat-actions { display: flex; gap: 0.5rem; align-items: center; flex-shrink: 0; }

        /* Boutons */
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.55rem 1.1rem; border-radius: 8px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all .2s; font-family: inherit; }
        .btn-primary    { background: #4f46e5; color: white; }
        .btn-primary:hover { background: #4338ca; }
        .btn-success    { background: #d1fae5; color: #065f46; }
        .btn-success:hover { background: #059669; color: white; }
        .btn-danger     { background: #fee2e2; color: #991b1b; }
        .btn-danger:hover { background: #dc2626; color: white; }
        .btn-secondary  { background: #f1f5f9; border: 1px solid #e2e8f0; color: #475569; }
        .btn-secondary:hover { background: #e2e8f0; }

        /* Empty */
        .empty-state { text-align: center; padding: 3rem; color: #94a3b8; background: white; border-radius: 20px; }
        .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 1rem; }
        .empty-state p { margin-bottom: 1.5rem; }

        /* ═══════════════════════════════════════
           MODALE PUBLICATION OFFRE
        ═══════════════════════════════════════ */
        .modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.6); display: none; align-items: center; justify-content: center; z-index: 9999; padding: 1rem; backdrop-filter: blur(4px); }
        .modal-overlay.open { display: flex; }

        .modal { background: white; border-radius: 24px; width: 100%; max-width: 620px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 60px rgba(0,0,0,0.3); animation: slideUp .3s ease; }
        @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .modal-header { padding: 1.75rem 2rem 0; display: flex; justify-content: space-between; align-items: center; }
        .modal-header h2 { font-size: 1.2rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 0.6rem; }
        .modal-close { background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 1rem; color: #64748b; display: flex; align-items: center; justify-content: center; transition: all .2s; }
        .modal-close:hover { background: #e2e8f0; color: #1e293b; }

        .modal-body { padding: 1.5rem 2rem 2rem; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 1.1rem; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { display: block; font-size: 0.83rem; font-weight: 600; color: #374151; margin-bottom: 0.4rem; }
        .form-group label .req { color: #ef4444; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 0.9rem; font-family: inherit; color: #1e293b; transition: border-color .2s; background: white;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .form-group textarea { resize: vertical; min-height: 100px; line-height: 1.6; }
        .char-count { font-size: 0.75rem; color: #94a3b8; text-align: right; margin-top: 0.25rem; }

        /* Tags compétences */
        .tags-wrap { border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 0.5rem; display: flex; flex-wrap: wrap; gap: 0.4rem; cursor: text; min-height: 48px; transition: border-color .2s; }
        .tags-wrap:focus-within { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .tag-chip { display: inline-flex; align-items: center; gap: 0.3rem; background: #ede9fe; color: #4f46e5; font-size: 0.8rem; font-weight: 600; padding: 0.25rem 0.65rem; border-radius: 20px; }
        .tag-chip button { background: none; border: none; cursor: pointer; color: #4f46e5; font-size: 0.9rem; line-height: 1; padding: 0; }
        .tag-chip button:hover { color: #dc2626; }
        .tag-input { border: none !important; outline: none !important; padding: 0.25rem 0.4rem !important; font-size: 0.88rem !important; min-width: 120px; flex: 1; box-shadow: none !important; }

        /* Salaire row */
        .salary-row { display: grid; grid-template-columns: 1fr 1fr 120px 110px; gap: 0.75rem; }

        /* Section divider */
        .form-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.25rem 0 1rem; }
        .form-section-label { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 1rem; }

        /* Validation errors */
        .field-error { font-size: 0.78rem; color: #ef4444; margin-top: 0.3rem; display: none; }
        .field-error.show { display: block; }
        .field-invalid { border-color: #ef4444 !important; }

        .modal-footer { padding: 1.25rem 2rem 1.75rem; border-top: 1px solid #f1f5f9; display: flex; gap: 0.75rem; justify-content: flex-end; }

        /* Modale entretien */
        .modal-sm { max-width: 420px; }

        @media(max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
            .salary-row { grid-template-columns: 1fr 1fr; }
            .stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/" class="logo"><i class="fas fa-briefcase"></i> JobAI</a>
    <div class="nav-right">
        <span style="color:#94a3b8;font-size:0.88rem">
            <i class="fas fa-building"></i> <?= e($entreprise) ?>
        </span>
        <a href="/"><i class="fas fa-home"></i> Accueil</a>
        <form method="POST" action="<?= route('logout') ?>">
            <?= csrf_field() ?>
            <button type="submit"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
        </form>
    </div>
</nav>

<div class="container">

    <!-- Flash messages -->
    <?php if (session('succes')): ?>
        <div class="flash success"><i class="fas fa-check-circle"></i> <?= e(session('succes')) ?></div>
    <?php endif; ?>
    <?php if (session('info')): ?>
        <div class="flash info"><i class="fas fa-info-circle"></i> <?= e(session('info')) ?></div>
    <?php endif; ?>
    <?php if (session('erreur')): ?>
        <div class="flash error"><i class="fas fa-exclamation-circle"></i> <?= e(session('erreur')) ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stats">
        <div class="stat-card">
            <div class="num"><?= $totalOffres ?></div>
            <div class="label">Offres publiées</div>
        </div>
        <div class="stat-card green">
            <div class="num"><?= $totalCandidatures ?></div>
            <div class="label">Candidatures reçues</div>
        </div>
        <div class="stat-card orange">
            <div class="num"><?= $entretiensAVenir ?></div>
            <div class="label">Entretiens à venir</div>
        </div>
    </div>

    <!-- Header mes offres -->
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-list-alt" style="color:#4f46e5"></i> Mes offres d'emploi
        </h2>
        <button class="btn btn-primary" onclick="ouvrirModalOffre()">
            <i class="fas fa-plus"></i> Publier une offre
        </button>
    </div>

    <!-- Liste des offres -->
    <?php if ($offres->isEmpty()): ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Vous n'avez pas encore publié d'offre.</p>
            <button class="btn btn-primary" onclick="ouvrirModalOffre()">
                <i class="fas fa-plus"></i> Publier ma première offre
            </button>
        </div>
    <?php else: ?>
        <?php foreach ($offres as $offre): ?>
        <div class="offre-card <?= e($offre->status) ?>">
            <div class="offre-header">
                <div>
                    <div class="offre-titre"><?= e($offre->titre) ?></div>
                    <div class="offre-meta">
                        <span><i class="fas fa-map-marker-alt"></i> <?= e($offre->ville) ?><?= $offre->pays ? ', '.e($offre->pays) : '' ?></span>
                        <span><i class="fas fa-file-contract"></i> <?= e($offre->type_contrat) ?></span>
                        <?php if ($offre->mode_travail): ?>
                            <span><i class="fas fa-laptop-house"></i> <?= e($offre->mode_travail) ?></span>
                        <?php endif; ?>
                        <span><i class="fas fa-users"></i> <?= $offre->candidatures->count() ?> candidature(s)</span>
                        <span><i class="fas fa-calendar"></i> <?= $offre->created_at->format('d/m/Y') ?></span>
                    </div>
                </div>
                <div class="offre-actions">
                    <span class="badge <?= e($offre->status) ?>">
                        <?= match($offre->status) {
                            'active'   => '<i class="fas fa-check-circle"></i> Publiée',
                            'pending'  => '<i class="fas fa-clock"></i> En attente',
                            'inactive' => '<i class="fas fa-ban"></i> Désactivée',
                            default    => e($offre->status)
                        } ?>
                    </span>
                    <?php $nbCands = $offre->candidatures->count(); ?>
                    <?php if ($nbCands > 0): ?>
                        <button class="btn btn-secondary" onclick="toggleCandidats(<?= $offre->id ?>)" id="btn-cands-<?= $offre->id ?>">
                            <i class="fas fa-chevron-up"></i>
                            <span style="background:#4f46e5;color:white;border-radius:20px;padding:0.1rem 0.55rem;font-size:0.78rem;margin-left:0.3rem;"><?= $nbCands ?></span>
                            Candidat<?= $nbCands > 1 ? 's' : '' ?>
                        </button>
                    <?php else: ?>
                        <span style="font-size:0.82rem;color:#94a3b8;font-style:italic;">Aucune candidature</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Candidats — ouverts par défaut -->
            <?php if ($offre->candidatures->count() > 0): ?>
            <div class="candidats-section open" id="candidats-<?= $offre->id ?>">
                <?php foreach ($offre->candidatures->sortByDesc('score_matching') as $c): ?>
                <div class="candidat-row">
                    <div>
                        <div class="candidat-name"><?= e($c->user?->name ?? '—') ?></div>
                        <div class="candidat-info">
                            <?= e($c->user?->email) ?>
                            <?php if ($c->user?->titre_poste): ?> &bull; <?= e($c->user->titre_poste) ?><?php endif; ?>
                            <?php if ($c->score_matching): ?>
                                &bull; <strong style="color:#4f46e5"><?= number_format($c->score_matching, 1) ?>% correspondance IA</strong>
                            <?php endif; ?>
                        </div>
                        <?php if ($c->statut === 'entretien_programme' && $c->entretien_date): ?>
                            <div style="font-size:0.8rem;color:#059669;margin-top:0.35rem">
                                <i class="fas fa-calendar-check"></i>
                                Entretien le <?= $c->entretien_date->format('d/m/Y') ?> à <?= substr($c->entretien_heure ?? '', 0, 5) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="candidat-actions">
                        <span class="badge candidat_<?= $c->statut === 'entretien_programme' ? 'entretien' : ($c->statut === 'refusee' ? 'refus' : ($c->statut === 'vue' ? 'vue' : 'en_attente')) ?>">
                            <?= $c->libelleStatut() ?>
                        </span>
                        <?php if (!in_array($c->statut, ['refusee', 'entretien_programme'])): ?>
                            <button class="btn btn-success" onclick="ouvrirModalEntretien(<?= $c->id ?>, '<?= e($c->user?->name) ?>')">
                                <i class="fas fa-calendar-plus"></i> Entretien
                            </button>
                            <form method="POST" action="<?= route('employeur.rejeter', $c) ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Rejeter le dossier de <?= e($c->user?->name) ?> ?')">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<!-- ═══════════════════════════════════════════
     MODALE : Publier une offre
═══════════════════════════════════════════ -->
<div class="modal-overlay" id="modalOffre">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-plus-circle" style="color:#4f46e5"></i> Publier une offre</h2>
            <button class="modal-close" onclick="fermerModalOffre()"><i class="fas fa-times"></i></button>
        </div>

        <form class="modal-body" id="formOffre" method="POST" action="<?= route('offres.store') ?>">
            <?= csrf_field() ?>

            <!-- Poste -->
            <div class="form-section-label">Informations sur le poste</div>

            <div class="form-group full">
                <label>Titre du poste <span class="req">*</span></label>
                <input type="text" name="titre" id="f-titre" placeholder="Ex : Développeur Full Stack React" maxlength="150">
                <span class="field-error" id="e-titre">Ce champ est obligatoire.</span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Type de contrat <span class="req">*</span></label>
                    <select name="type_contrat" id="f-type_contrat">
                        <option value="">— Choisir —</option>
                        <option>CDI</option>
                        <option>CDD</option>
                        <option>Stage</option>
                        <option>Alternance</option>
                        <option>Freelance</option>
                        <option>Temps partiel</option>
                    </select>
                    <span class="field-error" id="e-type_contrat">Veuillez choisir un type.</span>
                </div>
                <div class="form-group">
                    <label>Mode de travail</label>
                    <select name="mode_travail">
                        <option value="">— Choisir —</option>
                        <option>Présentiel</option>
                        <option>Télétravail</option>
                        <option>Hybride</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Ville <span class="req">*</span></label>
                    <input type="text" name="ville" id="f-ville" placeholder="Ex : Douala">
                    <span class="field-error" id="e-ville">Veuillez indiquer la ville.</span>
                </div>
                <div class="form-group">
                    <label>Pays <span class="req">*</span></label>
                    <input type="text" name="pays" id="f-pays" placeholder="Ex : Cameroun">
                    <span class="field-error" id="e-pays">Veuillez indiquer le pays.</span>
                </div>
            </div>

            <div class="form-group">
                <label>Catégorie métier</label>
                <select name="categorie">
                    <option value="">— Choisir —</option>
                    <option>Informatique / Tech</option>
                    <option>Finance / Banque</option>
                    <option>Santé / Médical</option>
                    <option>Éducation</option>
                    <option>Commerce / Vente</option>
                    <option>Marketing / Communication</option>
                    <option>BTP / Construction</option>
                    <option>Transport / Logistique</option>
                    <option>Ressources Humaines</option>
                    <option>Juridique</option>
                    <option>Autre</option>
                </select>
            </div>

            <hr class="form-divider">
            <div class="form-section-label">Description & Compétences</div>

            <div class="form-group">
                <label>Description du poste <span class="req">*</span> <span id="desc-count" style="font-weight:400;color:#94a3b8;font-size:0.78rem">0 / 2000</span></label>
                <textarea name="description" id="f-description" placeholder="Décrivez les missions, le profil recherché, les avantages…" maxlength="2000"></textarea>
                <span class="field-error" id="e-description">Minimum 50 caractères.</span>
            </div>

            <div class="form-group">
                <label>Compétences requises <span class="req">*</span> <span style="font-weight:400;color:#94a3b8;font-size:0.78rem">Appuyer Entrée ou virgule</span></label>
                <div class="tags-wrap" id="tagsWrap" onclick="document.getElementById('tagInput').focus()">
                    <input class="tag-input" type="text" id="tagInput" placeholder="Ex : Python, Gestion projet…">
                </div>
                <input type="hidden" name="competences" id="competencesHidden">
                <span class="field-error" id="e-competences">Ajoutez au moins une compétence.</span>
            </div>

            <hr class="form-divider">
            <div class="form-section-label">Rémunération <span style="font-weight:400;color:#94a3b8">(optionnel)</span></div>

            <div class="salary-row">
                <div class="form-group" style="margin:0">
                    <label>Salaire min.</label>
                    <input type="number" name="salaire_min" placeholder="0" min="0">
                </div>
                <div class="form-group" style="margin:0">
                    <label>Salaire max.</label>
                    <input type="number" name="salaire_max" placeholder="0" min="0">
                </div>
                <div class="form-group" style="margin:0">
                    <label>Devise</label>
                    <select name="devise">
                        <option value="XAF">FCFA</option>
                        <option value="XOF">XOF</option>
                        <option value="EUR">€ EUR</option>
                        <option value="USD">$ USD</option>
                        <option value="CAD">CA$</option>
                        <option value="CHF">CHF</option>
                        <option value="MAD">DH</option>
                        <option value="NGN">₦</option>
                    </select>
                </div>
                <div class="form-group" style="margin:0">
                    <label>Période</label>
                    <select name="salary_type">
                        <option value="month">/ mois</option>
                        <option value="year">/ an</option>
                        <option value="day">/ jour</option>
                    </select>
                </div>
            </div>

        </form>

        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="fermerModalOffre()">Annuler</button>
            <button class="btn btn-primary" onclick="soumettreOffre()">
                <i class="fas fa-paper-plane"></i> Soumettre pour validation
            </button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════
     MODALE : Programmer un entretien
═══════════════════════════════════════════ -->
<div class="modal-overlay" id="modalEntretien">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h2><i class="fas fa-calendar-plus" style="color:#059669"></i> Programmer un entretien</h2>
            <button class="modal-close" onclick="fermerModalEntretien()"><i class="fas fa-times"></i></button>
        </div>
        <form class="modal-body" id="formEntretien" method="POST">
            <?= csrf_field() ?>
            <p id="modal-candidat-name" style="color:#64748b;font-size:0.88rem;margin-bottom:1.25rem;background:#f8fafc;padding:0.75rem 1rem;border-radius:8px"></p>
            <div class="form-group">
                <label>Date de l'entretien <span class="req">*</span></label>
                <input type="date" name="entretien_date" required min="<?= now()->toDateString() ?>">
            </div>
            <div class="form-group">
                <label>Heure <span class="req">*</span></label>
                <input type="time" name="entretien_heure" required>
            </div>
            <div class="form-group">
                <label>Message pour le candidat <span style="font-weight:400;color:#94a3b8">(optionnel)</span></label>
                <textarea name="note_employeur" rows="3" placeholder="Ex : Entretien via Google Meet, lien vous sera transmis..."></textarea>
            </div>
        </form>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="fermerModalEntretien()">Annuler</button>
            <button class="btn btn-success" onclick="document.getElementById('formEntretien').submit()">
                <i class="fas fa-paper-plane"></i> Envoyer l'invitation
            </button>
        </div>
    </div>
</div>

<script>
// ─── Tags compétences ───
const tags = [];
const tagInput   = document.getElementById('tagInput');
const tagsWrap   = document.getElementById('tagsWrap');
const hiddenComp = document.getElementById('competencesHidden');

function addTag(val) {
    val = val.trim().replace(/,/g, '');
    if (!val || tags.includes(val) || tags.length >= 12) return;
    tags.push(val);
    renderTags();
}
function removeTag(i) { tags.splice(i, 1); renderTags(); }
function renderTags() {
    tagsWrap.querySelectorAll('.tag-chip').forEach(e => e.remove());
    tags.forEach((t, i) => {
        const chip = document.createElement('span');
        chip.className = 'tag-chip';
        chip.innerHTML = `${t}<button type="button" onclick="removeTag(${i})">×</button>`;
        tagsWrap.insertBefore(chip, tagInput);
    });
    hiddenComp.value = tags.join(',');
}
tagInput.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        addTag(tagInput.value); tagInput.value = '';
    } else if (e.key === 'Backspace' && !tagInput.value && tags.length) {
        removeTag(tags.length - 1);
    }
});
tagInput.addEventListener('blur', () => { if (tagInput.value.trim()) { addTag(tagInput.value); tagInput.value = ''; } });

// ─── Compteur description ───
const descArea  = document.getElementById('f-description');
const descCount = document.getElementById('desc-count');
descArea.addEventListener('input', () => {
    const l = descArea.value.length;
    descCount.textContent = `${l} / 2000`;
    descCount.style.color = l > 1800 ? '#ef4444' : '#94a3b8';
});

// ─── Modales offre ───
function ouvrirModalOffre() { document.getElementById('modalOffre').classList.add('open'); document.body.style.overflow = 'hidden'; }
function fermerModalOffre() { document.getElementById('modalOffre').classList.remove('open'); document.body.style.overflow = ''; }

function soumettreOffre() {
    let ok = true;
    const rules = [
        { id: 'f-titre',        err: 'e-titre',        check: v => v.trim().length >= 3 },
        { id: 'f-type_contrat', err: 'e-type_contrat', check: v => v !== '' },
        { id: 'f-ville',        err: 'e-ville',        check: v => v.trim().length >= 2 },
        { id: 'f-pays',         err: 'e-pays',         check: v => v.trim().length >= 2 },
        { id: 'f-description',  err: 'e-description',  check: v => v.trim().length >= 50 },
    ];
    rules.forEach(r => {
        const el  = document.getElementById(r.id);
        const err = document.getElementById(r.err);
        if (!r.check(el.value)) {
            el.classList.add('field-invalid'); err.classList.add('show'); ok = false;
        } else {
            el.classList.remove('field-invalid'); err.classList.remove('show');
        }
    });
    const compErr = document.getElementById('e-competences');
    if (!tags.length) { tagsWrap.style.borderColor = '#ef4444'; compErr.classList.add('show'); ok = false; }
    else              { tagsWrap.style.borderColor = '';        compErr.classList.remove('show'); }

    if (ok) document.getElementById('formOffre').submit();
}

// ─── Modal entretien ───
function ouvrirModalEntretien(candidatureId, nomCandidat) {
    document.getElementById('formEntretien').action = '/employeur/candidature/' + candidatureId + '/entretien';
    document.getElementById('modal-candidat-name').innerHTML = '<i class="fas fa-user"></i> Candidat : <strong>' + nomCandidat + '</strong>';
    document.getElementById('modalEntretien').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function fermerModalEntretien() { document.getElementById('modalEntretien').classList.remove('open'); document.body.style.overflow = ''; }

// ─── Toggles candidats ───
function toggleCandidats(id) {
    const section = document.getElementById('candidats-' + id);
    const btn     = document.getElementById('btn-cands-' + id);
    section.classList.toggle('open');
    const icon = btn ? btn.querySelector('i') : null;
    if (icon) icon.className = section.classList.contains('open') ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
}

// ─── Fermer modal sur clic extérieur ───
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => { if (e.target === overlay) { fermerModalOffre(); fermerModalEntretien(); } });
});

// ═══════════════════════════════════════════════
// POLLING TEMPS RÉEL — toutes les 12 secondes
// ═══════════════════════════════════════════════
const LIVE_URL   = '<?= route('employeur.live') ?>';
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
let   lastTotals = {};   // { offre_id: total_candidatures }
let   isFirst    = true;

function statutBadgeClass(statut) {
    return statut === 'entretien_programme' ? 'candidat_entretien'
         : statut === 'refusee'            ? 'candidat_refus'
         : statut === 'vue'                ? 'candidat_vue'
         : 'candidat_en_attente';
}

function buildCandidatRow(c) {
    const scoreHtml = c.score
        ? `&bull; <strong style="color:#4f46e5">${c.score}% correspondance IA</strong>` : '';
    const entretienHtml = (c.statut === 'entretien_programme' && c.entretien_date)
        ? `<div style="font-size:0.8rem;color:#059669;margin-top:0.35rem">
               <i class="fas fa-calendar-check"></i> Entretien le ${c.entretien_date} à ${c.entretien_heure}
           </div>` : '';
    const actionsHtml = c.peut_agir
        ? `<button class="btn btn-success" onclick="ouvrirModalEntretien(${c.id}, '${c.nom.replace(/'/g,"\\'")}')">
               <i class="fas fa-calendar-plus"></i> Entretien
           </button>
           <form method="POST" action="${c.rejeter_url}" style="display:inline">
               <input type="hidden" name="_token" value="${CSRF_TOKEN}">
               <button type="submit" class="btn btn-danger"
                   onclick="return confirm('Rejeter le dossier de ${c.nom.replace(/'/g,"\\'")} ?')">
                   <i class="fas fa-times"></i> Rejeter
               </button>
           </form>` : '';

    return `<div class="candidat-row" id="cand-row-${c.id}">
        <div>
            <div class="candidat-name">${c.nom}</div>
            <div class="candidat-info">${c.email}${c.titre_poste ? ' &bull; ' + c.titre_poste : ''} ${scoreHtml}</div>
            ${entretienHtml}
        </div>
        <div class="candidat-actions">
            <span class="badge ${statutBadgeClass(c.statut)}">${c.statut_libelle}</span>
            ${actionsHtml}
        </div>
    </div>`;
}

async function pollCandidatures() {
    try {
        const res  = await fetch(LIVE_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!res.ok) return;
        const data = await res.json();

        // Mettre à jour le compteur global
        const totalEl = document.querySelector('.stat-card.green .num');
        if (totalEl) totalEl.textContent = data.totalCandidatures;

        data.offres.forEach(offre => {
            const section = document.getElementById('candidats-' + offre.id);
            const btnEl   = document.getElementById('btn-cands-' + offre.id);
            const prev    = lastTotals[offre.id] ?? offre.total;

            // Nouvelle candidature détectée
            if (!isFirst && offre.total > prev) {
                const nb     = offre.total - prev;
                const notif  = document.createElement('div');
                notif.style.cssText = 'position:fixed;top:1.2rem;right:1.2rem;background:#4f46e5;color:white;padding:0.9rem 1.4rem;border-radius:14px;box-shadow:0 8px 24px rgba(79,70,229,0.35);z-index:9999;font-weight:700;font-size:0.95rem;display:flex;align-items:center;gap:0.6rem;animation:slideIn .3s ease';
                notif.innerHTML = `<i class="fas fa-user-plus"></i> ${nb} nouvelle${nb>1?'s':''} candidature${nb>1?'s':''}`;
                document.body.appendChild(notif);
                setTimeout(() => notif.remove(), 4000);
            }

            lastTotals[offre.id] = offre.total;

            if (!section) return;

            // Reconstruire la section candidats
            if (offre.total === 0) {
                section.innerHTML = '';
                section.classList.remove('open');
                if (btnEl) btnEl.style.display = 'none';
                return;
            }

            if (btnEl) {
                btnEl.style.display = '';
                const badge = btnEl.querySelector('span');
                if (badge) badge.textContent = offre.total;
            }

            section.innerHTML = offre.candidatures.map(buildCandidatRow).join('');
            section.classList.add('open');
        });

        isFirst = false;

    } catch(e) { /* silencieux si réseau indispo */ }
}

// Ajout animation CSS pour la notif
const styleEl = document.createElement('style');
styleEl.textContent = '@keyframes slideIn{from{transform:translateX(120%);opacity:0}to{transform:translateX(0);opacity:1}}';
document.head.appendChild(styleEl);

// Lancer dès le chargement puis toutes les 12s
pollCandidatures();
setInterval(pollCandidatures, 12000);
</script>
</body>
</html>
