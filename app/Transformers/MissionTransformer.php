<?php

namespace App\Transformers;

use League\Fractal; 
use League\Fractal\ParamBag; 
use Carbon\Carbon;
use App\Transformers\MissionTaskTransformer;
use App\Transformers\ClientBranchTransformer;

class MissionTransformer extends Fractal\TransformerAbstract
{ 
    protected $availableIncludes = [
        'tasks' , 'client','client_branch','status'
    ];

    public function transform($item)
    {

        $res =  [
            'id' => $item['id'],
            'emp_id' => $item['EmpId'],
            'assignedBy' => $item['AssignedByEmpId'],
            'PriorityId' => $item['PriorityId'],
            'ClientBranchId' => $item['ClientBranchId'],
            'title' => $item['title'],
            'description' => $item['description'],
            'start_date' => null,
            'complete_date' => null, 
            //'StatusId' => $item['StatusId']
            'is_active' => $item['is_currently_active']
            //'status' => $item['status'],
        ];
        if ($item['start_date'])
        {
            $res['start_date'] =  Carbon::parse($item['start_date'])->timestamp;
        }
        if ($item['complete_date'])
        {
            $res['complete_date'] =  Carbon::parse($item['complete_date'])->timestamp;
        }
        if ($item['tasks'])
        {
            $res['tasks_count'] =  count($item['tasks']);
        }
 
 
        return $res; 
    }
    
    public function includeTasks($item){ 
        $tasks = $item->tasks;
        return $this->collection($tasks, new MissionTaskTransformer());
    }
    public function includeClient($item, ParamBag $params){ 
        if($item->client_branch && $item->client_branch->client)
        {
            $client = $item->client_branch->client;
            $fields = $params->get('fields'); 
    
            return $this->item($client, new ClientTransformer($fields));
        }
      
    }

    public function includeClientBranch($item){ 
        $client_branch = $item->client_branch;
        return $this->item($client_branch, new ClientBranchTransformer());
    }
    public function includeStatus($item){ 
        // $status = null;
        // if ($item->StatusId==1)
        // {
        //     $status = ["id"=>1,"name"=>"New"];
        // }else if ($item->StatusId==2)
        // {
        //     $status = ["id"=>2,"name"=>"Pending"]; 
        // }else if ($item->StatusId==3)
        // {
        //     $status = ["id"=>3,"name"=>"Completed"]; 
        // }else if ($item->StatusId==4)
        // {
        //     $status = ["id"=>4,"name"=>"Cancelled"];  
        // }else if ($item->StatusId==5)
        // {
        //     $status = ["id"=>5,"name"=>"Re-arranged"];  
        // } 
        $status = $item->status;
        return $this->item($status, new MissionStatusTransformer());
    }

}