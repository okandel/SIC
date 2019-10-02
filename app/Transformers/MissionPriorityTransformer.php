<?php

namespace App\Transformers; 

use League\Fractal; 
class MissionPriorityTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [ 
    ];

    public function transform($type)
    {
        return [
            'id' => $type['id'],
            'name' => $type['name'], 
        ];
    }  
}