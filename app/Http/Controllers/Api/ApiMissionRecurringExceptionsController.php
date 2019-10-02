<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionRecurringExceptions\MissionRecurringExceptionsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionRecurringExceptionsController extends Controller
{
    protected $exception;

    public function __construct(MissionRecurringExceptionsRepositoryInterface $exception)
    {
        $this->exception = $exception;
    }

    public function get(Request $request)
    {
        $exception = $this->exception->get($request->id);
        return response()->json(['data' => $exception]);
    }

    public function list()
    {
        $exceptions = $this->exception->list();
        return response()->json(['data' => $exceptions]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required',
            'MissionId' => 'required',
            'exception_type' => 'required',
            'exception_value' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $exception_array = [
            'FirmId' => $request->FirmId,
            'MissionId' => $request->MissionId,
            'exception_type' => $request->exception_type,
            'exception_value' => $request->exception_value,
        ];
        $exception = $this->exception->create($exception_array);

        return response()->json(['data' => $exception]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'FirmId' => 'required',
            'MissionId' => 'required',
            'exception_type' => 'required',
            'exception_value' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $exception_array = [
            'FirmId' => $request->FirmId,
            'MissionId' => $request->MissionId,
            'exception_type' => $request->exception_type,
            'exception_value' => $request->exception_value,        ];
        $exception = $this->exception->update($request->id ,$exception_array);

        return response()->json(['data' => $exception]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $exception = $this->exception->delete($request->id);
        return response()->json(['message' => 'Exception deleted successfully', 'deleted_exception' => $exception]);
    }

}
