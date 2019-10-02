<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionStatus\MissionStatusRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionStatusController extends Controller
{
    protected $status;

    public function __construct(MissionStatusRepositoryInterface $status)
    {
        $this->status = $status;
    }

    public function get(Request $request)
    {
        $status = $this->status->get($request->id);
        return response()->json(['data' => $status]);
    }

    public function list()
    {
        $status = $this->status->list();
        return response()->json(['data' => $status]);
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

        $status_array = [
            'FirmId' => $request->FirmId,
            'name' => $request->name,
            'order' => $request->order,
        ];
        $status = $this->status->create($status_array);

        return response()->json(['data' => $status]);
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

        $status_array = [
            'FirmId' => $request->FirmId,
            'name' => $request->name,
            'order' => $request->order,
        ];
        $status = $this->status->update($request->id ,$status_array);

        return response()->json(['data' => $status]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $status = $this->status->delete($request->id);
        return response()->json(['message' => 'Status deleted successfully', 'deleted_status' => $status]);
    }

}
