<?php

namespace App\Repositories;

use App\Models\Driver;
use App\Repositories\Interfaces\DriverRepositoryInterface;

class DriverRepository implements DriverRepositoryInterface
{
    public function getAll()
    {
        return Driver::all();
    }

    public function find($id)
    {
        return Driver::find($id);
    }

    public function create(array $data)
    {
        return Driver::create($data);
    }

    public function update($id, array $data)
    {
        $driver = Driver::find($id);
        if ($driver) {
            $driver->update($data);
            return $driver;
        }
        return null;
    }

    public function delete($id)
    {
        $driver = Driver::find($id);
        if ($driver) {
            $driver->delete();
            return true;
        }
        return false;
    }
}
