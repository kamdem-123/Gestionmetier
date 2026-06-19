<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidature extends Model
{
    use HasFactory;

    protected $table = 'candidatures';

    protected $fillable = [
        'user_id', 'offre_id', 'score_matching',
        'statut', 'notif_recruteur_envoyee', 'notif_candidat_envoyee',
        'entretien_date', 'entretien_heure', 'note_employeur',
    ];

    protected $casts = [
        'score_matching'          => 'decimal:2',
        'notif_recruteur_envoyee' => 'boolean',
        'notif_candidat_envoyee'  => 'boolean',
        'entretien_date'          => 'date',
    ];

    const STATUT_EN_ATTENTE          = 'en_attente';
    const STATUT_VUE                 = 'vue';
    const STATUT_ACCEPTEE            = 'acceptee';
    const STATUT_REFUSEE             = 'refusee';
    const STATUT_ENTRETIEN_PROGRAMME = 'entretien_programme';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offre(): BelongsTo
    {
        return $this->belongsTo(Offre::class);
    }

    public function libelleStatut(): string
    {
        return match($this->statut) {
            self::STATUT_EN_ATTENTE          => 'En attente',
            self::STATUT_VUE                 => 'Vue par l\'employeur',
            self::STATUT_ACCEPTEE            => 'Acceptée',
            self::STATUT_REFUSEE             => 'Refusée',
            self::STATUT_ENTRETIEN_PROGRAMME => 'Entretien programmé',
            default                          => ucfirst($this->statut),
        };
    }
}
