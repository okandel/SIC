<?php

namespace App\Http\Controllers\Api;

use App\Repositories\EmployeeDevices\EmployeeDevicesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiEmployeeDevicesController extends Controller
{
    protected $device;

    public function __construct(EmployeeDevicesRepositoryInterface $device)
    {
        $this->device = $device;
    }

    public function get(Request $request)
    {
        $device = $this->device->get($request->id);
        return response()->json(['data' => $device]);
    }

    public function list()
    {
        $devices = $this->device->list();
        return response()->json(['data' => $devices]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EmpId' => 'required',
            'device_unique_id' => 'required',
//            'token' => 'required',
//            'firebase_token' => 'required',
            'is_logged_in' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $device_array = [
            'EmpId' => $request->EmpId,
            'device_unique_id' => $request->device_unique_id,
            'token' => $request->token,
            'firebase_token' => $request->firebase_token,
            'is_logged_in' => $request->is_logged_in,
        ];
        $device = $this->device->create($device_array);

        return response()->json(['data' => $device]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'EmpId' => 'required',
            'device_unique_id' => 'required',
//            'token' => 'required',
//            'firebase_token' => 'required',
            'is_logged_in' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $device_array = [
            'EmpId' => $request->EmpId,
            'device_unique_id' => $request->device_unique_id,
            'token' => $request->token,
            'firebase_token' => $request->firebase_token,
            'is_logged_in' => $request->is_logged_in,
        ];
        $device = $this->device->update($request->id ,$device_array);

        return response()->json(['data' => $device]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $device = $this->device->delete($request->id);
        return response()->json(['message' => 'device deleted successfully', 'deleted_device' => $device]);
    }

}
