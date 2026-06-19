<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobAI - Inscription</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --success: #10b981;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Animation de fond */
        body::before {
            content: '';
            position: fixed;
            top: -30%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: float 25s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-20px, -20px) rotate(180deg); }
        }

        .container {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 10;
            animation: fadeInUp 0.6s ease;
            margin-bottom: 40px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo a {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .logo i {
            font-size: 1.4rem;
        }

        h1 {
            font-size: 1.15rem;
            color: var(--dark);
            margin-bottom: 6px;
            font-weight: 700;
            text-align: center;
            line-height: 1.3;
        }

        .subtitle {
            text-align: center;
            color: var(--gray);
            margin-bottom: 20px;
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .features {
            list-style: none;
            margin-bottom: 20px;
            background: var(--light);
            padding: 15px;
            border-radius: 12px;
        }

        .features li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
            color: var(--dark);
            font-size: 0.8rem;
            line-height: 1.4;
        }

        .features li:last-child {
            margin-bottom: 0;
        }

        .features li i {
            color: var(--primary);
            margin-right: 10px;
            margin-top: 2px;
            font-size: 0.7rem;
            background: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.15);
        }

        .btn-social {
            width: 100%;
            padding: 11px 16px;
            margin-bottom: 10px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: white;
            color: var(--dark);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-social:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.12);
        }

        .btn-social img {
            width: 18px;
            height: 18px;
        }

        .terms {
            text-align: center;
            font-size: 0.72rem;
            color: var(--gray);
            margin: 14px 0;
            line-height: 1.5;
        }

        .terms a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 18px 0;
            color: var(--gray);
            font-size: 0.8rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
        }

        .divider span {
            padding: 0 12px;
        }

        .btn-email {
            width: 100%;
            padding: 11px 16px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .btn-email:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
        }

        .login-link {
            text-align: center;
            margin-top: 18px;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Particules décoratives */
        .particle {
            position: fixed;
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.25);
            border-radius: 50%;
            animation: particle-float 15s infinite;
            pointer-events: none;
        }

        .particle:nth-child(1) { top: 15%; left: 8%; animation-delay: 0s; }
        .particle:nth-child(2) { top: 50%; right: 10%; animation-delay: 3s; }
        .particle:nth-child(3) { bottom: 20%; left: 25%; animation-delay: 6s; }

        @keyframes particle-float {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.2; }
            50% { transform: translateY(-15px) scale(1.3); opacity: 0.5; }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px 15px;
            }
            .container {
                padding: 25px 20px;
            }
            h1 {
                font-size: 1.05rem;
            }
            .logo a {
                font-size: 1.4rem;
            }
            .features li {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>

    <!-- Particules décoratives -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="container">
        <div class="logo">
            <a href="/">
                <i class="fas fa-briefcase"></i>
                JobAI
            </a>
        </div>

        <h1>Des Recruteurs Vous Cherchent</h1>
        <p class="subtitle">Rejoignez la plateforme intelligente de placement professionnel</p>
        
        <ul class="features">
            <li><i class="fas fa-check"></i><span>Plus d'offres, plus d'entretiens, plus de propositions !</span></li>
            <li><i class="fas fa-check"></i><span>Accédez à 80% d'offres non publiées grâce à des chasseurs de têtes</span></li>
            <li><i class="fas fa-check"></i><span>Créez un CV optimisé pour les logiciels ATS</span></li>
            <li><i class="fas fa-check"></i><span>Profitez d'un examen gratuit de votre CV</span></li>
        </ul>

        <!-- Lien Laravel vers Google -->
        <a href="<?php echo route('google.redirect'); ?>" class="btn-social">
            <i class="fab fa-google"></i>
            Continuer avec Google
        </a>

        <div class="divider"><span>ou</span></div>

        <!-- Formulaire inscription email -->
        <?php if ($errors->any()): ?>
            <div style="background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:10px;font-size:0.85rem;margin-bottom:1rem;">
                <?= e($errors->first()) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo route('inscrit.submit'); ?>">
            <?= csrf_field() ?>
            <div style="margin-bottom:0.75rem;">
                <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:0.35rem;">Nom complet</label>
                <input type="text" name="name" value="<?= e(old('name')) ?>"
                    placeholder="Jean Dupont" required
                    style="width:100%;padding:0.75rem 1rem;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.9rem;outline:none;font-family:inherit;transition:border-color .2s;"
                    onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div style="margin-bottom:0.75rem;">
                <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:0.35rem;">Adresse e-mail</label>
                <input type="email" name="email" value="<?= e(old('email')) ?>"
                    placeholder="votre@email.com" required
                    style="width:100%;padding:0.75rem 1rem;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.9rem;outline:none;font-family:inherit;transition:border-color .2s;"
                    onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div style="margin-bottom:0.75rem;">
                <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:0.35rem;">Mot de passe</label>
                <input type="password" name="password"
                    placeholder="Minimum 8 caractères" required
                    style="width:100%;padding:0.75rem 1rem;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.9rem;outline:none;font-family:inherit;transition:border-color .2s;"
                    onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <div style="margin-bottom:1.1rem;">
                <label style="display:block;font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:0.35rem;">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation"
                    placeholder="••••••••" required
                    style="width:100%;padding:0.75rem 1rem;border:1.5px solid #e2e8f0;border-radius:10px;font-size:0.9rem;outline:none;font-family:inherit;transition:border-color .2s;"
                    onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <button type="submit" class="btn-email" style="width:100%;border:none;cursor:pointer;">
                <i class="fas fa-user-plus"></i>
                Créer mon compte
            </button>
        </form>

        <p class="terms" style="margin-top:1rem;">
            En créant un compte, vous acceptez nos <a href="#">Conditions d'utilisation</a>
            et notre <a href="#">Politique de confidentialité</a>.
        </p>

        <p class="login-link">
            Vous avez déjà un compte ? <a href="<?php echo route('connexion'); ?>">Se connecter</a>
        </p>
    </div>

</body>
</html>