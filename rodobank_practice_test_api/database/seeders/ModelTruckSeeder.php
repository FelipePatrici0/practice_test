<?php

namespace Database\Seeders;

use App\Models\ModelTruck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelTruckSeeder extends Seeder
{
    public function run()
    {
        // Usando o factory para gerar 5 registros
        ModelTruck::factory()->count(5)->create();
    }
}
