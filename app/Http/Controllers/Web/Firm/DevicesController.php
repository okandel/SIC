<?php

namespace App\Http\Controllers\Web\Firm;

use App\Repositories\Devices\DevicesRepositoryInterface;
use App\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class DevicesController extends BaseFirmController
{
    protected $deviceRep;

    public function __construct(DevicesRepositoryInterface $deviceRep)
    {
        parent::__construct();
        $this->deviceRep = $deviceRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.devices.index');
    }

    //***********************************************************************************
    public function getDevices(Request $request)
    {
        $type = $request->type;
        $display_name = $request->display_name;
        $year = $request->year;
        return datatables()->of($this->deviceRep->list($type, $display_name, $year))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $device = new Device();
        return view('firm.devices.create')->with(['device' => $device]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'os_type.required' => 'The Operations System Type field is required!',
            'display_name.required' => 'The display name field is required!',
            'device_unique_id.required' => 'The device unique id field is required!'
        ];
        $validator = Validator::make($request->all(), [
            'os_type' => 'required',
            'display_name' => 'required',
            'device_unique_id' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $device_array = [
            'os_type' => $request->os_type,
            'display_name' => $request->display_name,
            'device_unique_id' => $request->device_unique_id,
        ];

        $created_device = $this->deviceRep->create($device_array);
        if ($created_device) {
            session()->flash('success_message', 'Device created successfully');
            return redirect('/firm/devices/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $device = $this->deviceRep->get($id);
        return view('firm.devices.edit')->with(['device' => $device]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'os_type.required' => 'The Operations System Type field is required!',
            'display_name.required' => 'The display name field is required!',
            'device_unique_id.required' => 'The device unique id field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'os_type' => 'required',
            'display_name' => 'required',
            'device_unique_id' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $device_array = [
            'os_type' => $request->os_type,
            'display_name' => $request->display_name,
            'device_unique_id' => $request->device_unique_id,
        ];

        $updated_device = $this->deviceRep->update($id, $device_array);
        if ($updated_device) {
            session()->flash('success_message', 'Device updated successfully');
            return redirect('/firm/devices/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_device = $this->deviceRep->delete($id);

        if ($deleted_device) {
            session()->flash('success_message', 'Device deleted successfully');
            return redirect('/firm/devices/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
