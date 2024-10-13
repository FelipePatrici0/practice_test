<?php
use App\Models\Transportadora;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can get transportadoras', function () {
    Transportadora::factory()->count(3)->create();

    $response = $this->get('/api/transportadoras');

    $response->assertStatus(200);

    $this->assertCount(3, $response->json());
});