<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Motorista>
 */
class MotoristaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_motorista' => $this->faker->name(),
            'cpf_motorista' => $this->faker->numerify('###########'),
            'data_nascimento_motorista' => $this->faker->date('Y-m-d'),
            'email_motorista' => $this->faker->safeEmail(),
        ];
    }
}
