<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte employeur — JobAI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; }

        .card { background: white; border-radius: 24px; padding: 2.5rem; width: 100%; max-width: 560px; box-shadow: 0 25px 60px rgba(0,0,0,0.2); }
        .card-header { text-align: center; margin-bottom: 2rem; }
        .card-header .icon { width: 64px; height: 64px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.6rem; color: white; }
        .card-header h1 { font-size: 1.6rem; font-weight: 800; color: #1e293b; margin-bottom: 0.4rem; }
        .card-header p { color: #64748b; font-size: 0.9rem; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 1.1rem; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.4rem; }
        .form-group label .req { color: #ef4444; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px;
            font-size: 0.92rem; font-family: inherit; color: #1e293b; transition: border-color .2s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .form-group .error-msg { font-size: 0.78rem; color: #ef4444; margin-top: 0.3rem; display: none; }

        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.5rem 0; }

        .btn-submit { width: 100%; padding: 1rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all .3s; margin-top: 0.5rem; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,70,229,0.4); }

        .footer-links { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #64748b; }
        .footer-links a { color: #4f46e5; text-decoration: none; font-weight: 600; }

        .alert { padding: 0.85rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.88rem; display: flex; gap: 0.5rem; align-items: flex-start; }
        .alert.error   { background: #fee2e2; color: #991b1b; }
        .alert.success { background: #d1fae5; color: #065f46; }

        /* Erreurs Laravel */
        .field-error { font-size: 0.78rem; color: #ef4444; margin-top: 0.3rem; }

        @media(max-width: 480px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <div class="icon"><i class="fas fa-building"></i></div>
        <h1>Créer un compte employeur</h1>
        <p>Votre demande sera examinée par notre équipe sous 24h.</p>
    </div>

    <?php if ($errors->any()): ?>
        <div class="alert error">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="list-style:none;padding:0">
                <?php foreach ($errors->all() as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= route('demande-employeur.store') ?>">
        <?= csrf_field() ?>

        <div class="form-row">
            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?= old('prenom') ?>" placeholder="Jean">
            </div>
            <div class="form-group">
                <label>Nom <span class="req">*</span></label>
                <input type="text" name="nom" value="<?= old('nom') ?>" placeholder="Dupont" required>
            </div>
        </div>

        <div class="form-group">
            <label>Email professionnel <span class="req">*</span></label>
            <input type="email" name="email" value="<?= old('email') ?>" placeholder="jean@monentreprise.com" required>
        </div>

        <div class="form-group">
            <label>Téléphone</label>
            <input type="tel" name="telephone" value="<?= old('telephone') ?>" placeholder="+237 6XX XXX XXX">
        </div>

        <hr class="divider">

        <div class="form-row">
            <div class="form-group">
                <label>Nom de l'entreprise <span class="req">*</span></label>
                <input type="text" name="entreprise" value="<?= old('entreprise') ?>" placeholder="TechCorp Solutions" required>
            </div>
            <div class="form-group">
                <label>Secteur d'activité</label>
                <select name="secteur">
                    <option value="">— Sélectionner —</option>
                    <option <?= old('secteur') === 'Informatique / Tech' ? 'selected' : '' ?>>Informatique / Tech</option>
                    <option <?= old('secteur') === 'Finance / Banque' ? 'selected' : '' ?>>Finance / Banque</option>
                    <option <?= old('secteur') === 'Santé / Médical' ? 'selected' : '' ?>>Santé / Médical</option>
                    <option <?= old('secteur') === 'Éducation' ? 'selected' : '' ?>>Éducation</option>
                    <option <?= old('secteur') === 'Commerce / Vente' ? 'selected' : '' ?>>Commerce / Vente</option>
                    <option <?= old('secteur') === 'Marketing / Communication' ? 'selected' : '' ?>>Marketing / Communication</option>
                    <option <?= old('secteur') === 'BTP / Construction' ? 'selected' : '' ?>>BTP / Construction</option>
                    <option <?= old('secteur') === 'Transport / Logistique' ? 'selected' : '' ?>>Transport / Logistique</option>
                    <option <?= old('secteur') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Message (optionnel)</label>
            <textarea name="message" rows="3" placeholder="Décrivez brièvement votre besoin en recrutement..."><?= old('message') ?></textarea>
        </div>

        <hr class="divider">

        <div class="form-group">
            <label>Mot de passe <span class="req">*</span></label>
            <input type="password" name="password" placeholder="Minimum 8 caractères" required>
        </div>
        <div class="form-group">
            <label>Confirmer le mot de passe <span class="req">*</span></label>
            <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe" required>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-paper-plane"></i> Envoyer ma demande
        </button>
    </form>

    <div class="footer-links">
        Déjà un compte ? <a href="<?= route('connexion') ?>">Se connecter</a>
        &bull; <a href="/">Retour à l'accueil</a>
    </div>
</div>

</body>
</html>
