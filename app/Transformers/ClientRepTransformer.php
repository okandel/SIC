<?php

namespace App\Transformers;
use App\Transformers\ClientTransformer; 
use App\Transformers\ClientBranchTransformer; 

use League\Fractal; 
class ClientRepTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [
        'client' ,'branches' 
    ];

    public function transform($item)
    {    
        return [
            'id' => $item['id'],
            'first_name' => $item['first_name'],
            'last_name' => $item['last_name'],
            'email' => $item['email'],
            'phone' => $item['phone'],
            'image' => $item['image'] ,
            
            'position' => $item['position'],
            'is_main_contact' => $item['is_main_contact'],
        ];
    }


    public function includeClient($item){ 
        $client = $item->client;
        return $this->item($client, new ClientTransformer());
    }
    public function includeBranches($item){ 
        $branches = $item->branches;
        return $this->collection($branches, new ClientBranchTransformer());
    }

}