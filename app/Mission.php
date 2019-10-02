<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mission extends Model
{

    public $currentFirmRelationPath = "employee";
    use \App\Traits\CurrentFirmScope;

    protected $fillable = [
        'EmpId',
        'AssignedBy',
        'PriorityId',
        'ClientBranchId',
        'title',
        'description',
        'start_date',
        'complete_date',
        'recurring_type',
        'repeat_value',
        'total_cycle',
        'StatusId'
    ];
  
    protected $dates = [
        'created_at',
        'updated_at',
        'start_date',
        'complete_date',
    ];

    public function getStatusIdAttribute($value)
    {
        // Default                  => 0
        // New                      => 1
        // Pending                  => 2
        // Completed                => 3 == DB
        // Expired || Cancelled      => 4
        // Re-arranged              => 5 == DB

        if ($value == 3 ||  // Completed
            $value == 5  //Re-arranged
        ) {
            return $value;
        } else {
            if ( $this->start_date >= Carbon::today()
                && $this->start_date <= Carbon::today()->addDays(1)->addMillis(-1)) {
                return 2; //Pending
            } else if ( 
                 $this->start_date > Carbon::today()->addDays(1)->addMillis(-1)) {
                return 1; //New
            } else {
                return 4; //Expired
            }
        }
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'EmpId');
    }

    public function assigned_by()
    {
        return $this->belongsTo('App\FirmLogin', 'AssignedBy');
    }

    public function priority()
    {
        return $this->belongsTo('App\MissionPriority', 'PriorityId');
    }

    public function status()
    {
        return $this->belongsTo('App\MissionStatus', 'StatusId');
    }

    public function client_branch()
    {
        return $this->belongsTo('App\ClientBranch', 'ClientBranchId');
    }

    public function tasks()
    {
        return $this->hasMany('App\MissionTask', 'MissionId');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle', 'mission_assets', 'MissionId', 'VehicleId');
    }

    public function devices()
    {
        return $this->belongsToMany('App\Device', 'mission_devices', 'MissionId', 'DeviceId');
    }

    public function attachments()
    {
        return $this->hasMany('App\MissionTaskAttachment', 'MissionId');
    }

    public function occurrence()
    {
        return $this->hasMany('App\MissionOccurrence', 'MissionId'); 
    } 
    public function OccurrenceAsMissionObj()
    { 
         $mission= clone $this; 
        $res = $this->occurrence->map(function($item) use($mission){
            $mission = clone $mission; 

            $mission->id = $item->id;
            $mission->StatusId = $item->StatusId;
            $mission->start_date =  $item->scheduled_date; 
            if($item->EmpId)
            {
                $mission->EmpId =  $item->EmpId;
            }
            return  $mission;
        }); 
        return $res;
    }
}
