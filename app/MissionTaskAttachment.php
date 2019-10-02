<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionTaskAttachment extends Model
{
    protected $fillable = ['TaskId', 'MissionId', 'attachment_url', 'mime_type'];

    public function task()
    {
        return $this->belongsTo('App\MissionTask', 'TaskId');
    }

    public function mission()
    {
        return $this->belongsTo('App\Mission', 'MissionId');
    }

    public function getimageAttribute($value)
    {
        return asset($value);
    }
}
