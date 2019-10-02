<?php

namespace App\Http\Controllers\Api\v1\Employee;

use Fractal;
use App\Http\Controllers\Api\v1\Employee\BaseApiController;
use App\Repositories\ClientBranches\ClientBranchesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; 
use App\Transformers\ClientBranchTransformer; 

class ApiClientBranchesController extends BaseApiController
{
    protected $clientBranchRep;

    public function __construct(ClientBranchesRepositoryInterface $clientBranchRep)
    {
        parent::__construct(); 
        $this->clientBranchRep = $clientBranchRep;
    }

    public function get(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $clientBranch = $this->clientBranchRep->get($request->id);
        if (empty($clientBranch))
        {
            return self::errify(400, ['errors' => ['clientBranch.not_found' ]]);    
        }
        $clientBranch = Fractal::item($clientBranch)
        ->transformWith(new ClientBranchTransformer())
        ->parseIncludes(['reps','client']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clientBranch); 
    }
 

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required'
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }

            $client_id = $request->client_id;
      
        $clientBranchs = $this->clientBranchRep->with(['client','reps'])->list($client_id);
          
        $clientBranchs = Fractal::collection($clientBranchs)
        ->transformWith(new ClientBranchTransformer())
        //->parseIncludes(['reps','client']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clientBranchs); 
         
    }

  
 
}
