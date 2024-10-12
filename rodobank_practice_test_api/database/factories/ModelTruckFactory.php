<?php

namespace Database\Factories;

use App\Models\ModelTruck;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModelTruck>
 */
class ModelTruckFactory extends Factory
{
    protected $model = ModelTruck::class;

    public function definition()
    {
        $truckModels = [
            'Volvo FH16',
            'Mercedes-Benz Actros',
            'Scania R450',
            'Iveco S-Way',
            'DAF XF'
        ];
        return [
            'model_truck_tmt' => $this->faker->randomElement($truckModels),
            'color_truck_tmt' => $this->faker->safeColorName(),
        ];
    }
}
