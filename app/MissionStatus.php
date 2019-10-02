<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionStatus extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;

    protected $fillable = ['FirmId', 'name', 'order'];

    protected $table = 'mission_statuses';
}
