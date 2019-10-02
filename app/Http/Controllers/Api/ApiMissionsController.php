<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Missions\MissionsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionsController extends Controller
{
    protected $mission;

    public function __construct(MissionsRepositoryInterface $mission)
    {
        $this->mission = $mission;
    }

    public function get(Request $request)
    {
        $mission = $this->mission->get($request->id);
        return response()->json(['data' => $mission]);
    }

    public function list(Request $request)
    {
        $missions = $this->mission->list($request->EmpId, $request->ClientBranchId, $request->ClientId);
        return response()->json(['data' => $missions]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EmpId' => 'required',
            'AssignedByEmpId' => 'required',
            'PriorityId' => 'required',
            'ClientBranchId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'repeat_value' => 'required',
            'total_cycle' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $mission_array = [
            'EmpId' => $request->EmpId,
            'AssignedByEmpId' => $request->AssignedByEmpId,
            'PriorityId' => $request->PriorityId,
            'ClientBranchId' => $request->ClientBranchId,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'complete_date' => $request->complete_date,
            'recurring_type' => $request->recurring_type,
            'repeat_value' => $request->repeat_value,
            'total_cycle' => $request->total_cycle
        ];
        $mission = $this->mission->create($mission_array);

        return response()->json(['data' => $mission]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EmpId' => 'required',
            'AssignedByEmpId' => 'required',
            'PriorityId' => 'required',
            'ClientBranchId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'repeat_value' => 'required',
            'total_cycle' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $mission_array = [
            'EmpId' => $request->EmpId,
            'AssignedByEmpId' => $request->AssignedByEmpId,
            'PriorityId' => $request->PriorityId,
            'ClientBranchId' => $request->ClientBranchId,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'complete_date' => $request->complete_date,
            'recurring_type' => $request->recurring_type,
            'repeat_value' => $request->repeat_value,
            'total_cycle' => $request->total_cycle
        ];
        $mission = $this->mission->update($request->id ,$mission_array);

        return response()->json(['data' => $mission]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $mission = $this->mission->delete($request->id);
        return response()->json(['message' => 'Mission deleted successfully', 'deleted_mission' => $mission]);
    }

}
