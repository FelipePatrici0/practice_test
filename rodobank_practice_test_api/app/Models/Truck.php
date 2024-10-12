<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $table = 'tb_truck';

    protected $primaryKey = 'id_truck_tbt';

    protected $fillable = [
        'id_driver_tbt',
        'id_model_truck_tbt',
        'plate_truck_tbt',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'id_driver_tbt');
    }

    public function model()
    {
        return $this->belongsTo(ModelTruck::class, 'id_model_truck_tbt');
    }
}
