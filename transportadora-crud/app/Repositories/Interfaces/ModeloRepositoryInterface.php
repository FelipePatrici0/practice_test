<?php

namespace App\Repositories\Interfaces;

use App\Models\Modelo;
use App\Repositories\DTOs\ModeloDTO;

interface ModeloRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?Modelo;
    public function save(ModeloDTO $modeloDTO): Modelo;
    public function update(ModeloDTO $modeloDTO, string $id) : void;
    public function delete(string $id): void;
}