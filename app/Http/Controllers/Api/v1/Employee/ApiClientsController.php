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
use App\Mission;


use Carbon\Carbon;
class ApiClientsController extends BaseApiController
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

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
 
        $client = $this->client->with([
            'branches.missions','missions.occurrence'])->get($request->id);
        if (empty($client))
        {
            return self::errify(400, ['errors' => ['client.not_found' ]]);    
        }
        
        $clients = Fractal::item($client)
        ->transformWith(new ClientTransformer())
        ->parseIncludes(['statistics','branches','branches.reps','missions',
              "missions.status","missions.tasks","missions.tasks.item","missions.tasks.type",
            // "missions.employee","missions.assigned_by","missions.priority","missions.occurrence" 
            ]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clients); 
    }
 

    public function list(Request $request)
    {
        $item_id = $request->item_id;

        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $city_id = $request->city_id;

        $clients = $this->client->with([
            'branches.reps',
            'branches'=> function ($query) use ($country_id,$state_id,$city_id) {
                return $query
                ->when($country_id, function ($query, $country_id) {
                    return $query->where('CountryId', $country_id);
                }) 
                ->when($state_id, function ($query, $state_id) {
                    return $query->where('StateId', $state_id);
                }) 
                ->when($city_id, function ($query, $city_id) {
                    return $query->where('CityId', $city_id);
                }); 
            },
            'reps'])->list(
            [
                "item_id" =>$request->item_id,
                "country_id" =>$request->country_id,
                "state_id" =>$request->state_id,
                "city_id" =>$request->city_id,
                
                "contact_person" =>$request->contact_person,
                "email" =>$request->email,
                "phone" =>$request->phone,
            ]
        );
          
        $clients = Fractal::collection($clients)
        ->transformWith(new ClientTransformer())
        ->parseIncludes(['branches','branches.reps']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clients);
         
    }
    public function nearest(Request $request)
    {
        $country_id = $request->country_id;
        $state_id = $request->state_id;
        $city_id = $request->city_id;

        $clients = $this->client->with([
            'branches.reps',
            'branches'=> function ($query) use ($country_id,$state_id,$city_id) {
                return $query
                ->when($country_id, function ($query, $country_id) {
                    return $query->where('CountryId', $country_id);
                }) 
                ->when($state_id, function ($query, $state_id) {
                    return $query->where('StateId', $state_id);
                }) 
                ->when($city_id, function ($query, $city_id) {
                    return $query->where('CityId', $city_id);
                }); 
            },
            'reps'])->list(
            [
                "country_id" =>$request->country_id,
                "state_id" =>$request->state_id,
                "city_id" =>$request->city_id
            ]
        );
          
        $clients = Fractal::collection($clients)
        ->transformWith(new ClientTransformer())
        ->parseIncludes(['branches','branches.reps']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clients);
         
    }

    public function create(Request $request)
    { 
        $employee_auth = Auth::user();
        $employee =$employee_auth; 

        $validator = Validator::make($request->all(), [ 
            'contact_person' => 'required',
            //'email' => 'required',
            'phone' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'city_id' => 'required',
        ]); 

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $client_array = [ 
            'contact_person' => $request->contact_person,
            //'email' => $request->email,
            'phone' => $request->phone,
            'IsApproved' => 0,
        ];
        $client = $this->client->create($client_array);

        if ($client)
        { 
            $city = $this->city->get($request->city_id,false);
            if ($city)
            { 
                $clientBranch_array = [
                    'ClientId' => $client->id,
                    'display_name' => $city->name,
                    'contact_person' => $request->contact_person,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => '',
                    'CountryId' => $city->country_id,
                    'StateId' => $city->state_id,
                    'CityId' => $city->id,
                    'location' => new Point($request->lat, $request->lng)
                ];
                $clientBranch =$this->clientBranch->create($clientBranch_array); 

               
                $taskItems = $request->items;
                if ($taskItems && is_array($taskItems))
                {
                    $incidentMission_array = [
                        'EmpId' => $employee->id,
                        'ClientBranchId' => $clientBranch->id,
                        'title' => 'Incident Mission' ,
                        'created_at' => Carbon::now()
                    ];
                    $incidentMission =$this->incidentMission->create($incidentMission_array); 

                    foreach ($taskItems as $key => $taskItem) { 
                        $incidentMissionTasks_array = [
                            'IncidentMissionId' => $incidentMission->id,
                            'ItemId' => $taskItem["item_id"],
                            'TypeId' => $taskItem["type_id"] 
                        ];
                        $incidentMissionTask =$this->incidentMissionTask->create($incidentMissionTasks_array); 
                    }
                }
            }else{ 
                return self::errify(400, ['errors' => ['city.not_found' ]]); 
            }
        }else
        {
            return self::errify(400, ['errors' => ['can\'nt create client, please try again' ]]); 
        }

        $clients = Fractal::item($client)
        ->transformWith(new ClientTransformer())
        ->parseIncludes(['branches','branches.reps']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clients); 
    }
 
}
