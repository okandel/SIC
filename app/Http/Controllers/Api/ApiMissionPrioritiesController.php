<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionPriorities\MissionPrioritiesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionPrioritiesController extends Controller
{
    protected $priority;

    public function __construct(MissionPrioritiesRepositoryInterface $priority)
    {
        $this->priority = $priority;
    }

    public function get(Request $request)
    {
        $priority = $this->priority->get($request->id);
        return response()->json(['data' => $priority]);
    }

    public function list()
    {
        $priorities = $this->priority->list();
        return response()->json(['data' => $priorities]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required',
            'name' => 'required',
            'order' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $priority_array = [
            'FirmId' => $request->FirmId,
            'name' => $request->name,
            'order' => $request->order,
        ];
        $priority = $this->priority->create($priority_array);

        return response()->json(['data' => $priority]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'FirmId' => 'required',
            'name' => 'required',
            'order' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $priority_array = [
            'FirmId' => $request->FirmId,
            'name' => $request->name,
            'order' => $request->order,
        ];
        $priority = $this->priority->update($request->id ,$priority_array);

        return response()->json(['data' => $priority]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $priority = $this->priority->delete($request->id);
        return response()->json(['message' => 'Priority deleted successfully', 'deleted_priority' => $priority]);
    }

}
