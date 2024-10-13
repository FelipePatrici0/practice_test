<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportadora extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = ['nome_transportadora', "cnpj_transportadora","status_transportadora"];

    public function motoristas()
    {
        return $this->belongsToMany(Motorista::class, "transportadora_motorista");
    }
}
