<?php
$offre      = $offre ?? null;
$entreprise = $offre?->entreprise ?? null;
$dejaPostule = $dejaPostule ?? false;
$user = auth()->user() ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postuler — JobAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

<div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-xl">

    <!-- Bouton retour -->
    <a href="<?= route('offres.index') ?>" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 text-sm font-semibold mb-6 hover:underline">
        ← Retour aux offres
    </a>

    <?php if (!$offre): ?>
        <p class="text-red-500 text-center">Offre introuvable.</p>
        <div class="text-center mt-4">
            <a href="<?= route('offres.index') ?>" class="text-blue-600 hover:underline">← Retour aux offres</a>
        </div>

    <?php elseif ($dejaPostule): ?>
        <div class="text-center">
            <div class="mb-4 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="48" height="48" class="text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Déjà postulé</h2>
            <p class="text-gray-500 mb-6">Vous avez déjà envoyé une candidature pour <strong><?= htmlspecialchars($offre->titre) ?></strong>.</p>
            <a href="/dashboard" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Voir mon tableau de bord</a>
        </div>

    <?php else: ?>
        <!-- En-tête offre -->
        <div class="mb-6">
            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Candidature</span>
            <h1 class="text-2xl font-bold text-gray-900 mt-1"><?= htmlspecialchars($offre->titre) ?></h1>
            <?php if ($entreprise): ?>
                <p class="text-gray-500 mt-1"><?= htmlspecialchars($entreprise->nom) ?> — <?= htmlspecialchars($offre->ville ?? '') ?>, <?= htmlspecialchars($offre->pays ?? '') ?></p>
            <?php endif; ?>
        </div>

        <!-- Badge AI -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start gap-3">
            <span class="flex-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="28" height="28" class="text-blue-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
                </svg>
            </span>
            <div>
                <p class="text-sm font-semibold text-blue-800">Analyse IA automatique</p>
                <p class="text-xs text-blue-600 mt-1">Après votre candidature, notre IA analysera la compatibilité entre votre profil et cette offre. Le recruteur recevra un score de matching.</p>
            </div>
        </div>

        <!-- Message flash -->
        <?php if (session('erreur')): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-4 text-sm">
                <?= htmlspecialchars(session('erreur')) ?>
            </div>
        <?php endif; ?>

        <?php if (session('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm">
                <?= htmlspecialchars(session('success')) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <form method="POST" action="/postuler" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="offre_id" value="<?= $offre->id ?>">

            <!-- Titre de poste (modifiable) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Votre titre de poste actuel *</label>
                <input type="text" name="titre_poste_candidature"
                    placeholder="ex: Développeur Full Stack, Data Analyst..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="<?= htmlspecialchars($user?->titre_poste ?? '') ?>"
                    required>
                <p class="text-xs text-gray-400 mt-1">
                    Ce titre sera visible par le recruteur.
                </p>
            </div>

            <!-- Compétences -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Vos compétences *</label>
                <textarea name="competences" rows="2"
                    placeholder="ex: PHP, Laravel, React, MySQL, Docker..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required><?= htmlspecialchars($user?->competences ?? '') ?></textarea>
                <p class="text-xs text-gray-400 mt-1">Séparez par des virgules. Ces compétences seront comparées avec celles requises par l'offre.</p>
            </div>

            <!-- Expérience -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Années d'expérience</label>
                <input type="number" name="experience_annees" min="0" max="50"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="<?= htmlspecialchars($user?->experience_annees ?? '0') ?>">
            </div>

            <!-- Niveau d'études -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Niveau d'études</label>
                <select name="niveau_etude"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Sélectionnez --</option>
                    <option value="Bac" <?= ($user?->niveau_etude === 'Bac') ? 'selected' : '' ?>>Bac</option>
                    <option value="Bac+2" <?= ($user?->niveau_etude === 'Bac+2') ? 'selected' : '' ?>>Bac+2 (BTS/DUT)</option>
                    <option value="Bac+3" <?= ($user?->niveau_etude === 'Bac+3') ? 'selected' : '' ?>>Bac+3 (Licence)</option>
                    <option value="Bac+5" <?= ($user?->niveau_etude === 'Bac+5') ? 'selected' : '' ?>>Bac+5 (Master)</option>
                    <option value="Doctorat" <?= ($user?->niveau_etude === 'Doctorat') ? 'selected' : '' ?>>Doctorat</option>
                </select>
            </div>

            <!-- Bio / Présentation -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Présentation courte</label>
                <textarea name="bio" rows="3"
                    placeholder="Décrivez brièvement votre expérience et vos motivations..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($user?->bio ?? '') ?></textarea>
            </div>

            <!-- CV Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Votre CV (PDF, DOC, DOCX)</label>
                <input type="file" name="cv" accept=".pdf,.doc,.docx"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <?php if ($user?->cv_path): ?>
                    <p class="text-xs text-gray-400 mt-1">CV actuel : <a href="<?= htmlspecialchars($user->cv_path) ?>" target="_blank" class="text-blue-500 hover:underline">Voir mon CV</a></p>
                <?php endif; ?>
            </div>

            <!-- Bouton submit -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2">
                Envoyer ma candidature
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="inline">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="<?= route('offres.index') ?>" class="text-sm text-gray-400 hover:underline">← Retour aux offres</a>
        </div>
    <?php endif; ?>

</div>
</body>
</html>