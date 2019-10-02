<?php

namespace App\Http\Controllers\Web\Firm;

use App\MissionStatus;
use App\Repositories\MissionStatus\MissionStatusRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class MissionStatusController extends BaseFirmController
{
    protected $statusRep;

    //***********************************************************************************
    public function __construct(MissionStatusRepositoryInterface $statusRep)
    {
        parent::__construct();
        $this->statusRep = $statusRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.missionStatus.index');
    }

    //***********************************************************************************
    public function getStatus(Request $request)
    {
        $name = $request->name;
        $order = $request->_order;
        return datatables()->of($this->statusRep->list($name, $order))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $status = new MissionStatus();
        return view('firm.missionStatus.create')->with(['status' => $status]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'The name field is required!',
            'order.required' => 'The display order field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'order' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $status_array = [
            'name' => $request->name,
            'order' => $request->order,
        ];

        $created_status = $this->statusRep->create($status_array);
        if ($created_status) {
            session()->flash('success_message', 'Mission status created successfully');
            return redirect('/firm/mission-status/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $status = $this->statusRep->get($id);
        return view('firm.missionStatus.edit')->with(['status' => $status]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'name.required' => 'The name field is required!',
            'order.required' => 'The display order field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'order' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $status_array = [
            'name' => $request->name,
            'order' => $request->order,
        ];

        $updated_status = $this->statusRep->update($id, $status_array);
        if ($updated_status) {
            session()->flash('success_message', 'Mission status updated successfully');
            return redirect('/firm/mission-status/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_status = $this->statusRep->delete($id);

        if ($deleted_status) {
            session()->flash('success_message', 'Mission status deleted successfully');
            return redirect('/firm/mission-status/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
