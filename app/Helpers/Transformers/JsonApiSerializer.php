<?php

/*  
    [TBD]

    This serializer is mainly for fixing crashing when including properties in the original JsonApiSerializer 
    for Laravel-Fractal version 1.5.0. We had to use an old dependency of Fractal dependency 
    as datatables-oracle are already using this.

    Once we upgrade, this can be removed.

*/

namespace App\Helpers\Transformers;

use League\Fractal\Serializer\JsonApiSerializer as FractalJsonApiSerializer;
use League\Fractal\Resource\ResourceInterface;

class JsonApiSerializer extends FractalJsonApiSerializer
{

	public function collection($resourceKey, array $data)
    {
        return $this->item($resourceKey, $data);
    }

    public function item($resourceKey, array $data)
    {

        if(array_key_exists('data', $data)){
            
            $data = $data['data'];

        }else if($resourceKey){
            
            $data = [$resourceKey => $data];

        }

        return $data;
    }

    public function sideloadIncludes()
    {
        return false;
    }
}