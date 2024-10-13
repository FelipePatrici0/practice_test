<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caminhao extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'caminhoes';

    protected $fillable = ['motorista_id', 'modelo_id','placa_caminhao'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

}
