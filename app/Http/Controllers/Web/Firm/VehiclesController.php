<?php

namespace App\Http\Controllers\Web\Firm;

use App\Repositories\Vehicles\VehiclesRepositoryInterface;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class VehiclesController extends BaseFirmController
{
    protected $vehicleRep;

    //***********************************************************************************
    public function __construct(VehiclesRepositoryInterface $vehicleRep)
    {
        parent::__construct();
        $this->vehicleRep = $vehicleRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.vehicles.index');
    }

    //***********************************************************************************
    public function getVehicles(Request $request)
    {
        $type = $request->type;
        $brand = $request->brand;
        $year = $request->year;
        return datatables()->of($this->vehicleRep->list($type, $brand, $year))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $vehicle = new Vehicle();
        return view('firm.vehicles.create')->with(['vehicle' => $vehicle]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'type.required' => 'The type field is required!',
            'brand.required' => 'The brand field is required!',
            'year.required' => 'The year field is required!',
            'no_of_passengers.required' => 'The no of passengers field is required!',
            'body_type.required' => 'The body type field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'no_of_passengers' => 'required',
            'body_type' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $vehicle_array = [
            'type' => $request->type,
            'brand' => $request->brand,
            'year' => $request->year,
            'no_of_passengers' => $request->no_of_passengers,
            'body_type' => $request->body_type,
        ];

        $created_vehicle = $this->vehicleRep->create($vehicle_array);
        if ($created_vehicle) {
            session()->flash('success_message', 'Vehicle created successfully');
            return redirect('/firm/vehicles/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $vehicle = $this->vehicleRep->get($id);
        return view('firm.vehicles.edit')->with(['vehicle' => $vehicle]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'type.required' => 'The type field is required!',
            'brand.required' => 'The brand field is required!',
            'year.required' => 'The year field is required!',
            'no_of_passengers.required' => 'The no of passengers field is required!',
            'body_type.required' => 'The body type field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'no_of_passengers' => 'required',
            'body_type' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $vehicle_array = [
            'type' => $request->type,
            'brand' => $request->brand,
            'year' => $request->year,
            'no_of_passengers' => $request->no_of_passengers,
            'body_type' => $request->body_type,
        ];

        $updated_vehicle = $this->vehicleRep->update($id, $vehicle_array);
        if ($updated_vehicle) {
            session()->flash('success_message', 'Vehicle updated successfully');
            return redirect('/firm/vehicles/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_vehicle = $this->vehicleRep->delete($id);

        if ($deleted_vehicle) {
            session()->flash('success_message', 'Vehicle deleted successfully');
            return redirect('/firm/vehicles/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
