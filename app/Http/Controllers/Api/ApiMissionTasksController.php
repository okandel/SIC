<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionTasks\MissionTasksRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionTasksController extends Controller
{
    protected $mission_task;

    public function __construct(MissionTasksRepositoryInterface $mission_task)
    {
        $this->mission_task = $mission_task;
    }

    public function get(Request $request)
    {
        $mission_task = $this->mission_task->get($request->id);
        return response()->json(['data' => $mission_task]);
    }

    public function list()
    {
        $mission_tasks = $this->mission_task->list();
        return response()->json(['data' => $mission_tasks]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MissionId' => 'required',
            'ServiceId' => 'required',
            'TypeId' => 'required',
            'service_payload' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $mission_task_array = [
            'MissionId' => $request->MissionId,
            'ServiceId' => $request->ServiceId,
            'TypeId' => $request->TypeId,
            'service_payload' => $request->service_payload
        ];
        $mission_task = $this->mission_task->create($mission_task_array);

        return response()->json(['data' => $mission_task]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'MissionId' => 'required',
            'ServiceId' => 'required',
            'TypeId' => 'required',
            'service_payload' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $mission_task_array = [
            'MissionId' => $request->MissionId,
            'ServiceId' => $request->ServiceId,
            'TypeId' => $request->TypeId,
            'service_payload' => $request->service_payload
        ];
        $mission_task = $this->mission_task->update($request->id ,$mission_task_array);

        return response()->json(['data' => $mission_task]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $mission_task = $this->mission_task->delete($request->id);
        return response()->json(['message' => 'Mission task deleted successfully', 'deleted_mission_task' => $mission_task]);
    }

}
