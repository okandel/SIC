<?php

namespace App\Http\Controllers\Api\v1\Employee;

use Fractal;
use App\Http\Controllers\Api\v1\Employee\BaseApiController;
use App\Repositories\ClientReps\ClientRepsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; 
use App\Transformers\ClientRepTransformer; 

class ApiClientRepsController extends BaseApiController
{
    protected $clientRep;

    public function __construct(ClientRepsRepositoryInterface $clientRep)
    {
        parent::__construct(); 
        $this->clientRep = $clientRep;
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $clientRep = $this->clientRep->get($request->id);
        if (empty($clientRep))
        {
            return self::errify(400, ['errors' => ['clientRep.not_found' ]]);    
        }
        $clientReps = Fractal::item($clientRep)
        ->transformWith(new ClientRepTransformer())
        ->parseIncludes(['branches','client']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clientReps); 
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
      
        $clientReps = $this->clientRep->with(['client','branches'])->list($client_id);
     
        $clientReps = Fractal::collection($clientReps)
        ->transformWith(new ClientRepTransformer())
        //->parseIncludes(['branches','client']) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($clientReps); 
         
    }

  
 
}
