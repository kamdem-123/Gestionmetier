<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des offres</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f3f4f6; color: #111827; }
        .container { max-width: 1180px; margin: 2rem auto; padding: 1rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .header h1 { margin: 0; font-size: 2rem; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.9rem 1.2rem; border-radius: 999px; border: none; cursor: pointer; font-weight: 700; }
        .btn-primary { background: #4f46e5; color: white; }
        .btn-secondary { background: #eef2ff; color: #4338ca; }
        .grid { display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; }
        .card { background: white; border-radius: 24px; box-shadow: 0 15px 40px rgba(15,23,42,0.08); padding: 1.5rem; }
        .section-title { font-size: 1.1rem; color: #374151; margin-bottom: 1rem; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 0.9rem 1rem; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .table th { color: #6b7280; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.04em; }
        .badge { display: inline-flex; padding: 0.35rem 0.8rem; border-radius: 999px; background: #eef2ff; color: #4338ca; font-size: 0.85rem; }
        .action-btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; padding: 0.55rem 0.8rem; border-radius: 999px; border: none; cursor: pointer; font-size: 0.85rem; }
        .action-delete { background: #fee2e2; color: #b91c1c; }
        .action-view { background: #e0f2fe; color: #0c4a6e; }
        .list-item { display: grid; gap: 0.5rem; }
        .list-item h3 { margin: 0; font-size: 1rem; }
        .list-item p { margin: 0; color: #6b7280; font-size: 0.95rem; }
        .alert { background: #fef3c7; color: #92400e; border-radius: 18px; padding: 1rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Administration</h1>
                <p>Gestion des offres et suivi des CVs candidats.</p>
            </div>
            <button class="btn btn-primary" onclick="window.location.href='/publier_offre.php'"><i class="fas fa-plus"></i> Publier une offre</button>
        </div>

        <div class="alert">
            <strong>Note :</strong> Les offres et CV sont stockés localement dans le navigateur pour la démo. Les actions de suppression s'appliquent au stockage local uniquement.
        </div>

        <div class="grid">
            <div class="card">
                <div class="section-title">Offres publiées</div>
                <table class="table" id="offersTable">
                    <thead>
                        <tr>
                            <th>Poste</th>
                            <th>Entreprise</th>
                            <th>Ville</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="card">
                <div class="section-title">Derniers CV reçus</div>
                <div id="cvsList"></div>
            </div>
        </div>
    </div>

    <script>
        function loadOffers() {
            const offers = JSON.parse(localStorage.getItem('jobai_offers') || '[]');
            const tbody = document.querySelector('#offersTable tbody');
            tbody.innerHTML = '';
            if (!offers.length) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="5" style="text-align:center; color:#6b7280;">Aucune offre publiée pour le moment.</td>';
                tbody.appendChild(row);
                return;
            }
            offers.forEach((offer, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${offer.titre || '—'}</td>
                    <td>${offer.entreprise_nom || '—'}</td>
                    <td>${offer.ville || '—'}</td>
                    <td>${offer.type_contrat || '—'}</td>
                    <td style="display:flex; gap:0.5rem;">
                        <button class="action-btn action-view" onclick="window.location.href='/offre-detail.php?id=last'"><i class="fas fa-eye"></i> Voir</button>
                        <button class="action-btn action-delete" onclick="deleteOffer(${index})"><i class="fas fa-trash"></i> Supprimer</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function loadCVs() {
            const cvs = JSON.parse(localStorage.getItem('jobai_candidats') || '[]');
            const container = document.getElementById('cvsList');
            container.innerHTML = '';
            if (!cvs.length) {
                container.innerHTML = '<p style="color:#6b7280;">Aucun CV enregistré localement.</p>';
                return;
            }
            cvs.slice(0, 5).forEach(cv => {
                const item = document.createElement('div');
                item.className = 'list-item';
                item.innerHTML = `
                    <h3>${cv.nom || 'Candidat'} - ${cv.poste || 'Poste visé'}</h3>
                    <p><strong>Email :</strong> ${cv.email || 'Non renseigné'}</p>
                    <p><strong>Résumé :</strong> ${cv.resume || 'Aucun résumé'}</p>
                `;
                container.appendChild(item);
            });
        }

        function deleteOffer(index) {
            const offers = JSON.parse(localStorage.getItem('jobai_offers') || '[]');
            offers.splice(index, 1);
            localStorage.setItem('jobai_offers', JSON.stringify(offers));
            loadOffers();
        }

        loadOffers();
        loadCVs();
    </script>
</body>
</html>
