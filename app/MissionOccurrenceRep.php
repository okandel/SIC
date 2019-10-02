<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionOccurrenceRep extends Model
{
    protected $fillable = ['MissionOccurenceId', 'RepId']; 
    public $timestamps = false;
    
    protected $table = 'mission_occurrence_reps';

    public function rep()
    {
        return $this->belongsTo('App\ClientRep', 'RepId');
    }
}
