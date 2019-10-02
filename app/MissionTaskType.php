<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionTaskType extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;
    
    protected $table = 'mission_task_types';
    protected $fillable = ['FirmId', 'name', 'order'];
}
