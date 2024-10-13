<?php

namespace App\Repositories;

use App\Models\Carrier;
use App\Repositories\Interfaces\CarrierRepositoryInterface;

class CarrierRepository implements CarrierRepositoryInterface
{
    public function getAll()
    {
        return Carrier::all();
    }

    public function find($id)
    {
        return Carrier::find($id);
    }

    public function create(array $data)
    {
        return Carrier::create($data);
    }

    public function update($id, array $data)
    {
        $carrier = Carrier::find($id);
        if ($carrier) {
            $carrier->update($data);
            return $carrier;
        }
        return null;
    }

    public function updateActiveStatus($id, bool $is_active)
    {
        $carrier = $this->find($id);

        if (!$carrier) {
            return null; // Ou lançar uma exceção
        }

        $carrier->is_active_tbc = $is_active;
        $carrier->save(); // Salva as mudanças

        return $carrier; // Retorna o carrier atualizado
    }

    public function delete($id)
    {
        $carrier = Carrier::find($id);
        if ($carrier) {
            $carrier->delete();
            return true;
        }
        return false;
    }
    
}
