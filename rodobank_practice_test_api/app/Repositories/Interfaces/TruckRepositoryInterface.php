<?php

namespace App\Repositories\Interfaces;

interface TruckRepositoryInterface
{
    public function getAll();
    public function getTruckDriversData();
    public function getTruckAssociatedWithDriver($id);
    public function find($id);
    public function findTruckDriversData($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
