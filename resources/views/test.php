<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobAI - Bienvenue</title>
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

        /* Bouton retour */
        .btn-back {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .btn-back:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: var(--primary);
        }

        .btn-back i {
            font-size: 0.9rem;
        }

        .container {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 600px;
            position: relative;
            z-index: 10;
            animation: fadeInUp 0.6s ease;
            margin-bottom: 40px;
            text-align: center;
            margin-top: 20px;
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
            margin-bottom: 25px;
        }

        .logo a {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .logo i {
            font-size: 1.5rem;
        }

        h1 {
            font-size: 1.4rem;
            color: var(--dark);
            margin-bottom: 10px;
            font-weight: 700;
            line-height: 1.3;
        }

        .welcome-text {
            color: var(--gray);
            margin-bottom: 30px;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .welcome-text strong {
            color: var(--primary);
        }

        /* Zone de téléversement */
        .upload-zone {
            border: 2px dashed #e2e8f0;
            border-radius: 16px;
            padding: 30px 20px;
            margin-bottom: 20px;
            background: var(--light);
            transition: all 0.3s;
            cursor: pointer;
        }

        .upload-zone:hover {
            border-color: var(--primary);
            background: #f0f4ff;
        }

        .upload-zone.dragover {
            border-color: var(--primary);
            background: #e0e7ff;
            transform: scale(1.02);
        }

        .upload-zone i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .upload-zone p {
            color: var(--gray);
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .upload-zone .file-types {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        #file-input {
            display: none;
        }

        .file-name {
            margin-top: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--dark);
            display: none;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .file-name.show {
            display: flex;
        }

        .file-name i {
            font-size: 1rem;
            margin: 0;
        }

        /* Boutons */
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-search {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-search:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.15);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
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

        /* Message de succès */
        .success-message {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background: #d1fae5;
            border-radius: 12px;
            color: #065f46;
            font-size: 0.9rem;
            animation: fadeInUp 0.4s ease;
        }

        .success-message.show {
            display: block;
        }

        .success-message i {
            margin-right: 8px;
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
                margin-top: 50px;
            }
            h1 {
                font-size: 1.2rem;
            }
            .logo a {
                font-size: 1.5rem;
            }
            .btn-back {
                top: 10px;
                right: 10px;
                padding: 8px 15px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

    <!-- Bouton Retour -->
    <a href="a" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        Retour
    </a>

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

        <h1>👋 Bienvenue sur JobAI</h1>
        <p class="welcome-text">
            Votre assistant intelligent pour trouver <strong>le métier de vos rêves</strong>. 
            Téléversez votre CV pour une analyse personnalisée ou recherchez directement des opportunités.
        </p>

        <!-- Zone de téléversement -->
        <div class="upload-zone" id="upload-zone" onclick="document.getElementById('file-input').click()">
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Cliquez ou glissez votre CV ici</p>
            <span class="file-types">PDF, DOC, DOCX (max 5 Mo)</span>
            
            <div class="file-name" id="file-name">
                <i class="fas fa-file-alt"></i>
                <span id="file-name-text"></span>
            </div>
        </div>

        <input type="file" id="file-input" accept=".pdf,.doc,.docx" onchange="handleFileSelect(event)">

        <!-- Message de succès -->
        <div class="success-message" id="success-message">
            <i class="fas fa-check-circle"></i>
            <span id="success-text">CV téléversé avec succès !</span>
        </div>

        <div class="divider"><span>ou</span></div>

        <!-- Boutons d'action -->
        <div class="btn-group">
            <button class="btn btn-submit" id="btn-submit" onclick="submitCV()" disabled>
                <i class="fas fa-paper-plane"></i>
                Soumettre mon CV
            </button>

            <a href="/offres" class="btn btn-search">
                <i class="fas fa-search"></i>
                Rechercher un employé
            </a>
        </div>
    </div>

    <script>
        const uploadZone = document.getElementById('upload-zone');
        const fileInput = document.getElementById('file-input');
        const fileNameDiv = document.getElementById('file-name');
        const fileNameText = document.getElementById('file-name-text');
        const btnSubmit = document.getElementById('btn-submit');
        const successMessage = document.getElementById('success-message');
        const successText = document.getElementById('success-text');

        let selectedFile = null;

        // Drag & drop
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                handleFile(file);
            }
        }

        function handleFile(file) {
            // Vérification du type
            const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            const allowedExtensions = ['.pdf', '.doc', '.docx'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
            
            if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                alert('Format non supporté. Veuillez utiliser PDF, DOC ou DOCX.');
                return;
            }

            // Vérification de la taille (5 Mo max)
            if (file.size > 5 * 1024 * 1024) {
                alert('Fichier trop volumineux. Taille maximale : 5 Mo.');
                return;
            }

            selectedFile = file;
            fileNameText.textContent = file.name;
            fileNameDiv.classList.add('show');
            btnSubmit.disabled = false;
            successMessage.classList.remove('show');
        }

        function submitCV() {
            if (!selectedFile) {
                alert('Veuillez d\'abord sélectionner un CV.');
                return;
            }

            // Simulation d'envoi
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';

            setTimeout(() => {
                successText.textContent = `CV "${selectedFile.name}" téléversé avec succès !`;
                successMessage.classList.add('show');
                
                btnSubmit.innerHTML = '<i class="fas fa-check"></i> CV soumis';
                
                // Réinitialisation après 3 secondes
                setTimeout(() => {
                    selectedFile = null;
                    fileNameDiv.classList.remove('show');
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Soumettre mon CV';
                }, 3000);
            }, 1500);
        }
    </script>

</body>
</html>