<?php

namespace App\Repositories\Interfaces;

interface CarrierRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateActiveStatus($id, bool $is_active);
    public function delete($id);
}
