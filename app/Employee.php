<?php

namespace App;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;
    use SoftDeletes;
    use SpatialTrait;

    protected $table = 'employees';
    protected $fillable = [
        'FirmId',
        'first_name',
        'last_name',
        'image',
        'email',
        'password',
        'hash',
        'phone',
        'current_location',
        'alt',
        'speed',
        'bearing_heading',
        'email_verified',
        'phone_verified',
        'duty_status',
    ];
    protected $hidden = [
        'password',
    ];

    protected $appends = ['lat', 'lng'];

    protected $spatialFields = [
        'current_location'
    ];

    public function getLatAttribute()
    {
        if ($this->current_location) {
            return $this->current_location->getLat();
        } else {
            return null;
        }
    }

    public function getLngAttribute()
    {
        if ($this->current_location) {
            return $this->current_location->getLng();
        } else {
            return null;
        }
    }

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'FirmId');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle', 'employee_assets', 'EmployeeId', 'VehicleId');
    }

    public function devices()
    {
        return $this->belongsToMany('App\Device', 'employee_devices', 'EmpId', 'device_unique_id', 'id', 'device_unique_id');
    }

    public function missions()
    {
        return $this->hasMany('App\Mission', 'EmpId');
    }

    //Missions temporary assigned to this emp
    public function excptional_missionsOccurrences()
    {
        return $this->hasMany('App\MissionOccurrence', 'EmpId');
    }


    public function getimageAttribute($value)
    {
        if ($value) {
            return asset($value);
        }
        return asset("/uploads/defaults/employee.jpg");
    }

    public function getStatistics()
    {
        $missions = $this->missions->pluck('occurrence')->flatten();
        $excptional_missionsOccurrences = $this->excptional_missionsOccurrences;

        $all_missions = $missions->union($excptional_missionsOccurrences);

        $total_tasks = $all_missions->count();
        $new_tasks = $all_missions
            ->filter(function ($value, $key) {
                return $value->StatusId != 3 && $value->StatusId != 5;
            })->count();
        $done_tasks = $all_missions->where('StatusId', 3)->count();
        $Rearranged_tasks = $all_missions->where('StatusId', 5)->count();
        $statistics = [
            "total_tasks" => $total_tasks,
            "new_tasks" => $new_tasks,
            "done_tasks" => $done_tasks,
            "Rearranged_tasks" => $Rearranged_tasks,
            "success_rate" => round($done_tasks / $total_tasks * 100, 2),
        ];
        return $statistics;
    }

}
