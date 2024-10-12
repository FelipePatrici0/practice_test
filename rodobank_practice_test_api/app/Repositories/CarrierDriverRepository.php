<?php

namespace App\Repositories;

use App\Models\RelCarrierDrive as CarrierDriver;
use App\Repositories\Interfaces\CarrierDriverRepositoryInterface;

class CarrierDriverRepository implements CarrierDriverRepositoryInterface
{
    public function getAll()
    {
        return CarrierDriver::all();
    }

    public function find($id)
    {
        return CarrierDriver::find($id);
    }

    public function create(array $data)
    {
        return CarrierDriver::create($data);
    }

    public function driverAlreadyRegistered($id_carrier, $id_driver)
    {
        return CarrierDriver::where([
            ['id_carrier_rcd', '=', $id_carrier],
            ['id_driver_rcd', '=', $id_driver],
        ])->exists();
    }

    public function driverAlreadyRegisteredUpdate($id_carrier, $id_driver, $currentId = null)
    {
        return CarrierDriver::where('id_carrier_rcd', $id_carrier)
            ->where('id_driver_rcd', $id_driver)
            ->when($currentId, function ($query) use ($currentId) {
                return $query->where('id_carrier_driver_rcd', '!=', $currentId);
            })
            ->exists();
    }


    public function update($id, array $data)
    {
        $carrier_driver = CarrierDriver::find($id);
        if ($carrier_driver) {
            $carrier_driver->update($data);
            return $carrier_driver;
        }
        return null;
    }

    public function delete($id)
    {
        $carrier_driver = CarrierDriver::find($id);
        if ($carrier_driver) {
            $carrier_driver->delete();
            return true;
        }
        return false;
    }
}
