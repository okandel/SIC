<?php

namespace App\Transformers;

use League\Fractal; 
use League\Fractal\ParamBag; 

use App\Transformers\ClientBranchTransformer;
use Illuminate\Support\Arr;

class ClientTransformer extends Fractal\TransformerAbstract
{ 
    protected $fields;
    protected $missions;
    protected $availableIncludes = [
        'branches', 
        'reps',
        'missions',
        'statistics'
    ];
    public function __construct($fields=null){ 
        $this->fields = $fields;
    }
    public function transform($item)
    {
        $res = [
            'id' => $item['id'],
            'contact_person' => $item['contact_person'],
            'email' => $item['email'],
            'phone' => $item['phone'],
            'image' => $item['image'] ,
        ];
        if($this->fields!= null)
        { 
            return Arr::only($res,$this->fields);
        }
        return $res;
    }
    
    public function includeBranches($item, ParamBag $params){ 
        $branches = $item->branches;
        $fields = $params->get('fields'); 
        return $this->collection($branches, new ClientBranchTransformer($fields));
    }

    public function includeMissions($item){ 
        $this->getMissions($item);
        //$fields = $params->get('fields');   
        return  $this->collection($this->missions, new MissionTransformer(/*$fields*/));
    }
    public function includeStatistics($item){ 
        $statistics = $item->getStatistics(); 

        $total_tasks = $statistics["total_tasks"];
        $success_rate = $statistics["success_rate"]; 
        $statistics = [
            "total_tasks"=>$total_tasks,
            "success_rate"=> $success_rate,
        ]; 
 
        //$fields = $params->get('fields');   
        return  $this->item($statistics, new ClientStatisticTransformer(/*$fields*/));
    }

    private function getMissions($item){ 
        if ($this->missions==null)
        { 
            $missions = collect($item->branches->pluck('missions')->flatten())
            ->map(function($item) {  
                 return  $item->OccurrenceAsMissionObj();
            })->flatten();
            $this->missions = $missions;
        }
        return $this->missions;  
    }
}


class ClientStatisticTransformer extends Fractal\TransformerAbstract
{ 
    protected $fields; 
    protected $availableIncludes = [ 
    ];
    public function __construct($fields=null){ 
        $this->fields = $fields;
    }
    public function transform($item)
    {
        $res = [
            [
                'name'=>'Total Tasks',
                'value'=>$item["total_tasks"]
            ],
            [
                'name'=>'Success Rate',
                'value'=>$item["success_rate"]
            ]
        ];
        if($this->fields!= null)
        { 
            return Arr::only($res,$this->fields);
        }
        return $res;
    }
     
}