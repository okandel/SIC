<?php

namespace App\Repositories\Vehicles;


interface VehiclesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($type=null, $brand=null, $year=null);

    public function create(array $vehicle_array);

    public function update($id, array $vehicle_array);

    public function delete($id);

}