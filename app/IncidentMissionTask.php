<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentMissionTask extends Model
{
    protected $fillable = [
        'IncidentMissionId', 
        'ItemId',
        'TypeId' 
    ];
    public $timestamps = false;

    
    public function mission()
    {
        return $this->belongsTo('App\IncidentMission', 'IncidentMissionId');
    }

    public function type()
    {
        return $this->belongsTo('App\MissionTaskType', 'TypeId');
    }

    public function item()
    {
        return $this->belongsTo('App\Item', 'ItemId');
    }
 
}
