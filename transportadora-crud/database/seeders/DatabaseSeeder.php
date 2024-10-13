<?php

namespace Database\Seeders;

use App\Models\Caminhao;
use App\Models\Modelo;
use App\Models\Motorista;
use App\Models\Transportadora;
use App\Models\User;
use Database\Seeders\ModeloSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            ModeloSeeder::class,
        ]);

        Transportadora::factory(5)->create()->each(function ($transportadora) {
            Motorista::factory(10)->create()->each(function ($motorista) use ($transportadora) {
                $transportadora->motoristas()->attach($motorista->id);

                Caminhao::factory(2)->create([
                    'motorista_id' => $motorista->id, 
                    'modelo_id' => Modelo::inRandomOrder()->first()->id,  
                ]);
            });
        }); 
    }
}
