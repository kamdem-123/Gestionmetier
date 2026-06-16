<?php
// Page de détail d'une offre
$offerId = $_GET['id'] ?? 'last';
$stored = null;
if (isset($_COOKIE['jobai_last_offer'])) {
    $stored = json_decode($_COOKIE['jobai_last_offer'], true);
}
if (!$stored && isset($_GET['id']) && $_GET['id'] === 'last') {
    // fallback si le stockage local n'est pas accessible en PHP
    $stored = null;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir l'offre - JobAI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f3f4f6; color: #1f2937; }
        .container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
        .breadcrumb { margin-bottom: 1rem; font-size: 0.95rem; }
        .breadcrumb a { color: #4f46e5; text-decoration: none; }
        .card { background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(15,23,42,0.08); overflow: hidden; }
        .hero { display: grid; grid-template-columns: 1fr auto; gap: 1rem; padding: 2rem; }
        .hero h1 { margin: 0; font-size: 2rem; }
        .company { margin-top: 0.5rem; color: #4b5563; }
        .type-pill { display: inline-flex; background: #eef2ff; color: #4338ca; padding: 0.45rem 0.85rem; border-radius: 999px; font-weight: 700; }
        .meta-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 1rem; margin-top: 1.5rem; }
        .meta-item { background: #f8fafc; border-radius: 16px; padding: 1rem; }
        .meta-item span { display: block; color: #6b7280; margin-bottom: 0.35rem; font-size: 0.9rem; }
        .job-content { padding: 2rem; border-top: 1px solid #e5e7eb; }
        .job-content h2 { margin-top: 0; font-size: 1.25rem; }
        .job-content p { line-height: 1.8; color: #374151; }
        .tags { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 1rem; }
        .tag { background: #e0e7ff; color: #3730a3; padding: 0.55rem 0.9rem; border-radius: 999px; font-size: 0.9rem; }
        .actions { display: flex; gap: 1rem; flex-wrap: wrap; padding: 2rem; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border: none; border-radius: 999px; cursor: pointer; font-weight: 700; padding: 0.95rem 1.25rem; }
        .btn-primary { background: #4f46e5; color: white; }
        .btn-secondary { background: #eef2ff; color: #4338ca; }
        .alert { background: #fef3c7; color: #854d0e; border-radius: 16px; padding: 1rem 1.25rem; margin-top: 2rem; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="breadcrumb">
            <a href="/recherche-metier.php">Offres</a> › Voir l'offre
        </nav>

        <div class="card">
            <div class="hero">
                <div>
                    <h1 id="offerTitle">Offre d'emploi</h1>
                    <p class="company" id="offerCompany">Entreprise</p>
                    <div class="type-pill" id="offerType">CDI</div>
                    <div class="meta-grid">
                        <div class="meta-item"><span>Localisation</span><strong id="offerLocation">Paris, France</strong></div>
                        <div class="meta-item"><span>Publié le</span><strong id="offerDate">2026-06-15</strong></div>
                        <div class="meta-item"><span>Rémunération</span><strong id="offerSalary">40 000 € / an</strong></div>
                        <div class="meta-item"><span>Référence</span><strong id="offerRef">REF-JOBAI-0001</strong></div>
                    </div>
                </div>
            </div>
            <div class="job-content">
                <h2>Description</h2>
                <p id="offerDescription">Aucune description n'est disponible pour cette offre.</p>
                <div class="tags" id="offerTags"></div>
                <div class="actions">
                    <button class="btn btn-primary" onclick="window.location.href='/postuler.php?id=<?= $offerId ?>'"><i class="fas fa-paper-plane"></i> Postuler</button>
                    <button class="btn btn-secondary" onclick="window.location.href='/recherche-metier.php'"><i class="fas fa-arrow-left"></i> Retour aux offres</button>
                </div>
                <div class="alert">
                    <strong>Note :</strong> Cette page utilise un stockage local temporaire. Si l'offre n'est pas chargée automatiquement, revenez depuis la recherche ou republiez votre offre.
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadStoredOffer() {
            const stored = localStorage.getItem('jobai_last_offer');
            if (!stored) return;
            const offer = JSON.parse(stored);
            if (!offer) return;
            document.getElementById('offerTitle').textContent = offer.titre || 'Offre d\'emploi';
            document.getElementById('offerCompany').textContent = offer.entreprise_nom || 'Entreprise';
            document.getElementById('offerType').textContent = offer.type_contrat || 'CDI';
            document.getElementById('offerLocation').textContent = `${offer.ville || ''}${offer.pays ? ', ' + offer.pays : ''}`;
            document.getElementById('offerDate').textContent = offer.date_publication || new Date().toISOString().split('T')[0];
            document.getElementById('offerSalary').textContent = `${offer.salaire || ''} ${offer.devise || '€'} ${offer.periode || '/mois'}`.trim();
            document.getElementById('offerRef').textContent = offer.id || 'REF-JOBAI-0000';
            document.getElementById('offerDescription').textContent = offer.description || 'Aucune description disponible.';
            const tagsContainer = document.getElementById('offerTags');
            if (offer.tags) {
                offer.tags.split(',').forEach(tag => {
                    const el = document.createElement('span');
                    el.className = 'tag';
                    el.textContent = tag.trim();
                    tagsContainer.appendChild(el);
                });
            }
        }
        loadStoredOffer();
    </script>
</body>
</html>
