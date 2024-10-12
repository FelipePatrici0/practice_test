<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTruck extends Model
{
    use HasFactory;

    protected $table = 'tb_model_truck';

    protected $primaryKey = 'id_model_truck_tmt';

    protected $fillable = [
        'model_truck_tmt',
        'color_truck_tmt',
    ];

    public function trucks()
    {
        return $this->hasMany(Truck::class, 'id_model_truck_tbt');
    }
}
