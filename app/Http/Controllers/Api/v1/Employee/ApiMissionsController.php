<?php

namespace App\Http\Controllers\Api\v1\Employee;

use Carbon\Carbon;
use Fractal;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use App\Http\Controllers\Api\v1\Employee\BaseApiController;
use App\Repositories\Missions\MissionsRepositoryInterface;
use App\Repositories\MissionTasks\MissionTasksRepositoryInterface;
use App\Repositories\MissionOccurrences\MissionOccurrencesRepositoryInterface;
use App\Repositories\MissionOccurrenceReps\MissionOccurrenceRepRepositoryInterface;
use App\Repositories\MissionOccurrenceTasks\MissionOccurrenceTaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Transformers\MissionTransformer;
use App\Transformers\MissionTaskTransformer;

class ApiMissionsController extends BaseApiController
{
    protected $mission;

    public function __construct(MissionsRepositoryInterface $mission,
    MissionTasksRepositoryInterface $missionTask,
    MissionOccurrencesRepositoryInterface $missionOccurrence,
    MissionOccurrenceTaskRepositoryInterface $missionOccurrenceTask,
    MissionOccurrenceRepRepositoryInterface $missionOccurrenceRep)
    {
        parent::__construct(); 
        $this->mission = $mission;
        $this->missionTask = $missionTask;
        $this->missionOccurrence = $missionOccurrence;
        $this->missionOccurrenceRep = $missionOccurrenceRep;
        $this->missionOccurrenceTask = $missionOccurrenceTask;
    }

    public function get(Request $request)
    {   
         $validator = Validator::make($request->all(), [
            'id' => 'required', 
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $mission_occurance_id = $request->id;


        $mission = $this->mission->with(["status","tasks","tasks.item","tasks.type",
        "employee","assigned_by","priority","client_branch.client",
        'occurrence'=> function ($query) use ($mission_occurance_id) {
              $query->where('id', $mission_occurance_id); 
        }])
        ->getAll()->first(); 
        if (empty($mission))
        {
            return self::errify(400, ['errors' => ['mission.not_found' ]]);    
        }
        $mission = $mission->OccurrenceAsMissionObj()->first(); 
        
        $mission = Fractal::item($mission)
        ->transformWith(new MissionTransformer())
        ->parseIncludes(['status','tasks','tasks.item','tasks.type'
            ,'client:fields(id|image)'
            ,'client_branch.country','client_branch.state','client_branch.city'
            ,'client_branch.reps']) 
          //->withResourceName('data')
          ->toArray();
        
          return response()->json(['data' => $mission]); 
    }
    
    public function list(Request $request)
    {
        $employee_auth = Auth::user();
        $employee =$employee_auth;


        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $city_id = $request->city_id;
        
        $EmpId = $employee->id;
        $ClientBranchId = $request->client_branch_id;
        $ClientId = $request->client_id; 

        $missions = $this->mission->with([/*'status',*/"tasks","tasks.item","tasks.type",
            "employee","assigned_by","priority","client_branch.client"])
        ->listOccurance(
            [
                "EmpId" =>$EmpId,
                "ClientBranchId" =>$ClientBranchId,
                "ClientId" =>$ClientId, 
                
                "country_id" =>$country_id,
                "state_id" =>$state_id,
                "city_id" =>$city_id
            ]);

        $missions = Fractal::collection($missions)
        ->transformWith(new MissionTransformer())
        ->parseIncludes(['status','tasks.item','tasks.type'
            ,'client:fields(id|image)'
            ,'client_branch.country','client_branch.state','client_branch.city'
            ,'client_branch.reps']) 
        //->withResourceName('data')
        ->toArray();
        
        return response()->json(['data' => $missions]); 
    }
    //Today Missions
    public function list_today(Request $request)
    {
        $employee_auth = Auth::user();
        $employee =$employee_auth;


        $include_statistics = $request->include_statistics;
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $city_id = $request->city_id;
        
        $EmpId = ($employee)?$employee->id: $request->EmpId;
        $ClientBranchId = $request->client_branch_id;
        $ClientId = $request->client_id; 
        
        $nearestEmployees = $request->nearestEmployees;
        $nearestClientIds = $request->nearestClientIds;
        $nearestVehicleIds = $request->nearestVehicleIds;
 
        $missions = $this->mission->with([/*'status',*/"tasks","tasks.item","tasks.type",
        "employee","assigned_by","priority","client_branch.client"])
        ->listOccurance(
            [
                "EmpId" =>$EmpId,
                "ClientBranchId" =>$ClientBranchId,
                "ClientId" =>$ClientId, 
                
                "country_id" =>$country_id,
                "state_id" =>$state_id,
                "city_id" =>$city_id, 

                 "StatusId" => 2,
                 "from_date" => Carbon::today(),
                 "to_date" =>Carbon::today()->addDays(1)->addMillis(-1),
                
                "nearestEmployeeIds" =>$nearestEmployees,
                "nearestClientIds" =>$nearestClientIds,
                "nearestVehicleIds" =>$nearestVehicleIds,
            ]); 

        $statistics = null;
        if($include_statistics)
        {
            $total_tasks = $missions->count();
            $new_tasks = $missions
                ->filter(function ($value, $key)   {
                    return $value->StatusId != 3 &&  $value->StatusId != 5;
                })->count();
            $done_tasks = $missions->where('StatusId',3)->count();
            $Rearranged_tasks = $missions->where('StatusId',5)->count();

            $statistics= [
                "total_tasks"=>$total_tasks,
                "new_tasks"=>$new_tasks,
                "done_tasks"=>$done_tasks,
                "Rearranged_tasks"=>$Rearranged_tasks
            ];
        }


        $missions = Fractal::collection($missions)
        ->transformWith(new MissionTransformer())
        ->parseIncludes(['status','tasks.item','tasks.type'
            ,'client:fields(id|image)'
            ,'client_branch.country','client_branch.state','client_branch.city'
            ,'client_branch.reps']) 
        //->withResourceName('tasks')
        ->toArray();

        $force_order = \Settings::get("Force_Order",1);
        $res = ['missions' => $missions, 'force_order' => $force_order];
        if($include_statistics)
        { 
            $res['statistics'] = $statistics;
        }
        return response()->json(['data' => $res]);  
    }
   
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EmpId' => 'required',
            'AssignedByEmpId' => 'required',
            'PriorityId' => 'required',
            'ClientBranchId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'repeat_value' => 'required',
            'total_cycle' => 'required'
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $mission_array = [
            'EmpId' => $request->EmpId,
            'AssignedByEmpId' => $request->AssignedByEmpId,
            'PriorityId' => $request->PriorityId,
            'ClientBranchId' => $request->ClientBranchId,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'complete_date' => $request->complete_date,
            'recurring_type' => $request->recurring_type,
            'repeat_value' => $request->repeat_value,
            'total_cycle' => $request->total_cycle
        ];
        $mission = $this->mission->create($mission_array);

        return response()->json(['data' => $mission]);
    }
 

    //setActive
    public function setActive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required' 
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }

