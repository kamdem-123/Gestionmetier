<?php

namespace App\Notifications;

use App\Models\Candidature;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DossierRejeteNotification extends Notification
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

        return (new MailMessage)
            ->subject("Réponse à votre candidature — {$offre->titre}")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Merci d'avoir postulé pour le poste de **{$offre->titre}** chez **{$entreprise?->nom}**.")
            ->line("Après examen de votre dossier, l'employeur ne souhaite pas poursuivre le processus de recrutement avec votre candidature pour ce poste.")
            ->line('Ne vous découragez pas, d\'autres opportunités vous attendent sur JobAI !')
            ->action('Voir les offres disponibles', url('/'))
            ->salutation('L\'équipe JobAI');
    }

    public function toArray(object $notifiable): array
    {
        $offre = $this->candidature->offre;
        return [
            'type'           => 'dossier_rejete',
            'candidature_id' => $this->candidature->id,
            'offre_id'       => $offre->id,
            'offre_titre'    => $offre->titre,
            'message'        => "Votre candidature pour {$offre->titre} n'a pas été retenue.",
        ];
    }
}
