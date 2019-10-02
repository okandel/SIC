<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionPriority extends Model
{

    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;
    protected $table = 'mission_priorities';

    protected $fillable = ['FirmId', 'name', 'order'];
}
