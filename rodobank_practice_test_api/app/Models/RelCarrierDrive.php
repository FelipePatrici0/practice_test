<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelCarrierDrive extends Model
{
    use HasFactory;

    protected $table = 'rel_carrier_driver';

    protected $primaryKey = 'id_carrier_driver_rcd';

    protected $fillable = [
        'id_carrier_rcd',
        'id_driver_rcd',
    ];
}
