<?php

namespace App\Transformers;

use League\Fractal; 
 
use App\Transformers\CityTransformer;

class StateTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [
        'cities' 
    ];

    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'] 
        ];
    }
    
    public function includeCities($item){ 
        $cities = $item->cities;
        return $this->collection($cities, new CityTransformer());
    }

}