<?php

namespace App\Transformers;

use League\Fractal; 

use App\Transformers\ClientBranchTransformer;

class EmployeesTransformer extends Fractal\TransformerAbstract
{  
    protected $missions;
    protected $availableIncludes = [ 
        'statistics'
    ];
    public function transform($item)
    {
        $res =  [
            'first_name' => $item['first_name'],
            'last_name' => $item['last_name'],
            'email' => $item['email'],
            'phone' => $item['phone'],
            'current_location' => $item['current_location'],
            'alt' => $item['alt'],
            'speed' => $item['speed'],
            'bearing_heading' => $item['bearing_heading'],
            'image' => $item['image'],
            'hash' => $item['hash']??"" ,
            'duty_status' => $item['duty_status']??0 
        ];

        if ($item['token'])
        {
            $res['token'] =  $item['token'];
        }
        return $res;
    }

    public function includeStatistics($item){ 
        
        $statistics = $item->getStatistics(); 

        $total_tasks = $statistics["total_tasks"];
        $success_rate = $statistics["success_rate"]; 
        $statistics = [
            "total_tasks"=>$total_tasks,
            "success_rate"=> $success_rate,
        ]; 
        return  $this->item($statistics, new EmployeeStatisticTransformer(/*$fields*/));
    }
 
}


class EmployeeStatisticTransformer extends Fractal\TransformerAbstract
{
    protected $fields;
    protected $availableIncludes = [
    ];

    public function __construct($fields = null)
    {
        $this->fields = $fields;
    }

    public function transform($item)
    {
        $res = [
            [
                'name' => 'Total Tasks',
                'value' => $item["total_tasks"]
            ],
            [
                'name' => 'Success Rate',
                'value' => $item["success_rate"]
            ]
        ];
        if ($this->fields != null) {
            return Arr::only($res, $this->fields);
        }
        return $res;
    }

}