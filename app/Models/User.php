<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'verification', 'classe_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function isDirecteur(): bool
    {
        return $this->role === 'directeur';
    }

    public function isEnseignant(): bool
    {
        return $this->role === 'enseignant';
    }

    public function isGestionnaire(): bool
    {
        return $this->role === 'gestionnaire';
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    /**
     * Eleves rattaches a ce parent
     */
    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(Eleve::class, 'parent_eleve');
    }
}
