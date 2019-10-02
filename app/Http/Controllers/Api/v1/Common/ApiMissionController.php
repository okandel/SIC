<?php
 
 namespace App\Http\Controllers\Api\v1\Common;

 use Illuminate\Http\Request;
 use App\Http\Controllers\Api\v1\Common\BaseCommonController;
 use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
 use Illuminate\Support\Facades\Config; 
 use Illuminate\Support\Facades\Validator; 
 use DB;
 use Fractal;
 use App\Transformers\MissionStatusTransformer; 
  
 use App\Repositories\MissionStatus\MissionStatusRepositoryInterface; 
 
 class ApiMissionController extends BaseCommonController {
   
    protected $status; 

    public function __construct(MissionStatusRepositoryInterface $status)
    {
        parent::__construct();  
        $this->status = $status; 
    }
    
    public function mission_status_list(Request $request)
    { 
        $validator = Validator::make($request->all(), [
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $list = $this->status->with([])->list();

           
        $list = Fractal::collection($list)
        ->transformWith(new MissionStatusTransformer())
        ->parseIncludes([]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($list);  
    }
    
}
