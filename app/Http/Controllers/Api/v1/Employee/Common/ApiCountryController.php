<?php
 
 namespace App\Http\Controllers\Api\v1\Employee\Common;

 use Illuminate\Http\Request;
 use App\Http\Controllers\Api\v1\Employee\Common\BaseCommonController;
 use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
 use Illuminate\Support\Facades\Config; 
 use Illuminate\Support\Facades\Validator; 
 use DB; 
 use Fractal;
 use App\Mission;
 use App\Transformers\CountryTransformer;
 use App\Transformers\StateTransformer;
 use App\Transformers\CityTransformer;
 use App\Repositories\Country\CountryRepositoryInterface; 
 use App\Repositories\State\StateRepositoryInterface; 
 use App\Repositories\City\CityRepositoryInterface; 
 use App\Repositories\Missions\MissionsRepositoryInterface;
 
 class ApiCountryController extends BaseCommonController {
  
    protected $country;
    protected $state;
    protected $city; 

    public function __construct(CountryRepositoryInterface $country,
    StateRepositoryInterface $state,
    CityRepositoryInterface $city,
    MissionsRepositoryInterface $mission)
    {
        parent::__construct(); 
        $this->country = $country; 
        $this->state = $state; 
        $this->city = $city; 
        $this->mission = $mission;
    }
  
    
    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }

        $list = $this->country->with(['states','states.cities'])->list();

           
        $list = Fractal::collection($list)
        ->transformWith(new CountryTransformer())
        ->parseIncludes(['states','states.cities' ]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($list);  
    }

    public function state_list(Request $request)
    { 
        $validator = Validator::make($request->all(), [ 
            'country_id' => 'required',
        ]);

       if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $list = $this->state->with(['cities'])->list($request->country_id);

           
        $list = Fractal::collection($list)
        ->transformWith(new StateTransformer())
        ->parseIncludes(['cities' ]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($list);  
    }

    public function city_list(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'state_id' => 'required',
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $list = $this->city->with([])->list($request->state_id);

           
        $list = Fractal::collection($list)
        ->transformWith(new CityTransformer())
        ->parseIncludes([  ]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($list);  
    }


    public function nearest_city_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }

        $city_name = $request->city_name;
        $list =[];

        $last_assigned_mission_state = Mission::with("client_branch:id,StateId")
        ->whereHas('client_branch', function ($query) {
            $query->whereNotNull('StateId');
        })
        ->orderBy(DB::raw("abs(TIMESTAMPDIFF(HOUR,created_at, CURDATE()))"))->select('ClientBranchId')->first();

        if ($last_assigned_mission_state)
        {
            $state_id = $last_assigned_mission_state->client_branch->StateId;
            $list = $this->city->list($state_id,$city_name);    
        } 
          
        $list = Fractal::collection($list)
        ->transformWith(new CityTransformer())
        ->parseIncludes([  ]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($list);  
      
    }

}
