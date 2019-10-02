<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionOccurrenceTask extends Model
{
    protected $fillable = ['MissionOccurenceId','TaskId', 'StatusId']; 
     
    public $timestamps = false;
    protected $table = 'mission_occurrence_task';

    public function task()
    {
        return $this->belongsTo('App\MissionTask', 'TaskId');
    }
}
