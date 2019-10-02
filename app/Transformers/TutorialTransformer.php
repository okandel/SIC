<?php

namespace App\Transformers;

use League\Fractal; 

use App\Transformers\StateTransformer;
use App\Transformers\CityTransformer;

class TutorialTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [ 
    ];

    public function transform($item)
    {
        return [
            'title' => $item['title'],
            'content' => $item['content'],
            'image' => $item['image'] 
        ];
    }
    
     
}