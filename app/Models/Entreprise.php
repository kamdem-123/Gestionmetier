<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entreprise extends Model
{
    use HasFactory;

    protected $table = 'entreprises';

    protected $fillable = [
        'nom',
        'secteur',
        'email_contact',
        'telephone',
        'website',
        'logo',
    ];

    public function offres(): HasMany
    {
        return $this->hasMany(Offre::class);
    }
}
