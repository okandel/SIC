<?php
 
 namespace App\Http\Controllers\Api\v1\Common;

 use Illuminate\Http\Request;
 use App\Http\Controllers\Api\v1\Common\BaseCommonController;
 use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
 use Illuminate\Support\Facades\Config; 
 use Illuminate\Support\Facades\Validator; 
 use DB;
 use Fractal;
 use App\Transformers\CountryTransformer;
 use App\Transformers\StateTransformer;
 use App\Transformers\CityTransformer;
 use App\Repositories\Country\CountryRepositoryInterface; 
 use App\Repositories\State\StateRepositoryInterface; 
 use App\Repositories\City\CityRepositoryInterface; 
 
 class ApiCountryController extends BaseCommonController {
  
    protected $country;
    protected $state;
    protected $city; 

    public function __construct(CountryRepositoryInterface $country,
    StateRepositoryInterface $state,
    CityRepositoryInterface $city)
    {
        parent::__construct(); 
        $this->country = $country; 
        $this->state = $state; 
        $this->city = $city; 
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

}
