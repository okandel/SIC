<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionTask extends Model
{
    protected $fillable = [
        'MissionId', 
        'ItemId',
        'TypeId',
        'quantity',
        'item_payload'
    ];

    public function mission()
    {
        return $this->belongsTo('App\Mission', 'MissionId');
    }

    public function type()
    {
        return $this->belongsTo('App\MissionTaskType', 'TypeId');
    }

    public function item()
    {
        return $this->belongsTo('App\Item', 'ItemId');
    }

    public function attachments()
    {
        return $this->hasMany('App\MissionTaskAttachment', 'TaskId');
    }
}
