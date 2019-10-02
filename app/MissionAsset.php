<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionAsset extends Model
{
    protected $fillable = ['MissionId', 'VehicleId'];
}
