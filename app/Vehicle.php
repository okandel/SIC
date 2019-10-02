<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    
    use \App\Traits\CurrentFirmScope; 
    use \App\Traits\CurrentFirmScopeWrite;
    
    protected $fillable = ['FirmId', 'type', 'brand', 'year', 'no_of_passengers', 'body_type'];


    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employee_assets', 'VehicleId', 'EmployeeId');
    }

    public function missions()
    {
        return $this->belongsToMany('App\Mission', 'mission_assets', 'VehicleId', 'MissionId');
    }
}
