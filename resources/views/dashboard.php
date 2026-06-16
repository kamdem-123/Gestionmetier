<?php /* resources/views/dashboard.php */ ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; padding: 40px; }
        .card { background: #fff; max-width: 500px; margin: 0 auto; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .avatar { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; }
        .info { margin-top: 20px; }
        .info p { margin: 8px 0; color: #333; }
        .label { font-weight: 600; color: #666; }
        .logout { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #ff6b6b; color: #fff; text-decoration: none; border-radius: 8px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h1>👋 Bienvenue, <?php echo Auth::user()->name; ?> !</h1>
        
        <?php if(Auth::user()->avatar): ?>
            <img src="<?php echo Auth::user()->avatar; ?>" alt="Photo" class="avatar">
        <?php endif; ?>
        
        <div class="info">
            <p><span class="label">Nom complet :</span> <?php echo Auth::user()->name; ?></p>
            <p><span class="label">Email :</span> <?php echo Auth::user()->email; ?></p>
            <p><span class="label">ID Google :</span> <?php echo Auth::user()->google_id; ?></p>
        </div>
        
        <form method="POST" action="<?php echo route('logout'); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout">Se déconnecter</button>
        </form>
    </div>
</body>
</html>