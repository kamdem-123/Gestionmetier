<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CompteEmployeurRefuseNotification extends Notification
{
    public function __construct(
        public string $nomEntreprise,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('❌ Votre demande de compte employeur — JobAI')
            ->greeting('Bonjour,')
            ->line("Nous avons bien reçu votre demande de compte employeur pour **{$this->nomEntreprise}**.")
            ->line("Après examen, nous ne sommes malheureusement pas en mesure d'approuver votre demande pour le moment.")
            ->line('Si vous pensez qu\'il s\'agit d\'une erreur, vous pouvez nous contacter directement.')
            ->action('Nous contacter', url('/'))
            ->salutation('L\'équipe JobAI');
    }
}
