<?php

namespace App\Notifications;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauCandidatMatchNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Candidature $candidature
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $candidat   = $this->candidature->user;
        $offre      = $this->candidature->offre;
        $score      = number_format($this->candidature->score_matching, 1);

        return (new MailMessage)
            ->subject("🎯 Nouveau candidat compatible — {$score}% de correspondance")
            ->greeting("Bonjour,")
            ->line("Un candidat très compatible vient de postuler à votre offre.")
            ->line("**Offre :** {$offre->titre}")
            ->line("**Candidat :** {$candidat->name}")
            ->line("**Score de correspondance :** {$score}%")
            ->action('Voir la candidature', url('/admin'))
            ->line("Ce candidat a été sélectionné automatiquement par notre système d'analyse IA.")
            ->salutation("L'équipe JobAI");
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'            => 'nouveau_candidat_match',
            'candidature_id'  => $this->candidature->id,
            'offre_id'        => $this->candidature->offre_id,
            'offre_titre'     => $this->candidature->offre->titre,
            'candidat_id'     => $this->candidature->user_id,
            'candidat_nom'    => $this->candidature->user->name,
            'score'           => $this->candidature->score_matching,
            'message'         => "Candidat {$this->candidature->user->name} — {$this->candidature->score_matching}% de correspondance pour \"{$this->candidature->offre->titre}\"",
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
