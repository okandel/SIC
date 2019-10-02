<?php

namespace App\Repositories\Devices;


use App\Device;

use App\Repositories\BaseRepository;   
class DevicesRepository extends BaseRepository implements DevicesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Device::Query()); 
    }  

    public function list($os_type=null, $display_name=null, $device_unique_id=null)
    {
        $devices = $this->query();
        if ($os_type)
        {
            $devices = $devices->where('os_type', 'like', '%'.$os_type.'%');
        }
        if ($display_name)
        {
            $devices = $devices->where('display_name', 'like', '%'.$display_name.'%');
        }
        if ($device_unique_id)
        {
            $devices = $devices->where('device_unique_id', 'like', '%'.$device_unique_id.'%');
        }

        $devices = $devices->get();
        return $devices;
    }
 
}