<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_CANDIDAT  = 'candidat';
    const ROLE_EMPLOYEUR = 'employeur';
    const ROLE_ADMIN     = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
        'google_id', 'avatar', 'email_verified_at',
        'is_admin', 'role',
        'titre_poste', 'competences', 'cv_texte', 'cv_path',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_admin'          => 'boolean',
    ];

    public function isAdmin(): bool     { return $this->role === self::ROLE_ADMIN || (bool) $this->is_admin; }
    public function isEmployeur(): bool { return $this->role === self::ROLE_EMPLOYEUR; }
    public function isCandidat(): bool  { return $this->role === self::ROLE_CANDIDAT || $this->role === null; }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }
}
