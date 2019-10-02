<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionOccurrence extends Model
{
    protected $fillable = ['MissionId', 'EmpId', 'StatusId', 'ReasonId', 'scheduled_date', 'comment', 'is_currently_active'];

    
    protected $table = 'mission_occurrences';
    protected $dates = [
        'created_at',
        'updated_at',
        'scheduled_date' 
    ];
    public function mission()
    {
        return $this->belongsTo('App\Mission', 'MissionId');
    }
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'EmpId');
    }

    public function tasksOccurrences()
    {
        return $this->hasMany('App\MissionOccurrenceTask', 'MissionOccurenceId');
    }

    public function repsOccurrences()
    {
        return $this->hasMany('App\MissionOccurrenceRep', 'MissionOccurenceId');
    }
}
