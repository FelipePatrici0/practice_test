<?php

namespace App\Repositories;

use App\Models\Modelo;
use App\Repositories\Interfaces\ModeloRepositoryInterface;
use App\Repositories\DTOs\ModeloDTO;

class ModeloRepositoryEloquent implements ModeloRepositoryInterface
{
    public function findAll(): array
    {
        return Modelo::all()->toArray();
    }
    public function findById(string $id): ?Modelo 
    {
        return Modelo::query()->find($id);
    }
    public function save(ModeloDTO $modeloDTO): Modelo
    {
        return Modelo::query()->create($modeloDTO->toArray());
    }
    public function update(ModeloDTO $modeloDTO, string $id) : void
    {
        $modelo = $this->findById($id);
        if ($modelo) {
            $modelo->update($modeloDTO->toArray());
        }
    }
    public function delete(string $id): void
    {
        Modelo::query()->where('id',$id)->delete();
    }
}