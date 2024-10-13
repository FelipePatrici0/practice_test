<?php

namespace App\Repositories\Interfaces;

use App\Models\Transportadora;
use App\Repositories\DTOs\StatusTransportadoraDTO;
use App\Repositories\DTOs\TransportadoraDTO;

interface TransportadoraRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?Transportadora;
    public function findByIdWithMotoristas(string $id): ?Transportadora;
    public function save(TransportadoraDTO $transportadoraDTO): Transportadora;
    public function update(TransportadoraDTO $transportadoraDTO, string $id) : void;
    public function updateStatus(StatusTransportadoraDTO $statusTransportadoraDTO, string $id): bool;
    public function updateMotoristas(array $motoristasIds, string $id): array;
    public function delete(string $id): void;
}