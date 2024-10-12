<?php

namespace App\Repositories;

use App\Models\Truck;
use App\Repositories\Interfaces\TruckRepositoryInterface;

class TruckRepository implements TruckRepositoryInterface
{
    public function getAll()
    {
        return Truck::all();
    }

    public function find($id)
    {
        return Truck::find($id);
    }

    public function create(array $data)
    {
        return Truck::create($data);
    }

    public function update($id, array $data)
    {
        $truck = Truck::find($id);
        if ($truck) {
            $truck->update($data);
            return $truck;
        }
        return null;
    }

    public function delete($id)
    {
        $truck = Truck::find($id);
        if ($truck) {
            $truck->delete();
            return true;
        }
        return false;
    }
}
