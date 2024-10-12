<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'tb_driver';

    protected $primaryKey = 'id_driver_tbd';

    protected $fillable = [
        'name_driver_tbd',
        'cpf_driver_tbd',
        'birthdate_driver_tbd',
        'email_driver_tbd',
    ];

    public function trucks()
    {
        return $this->hasMany(Truck::class, 'id_driver_tbt');
    }

    public function carriers()
    {
        return $this->belongsToMany(Carrier::class, 'rel_carrier_driver', 'id_driver_rcd', 'id_carrier_rcd');
    }
}
