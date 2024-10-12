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

    public function getDriversAssociatedWithCarrier($id_carrier)
    {
        return CarrierDriver::select(
                'rcd.id_carrier_driver_rcd',
                'tc.name_carrier_tbc',
                'tc.cnpj_carrier_tbc',
                'td.name_driver_tbd',
                'td.cpf_driver_tbd',
                'td.birthdate_driver_tbd',
                'td.email_driver_tbd',
                'rcd.created_at',
                'rcd.updated_at'
            )
            ->from('rel_carrier_driver as rcd')
            ->join('tb_carrier as tc', 'rcd.id_carrier_rcd', '=', 'tc.id_carrier_tbc')
            ->join('tb_driver as td', 'rcd.id_driver_rcd', '=', 'td.id_driver_tbd')
            ->where('rcd.id_carrier_rcd', $id_carrier)
            ->get();
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