        $employee_auth = Auth::user();
        $employee =$employee_auth;
 
        $missionOccurrence = $this->missionOccurrence->setActive($request->id ,$employee ->id);

        return response()->json(['data' => 'ok']);
    }

      //setDone
      public function setDone(Request $request)
      {
        $validator = Validator::make($request->all(), [
            'mission_id' => 'required'
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $StatusId = 3; //Done
        $missionOccurrenceId = $request->mission_id;
        $mission_occurence_array = [ 
            'id' => $missionOccurrenceId ,
            'comment' => $request->comment,t,
            'StatusId' => $StatusId             
        ];
        $missionOccurrence = $this->missionOccurrence->update($missionOccurrenceId ,$mission_array);
 
        $missionId = $missionOccurrence->MissionId;
        //Mission tasks
        $mission_tasks = $request->tasks;
        if ($mission_tasks && is_array($mission_tasks))
        { 
            foreach ($mission_tasks as $key => $task) { 
 
                if($task["id"]==0)
                {
                    $mission_tasks_array = [
                        'MissionId' => $missionId,
                        'ItemId' => $task["item_id"],
                        'TypeId' => $task["type_id"]
                    ];
                    $missionTask =$this->missionTask->create($mission_tasks_array); 
                    $task["id"] = $missionTask->id;
                }    
 
                $mission_occurence_tasks_array = [ 
                    'MissionOccurenceId' => $missionOccurrenceId,
                    'TaskId' => $task["id"],
                    'StatusId' => $task["status_id"],
                ];
                $mission_reps =$this->missionOccurrenceTask->create($mission_occurence_tasks_array); 
            }
        }

        //Mission Reps
        $mission_reps = $request->mission_reps;
        if ($mission_reps && is_array($mission_reps))
        { 
            foreach ($mission_reps as $key => $rep) { 
                $mission_occurence_reps_array = [
                    'MissionOccurenceId' => $missionOccurrenceId,
                    'MissionId' => $request->mission_id,
                    'RepId' => $rep 
                ];
                $mission_reps =$this->missionOccurrenceRep->create($mission_occurence_reps_array); 
            }
        }

        return response()->json(['data' => 'ok']);
      }

      //setRearrange
      public function setRearrange(Request $request)
      {
        $validator = Validator::make($request->all(), [
            'mission_id' => 'required',
            'reason_id' => 'required'
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $StatusId = 5; //Rearrange
        $missionOccurrenceId = $request->mission_id; 
        $mission_occurence_array = [ 
            'id' => $missionOccurrenceId ,
            'comment' => $request->comment,
            'StatusId' => $StatusId ,
            'ReasonId' => $request->reason_id,  
            'scheduled_date' => $request->scheduled_date     
        ];
        $missionOccurrence = $this->missionOccurrence->update($missionOccurrenceId ,$mission_array);
 
        $missionId = $missionOccurrence->MissionId;
  
        return response()->json(['data' => 'ok']);
    }
      

}
