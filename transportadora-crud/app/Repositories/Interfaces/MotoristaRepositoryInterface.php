<?php

namespace App\Repositories\Interfaces;

use App\Models\Motorista;
use App\Repositories\DTOs\MotoristaDTO;

interface MotoristaRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?Motorista;
    public function findByIdWithCaminhoes(string $id): ?Motorista;
    public function save(MotoristaDTO $motoristaDTO): Motorista;
    public function update(MotoristaDTO $motoristaDTO, string $id) : void;
    public function delete(string $id): void;
}