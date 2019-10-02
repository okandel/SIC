<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\v1\Employee\BaseApiController;
use App\Repositories\ClientReps\ClientRepsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiClientRepsController extends BaseApiController
{
    protected $rep;

    public function __construct(ClientRepsRepositoryInterface $rep)
    {
        parent::__construct(); 
        $this->rep = $rep;
    }

    public function get(Request $request)
    {
        $rep = $this->rep->get($request->id);
        return response()->json(['data' => $rep]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ClientId' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $rep_array = [
            'ClientId' => $request->ClientId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified' => false,
            'phone_verified' => false,
        ];
        $rep = $this->rep->create($rep_array);

        return response()->json(['data' => $rep]);
    }

    public function list()
    {
        $reps = $this->rep->list();
        return response()->json(['data' => $reps]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'ClientId' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $rep_array = [
            'ClientId' => $request->ClientId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone
        ];
        $rep = $this->rep->update($request->id ,$rep_array);

        return response()->json(['data' => $rep]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $rep = $this->rep->delete($request->id);
        return response()->json(['message' => 'client rep deleted successfully', 'deleted_rep' => $rep]);
    }

    public function verify_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $rep_array = [
            'email_verified' => true,
        ];
        $rep = $this->rep->update($request->id ,$rep_array);

        return response()->json(['data' => $rep]);
    }

    public function verify_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $rep_array = [
            'phone_verified' => true,
        ];
        $rep = $this->rep->update($request->id ,$rep_array);

        return response()->json(['data' => $rep]);
    }


}
