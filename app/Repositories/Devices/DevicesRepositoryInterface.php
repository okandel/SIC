<?php

namespace App\Repositories\Devices;


interface DevicesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($type=null, $brand=null, $year=null);

    public function create(array $device_array);

    public function update($id, array $device_array);

    public function delete($id);

}