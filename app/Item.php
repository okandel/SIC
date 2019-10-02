<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;
    protected $fillable = ['FirmId', 'ItemTemplateId', 'name', 'description', 'image', 'item_payload'];
    use SoftDeletes;
    protected $table = 'items';

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'FirmId');
    }

    public function itemTemplate()
    {
        return $this->belongsTo('App\ItemTemplate', 'ItemTemplateId');
    }

    public function tasks()
    {
        return $this->hasMany('App\MissionTask', 'ItemId');
    }

    public function getimageAttribute($value)
    {
        if ($value) {
            return asset($value);
        }
        return asset("/uploads/defaults/client.png");
    }

}
