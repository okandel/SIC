<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Plans\PlansRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiPlansController extends Controller
{
    protected $plan;

    public function __construct(PlansRepositoryInterface $plan)
    {
        $this->plan = $plan;
    }

    public function get(Request $request)
    {
        $plan = $this->plan->get($request->id);
        return response()->json(['data' => $plan]);
    }

    public function list()
    {
        $plans = $this->plan->list();
        return response()->json(['data' => $plans]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $plan_array = [
            'name' => $request->name,
        ];
        $plan = $this->plan->create($plan_array);

        return response()->json(['data' => $plan]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $plan_array = [
            'name' => $request->name
        ];
        $plan = $this->plan->update($request->id ,$plan_array);

        return response()->json(['data' => $plan]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $plan = $this->plan->delete($request->id);
        return response()->json(['message' => 'Plan deleted successfully', 'deleted_plan' => $plan]);
    }

}
