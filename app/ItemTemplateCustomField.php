<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTemplateCustomField extends Model
{

    protected $fillable = ['ItemTemplateId', 'display_name', 'type', 'options', 'default_value', 'is_required'];
    protected $table = 'item_template_custom_fields';

    public function template()
    {
        return $this->belongsTo('App\ItemTemplate');
    }
}
