<?php

namespace App\Repositories;

use App\Models\Caminhao;
use App\Repositories\Interfaces\CaminhaoRepositoryInterface;
use App\Repositories\DTOs\CaminhaoDTO;

class CaminhaoRepositoryEloquent implements CaminhaoRepositoryInterface
{
    public function findAll(): array
    {
        return Caminhao::all()->toArray();
    }
    public function findById(string $id): ?Caminhao 
    {
        return Caminhao::query()->find($id);
    }
    public function save(CaminhaoDTO $caminhaoDTO): Caminhao
    {
        return Caminhao::query()->create($caminhaoDTO->toArray());
    }
    public function update(CaminhaoDTO $caminhaoDTO, string $id) : void
    {
        $caminhao = $this->findById($id);
        if ($caminhao) {
            $caminhao->update($caminhaoDTO->toArray());
        }
    }
    public function delete(string $id): void
    {
        Caminhao::query()->where('id',$id)->delete();
    }
}