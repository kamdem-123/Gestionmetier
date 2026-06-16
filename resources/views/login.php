<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobAI - Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #eef2ff; color: #111827; }
        .container { max-width: 420px; margin: 4rem auto; padding: 2rem; background: white; border-radius: 24px; box-shadow: 0 18px 50px rgba(15,23,42,0.12); }
        h1 { font-size: 1.8rem; margin-bottom: 0.5rem; color: #111827; }
        p { color: #6b7280; margin-bottom: 1.75rem; }
        .field { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.35rem; font-weight: 700; color: #374151; }
        input { width: 100%; padding: 0.95rem 1rem; border: 1px solid #d1d5db; border-radius: 16px; font-size: 1rem; }
        .btn { width: 100%; border: none; border-radius: 16px; padding: 0.95rem 1rem; background: #4f46e5; color: white; font-weight: 700; font-size: 1rem; cursor: pointer; }
        .alt-link { margin-top: 1rem; text-align: center; color: #4f46e5; text-decoration: none; display: inline-block; }
        .error { color: #dc2626; font-size: 0.9rem; margin-top: 0.5rem; }
        .social-link { display: inline-flex; align-items: center; gap: 0.5rem; justify-content: center; width: 100%; padding: 0.95rem 1rem; border-radius: 16px; border: 1px solid #d1d5db; background: white; color: #111827; font-weight: 700; text-decoration: none; margin-top: 0.75rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <p>Connectez-vous avec votre e-mail et mot de passe.</p>

        <?php if(session()->has('errors')): ?>
            <div class="error"><?= session('errors')->first('email') ?></div>
        <?php endif; ?>

        <form method="POST" action="/connexion">
            <?php echo csrf_field(); ?>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?= old('email') ?>" required>
            </div>
            <div class="field">
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" required>
            </div>
            <button class="btn" type="submit">Se connecter</button>
        </form>

        <a href="<?php echo route('google.redirect'); ?>" class="social-link">
            <i class="fab fa-google"></i> Continuer avec Google
        </a>

        <a class="alt-link" href="<?php echo route('register'); ?>">Créer un compte</a>
    </div>
</body>
</html>
