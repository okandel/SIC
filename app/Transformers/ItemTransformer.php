<?php

namespace App\Transformers;

use League\Fractal; 
use App\Helpers\CommonHelper;
use App\Transformers\ItemCustomFieldTransformer;

class ItemTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [
        //'customFields' 
    ];

    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'description' => $item['description'] ,
            'image' => $item['image'] ,
            //'pay_load_string' => $item['item_payload'],
            'pay_load' => CommonHelper::getPayLoadJson($item['ItemTemplateId'] ,$item['item_payload'])
        ];
    }
    
    // public function includeCustomFields($item){ 
    //     $customFields = $item->customFields;
    //     return $this->collection($customFields, new ItemCustomFieldTransformer());
    // }

}