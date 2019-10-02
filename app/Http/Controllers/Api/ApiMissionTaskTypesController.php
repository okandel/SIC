<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionTaskTypes\MissionTaskTypesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionTaskTypesController extends Controller
{
    protected $type;

    public function __construct(MissionTaskTypesRepositoryInterface $type)
    {
        $this->type = $type;
    }

    public function get(Request $request)
    {
        $type = $this->type->get($request->id);
        return response()->json(['data' => $type]);
    }

    public function list()
    {
        $types = $this->type->list();
        return response()->json(['data' => $types]);
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

        $type_array = [
            'FirmId' => $request->FirmId,
            'name' => $request->name,
            'order' => $request->order,
        ];
        $type = $this->type->create($type_array);

        return response()->json(['data' => $type]);
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

        $type_array = [
            'FirmId' => $request->FirmId,
            'name' => $request->name,
            'order' => $request->order,
        ];
        $type = $this->type->update($request->id ,$type_array);

        return response()->json(['data' => $type]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $type = $this->type->delete($request->id);
        return response()->json(['message' => 'Type deleted successfully', 'deleted_type' => $type]);
    }

}
