<?php

namespace App\Repositories\EmployeeDevices;


use App\EmployeeDevice;
use App\Repositories\BaseRepository;   
class EmployeeDevicesRepository extends BaseRepository implements EmployeeDevicesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(EmployeeDevice::Query()); 
    } 
  
    public function list()
    { 
        $devices = $this->getAll();
        return $devices;
    } 
}