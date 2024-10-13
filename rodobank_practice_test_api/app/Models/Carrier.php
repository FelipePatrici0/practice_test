<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $table = 'tb_carrier';

    protected $primaryKey = 'id_carrier_tbc';

    protected $fillable = [
        'name_carrier_tbc',
        'cnpj_carrier_tbc',
        'is_active_tbc',
    ];

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'rel_carrier_driver', 'id_carrier_rcd', 'id_driver_rcd');
    }
}
