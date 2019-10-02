<?php

namespace App\Transformers;

use League\Fractal;  

class CityTransformer extends Fractal\TransformerAbstract
{ 
    
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'] 
        ];
    }
    
    

}