<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeEmployeur extends Model
{
    use HasFactory;

    protected $table = 'demandes_employeur';

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone',
        'entreprise', 'secteur', 'message',
        'password', 'statut',
    ];

    protected $hidden = ['password'];

    const STATUT_PENDING  = 'pending';
    const STATUT_APPROVED = 'approved';
    const STATUT_REJECTED = 'rejected';
}
