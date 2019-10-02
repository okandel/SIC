<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemTemplate extends Model
{
    use SoftDeletes;
    use \App\Traits\CurrentFirmScope; 
    use \App\Traits\CurrentFirmScopeWrite;

    protected $table = 'item_templates';

    protected $fillable = ['FirmId', 'display_name', 'description'];
    

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'FirmId');
    }

    public function customFields()
    {
        return $this->hasMany('App\ItemTemplateCustomField', 'ItemTemplateId');
    }

    public function items()
    {
        return $this->hasMany('App\Item', 'ItemTemplateId');
    }
}
