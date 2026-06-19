<?php

namespace App\Notifications;

use App\Models\Offre;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleOffreMatchNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Offre $offre,
        public float $score
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $score      = number_format($this->score, 1);
        $entreprise = $this->offre->entreprise;

        return (new MailMessage)
            ->subject("💼 Offre correspondant à votre profil — {$score}% de correspondance")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Notre IA a trouvé une offre d'emploi qui correspond à votre profil.")
            ->line("**Poste :** {$this->offre->titre}")
            ->line("**Entreprise :** {$entreprise->nom}")
            ->line("**Localisation :** {$this->offre->ville}, {$this->offre->pays}")
            ->line("**Score de correspondance :** {$score}%")
            ->action('Voir l\'offre', url('/offre-detail.php?id=' . $this->offre->id))
            ->line("Bonne chance dans votre recherche d'emploi !")
            ->salutation("L'équipe JobAI");
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'            => 'nouvelle_offre_match',
            'offre_id'        => $this->offre->id,
            'offre_titre'     => $this->offre->titre,
            'entreprise_nom'  => $this->offre->entreprise->nom,
            'ville'           => $this->offre->ville,
            'pays'            => $this->offre->pays,
            'score'           => $this->score,
            'message'         => "Nouvelle offre \"{$this->offre->titre}\" — {$this->score}% de correspondance avec votre profil",
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
