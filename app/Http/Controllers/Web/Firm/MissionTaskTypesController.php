<?php

namespace App\Http\Controllers\Web\Firm;

use App\MissionTaskType;
use App\Repositories\MissionTaskTypes\MissionTaskTypesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class MissionTaskTypesController extends BaseFirmController
{
    protected $typeRep;

    //***********************************************************************************
    public function __construct(MissionTaskTypesRepositoryInterface $typeRep)
    {
        parent::__construct();
        $this->typeRep = $typeRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.missionTaskTypes.index');
    }

    //***********************************************************************************
    public function getTypes(Request $request)
    {
        $name = $request->name;
        $order = $request->_order;
        return datatables()->of($this->typeRep->list($name, $order))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $type = new MissionTaskType();
        return view('firm.missionTaskTypes.create')->with(['type' => $type]);
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

        $type_array = [
            'name' => $request->name,
            'order' => $request->order,
        ];

        $created_type = $this->typeRep->create($type_array);
        if ($created_type) {
            session()->flash('success_message', 'Mission task type created successfully');
            return redirect('/firm/mission-task-types/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $type = $this->typeRep->get($id);
        return view('firm.missionTaskTypes.edit')->with(['type' => $type]);
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

        $type_array = [
            'name' => $request->name,
            'order' => $request->order,
        ];

        $updated_type = $this->typeRep->update($id, $type_array);
        if ($updated_type) {
            session()->flash('success_message', 'Mission task type updated successfully');
            return redirect('/firm/mission-task-types/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_type = $this->typeRep->delete($id);

        if ($deleted_type) {
            session()->flash('success_message', 'Mission type deleted successfully');
            return redirect('/firm/mission-task-types/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
