<?php

namespace App\Http\Controllers\Web\Firm;

use App\MissionRecurringException;
use App\Repositories\MissionRecurringExceptions\MissionRecurringExceptionsRepositoryInterface;
use App\Repositories\Missions\MissionsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class MissionRecurringExceptionsController extends BaseFirmController
{
    protected $exceptionRep;
    protected $missionRep;

    //***********************************************************************************
    public function __construct(MissionRecurringExceptionsRepositoryInterface $exceptionRep, MissionsRepositoryInterface $missionRep)
    {
        parent::__construct();
        $this->exceptionRep = $exceptionRep;
        $this->missionRep = $missionRep;
    }

    //***********************************************************************************
    public function index($MissionId=null)
    {
        $missions = $this->missionRep->list();
        return view('firm.missionRecurringExceptions.index')->with(['MissionId' => $MissionId, 'missions' => $missions]);
    }

    //***********************************************************************************
    public function getExceptions(Request $request)
    {
        $MissionId = $request->MissionId;
        $type = $request->exception_type;
        $MissionId_search = $request->MissionId_search;
        return datatables()->of($this->exceptionRep
            ->with('mission')
            ->list($MissionId, $type, $MissionId_search))->toJson();
    }

    //***********************************************************************************
    public function create($MissionId=null)
    {
        $exception = new MissionRecurringException();
        return view('firm.missionRecurringExceptions.create')->with(['exception' => $exception, 'MissionId' => $MissionId]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'exception_type.required' => 'The exception type field is required!',
            'date_exception_value.required' => 'The date exception value field is required!',
            'week_exception_value.required' => 'The week exception value field is required!',
            'month_exception_value.required' => 'The month exception value field is required!',
        ];

        if ($request->exception_type == '1') {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
                'date_exception_value' => 'required',
            ], $messages);
        } elseif ($request->exception_type == '2') {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
                'week_exception_value' => 'required',
            ], $messages);
        } elseif ($request->exception_type == '3') {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
                'month_exception_value' => 'required',
            ], $messages);
        } else {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
            ], $messages);
        }

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $exception_array = [
            'MissionId' => $request->MissionId,
            'exception_type' => $request->exception_type,
        ];

        if ($request->exception_type == '1') { //Date
            $exception_array['exception_value'] = $request->date_exception_value;
        } elseif ($request->exception_type == '2') { //Day of week
            $exception_array['exception_value'] = json_encode($request->week_exception_value);
        } elseif ($request->exception_type == '3') { //Day of month
            $exception_array['exception_value'] = json_encode($request->month_exception_value);
        }

        if ($request->MissionId) {
            $exception_array['MissionId'] = $request->MissionId;
        }

        $created_exception = $this->exceptionRep->create($exception_array);
        if ($created_exception) {
            session()->flash('success_message', 'Mission recurring exception created successfully');
            return redirect('/firm/mission-recurring-exceptions/index/'.$request->MissionId);
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id, $MissionId=null)
    {
        $exception = $this->exceptionRep->get($id);
        return view('firm.missionRecurringExceptions.edit')->with(['exception' => $exception, 'MissionId' => $MissionId]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'exception_type.required' => 'The exception type field is required!',
            'date_exception_value.required' => 'The date exception value field is required!',
            'week_exception_value.required' => 'The week exception value field is required!',
            'month_exception_value.required' => 'The month exception value field is required!',
        ];

        if ($request->exception_type == '1') {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
                'date_exception_value' => 'required',
            ], $messages);
        } elseif ($request->exception_type == '2') {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
                'week_exception_value' => 'required',
            ], $messages);
        } elseif ($request->exception_type == '3') {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
                'month_exception_value' => 'required',
            ], $messages);
        } else {
            $validator = Validator::make($request->all(), [
                'exception_type' => 'required',
            ], $messages);
        }

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $exception_array = [
            'MissionId' => $request->MissionId,
            'exception_type' => $request->exception_type,
        ];

        if ($request->exception_type == '1') { //Date
            $exception_array['exception_value'] = $request->date_exception_value;
        } elseif ($request->exception_type == '2') { //Day of week
            $exception_array['exception_value'] = json_encode($request->week_exception_value);
        } elseif ($request->exception_type == '3') { //Day of month
            $exception_array['exception_value'] = json_encode($request->month_exception_value);
        }

        if ($request->MissionId) {
            $exception_array['MissionId'] = $request->MissionId;
        }

        $updated_exception = $this->exceptionRep->update($id, $exception_array);
        if ($updated_exception) {
            session()->flash('success_message', 'Mission recurring exception updated successfully');
            return redirect('/firm/mission-recurring-exceptions/index'.'/'.$request->MissionId);
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_exception = $this->exceptionRep->delete($id);

        if ($deleted_exception) {
            session()->flash('success_message', 'Mission recurring exception deleted successfully');
            return redirect()->back();
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
