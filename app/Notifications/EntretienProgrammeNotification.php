<?php

namespace App\Notifications;

use App\Models\Candidature;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EntretienProgrammeNotification extends Notification
{
    public function __construct(
        public Candidature $candidature,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $offre      = $this->candidature->offre;
        $entreprise = $offre->entreprise;
        $date       = $this->candidature->entretien_date?->format('d/m/Y');
        $heure      = $this->candidature->entretien_heure
                        ? substr($this->candidature->entretien_heure, 0, 5)
                        : '';

        return (new MailMessage)
            ->subject("📅 Entretien programmé — {$offre->titre}")
            ->greeting("Bonjour {$notifiable->name} !")
            ->line("Félicitations ! L'employeur **{$entreprise?->nom}** souhaite vous rencontrer pour le poste de **{$offre->titre}**.")
            ->line("**Date :** {$date}")
            ->line("**Heure :** {$heure}")
            ->line($this->candidature->note_employeur ? "**Message de l'employeur :** {$this->candidature->note_employeur}" : '')
            ->action('Voir mes candidatures', url('/dashboard'))
            ->salutation('L\'équipe JobAI');
    }

    public function toArray(object $notifiable): array
    {
        $offre = $this->candidature->offre;
        $date  = $this->candidature->entretien_date?->format('d/m/Y');
        $heure = $this->candidature->entretien_heure
                    ? substr($this->candidature->entretien_heure, 0, 5)
                    : '';

        return [
            'type'             => 'entretien_programme',
            'candidature_id'   => $this->candidature->id,
            'offre_id'         => $offre->id,
            'offre_titre'      => $offre->titre,
            'entretien_date'   => $date,
            'entretien_heure'  => $heure,
            'message'          => "Entretien le {$date} à {$heure} pour {$offre->titre}",
        ];
    }
}
