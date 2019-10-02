<?php
 
 namespace App\Http\Controllers\Api\v1\Common;

 use Illuminate\Http\Request;
 use App\Http\Controllers\Api\v1\Common\BaseCommonController;
 use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
 use Illuminate\Support\Facades\Config; 
 use Illuminate\Support\Facades\Validator; 
 use DB;
 use Fractal;
 use App\Transformers\MissionTaskTypeTransformer;
 use App\Transformers\MissionPriorityTransformer;
 
 use App\Repositories\MissionTaskTypes\MissionTaskTypesRepositoryInterface;
 use App\Repositories\MissionPriorities\MissionPrioritiesRepositoryInterface; 
 
 class ApiTaskController extends BaseCommonController {
  
    protected $type; 
    protected $priority; 

    public function __construct(MissionTaskTypesRepositoryInterface $type,MissionPrioritiesRepositoryInterface $priority)
    {
        parent::__construct(); 
        $this->type = $type;  
        $this->priority = $priority; 
    }
  
    
    public function task_type_list(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $list = $this->type->with([])->list();

           
        $list = Fractal::collection($list)
        ->transformWith(new MissionTaskTypeTransformer())
        ->parseIncludes(['']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($list);  
    }

    public function mission_priority_list(Request $request)
    { 
        $validator = Validator::make($request->all(), [
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $list = $this->priority->with([])->list();

           
        $list = Fractal::collection($list)
        ->transformWith(new MissionPriorityTransformer())
        ->parseIncludes([]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($list);  
    }
    
}
