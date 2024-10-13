<?php

namespace App\Repositories;

use App\Models\Transportadora;
use App\Repositories\DTOs\StatusTransportadoraDTO;
use App\Repositories\Interfaces\TransportadoraRepositoryInterface;
use App\Repositories\DTOs\TransportadoraDTO;

class TransportadoraRepositoryEloquent implements TransportadoraRepositoryInterface
{
    public function findAll(): array
    {
        return Transportadora::all()->toArray();
    }
    public function findById(string $id): ?Transportadora 
    {
        return Transportadora::query()->find($id);
    }
    public function findByIdWithMotoristas(string $id): ?Transportadora 
    {
        return Transportadora::with('motoristas')->find($id);
    }
    
    public function save(TransportadoraDTO $transportadoraDTO): Transportadora
    {
        return Transportadora::query()->create($transportadoraDTO->toArray());
    }
    public function updateMotoristas(array $motoristasIds, string $id): array
    {
        $transportadora = Transportadora::findOrFail($id);

        return $transportadora->motoristas()->sync($motoristasIds);
    }
    public function update(TransportadoraDTO $transportadoraDTO, string $id) : void
    {
        $transportadora = $this->findById($id);
        if ($transportadora) {
            $transportadora->update($transportadoraDTO->toArray());
        }
    }
    public function updateStatus(StatusTransportadoraDTO $statusTransportadoraDTO, string $id) : bool
    {
        $transportadora = $this->findById($id);
        if ($transportadora) {
            return $transportadora->update($statusTransportadoraDTO->toArray());
        }
        return false;
    }
    public function delete(string $id): void
    {
        Transportadora::query()->where('id',$id)->delete();
    }
}