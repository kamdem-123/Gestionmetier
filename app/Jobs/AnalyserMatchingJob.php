<?php

namespace App\Jobs;

use App\Models\Candidature;
use App\Services\MatchingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyserMatchingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Nombre de tentatives si le job échoue (ex: API HF indisponible).
     */
    public int $tries = 3;

    /**
     * Délai en secondes entre les tentatives.
     */
    public int $backoff = 10;

    public function __construct(
        public Candidature $candidature
    ) {}

    public function handle(MatchingService $matchingService): void
    {
        // Charger les relations nécessaires
        $candidature = $this->candidature->load(['user', 'offre']);

        $candidat = $candidature->user;
        $offre    = $candidature->offre;

        // Vérifier que le candidat a bien un profil renseigné
        if (empty($candidat->competences) && empty($candidat->cv_texte)) {
            Log::info('AnalyserMatchingJob: candidat sans profil, matching ignoré', [
                'candidature_id' => $candidature->id,
                'user_id'        => $candidat->id,
            ]);
            return;
        }

        // Calculer le score via le service AI
        $score = $matchingService->calculerScore($offre, $candidat);

        // Sauvegarder le score en base
        $candidature->update(['score_matching' => $score]);

        Log::info('AnalyserMatchingJob: score calculé', [
            'candidature_id' => $candidature->id,
            'score'          => $score,
        ]);

        // Si le score dépasse le seuil, notifier le recruteur
        if ($matchingService->estBonMatch($score) && !$candidature->notif_recruteur_envoyee) {
            NotifierRecruteurJob::dispatch($candidature->fresh());
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('AnalyserMatchingJob: échec définitif', [
            'candidature_id' => $this->candidature->id,
            'error'          => $exception->getMessage(),
        ]);
    }
}
