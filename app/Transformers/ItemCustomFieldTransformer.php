<?php

namespace App\Transformers;

use League\Fractal; 

use App\Transformers\ItemTransformer;

class ItemCustomFieldTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [
        'item' 
    ];

    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'display_name' => $item['display_name'],
            'type' => $item['type'],
            'options' => $item['options'],
            'default_value' => $item['default_value'],
            'is_required' => $item['is_required'],
        ];
    }
    
    public function includeItem($customFields){ 
        $item = $customFields->item;
        return $this->item($item, new ItemTransformer());
    }

}