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

    public function getTruckDriversData()
    {
        $data_truck_drivers = Truck::select(
            'td.name_driver_tbd',
            'td.cpf_driver_tbd',
            'td.birthdate_driver_tbd',
            'td.email_driver_tbd',
            'tmt.model_truck_tmt',
            'tmt.color_truck_tmt',
            'tb_truck.plate_truck_tbt'
        )
        ->join('tb_driver as td', 'tb_truck.id_driver_tbt', '=', 'td.id_driver_tbd')
        ->join('tb_model_truck as tmt', 'tb_truck.id_model_truck_tbt', '=', 'tmt.id_model_truck_tmt')
        ->get();

        return $data_truck_drivers;
    }

    public function find($id)
    {
        return Truck::find($id);
    }

    public function findTruckDriversData($id)
    {
        $data_truck_drivers = Truck::select(
            'td.name_driver_tbd',
            'td.cpf_driver_tbd',
            'td.birthdate_driver_tbd',
            'td.email_driver_tbd',
            'tmt.model_truck_tmt',
            'tmt.color_truck_tmt',
            'tb_truck.plate_truck_tbt'
        )
        ->join('tb_driver as td', 'tb_truck.id_driver_tbt', '=', 'td.id_driver_tbd')
        ->join('tb_model_truck as tmt', 'tb_truck.id_model_truck_tbt', '=', 'tmt.id_model_truck_tmt')
        ->where('td.id_driver_tbd', $id)
        ->get();

        return $data_truck_drivers;
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
