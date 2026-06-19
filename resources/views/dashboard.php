<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon espace candidat — JobAI</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; }

        /* Navbar */
        .navbar { background: #4f46e5; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { color: white; font-size: 1.4rem; font-weight: 800; text-decoration: none; }
        .navbar .nav-right { display: flex; align-items: center; gap: 1rem; }
        .navbar .user-name { color: rgba(255,255,255,0.85); font-size: 0.9rem; }
        .btn-logout { background: rgba(255,255,255,0.15); border: none; color: white; padding: 0.45rem 1rem; border-radius: 8px; cursor: pointer; font-size: 0.85rem; }
        .btn-logout:hover { background: rgba(255,255,255,0.25); }

        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }

        /* Flash */
        .flash { padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; }
        .flash.success { background: #d1fae5; color: #065f46; }
        .flash.error   { background: #fee2e2; color: #991b1b; }

        /* Stats */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; border-radius: 16px; padding: 1.25rem 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
        .stat-card .num { font-size: 1.8rem; font-weight: 800; color: #4f46e5; }
        .stat-card.orange .num { color: #d97706; }
        .stat-card.green .num  { color: #059669; }
        .stat-card.red .num    { color: #dc2626; }
        .stat-card .label { font-size: 0.8rem; color: #64748b; margin-top: 0.2rem; }

        /* Section */
        .section { background: white; border-radius: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); padding: 1.75rem; margin-bottom: 1.5rem; }
        .section-title { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; }

        /* Candidatures */
        .candidature-card { border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.25rem; margin-bottom: 1rem; display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start; }
        .candidature-card:last-child { margin-bottom: 0; }
        .offre-titre { font-weight: 700; font-size: 1rem; color: #1e293b; margin-bottom: 0.2rem; }
        .offre-entreprise { font-size: 0.85rem; color: #64748b; margin-bottom: 0.5rem; }
        .offre-meta { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .meta-tag { font-size: 0.78rem; color: #64748b; display: flex; align-items: center; gap: 0.3rem; }

        /* Badges statut */
        .badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; white-space: nowrap; }
        .badge.en_attente          { background: #fef9c3; color: #854d0e; }
        .badge.vue                 { background: #e0f2fe; color: #0369a1; }
        .badge.entretien_programme { background: #d1fae5; color: #065f46; }
        .badge.refusee             { background: #fee2e2; color: #991b1b; }
        .badge.acceptee            { background: #d1fae5; color: #065f46; }

        /* Entretien info */
        .entretien-info { margin-top: 0.75rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.85rem; color: #166534; }
        .entretien-info i { margin-right: 0.4rem; }

        /* Score bar */
        .score-bar { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; }
        .score-track { flex: 1; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; max-width: 120px; }
        .score-fill  { height: 100%; border-radius: 3px; background: linear-gradient(90deg, #4f46e5, #06b6d4); }
        .score-text  { font-size: 0.78rem; font-weight: 700; color: #4f46e5; }

        /* Notifications */
        .notif-item { display: flex; gap: 0.75rem; align-items: flex-start; padding: 0.85rem; border-radius: 10px; margin-bottom: 0.5rem; background: #f8fafc; }
        .notif-item.unread { background: #eef2ff; }
        .notif-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem; }
        .notif-icon.entretien { background: #d1fae5; color: #059669; }
        .notif-icon.refus     { background: #fee2e2; color: #dc2626; }
        .notif-icon.match     { background: #dbeafe; color: #2563eb; }
        .notif-text  { font-size: 0.85rem; color: #334155; flex: 1; }
        .notif-date  { font-size: 0.75rem; color: #94a3b8; white-space: nowrap; }

        .empty { text-align: center; padding: 2.5rem; color: #94a3b8; }
        .empty i { font-size: 2rem; display: block; margin-bottom: 0.75rem; }

        .btn-primary { display: inline-flex; align-items: center; gap: 0.5rem; background: #4f46e5; color: white; padding: 0.7rem 1.4rem; border-radius: 10px; text-decoration: none; font-size: 0.9rem; font-weight: 600; }
        .btn-primary:hover { background: #4338ca; }

        @media(max-width: 768px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
            .candidature-card { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/" class="logo"><i class="fas fa-briefcase"></i> JobAI</a>
    <div class="nav-right">
        <?php if ($user->avatar): ?>
            <img src="<?= e($user->avatar) ?>" alt="" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
        <?php endif; ?>
        <span class="user-name"><?= e($user->name) ?></span>

        <!-- Cloche notifications -->
        <div style="position:relative;cursor:pointer" onclick="toggleNotifPanel()">
            <div style="width:36px;height:36px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-bell" style="color:white;font-size:1rem"></i>
            </div>
            <span id="notif-badge" style="position:absolute;top:-4px;right:-4px;background:#ef4444;color:white;font-size:0.65rem;font-weight:800;width:18px;height:18px;border-radius:50%;display:<?= $totalNonLues > 0 ? 'flex' : 'none' ?>;align-items:center;justify-content:center;border:2px solid #4f46e5"><?= $totalNonLues ?></span>
        </div>

        <form method="POST" action="<?= route('logout') ?>">
            <?= csrf_field() ?>
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
        </form>
    </div>
</nav>

<!-- Panneau notifications déroulant -->
<div id="notif-panel" style="display:none;position:fixed;top:64px;right:1.5rem;width:360px;background:white;border-radius:16px;box-shadow:0 8px 40px rgba(0,0,0,0.18);z-index:9999;overflow:hidden;border:1px solid #e2e8f0">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center">
        <span style="font-weight:700;font-size:0.95rem">Notifications</span>
        <button onclick="marquerToutLu()" style="background:none;border:none;color:#4f46e5;cursor:pointer;font-size:0.8rem;font-weight:600">Tout marquer lu</button>
    </div>
    <div id="notif-list" style="max-height:380px;overflow-y:auto;padding:0.5rem"></div>
    <div id="notif-empty" style="display:none;padding:2rem;text-align:center;color:#94a3b8;font-size:0.88rem">
        <i class="fas fa-check-circle" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;color:#d1fae5"></i>
        Aucune notification non lue
    </div>
</div>

<div class="container">

    <?php if (session('succes')): ?>
        <div class="flash success"><i class="fas fa-check-circle"></i> <?= e(session('succes')) ?></div>
    <?php endif; ?>
    <?php if (session('erreur')): ?>
        <div class="flash error"><i class="fas fa-exclamation-circle"></i> <?= e(session('erreur')) ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stats">
        <div class="stat-card">
            <div class="num"><?= $totalPostules ?></div>
            <div class="label">Candidatures envoyées</div>
        </div>
        <div class="stat-card orange">
            <div class="num"><?= $enCours ?></div>
            <div class="label">En cours d'examen</div>
        </div>
        <div class="stat-card green">
            <div class="num"><?= $entretiensProgammes ?></div>
            <div class="label">Entretiens programmés</div>
        </div>
        <div class="stat-card red">
            <div class="num"><?= $refusees ?></div>
            <div class="label">Dossiers non retenus</div>
        </div>
    </div>

    <!-- Mes candidatures -->
    <div class="section">
        <div class="section-title" style="justify-content:space-between">
            <span><i class="fas fa-file-alt" style="color:#4f46e5"></i> Mes candidatures</span>
            <a href="/offres" class="btn-primary"><i class="fas fa-search"></i> Voir les offres</a>
        </div>

        <?php if ($candidatures->isEmpty()): ?>
            <div class="empty">
                <i class="fas fa-inbox"></i>
                Vous n'avez pas encore postulé à une offre.<br>
                <a href="/offres" style="color:#4f46e5;text-decoration:none;font-weight:600;">Parcourez les offres disponibles</a>
            </div>
        <?php else: ?>
            <?php foreach ($candidatures as $c): ?>
            <?php $offre = $c->offre; $entreprise = $offre?->entreprise; ?>
            <div class="candidature-card">
                <div>
                    <div class="offre-titre"><?= e($offre?->titre ?? 'Offre supprimée') ?></div>
                    <div class="offre-entreprise">
                        <i class="fas fa-building" style="font-size:0.75rem"></i>
                        <?= e($entreprise?->nom ?? '—') ?>
                        <?php if ($offre?->ville): ?> &bull; <?= e($offre->ville) ?><?php endif; ?>
                    </div>
                    <div class="offre-meta">
                        <?php if ($offre?->type_contrat): ?>
                            <span class="meta-tag"><i class="fas fa-file-contract"></i> <?= e($offre->type_contrat) ?></span>
                        <?php endif; ?>
                        <span class="meta-tag"><i class="fas fa-calendar"></i> Postulé le <?= $c->created_at->format('d/m/Y') ?></span>
                    </div>

                    <?php if ($c->score_matching): ?>
                    <div class="score-bar">
                        <div class="score-track"><div class="score-fill" style="width:<?= min(100, $c->score_matching) ?>%"></div></div>
                        <span class="score-text"><?= number_format($c->score_matching, 1) ?>% de correspondance IA</span>
                    </div>
                    <?php endif; ?>

                    <?php if ($c->statut === 'entretien_programme' && $c->entretien_date): ?>
                    <div class="entretien-info">
                        <i class="fas fa-calendar-check"></i>
                        Entretien programmé le <strong><?= $c->entretien_date->format('d/m/Y') ?></strong>
                        à <strong><?= substr($c->entretien_heure ?? '', 0, 5) ?></strong>
                        <?php if ($c->note_employeur): ?>
                            &bull; <em><?= e($c->note_employeur) ?></em>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div>
                    <span class="badge <?= e($c->statut) ?>">
                        <?php match($c->statut) {
                            'en_attente'          => print('<i class="fas fa-clock"></i> En attente'),
                            'vue'                 => print('<i class="fas fa-eye"></i> Vue'),
                            'entretien_programme' => print('<i class="fas fa-calendar-check"></i> Entretien'),
                            'refusee'             => print('<i class="fas fa-times-circle"></i> Non retenu'),
                            'acceptee'            => print('<i class="fas fa-check-circle"></i> Acceptée'),
                            default               => print(e($c->statut)),
                        }; ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Notifications dans la page -->
    <div class="section" id="section-notifs">
        <div class="section-title">
            <i class="fas fa-bell" style="color:#4f46e5"></i> Notifications
            <span id="page-notif-badge" style="background:#4f46e5;color:white;font-size:0.75rem;padding:0.15rem 0.55rem;border-radius:20px;font-weight:700;<?= $totalNonLues > 0 ? '' : 'display:none' ?>"><?= $totalNonLues ?></span>
        </div>
        <div id="page-notif-list">
        <?php if ($notifications->isNotEmpty()): ?>
            <?php foreach ($notifications as $notif): ?>
            <?php $data = $notif->data; $type = $data['type'] ?? ''; ?>
            <div class="notif-item unread">
                <div class="notif-icon <?= $type === 'entretien_programme' ? 'entretien' : ($type === 'dossier_rejete' ? 'refus' : 'match') ?>">
                    <i class="fas fa-<?= $type === 'entretien_programme' ? 'calendar-check' : ($type === 'dossier_rejete' ? 'times' : 'star') ?>"></i>
                </div>
                <div class="notif-text"><?= e($data['message'] ?? '') ?></div>
                <div class="notif-date"><?= $notif->created_at->diffForHumans() ?></div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p id="page-notif-empty" style="color:#94a3b8;font-size:0.88rem;text-align:center;padding:1.5rem 0">
                <i class="fas fa-check-circle" style="display:block;font-size:1.5rem;margin-bottom:0.5rem;color:#d1fae5"></i>
                Aucune notification pour le moment
            </p>
        <?php endif; ?>
        </div>
    </div>

</div>

<script>
const CSRF  = document.querySelector('meta[name="csrf-token"]').content;
const LURL  = '<?= route('dashboard.notifs') ?>';
let prevTotal = <?= $totalNonLues ?>;

// ─── Panneau cloche ───────────────────────────
function toggleNotifPanel() {
    const p = document.getElementById('notif-panel');
    p.style.display = p.style.display === 'none' ? 'block' : 'none';
    if (p.style.display === 'block') renderPanelNotifs();
}
document.addEventListener('click', e => {
    if (!e.target.closest('#notif-panel') && !e.target.closest('[onclick="toggleNotifPanel()"]'))
        document.getElementById('notif-panel').style.display = 'none';
});

function iconType(type) {
    return type === 'entretien_programme' ? 'calendar-check'
         : type === 'dossier_rejete'      ? 'times'
         : 'star';
}
function colorType(type) {
    return type === 'entretien_programme' ? 'entretien'
         : type === 'dossier_rejete'      ? 'refus'
         : 'match';
}

async function renderPanelNotifs() {
    const res  = await fetch(LURL);
    const data = await res.json();
    const list = document.getElementById('notif-list');
    const empty = document.getElementById('notif-empty');
    if (!data.notifs.length) { list.innerHTML = ''; empty.style.display = 'block'; return; }
    empty.style.display = 'none';
    list.innerHTML = data.notifs.map(n => `
        <div class="notif-item unread" style="margin:0.3rem;border-radius:10px">
            <div class="notif-icon ${colorType(n.type)}"><i class="fas fa-${iconType(n.type)}"></i></div>
            <div class="notif-text">${n.message}</div>
            <div class="notif-date">${n.ago}</div>
        </div>`).join('');
}

// ─── Polling toutes les 10s ───────────────────
async function pollNotifications() {
    try {
        const res  = await fetch(LURL);
        const data = await res.json();
        const total = data.total;

        // Badge cloche
        const badge = document.getElementById('notif-badge');
        badge.textContent = total;
        badge.style.display = total > 0 ? 'flex' : 'none';

        // Badge section page
        const pageBadge = document.getElementById('page-notif-badge');
        if (pageBadge) { pageBadge.textContent = total; pageBadge.style.display = total > 0 ? '' : 'none'; }

        // Nouvelle notification → toast + mise à jour liste
        if (total > prevTotal) {
            const n = data.notifs[0];
            showToast(n);
            updatePageList(data.notifs);
        }
        prevTotal = total;
    } catch(e) {}
}

function updatePageList(notifs) {
    const list = document.getElementById('page-notif-list');
    const empty = document.getElementById('page-notif-empty');
    if (empty) empty.remove();
    list.innerHTML = notifs.map(n => `
        <div class="notif-item unread">
            <div class="notif-icon ${colorType(n.type)}"><i class="fas fa-${iconType(n.type)}"></i></div>
            <div class="notif-text">${n.message}</div>
            <div class="notif-date">${n.ago}</div>
        </div>`).join('') + list.innerHTML;
}

function showToast(n) {
    const icon  = n.type === 'entretien_programme' ? '📅' : n.type === 'dossier_rejete' ? '❌' : '⭐';
    const toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;top:1.2rem;right:1.2rem;background:white;border:1px solid #e2e8f0;border-left:4px solid #4f46e5;padding:1rem 1.25rem;border-radius:14px;box-shadow:0 8px 30px rgba(0,0,0,0.15);z-index:9999;max-width:320px;animation:slideInRight .35s ease';
    toast.innerHTML = `
        <div style="font-weight:700;font-size:0.9rem;color:#1e293b;margin-bottom:0.25rem">${icon} Nouvelle notification</div>
        <div style="font-size:0.82rem;color:#64748b">${n.message}</div>`;
    document.body.appendChild(toast);
    setTimeout(() => toast.style.animation = 'slideOutRight .3s ease forwards', 5000);
    setTimeout(() => toast.remove(), 5300);
}

async function marquerToutLu() {
    await fetch('/notifications/marquer-lu', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' }
    });
    document.getElementById('notif-badge').style.display = 'none';
    const pb = document.getElementById('page-notif-badge');
    if (pb) pb.style.display = 'none';
    document.getElementById('notif-panel').style.display = 'none';
    prevTotal = 0;
}

// CSS animations
const s = document.createElement('style');
s.textContent = `
@keyframes slideInRight  { from{transform:translateX(120%);opacity:0} to{transform:translateX(0);opacity:1} }
@keyframes slideOutRight { from{transform:translateX(0);opacity:1}    to{transform:translateX(120%);opacity:0} }`;
document.head.appendChild(s);

pollNotifications();
setInterval(pollNotifications, 10000);
</script>
</body>
</html>
