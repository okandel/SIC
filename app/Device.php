<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    
    use \App\Traits\CurrentFirmScope; 
    use \App\Traits\CurrentFirmScopeWrite;
    
    protected $fillable = ['FirmId', 'os_type', 'display_name', 'device_unique_id'];


    // public function employees()
    // {
    //     return $this->belongsToMany('App\Employee', 'employee_assets', 'DeviceId', 'EmployeeId');
    // }

    public function missions()
    {
        return $this->belongsToMany('App\Mission', 'mission_devices', 'DeviceId', 'MissionId');
    }
}
