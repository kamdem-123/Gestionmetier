<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CompteEmployeurApprouveNotification extends Notification
{
    public function __construct(
        public string $nomEntreprise,
        public string $email,
        public string $motDePasse,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Votre compte employeur a été approuvé — JobAI')
            ->greeting('Bonjour !')
            ->line("Bonne nouvelle ! Votre demande de compte employeur pour **{$this->nomEntreprise}** a été approuvée par notre équipe.")
            ->line('Vous pouvez maintenant vous connecter avec les identifiants suivants :')
            ->line("**Email :** {$this->email}")
            ->line("**Mot de passe :** {$this->motDePasse}")
            ->action('Se connecter à JobAI', url('/connexion'))
            ->line('Nous vous recommandons de changer votre mot de passe après votre première connexion.')
            ->salutation('L\'équipe JobAI');
    }
}
