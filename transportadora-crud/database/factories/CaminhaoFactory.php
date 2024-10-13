<?php

namespace Database\Factories;

use App\Models\Modelo;
use App\Models\Motorista;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Caminhao>
 */
class CaminhaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'placa_caminhao' => strtoupper($this->faker->bothify('???-####')),
            'modelo_id' => Modelo::factory(),
            'motorista_id' => Motorista::factory(),
        ];
    }
}
