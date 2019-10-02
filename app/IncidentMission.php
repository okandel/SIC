<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentMission extends Model
{

    public $currentFirmRelationPath="employee";
    use \App\Traits\CurrentFirmScope;  

    protected $fillable = [
        'EmpId', 
        'ClientBranchId',
        'title',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at' 
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'EmpId');
    } 

    public function client_branch()
    {
        return $this->belongsTo('App\ClientBranch', 'ClientBranchId');
    }

    public function incident_tasks()
    {
        return $this->hasMany('App\IncidentMissionTask', 'IncidentMissionId');
    }
}
