<?php

namespace App\Jobs;

use App\Models\Candidature;
use App\Notifications\NouveauCandidatMatchNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotifierRecruteurJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 5;

    public function __construct(
        public Candidature $candidature
    ) {}

    public function handle(): void
    {
        $candidature = $this->candidature->load(['user', 'offre.entreprise']);

        $offre      = $candidature->offre;
        $entreprise = $offre->entreprise;
        $candidat   = $candidature->user;

        // Vérifier que l'entreprise a bien un email contact
        if (empty($entreprise->email_contact)) {
            Log::warning('NotifierRecruteurJob: pas d\'email contact pour l\'entreprise', [
                'entreprise_id'  => $entreprise->id,
                'candidature_id' => $candidature->id,
            ]);
            return;
        }

        // Envoyer la notification par email à l'adresse contact de l'entreprise
        // (pas de compte User recruteur pour l'instant, on utilise Notification::route)
        Notification::route('mail', $entreprise->email_contact)
            ->notify(new NouveauCandidatMatchNotification($candidature));

        // Marquer la notification comme envoyée
        $candidature->update(['notif_recruteur_envoyee' => true]);

        Log::info('NotifierRecruteurJob: notification recruteur envoyée', [
            'candidature_id' => $candidature->id,
            'email'          => $entreprise->email_contact,
            'score'          => $candidature->score_matching,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('NotifierRecruteurJob: échec définitif', [
            'candidature_id' => $this->candidature->id,
            'error'          => $exception->getMessage(),
        ]);
    }
}
