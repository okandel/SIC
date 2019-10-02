<?php

namespace App\Transformers;
use App\Transformers\ClientTransformer;
use App\Transformers\ClientRepTransformer;
use App\Transformers\CountryTransformer;
use App\Transformers\StateTransformer;
use App\Transformers\CityTransformer;

use Illuminate\Support\Arr;
use League\Fractal; 
use League\Fractal\ParamBag; 
class ClientBranchTransformer extends Fractal\TransformerAbstract
{ 
    protected $fields;
    
    protected $availableIncludes = [
        'client' ,'missions' ,'reps' ,'country' ,'state' ,'city' 
    ];
    public function __construct($fields=null){ 
        $this->fields = $fields;
    }

    public function transform($item)
    { 
        $res = [
            'id' => $item['id'],
            'display_name' => $item['display_name'],
            'contact_person' => $item['contact_person'],
            'email' => $item['email'],
            'phone' => $item['phone'],
            // 'countryId' => $item['CountryId'],
            // 'stateId' => $item['StateId'],
            // 'cityId' => $item['CityId'],
            'address' => $item['address'],
            'lat' => $item['lat'], //($item['location'])?$item['location']->getLat():"",
            'lng' => $item['lng'] //($item['location'])?$item['location']->getLng():"",
        ];
        if($this->fields!= null)
        { 
            return Arr::only($res,$this->fields);
        }
        return $res;
    }


    public function includeClient($item, ParamBag $params){ 
        $client = $item->client;
        $fields = $params->get('fields'); 

        return $this->item($client, new ClientTransformer($fields));
    }
    public function includeMissions($item, ParamBag $params){ 
        $missions = $item->missions;
        $fields = $params->get('fields'); 

    return $this->collection($missions, new MissionTransformer(/*$fields*/));
    }
    public function includeReps($item){ 
        $reps = $item->reps;
        return $this->collection($reps, new ClientRepTransformer());
    }
    public function includeCountry($item){ 
        $country = $item->country;
        return $this->item($country, new CountryTransformer());
    }
    public function includeState($item){ 
        $state = $item->state;
        return $this->item($state, new StateTransformer());
    }
    public function includeCity($item){ 
        $city = $item->city;
        return $this->item($city, new CityTransformer());
    }

    

}