<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Validation des offres | JobAI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f3f4f6; color: #111827; min-height: 100vh; }

        .navbar {
            background: #1e293b;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar .logo { font-size: 1.4rem; font-weight: 800; color: #818cf8; }
        .navbar .nav-links { display: flex; gap: 1rem; align-items: center; }
        .navbar a { color: #94a3b8; text-decoration: none; font-size: 0.9rem; }
        .navbar a:hover { color: white; }

        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }

        /* Alertes flash */
        .flash { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.75rem; }
        .flash.succes { background: #d1fae5; color: #065f46; }
        .flash.info   { background: #dbeafe; color: #1e40af; }
        .flash.erreur { background: #fee2e2; color: #991b1b; }

        /* Stat cards */
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .stat-card .num { font-size: 2rem; font-weight: 800; color: #4f46e5; }
        .stat-card .label { font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem; }
        .stat-card.warning .num { color: #d97706; }
        .stat-card.success .num { color: #059669; }

        /* Sections */
        .section { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); padding: 1.75rem; margin-bottom: 2rem; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .section-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 0.5rem; }
        .badge-count { background: #fef3c7; color: #92400e; padding: 0.2rem 0.65rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; }
        .badge-count.green { background: #d1fae5; color: #065f46; }

        /* Table */
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 0.75rem 1rem; background: #f8fafc; text-align: left; font-size: 0.8rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }
        .table td { padding: 1rem; border-top: 1px solid #f1f5f9; font-size: 0.9rem; vertical-align: middle; }
        .table tr:hover td { background: #fafafa; }

        .offre-titre { font-weight: 700; color: #1e293b; margin-bottom: 0.2rem; }
        .offre-meta { font-size: 0.8rem; color: #6b7280; }

        .badge { display: inline-flex; align-items: center; padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge.pending  { background: #fef3c7; color: #92400e; }
        .badge.active   { background: #d1fae5; color: #065f46; }
        .badge.inactive { background: #fee2e2; color: #991b1b; }

        /* Boutons d'action */
        .actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 8px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all .2s; }
        .btn-approve { background: #d1fae5; color: #065f46; }
        .btn-approve:hover { background: #059669; color: white; }
        .btn-reject  { background: #fee2e2; color: #991b1b; }
        .btn-reject:hover  { background: #dc2626; color: white; }
        .btn-view    { background: #e0f2fe; color: #0c4a6e; }
        .btn-view:hover    { background: #0284c7; color: white; }
        .btn-primary { background: #4f46e5; color: white; padding: 0.65rem 1.25rem; border-radius: 10px; }
        .btn-primary:hover { background: #4338ca; }

        .empty { text-align: center; padding: 2.5rem; color: #9ca3af; }
        .empty i { font-size: 2rem; margin-bottom: 0.75rem; display: block; }

        .nav-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
        .nav-tab { padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; background: #f1f5f9; color: #6b7280; }
        .nav-tab.active { background: #4f46e5; color: white; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo"><i class="fas fa-briefcase"></i> JobAI Admin</div>
    <div class="nav-links">
        <a href="<?= route('home') ?>"><i class="fas fa-home"></i> Accueil</a>
        <a href="<?= route('offres.index') ?>"><i class="fas fa-list"></i> Offres publiées</a>
        <form method="POST" action="<?= route('logout') ?>" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:0.9rem;">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </div>
</nav>

<div class="container">

    <!-- Flash messages -->
    <?php if (session('succes')): ?>
        <div class="flash succes"><i class="fas fa-check-circle"></i> <?= e(session('succes')) ?></div>
    <?php endif; ?>
    <?php if (session('info')): ?>
        <div class="flash info"><i class="fas fa-info-circle"></i> <?= e(session('info')) ?></div>
    <?php endif; ?>
    <?php if (session('erreur')): ?>
        <div class="flash erreur"><i class="fas fa-exclamation-circle"></i> <?= e(session('erreur')) ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stats">
        <div class="stat-card warning">
            <div class="num"><?= count($demandesEnAttente) ?></div>
            <div class="label">Demandes employeur en attente</div>
        </div>
        <div class="stat-card warning">
            <div class="num"><?= count($offresEnAttente) ?></div>
            <div class="label">Offres en attente de validation</div>
        </div>
        <div class="stat-card success">
            <div class="num"><?= count($offresActives) ?></div>
            <div class="label">Offres actives publiées</div>
        </div>
        <div class="stat-card">
            <div class="num"><?= \App\Models\Candidature::count() ?></div>
            <div class="label">Candidatures totales</div>
        </div>
    </div>

    <!-- Section : demandes compte employeur -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-user-tie" style="color:#d97706"></i>
                Demandes de compte employeur
                <span class="badge-count"><?= count($demandesEnAttente) ?></span>
            </div>
        </div>

        <?php if ($demandesEnAttente->isEmpty()): ?>
            <div class="empty"><i class="fas fa-check-double"></i> Aucune demande en attente.</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Contact</th>
                        <th>Entreprise</th>
                        <th>Secteur</th>
                        <th>Soumis le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($demandesEnAttente as $demande): ?>
                    <tr>
                        <td>
                            <div style="font-weight:700"><?= e($demande->prenom . ' ' . $demande->nom) ?></div>
                            <div style="font-size:0.82rem;color:#6b7280"><?= e($demande->email) ?></div>
                            <?php if ($demande->telephone): ?><div style="font-size:0.82rem;color:#6b7280"><?= e($demande->telephone) ?></div><?php endif; ?>
                            <?php if ($demande->message): ?><div style="font-size:0.8rem;color:#9ca3af;margin-top:0.3rem;font-style:italic">"<?= e(substr($demande->message, 0, 80)) ?>..."</div><?php endif; ?>
                        </td>
                        <td style="font-weight:600"><?= e($demande->entreprise) ?></td>
                        <td><?= e($demande->secteur ?: '—') ?></td>
                        <td><?= $demande->created_at->format('d/m/Y H:i') ?></td>
                        <td>
                            <div class="actions">
                                <form method="POST" action="<?= route('admin.demande.approuver', $demande) ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-approve"><i class="fas fa-check"></i> Approuver</button>
                                </form>
                                <form method="POST" action="<?= route('admin.demande.rejeter', $demande) ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-reject" onclick="return confirm('Refuser cette demande ?')"><i class="fas fa-times"></i> Refuser</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Section : offres en attente de validation -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-clock" style="color:#d97706"></i>
                Offres en attente de validation
                <span class="badge-count"><?= count($offresEnAttente) ?></span>
            </div>
            <a href="<?= route('offres.index') ?>" class="btn btn-primary">
                <i class="fas fa-list"></i> Voir les offres publiées
            </a>
        </div>

        <?php if ($offresEnAttente->isEmpty()): ?>
            <div class="empty">
                <i class="fas fa-check-double"></i>
                Aucune offre en attente — tout est à jour !
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Poste</th>
                        <th>Entreprise</th>
                        <th>Lieu</th>
                        <th>Contrat</th>
                        <th>Soumis le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($offresEnAttente as $offre): ?>
                    <tr>
                        <td>
                            <div class="offre-titre"><?= e($offre->titre) ?></div>
                            <div class="offre-meta"><?= e($offre->competences) ?></div>
                        </td>
                        <td><?= e($offre->entreprise?->nom ?? '—') ?></td>
                        <td><?= e($offre->ville) ?>, <?= e($offre->pays) ?></td>
                        <td><span class="badge pending"><?= e($offre->type_contrat) ?></span></td>
                        <td><?= $offre->created_at?->format('d/m/Y H:i') ?></td>
                        <td>
                            <div class="actions">
                                <form method="POST" action="<?= route('admin.offre.approuver', $offre) ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-approve">
                                        <i class="fas fa-check"></i> Approuver
                                    </button>
                                </form>
                                <form method="POST" action="<?= route('admin.offre.rejeter', $offre) ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-reject" onclick="return confirm('Rejeter cette offre ?')">
                                        <i class="fas fa-times"></i> Rejeter
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Section : offres actives -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-briefcase" style="color:#059669"></i>
                Offres publiées (actives)
                <span class="badge-count green"><?= count($offresActives) ?></span>
            </div>
        </div>

        <?php if ($offresActives->isEmpty()): ?>
            <div class="empty">
                <i class="fas fa-inbox"></i>
                Aucune offre active pour le moment.
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Poste</th>
                        <th>Entreprise</th>
                        <th>Lieu</th>
                        <th>Contrat</th>
                        <th>Publiée le</th>
                        <th>Candidatures</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($offresActives as $offre): ?>
                    <tr>
                        <td>
                            <div class="offre-titre"><?= e($offre->titre) ?></div>
                        </td>
                        <td><?= e($offre->entreprise?->nom ?? '—') ?></td>
                        <td><?= e($offre->ville) ?>, <?= e($offre->pays) ?></td>
                        <td><span class="badge active"><?= e($offre->type_contrat) ?></span></td>
                        <td><?= $offre->date_publication?->format('d/m/Y') ?></td>
                        <td>
                            <span style="font-weight:700;color:#4f46e5">
                                <?= $offre->candidatures()->count() ?>
                            </span> candidature(s)
                        </td>
                        <td>
                            <div class="actions">
                                <a href="<?= route('offres.index') ?>" class="btn btn-view">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <form method="POST" action="<?= route('admin.offre.rejeter', $offre) ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-reject" onclick="return confirm('Désactiver cette offre ?')">
                                        <i class="fas fa-ban"></i> Désactiver
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
