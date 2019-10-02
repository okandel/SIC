<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Vehicles\VehiclesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiVehiclesController extends Controller
{
    protected $vehicle;

    public function __construct(VehiclesRepositoryInterface $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function get(Request $request)
    {
        $vehicle = $this->vehicle->get($request->id);
        return response()->json(['data' => $vehicle]);
    }

    public function list()
    {
        $vehicles = $this->vehicle->list();
        return response()->json(['data' => $vehicles]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'no_of_passengers' => 'required',
            'body_type' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $vehicle_array = [
            'FirmId' => $request->FirmId,
            'type' => $request->type,
            'brand' => $request->brand,
            'year' => $request->year,
            'no_of_passengers' => $request->no_of_passengers,
            'body_type' => $request->body_type,
        ];
        $vehicle = $this->vehicle->create($vehicle_array);

        return response()->json(['data' => $vehicle]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'FirmId' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'no_of_passengers' => 'required',
            'body_type' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $vehicle_array = [
            'FirmId' => $request->FirmId,
            'type' => $request->type,
            'brand' => $request->brand,
            'year' => $request->year,
            'no_of_passengers' => $request->no_of_passengers,
            'body_type' => $request->body_type,
        ];
        $vehicle = $this->vehicle->update($request->id ,$vehicle_array);

        return response()->json(['data' => $vehicle]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $vehicle = $this->vehicle->delete($request->id);
        return response()->json(['message' => 'vehicle deleted successfully', 'deleted_vehicle' => $vehicle]);
    }

}
