<?php

namespace App\Http\Controllers\Web\Firm;

use App\MissionPriority;
use App\Repositories\MissionPriorities\MissionPrioritiesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class MissionPrioritiesController extends BaseFirmController
{
    protected $priorityRep;

    //***********************************************************************************
    public function __construct(MissionPrioritiesRepositoryInterface $priorityRep)
    {
        parent::__construct();
        $this->priorityRep = $priorityRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.missionPriorities.index');
    }

    //***********************************************************************************
    public function getPriorities(Request $request)
    {
        $name = $request->name;
        $order = $request->_order;
        return datatables()->of($this->priorityRep->list($name, $order))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $priority = new MissionPriority();
        return view('firm.missionPriorities.create')->with(['priority' => $priority]);
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

        $priority_array = [
            'name' => $request->name,
            'order' => $request->order,
        ];

        $created_priority = $this->priorityRep->create($priority_array);
        if ($created_priority) {
            session()->flash('success_message', 'Mission priority created successfully');
            return redirect('/firm/mission-priorities/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $priority = $this->priorityRep->get($id);
        return view('firm.missionPriorities.edit')->with(['priority' => $priority]);
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

        $priority_array = [
            'name' => $request->name,
            'order' => $request->order,
        ];

        $updated_priority = $this->priorityRep->update($id, $priority_array);
        if ($updated_priority) {
            session()->flash('success_message', 'Mission priority updated successfully');
            return redirect('/firm/mission-priorities/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_priority = $this->priorityRep->delete($id);

        if ($deleted_priority) {
            session()->flash('success_message', 'Mission priority deleted successfully');
            return redirect('/firm/mission-priorities/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }
}
