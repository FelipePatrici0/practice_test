<?php

namespace App\Repositories\Interfaces;

interface CarrierDriverRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function driverAlreadyRegistered(int $id_carrier, int $id_driver);
    public function driverAlreadyRegisteredUpdate(int $id_carrier, int $id_driver, int $currentId = null);
    public function update($id, array $data);
    public function delete($id);
}
