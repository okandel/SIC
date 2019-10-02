<?php

namespace App\Http\Controllers\Api\v1\Employee;

use Fractal;
use App\Http\Controllers\Api\v1\Employee\BaseApiController;
use App\Repositories\Clients\ClientsRepositoryInterface;
use App\Repositories\ClientBranches\ClientBranchesRepositoryInterface;

use App\Repositories\IncidentMissions\IncidentMissionsRepositoryInterface;
use App\Repositories\IncidentMissionTasks\IncidentMissionTasksRepositoryInterface;

use App\Repositories\City\CityRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; 
use App\Transformers\ClientTransformer;
use App\Transformers\ClientBranchTransformer;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;

use Carbon\Carbon;
class ApiChatController extends BaseApiController
{
    protected $client;
    protected $clientBranch;
    protected $city;
    protected $incidentMission;
    protected $incidentMissionTask;

    public function __construct(ClientsRepositoryInterface $client,
                ClientBranchesRepositoryInterface $clientBranch,
                CityRepositoryInterface $city,
                IncidentMissionsRepositoryInterface $incidentMission,
                IncidentMissionTasksRepositoryInterface $incidentMissionTask                
                )
    {
        parent::__construct(); 
        $this->client = $client;
        $this->clientBranch = $clientBranch;
        $this->city = $city;
        $this->incidentMission = $incidentMission;
        $this->incidentMissionTask = $incidentMissionTask;
    }
 
    public function client_list(Request $request)
    { 
        //Filters 
        $client_id = $request->client_id;


        $employee_auth = Auth::user();
        $employee_id = $employee_auth->id;


        $clients = $this->client
        ->with(['branches'=> function($query) use($employee_id)
        {
           return $query->whereHas('missions', function($query) use($employee_id)
           {
                $from_date =Carbon::today();
                $to_date =Carbon::today()->addDays(1)->addMillis(-1);
            
              return $query->where('EmpId', $employee_id)
              ->where('start_date', '>=', $from_date)
              ->where('start_date', '<=', $to_date)
              ->whereNotIn('StatusId', [3,5]);
           })->whereHas('reps');
        },'branches.reps'])
        ->list(["client_id" => $client_id])
        ->filter(function ($value, $key) { 
            return ($value->branches->count() >0 );
        }); 
          
        $clients = Fractal::collection($clients)
        ->transformWith(new ClientTransformer(['id','contact_person','email','image']))
        ->parseIncludes([
            'branches:fields(id|display_name|email)', // Not working
            'branches.reps']) 
        //->withResourceName('data')
        ->toArray();
        
        return response()->json(["data" => $clients]);
         
    }
    
 
 
}
