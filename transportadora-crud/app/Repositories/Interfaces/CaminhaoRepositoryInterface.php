<?php

namespace App\Repositories\Interfaces;

use App\Models\Caminhao;
use App\Repositories\DTOs\CaminhaoDTO;

interface CaminhaoRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?Caminhao;
    public function save(CaminhaoDTO $caminhaoDTO): Caminhao;
    public function update(CaminhaoDTO $caminhaoDTO, string $id) : void;
    public function delete(string $id): void;
}