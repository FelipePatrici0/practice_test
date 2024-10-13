<?php

namespace App\Repositories;

use App\Models\Motorista;
use App\Repositories\Interfaces\MotoristaRepositoryInterface;
use App\Repositories\DTOs\MotoristaDTO;

class MotoristaRepositoryEloquent implements MotoristaRepositoryInterface
{
    public function findAll(): array
    {
        return Motorista::all()->toArray();
    }
    public function findById(string $id): ?Motorista 
    {
        return Motorista::find($id);
    }
    public function findByIdWithCaminhoes(string $id): ?Motorista 
    {
        return Motorista::with('caminhoes')->find($id);
    }
    public function save(MotoristaDTO $motoristaDTO): Motorista
    {
        return Motorista::query()->create($motoristaDTO->toArray());
    }
    public function update(MotoristaDTO $motoristaDTO, string $id) : void
    {
        $motorista = $this->findById($id);
        if ($motorista) {
            $motorista->update($motoristaDTO->toArray());
        }
    }
    public function delete(string $id): void
    {
        Motorista::query()->where('id',$id)->delete();
    }
}