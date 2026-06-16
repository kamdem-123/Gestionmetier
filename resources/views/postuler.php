<?php
$offerId = $_GET['id'] ?? 'last';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postuler - JobAI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #111827; }
        .container { max-width: 900px; margin: 2rem auto; padding: 1rem; }
        .card { background: white; border-radius: 24px; box-shadow: 0 15px 50px rgba(15,23,42,0.08); overflow: hidden; }
        .hero { padding: 2rem; border-bottom: 1px solid #e5e7eb; }
        .hero h1 { margin: 0; font-size: 2rem; }
        .hero p { margin: 0.5rem 0 0; color: #6b7280; }
        .content { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; padding: 2rem; }
        .content form { display: grid; gap: 1rem; }
        .field { display: grid; gap: 0.4rem; }
        label { font-weight: 700; color: #374151; }
        input, textarea { width: 100%; padding: 0.95rem 1rem; border: 1px solid #d1d5db; border-radius: 16px; font-size: 0.95rem; }
        textarea { min-height: 170px; resize: vertical; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.95rem 1.2rem; border-radius: 999px; border: none; cursor: pointer; font-weight: 700; }
        .btn-primary { background: #4f46e5; color: white; }
        .btn-secondary { background: #eef2ff; color: #4338ca; }
        .details { background: #f8fafc; padding: 1.5rem; border-radius: 20px; border: 1px solid #e5e7eb; }
        .details h2 { margin: 0 0 1rem; font-size: 1.15rem; }
        .details p { color: #4b5563; line-height: 1.7; }
        .badge { display: inline-flex; gap: 0.5rem; align-items: center; padding: 0.55rem 0.8rem; border-radius: 999px; background: #eef2ff; color: #4338ca; font-weight: 700; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="hero">
                <h1>Postuler à une offre</h1>
                <p>Complétez le formulaire ci-dessous pour envoyer votre candidature.</p>
            </div>
            <div class="content">
                <form id="applicationForm">
                    <div class="field">
                        <label for="fullname">Nom complet</label>
                        <input id="fullname" name="fullname" type="text" placeholder="Votre nom complet" required>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" placeholder="votre@email.com" required>
                    </div>
                    <div class="field">
                        <label for="phone">Téléphone</label>
                        <input id="phone" name="phone" type="tel" placeholder="+221 77 123 45 67">
                    </div>
                    <div class="field">
                        <label for="message">Message de motivation</label>
                        <textarea id="message" name="message" placeholder="Expliquez pourquoi vous êtes le bon candidat..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Envoyer ma candidature</button>
                </form>
                <aside class="details">
                    <h2>Détails de l'offre</h2>
                    <p id="offerSummary">Chargement de l'offre publiée...</p>
                    <div class="badge"><i class="fas fa-info-circle"></i> Offre sélectionnée : <?= htmlspecialchars($offerId) ?></div>
                </aside>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('applicationForm');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Candidature envoyée ! Merci.');
            form.reset();
        });

        function loadOfferSummary() {
            const stored = localStorage.getItem('jobai_last_offer');
            const summary = document.getElementById('offerSummary');
            if (!stored) {
                summary.textContent = 'Aucune offre stockée localement. Veuillez revenir via la page des offres.';
                return;
            }
            const offer = JSON.parse(stored);
            if (!offer) {
                summary.textContent = 'Impossible de charger l\'offre actuellement.';
                return;
            }
            summary.innerHTML = `
                <strong>${offer.titre}</strong><br>
                ${offer.entreprise_nom}<br>
                ${offer.ville}${offer.pays ? ', ' + offer.pays : ''}<br>
                <small>${offer.type_contrat} • ${offer.salaire || 'Salaire non précisé'} ${offer.devise || '€'} ${offer.periode || '/mois'}</small>
            `;
        }
        loadOfferSummary();
    </script>
</body>
</html>
