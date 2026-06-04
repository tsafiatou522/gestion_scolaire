<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'verification'];

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
}