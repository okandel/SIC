<?php

namespace App\Repositories\EmployeeDevices;


interface EmployeeDevicesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list();

    public function create(array $device_array);

    public function update($id, array $device_array);

    public function delete($id);

}