<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Models\User;
use App\Notifications\NouvelleOffreMatchNotification;
use App\Services\MatchingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScannerOffresCommand extends Command
{
    protected $signature = 'matching:scanner-offres
                            {--jours=7 : Nombre de jours en arrière pour les nouvelles offres}
                            {--seuil= : Score minimum pour notifier (écrase la config)}
                            {--dry-run : Simule sans envoyer de notifications ni écrire en base}';

    protected $description = 'Scanne les nouvelles offres et notifie les candidats dont le profil correspond';

    public function handle(MatchingService $matchingService): int
    {
        $jours   = (int) $this->option('jours');
        $dryRun  = $this->option('dry-run');
        $seuil   = $this->option('seuil')
                    ? (float) $this->option('seuil')
                    : (float) config('services.huggingface.seuil_score', 70);

        $this->info("=== Scanner de matching JobAI ===");
        $this->info("Paramètres : offres des {$jours} derniers jours | seuil : {$seuil}% | dry-run : " . ($dryRun ? 'OUI' : 'NON'));
        $this->newLine();

        // Récupérer les offres publiées récentes avec leur entreprise
        $offres = Offre::with('entreprise')
            ->where('status', 'active')
            ->where('date_publication', '>=', now()->subDays($jours))
            ->get();

        if ($offres->isEmpty()) {
            $this->warn("Aucune offre publiée trouvée dans les {$jours} derniers jours.");
            return Command::SUCCESS;
        }

        $this->info("Offres trouvées : {$offres->count()}");

        // Récupérer les candidats ayant un profil renseigné
        $candidats = User::where('is_admin', false)
            ->where(function ($query) {
                $query->whereNotNull('competences')
                      ->where('competences', '!=', '')
                      ->orWhere(function ($q) {
                          $q->whereNotNull('cv_texte')
                            ->where('cv_texte', '!=', '');
                      });
            })
            ->get();

        if ($candidats->isEmpty()) {
            $this->warn("Aucun candidat avec un profil renseigné.");
            return Command::SUCCESS;
        }

        $this->info("Candidats avec profil : {$candidats->count()}");
        $this->newLine();

        $totalNotifications = 0;
        $totalPaires        = $offres->count() * $candidats->count();
        $progressBar        = $this->output->createProgressBar($totalPaires);
        $progressBar->start();

        foreach ($offres as $offre) {
            foreach ($candidats as $candidat) {

                $progressBar->advance();

                try {
                    $score = $matchingService->calculerScore($offre, $candidat);

                    // Ne notifier que si score suffisant ET pas déjà notifié pour cette offre
                    if ($score >= $seuil) {
                        $dejaNotifie = $candidat->notifications()
                            ->whereNull('read_at')
                            ->where('data->type', 'nouvelle_offre_match')
                            ->where('data->offre_id', $offre->id)
                            ->exists();

                        if (!$dejaNotifie) {
                            if (!$dryRun) {
                                $candidat->notify(new NouvelleOffreMatchNotification($offre, $score));
                            }

                            $totalNotifications++;

                            Log::info('ScannerOffres: match trouvé', [
                                'offre_id'    => $offre->id,
                                'offre_titre' => $offre->titre,
                                'user_id'     => $candidat->id,
                                'user_nom'    => $candidat->name,
                                'score'       => $score,
                                'dry_run'     => $dryRun,
                            ]);
                        }
                    }

                } catch (\Exception $e) {
                    Log::error('ScannerOffres: erreur sur paire offre/candidat', [
                        'offre_id'  => $offre->id,
                        'user_id'   => $candidat->id,
                        'error'     => $e->getMessage(),
                    ]);
                }
            }
        }

        $progressBar->finish();
        $this->newLine(2);

        $label = $dryRun ? 'notifications simulées' : 'notifications envoyées';
        $this->info("✅ Scan terminé — {$totalNotifications} {$label}");

        return Command::SUCCESS;
    }
}
