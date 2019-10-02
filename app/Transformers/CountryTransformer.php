<?php

namespace App\Transformers;

use League\Fractal; 

use App\Transformers\StateTransformer;
use App\Transformers\CityTransformer;

class CountryTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [
        'states' 
    ];

    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'] 
        ];
    }
    
    public function includeStates($item){ 
        $states = $item->states;
        return $this->collection($states, new StateTransformer());
    }

}