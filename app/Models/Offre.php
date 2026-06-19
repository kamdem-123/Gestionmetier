<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offre extends Model
{
    use HasFactory;

    protected $table = 'offres';

    protected $fillable = [
        'titre',
        'entreprise_id',
        'type_contrat',
        'mode_travail',
        'localisation',
        'ville',
        'pays',
        'categorie',
        'description',
        'competences',
        'salaire_min',
        'salaire_max',
        'devise',
        'salary_eur',
        'salary_type',
        'date_publication',
        'status',
        'posted_by_user_id',
    ];

    // Statuts possibles
    const STATUS_PENDING  = 'pending';
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ARCHIVED = 'archived';

    protected $casts = [
        'salaire_min'       => 'decimal:2',
        'salaire_max'       => 'decimal:2',
        'salary_eur'        => 'decimal:2',
        'date_publication'  => 'date',
    ];

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }

    public function scopePubliee($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeRecentes($query, int $jours = 7)
    {
        return $query->where('date_publication', '>=', now()->subDays($jours));
    }
}
