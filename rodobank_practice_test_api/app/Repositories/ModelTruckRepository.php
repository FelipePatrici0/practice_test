<?php

namespace App\Repositories;

use App\Models\ModelTruck;
use App\Repositories\Interfaces\ModelTruckRepositoryInterface;

class ModelTruckRepository implements ModelTruckRepositoryInterface
{
    public function getAll()
    {
        return ModelTruck::all();
    }

    public function find($id)
    {
        return ModelTruck::find($id);
    }

    public function create(array $data)
    {
        return ModelTruck::create($data);
    }

    public function update($id, array $data)
    {
        $model_truck = ModelTruck::find($id);
        if ($model_truck) {
            $model_truck->update($data);
            return $model_truck;
        }
        return null;
    }

    public function delete($id)
    {
        $model_truck = ModelTruck::find($id);
        if ($model_truck) {
            $model_truck->delete();
            return true;
        }
        return false;
    }
}
