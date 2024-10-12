<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Importando a interface JWTSubject

class User extends Authenticatable implements JWTSubject // Implementando a interface
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Método que retorna o identificador do usuário
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Retorna a chave primária do usuário
    }

    // Método que retorna as reivindicações personalizadas do JWT
    public function getJWTCustomClaims()
    {
        return []; // Retorna um array vazio (você pode adicionar reivindicações personalizadas se desejar)
    }
}

