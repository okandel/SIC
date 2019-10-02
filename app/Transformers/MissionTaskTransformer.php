<?php

namespace App\Transformers;
use App\Transformers\MissionTransformer;
use App\Transformers\MissionTaskTypeTransformer;
use App\Transformers\ItemTransformer;

use League\Fractal; 
class MissionTaskTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [
        'item' ,'type'
    ];

    public function transform($item)
    { 
        return [
            'id' => $item['id'],
            'MissionId' => $item['MissionId'],
            'ItemId' => $item['ItemId'],
            'TypeId' => $item['TypeId'],
            'quantity' => $item['quantity']??0,
            //'item_payload' => $item['item_payload'], 
        ];
    }


    public function includeItem($task){ 
        $item = $task->item;
        return $this->item($item, new ItemTransformer());
    }
    public function includeType($task){ 
        $type = $task->type;
        return $this->item($type, new MissionTaskTypeTransformer());
    }

}