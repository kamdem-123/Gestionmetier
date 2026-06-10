<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion | Job IA Exclusif</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .icon {
            width: 80px;
            height: 80px;
            background: #dcfce7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }

        .icon i {
            font-size: 2rem;
            color: #16a34a;
        }

        h1 {
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-bottom: 12px;
            font-weight: 700;
        }

        p {
            color: #666;
            font-size: 1rem;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .btn-login {
            display: inline-block;
            width: 100%;
            padding: 14px 20px;
            background: #ff6b6b;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #ff5252;
            transform: translateY(-1px);
        }

        .btn-home {
            display: inline-block;
            margin-top: 12px;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-home:hover {
            color: #c53030;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1>Vous êtes déconnecté</h1>
        <p>À bientôt sur Job IA Exclusif. N'oubliez pas de consulter régulièrement les nouvelles offres !</p>

        <a href="{{ route('connexion') }}" class="btn-login">
            <i class="fas fa-sign-in-alt"></i> Se reconnecter
        </a>

        <a href="{{ route('inscrit') }}" class="btn-home">
            ← Retour à l'accueil
        </a>
    </div>

</body>
</html>