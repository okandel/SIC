<?php

namespace App\Http\Controllers\Web\Firm;

use App\Client;
use App\ClientBranch;
use App\Employee;
use App\Mission;
use App\MissionPriority;
use App\Repositories\ClientBranches\ClientBranchesRepositoryInterface;
use App\Repositories\Clients\ClientsRepositoryInterface;
use App\Repositories\Employees\EmployeesRepositoryInterface;
use App\Repositories\Items\ItemsRepositoryInterface;
use App\Repositories\MissionOccurrences\MissionOccurrencesRepositoryInterface;
use App\Repositories\MissionPriorities\MissionPrioritiesRepositoryInterface;
use App\Repositories\Missions\MissionsRepositoryInterface;
use App\Repositories\MissionStatus\MissionStatusRepositoryInterface;
use App\Repositories\MissionTaskAttachments\MissionTaskAttachmentsRepositoryInterface;
use App\Repositories\Vehicles\VehiclesRepositoryInterface;
use App\Vehicle;
use App\Repositories\Devices\DevicesRepositoryInterface;
use App\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class MissionsController extends BaseFirmController
{
    protected $missionRep;
    protected $missionRep1;
    protected $priorityRep;
    protected $itemRep;
    protected $clientRep;
    protected $branchRep;
    protected $employeeRep;
    protected $attachmentRep;
    protected $deviceRep;
    protected $vehicleRep;
    protected $statusRep;
    protected $missionOccurrenceRep;

    //***********************************************************************************
    public function __construct(
        MissionsRepositoryInterface $missionRep,
        MissionsRepositoryInterface $missionRep1,
        MissionPrioritiesRepositoryInterface $priorityRep,
        ItemsRepositoryInterface $itemRep,
        ClientsRepositoryInterface $clientRep,
        ClientBranchesRepositoryInterface $branchRep,
        EmployeesRepositoryInterface $employeeRep,
        MissionTaskAttachmentsRepositoryInterface $attachmentRep,
        VehiclesRepositoryInterface $vehicleRep,
        DevicesRepositoryInterface $deviceRep,
        MissionStatusRepositoryInterface $statusRep,
        MissionOccurrencesRepositoryInterface $missionOccurrenceRep
    )
    {
        parent::__construct();
        $this->missionRep = $missionRep;
        $this->missionRep1 = $missionRep1;
        $this->priorityRep = $priorityRep;
        $this->itemRep = $itemRep;
        $this->clientRep = $clientRep;
        $this->branchRep = $branchRep;
        $this->employeeRep = $employeeRep;
        $this->attachmentRep = $attachmentRep;
        $this->vehicleRep = $vehicleRep;
        $this->deviceRep = $deviceRep;
        $this->statusRep = $statusRep;
        $this->missionOccurrenceRep = $missionOccurrenceRep;
    }

    //***********************************************************************************
    public function index()
    {
        $employees = $this->employeeRep->list();
        $clients = $this->clientRep->list();
        $branches = $this->branchRep->list();
        $items = $this->itemRep->list();
        $statuses = $this->statusRep->list();
        return view('firm.missions.index')
            ->with([
                'employees' => $employees,
                'clients' => $clients,
                'branches' => $branches,
                'items' => $items,
                'statuses' => $statuses
            ]);
    }

    //***********************************************************************************
    public function getMissions(Request $request)
    {
        $missions = $this->missionRep
            ->with(["tasks", "employee", "assigned_by", "priority", "client_branch.client", "status"])
            ->list([
                "EmpId" => $request->EmpId,
                "ClientId" => $request->ClientId,
                "ClientBranchId" => $request->ClientBranchId,
                "ItemId" => $request->ItemId,
                "StatusId" => $request->StatusId,
                "from_date" => $request->from_date,
                "to_date" => $request->to_date,
            ]);
        return datatables()->of($missions)->toJson();
    }

    //***********************************************************************************
    public function get($id)
    {
        $mission = $this->missionRep->with(["tasks",
            "tasks.item", "tasks.item.itemTemplate", "tasks.item.itemTemplate.customFields",
            "employee", "assigned_by", "priority", "client_branch.client"])->get($id);
        return view('firm.missions.details')->with(['mission' => $mission]);
    }

    public function getMissionOccurance($id)
    {
        $mission = $this->missionRep->with(["tasks",
            "tasks.item", "tasks.item.itemTemplate", "tasks.item.itemTemplate.customFields",
            "employee", "assigned_by", "priority", "client_branch.client"])
            ->listOccurance([
                "OccuranceId" =>$id
            ])->first();
        return view('firm.missions.details')->with(['mission' => $mission]);
    }

    //***********************************************************************************
    public function create()
    {
        $firm = \CurrentFirm::get();

        $mission = new Mission();
        $employees = $this->employeeRep->list();
        $priorities = $this->priorityRep->list();
        $clients = $this->clientRep->list();
        $branches = [0];
        return view('firm.missions.create')
            ->with([
                'mission' => $mission,
                'employees' => $employees,
                'priorities' => $priorities,
                'clients' => $clients,
                'branches' => $branches,
                '_clientId' => 0,
                'MissionId' => $mission->id,
                'firm' => $firm
            ]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $firm = \CurrentFirm::get();

        $messages = [
            'EmpId.required' => 'The employee field is required!',
            'PriorityId.required' => 'The priority field is required!',
            'ClientId.required' => 'The client field is required!',
            'ClientBranchId.required' => 'The client branch field is required!',
            'title.required' => 'The title field is required!',
            'description.required' => 'The description field is required!',
            'start_date.required' => 'The start date field is required!',
            'complete_date.required' => 'The complete date field is required!',
            'weekly_repeat_value.required' => 'The weekly repeat value field is required!',
            'monthly_repeat_value.required' => 'The monthly repeat value field is required!',
            'start_date_range.required' => 'The start date range field is required!',
            'end_date_range.required' => 'The end date range field is required'
        ];

        $validator_array = [
            'EmpId' => 'required',
            'PriorityId' => 'required',
            'ClientBranchId' => 'required',
            'title' => 'required',
            'description' => 'required',
        ];
        if ($request->complete_date) {
            $validator_array['start_date'] = 'required';
            $validator_array['complete_date'] = 'required';
        }
        if ($request->recurring_type == '1') {
            $validator_array['weekly_repeat_value'] = 'required';
        } elseif ($request->recurring_type == '2') {
            $validator_array['monthly_repeat_value'] = 'required';
        } elseif ($request->recurring_type == '3') {
            $validator_array['start_date_range'] = 'required';
            $validator_array['end_date_range'] = 'required';
        }

        $validator = Validator::make($request->all(), $validator_array, $messages);


        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $firm_login = $request->session()->get('user_firm');

        $mission_array = [
            'EmpId' => $request->EmpId,
            'AssignedBy' => $firm_login->id,
            'PriorityId' => $request->PriorityId,
            'ClientBranchId' => $request->ClientBranchId,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'complete_date' => $request->complete_date,
        ];

        if ($request->IsRecurring == 'true') {
            if ($request->recurring_type == '1') { //Weekly
                $mission_array['recurring_type'] = $request->recurring_type;
                $mission_array['repeat_value'] = json_encode($request->weekly_repeat_value);
                if ($request->IsLimited == 'true') {
                    $mission_array['total_cycle'] = $request->total_cycle;
                }
            } else if ($request->recurring_type == '2') { //Monthly
                $mission_array['recurring_type'] = $request->recurring_type;
                $mission_array['repeat_value'] = json_encode($request->monthly_repeat_value);
                if ($request->IsLimited == 'true') {
                    $mission_array['total_cycle'] = $request->total_cycle;
                }
            } else if ($request->recurring_type == '3') { //Date Range
                $mission_array['recurring_type'] = $request->recurring_type;
                $mission_array['repeat_value'] = json_encode($request->start_date_range.','.$request->end_date_range);
                if ($request->IsLimited == 'true') {
                    $mission_array['total_cycle'] = $request->total_cycle;
                }
            }
        }

        $created_mission = $this->missionRep->create($mission_array);
        if ($created_mission) {
            session()->flash('success_message', 'Mission created successfully');
//            return redirect('/firm/missions/index');
            return response()->json([
                'success_message' => 'Mission created successfully',
                'MissionId' => $created_mission->id,
                'firm' => $firm
            ]);
        } else {
            session()->flash('error_message', 'Something went wrong');
//            return redirect()->back()->withInput(Input::all())->withErrors($validator);
            return response()->json([
                'error_message' => 'Something went wrong',
            ]);
        }
    }

    //***********************************************************************************
    public function addAttachments(Request $request)
    {
        $mission = $this->missionRep->get($request->mission_id);

        if ($image = $request->file) {
            $path = 'uploads/'.$mission->employee->firm->Slug.'/missions/mission_'.$mission->id.'/mission-attachments/';
            $image_new_name = time() . '_' . $image->getClientOriginalName();
            $image->move($path, $image_new_name);

            $attachment_array = [
                'MissionId' => $mission->id,
                'attachment_url' => $path . $image_new_name,
                'mime_type' => $image->getClientMimeType()
            ];
            $this->attachmentRep->create($attachment_array);
        } else {
            session()->flash('success_message', 'Mission created successfully');
            return redirect('/firm/missions/index');
        }
    }

    //***********************************************************************************
    public function getAttachments($MissionId)
    {
        return datatables()->of($this->attachmentRep->list($MissionId, ''))->toJson();
    }

    //***********************************************************************************
    public function deleteAttachments($MissionId, $AttachmentId)
    {
        $attachment = $this->attachmentRep->get($AttachmentId);
        if ($attachment->attachment_url) {
            @unlink($attachment->getOriginal('attachment_url'));
        }

        $deleted_attachment = $this->attachmentRep->delete($AttachmentId);
        if ($deleted_attachment) {
            return redirect()->back();
        } else {
            return response()->json([
                'error_message' => 'Something went wrong',
            ]);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $mission = $this->missionRep->get($id);
        $employees = $this->employeeRep->list();
        $priorities = $this->priorityRep->list();
        $clients = $this->clientRep->list();
        $branches = $this->branchRep->list();
        $_branch = $this->branchRep->get($mission->ClientBranchId);
        $_client = $this->clientRep->get($_branch->ClientId);
        $attachments = $this->attachmentRep->list($mission->id, '');
        $status = $this->statusRep->list();
        return view('firm.missions.edit')
            ->with([
                'mission' => $mission,
                'employees' => $employees,
                'priorities' => $priorities,
                'clients' => $clients,
                'branches' => $branches,
                '_clientId' => $_client->id,
                'MissionId' => $mission->id,
                'attachments' => $attachments,
                'status' => $status
            ]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $firm = \CurrentFirm::get();
        $messages = [
            'EmpId.required' => 'The employee field is required!',
            'PriorityId.required' => 'The priority field is required!',
            'ClientId.required' => 'The client field is required!',
            'ClientBranchId.required' => 'The client branch field is required!',
            'title.required' => 'The title field is required!',
            'description.required' => 'The description field is required!',
            'start_date.required' => 'The start date field is required!',
            'complete_date.required' => 'The complete date field is required!',
            'weekly_repeat_value.required' => 'The weekly repeat value field is required!',
            'monthly_repeat_value.required' => 'The monthly repeat value field is required!',
            'start_date_range.required' => 'The start date range field is required!',
            'end_date_range.required' => 'The end date range field is required'
        ];

        $validator_array = [
            'EmpId' => 'required',
            'PriorityId' => 'required',
            'ClientBranchId' => 'required',
            'title' => 'required',
            'description' => 'required',
        ];
        if ($request->complete_date) {
               $validator_array['start_date'] = 'required';
               $validator_array['complete_date'] = 'required';
        }
        if ($request->recurring_type == '1') {
            $validator_array['weekly_repeat_value'] = 'required';
        } elseif ($request->recurring_type == '2') {
            $validator_array['monthly_repeat_value'] = 'required';
        } elseif ($request->recurring_type == '3') {
            $validator_array['start_date_range'] = 'required';
            $validator_array['end_date_range'] = 'required';
        }

        $validator = Validator::make($request->all(), $validator_array, $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $mission_array = [
            'EmpId' => $request->EmpId,
            'PriorityId' => $request->PriorityId,
            'ClientBranchId' => $request->ClientBranchId,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'complete_date' => $request->complete_date,
            'StatusId' => $request->StatusId
        ];

        if ($request->IsRecurring == 'true') {
            if ($request->recurring_type == '1') { //Weekly
                $mission_array['recurring_type'] = $request->recurring_type;
                $mission_array['repeat_value'] = json_encode($request->weekly_repeat_value);
                if ($request->IsLimited == 'true') {
                    $mission_array['total_cycle'] = $request->total_cycle;
                } else {
                    $mission_array['total_cycle'] = null;
                }
            } else if ($request->recurring_type == '2') { //Monthly
                $mission_array['recurring_type'] = $request->recurring_type;
                $mission_array['repeat_value'] = json_encode($request->monthly_repeat_value);
                if ($request->IsLimited == 'true') {
                    $mission_array['total_cycle'] = $request->total_cycle;
                } else {
                    $mission_array['total_cycle'] = null;
                }
            }else if ($request->recurring_type == '3') { //Date Range
                $mission_array['recurring_type'] = $request->recurring_type;
                $mission_array['repeat_value'] = json_encode($request->start_date_range.','.$request->end_date_range);
                if ($request->IsLimited == 'true') {
                    $mission_array['total_cycle'] = $request->total_cycle;
                } else {
                    $mission_array['total_cycle'] = null;
                }
            }
        } else {
            $mission_array['recurring_type'] = null;
            $mission_array['repeat_value'] = null;
        }

        $updated_mission = $this->missionRep->update($id, $mission_array);
        if ($updated_mission) {
            session()->flash('success_message', 'Mission updated successfully');
//            return redirect('/firm/missions/index');
            return response()->json([
                'success_message' => 'Mission Task updated successfully',
                'MissionId' => $updated_mission->id,
                'firm' => $firm
            ]);
        } else {
            session()->flash('error_message', 'Something went wrong');
//            return redirect()->back()->withInput(Input::all())->withErrors($validator);
            return response()->json([
                'error_message' => 'Something went wrong',
            ]);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $mission = $this->missionRep->get($id);
        $mission->tasks()->delete();
        $mission->vehicles()->detach();
        $mission->devices()->detach();
        if (count($mission->attachments) > 0) {
            foreach ($mission->attachments as $attachment) {
                @unlink($attachment->getOriginal('attachment_url'));
            }
            $mission->attachments()->delete();
        }

        $deleted_mission = $this->missionRep->delete($id);
        if ($deleted_mission) {
            session()->flash('success_message', 'Mission deleted successfully');
            return redirect('/firm/missions/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

    //***********************************************************************************
    public function checkRelations($id){
        $mission = $this->missionRep->get($id);

        if (count($mission->occurrence) > 0) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    //***********************************************************************************
    public function branches($ClientId, $mission_id = null)
    {
        $branches = $this->branchRep->list($ClientId);
        if ($mission_id) {
            $mission = $this->missionRep->get($mission_id);
        } else {
            $mission = new Mission();
        }
        return view('firm.missions._branches')->with(['branches' => $branches, 'mission' => $mission]);
    }

    //***********************************************************************************
    public function vehicles($id)
    {
        $mission = $this->missionRep->get($id);
        $vehicles = $this->vehicleRep->list('', '', '');
        return view('firm.missions._vehicles')->with(['_mission' => $mission, 'vehicles' => $vehicles]);
    }

    //***********************************************************************************
    public function save_vehicles($id, Request $request)
    {
        $mission = $this->missionRep->get($id);
        $mission->vehicles()->detach();
        $mission->vehicles()->attach($request->mission_vehicles);
        return redirect('/firm/missions/index');
    }

    //***********************************************************************************
    public function devices($id)
    {
        $mission = $this->missionRep->get($id);
        $devices = $this->deviceRep->list('', '', '');
        return view('firm.missions._devices')->with(['_mission' => $mission, 'devices' => $devices]);
    }

    //***********************************************************************************
    public function save_devices($id, Request $request)
    {
        $mission = $this->missionRep->get($id);
        $mission->devices()->detach();
        $mission->devices()->attach($request->mission_devices);
        return redirect('/firm/missions/index');
    }

    //***********************************************************************************
    public function getMissionPopup($id)
    {
        $mission_occurance_id = $id;


        $mission = $this->missionRep
            ->with(["tasks","vehicles", "employee","employee.missions", "assigned_by", "priority", "client_branch.client",
              'occurrence'=> function ($query) use ($mission_occurance_id) {
              $query->where('id', $mission_occurance_id);
        }])->getAll()->first();

        $mission = $mission->OccurrenceAsMissionObj()->first();
        $vehicles =$mission->vehicles;
        $devices =$mission->devices;
        $employees = $this->employeeRep->list();
        $priorities = $this->priorityRep->list();
        $clients = $this->clientRep->list();
        $branches = $this->branchRep->list();
        $_branch = $this->branchRep->get($mission->ClientBranchId);
        $_client = $this->clientRep->get($_branch->ClientId);
        return view('firm.missions._popup')
            ->with([
                'mission' => $mission,
                'employees' => $employees,
                'priorities' => $priorities,
                'clients' => $clients,
                'branches' => $branches,
                'vehicles' => $vehicles,
                'devices' => $devices,
                '_clientId' => $_client->id,
                'MissionId' => $mission->id
            ]);
    }

    //***********************************************************************************
    public function statusInfo($id)
    {
        $tasksOccurrences = [];
        $repsOccurrences = [];

        $mission = $this->missionRep->with(["employee", "occurrence", "client_branch.client", "status"])->get($id);
        if (count($mission->occurrence) > 0){
            $missionOccurrence = $mission->occurrence[0];
            // MissionTasksOccurrences
            if (count($missionOccurrence->tasksOccurrences) > 0) {
                $tasksOccurrences = $missionOccurrence->tasksOccurrences;
            }
            // MissionRepsOccurrences
            if (count($missionOccurrence->repsOccurrences)) {
                $repsOccurrences = $missionOccurrence->repsOccurrences;
            }

        } else {
            $missionOccurrence = null;
        }

        if ($mission->status->id == 3 || $mission->status->id == 5){
            return view('firm.missions.status')->with([
                'mission' => $mission,
                'missionOccurrence' => $missionOccurrence,
                'tasksOccurrences' => $tasksOccurrences,
                'repsOccurrences' => $repsOccurrences
                ]);
        } else {
            abort('404', 'Page not found');
        }
    }

    //***********************************************************************************
    public function occurrencesInfo($id)
    {
        $mission = $this->missionRep->with(["employee", "occurrence", "client_branch.client", "status"])->get($id);

        $mission_occurrences = $this->missionRep1->with(["tasks",
            "tasks.item", "tasks.item.itemTemplate", "tasks.item.itemTemplate.customFields",
            "employee", "assigned_by", "priority", "client_branch.client"])
            ->listOccurance([
                "MissionId" =>$mission->id
            ]);

        return view('firm.missions.occurrences')->with([
            'mission' => $mission,
            'mission_occurrences' => $mission_occurrences
        ]);

    }
}
