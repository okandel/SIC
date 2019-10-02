<?php

namespace App\Http\Controllers\Web\Firm;


use App\Item;
use App\ItemCustomField;
use App\Mission;
use App\MissionTask;
use App\MissionTaskAttachment;
use App\MissionTaskType;
use App\Repositories\Items\ItemsRepositoryInterface;
use App\Repositories\Missions\MissionsRepositoryInterface;
use App\Repositories\MissionTaskAttachments\MissionTaskAttachmentsRepositoryInterface;
use App\Repositories\MissionTasks\MissionTasksRepositoryInterface;
use App\Repositories\MissionTaskTypes\MissionTaskTypesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class MissionTasksController extends BaseFirmController
{
    protected $taskRep;
    protected $missionRep;
    protected $attachmentRep;
    protected $typeRep;
    protected $itemRep;

    //***********************************************************************************
    public function __construct(MissionTasksRepositoryInterface $taskRep,
                                MissionsRepositoryInterface $missionRep,
                                MissionTaskAttachmentsRepositoryInterface $attachmentRep,
                                MissionTaskTypesRepositoryInterface $typeRep,
                                ItemsRepositoryInterface $itemRep
    )
    {
        parent::__construct();
        $this->taskRep = $taskRep;
        $this->missionRep = $missionRep;
        $this->attachmentRep = $attachmentRep;
        $this->typeRep = $typeRep;
        $this->itemRep = $itemRep;
    }

    //***********************************************************************************
    public function index($MissionId)
    {
        $types = $this->typeRep->list();
        $items = $this->itemRep->list();
        $mission = $this->missionRep->get($MissionId);
        return view('firm.missions.tasks.index')
            ->with([
                'MissionId' => $MissionId,
                'types' => $types,
                'items' => $items,
                'mission' => $mission
            ]);
    }

    //***********************************************************************************
    public function getTasks(Request $request, $MissionId)
    {
        $TypeId = $request->TypeId;
        $ItemId = $request->ItemId;
        $quantity = $request->quantity;
        return datatables()->of($this->taskRep->list($MissionId, $TypeId, $ItemId, $quantity))->toJson();
    }

    //***********************************************************************************
    public function create($MissionId)
    {
        $mission = $this->missionRep->get($MissionId);
        $task = new MissionTask();
        $items = $this->itemRep->list();
        $fields = [0];
        $types = $this->typeRep->list();
        return view('firm.missions.tasks.create')
            ->with([
                'task' => $task,
                'MissionId' => $mission->id,
                'items' => $items,
                'fields' => $fields,
                'types' => $types,
                'mission' => $mission
            ]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $firm = \CurrentFirm::get();
        $messages = [
            'TypeId.required' => 'The type field is required!',
            'ItemId.required' => 'The item field is required!',
            'quantity.required' => 'The quantity field is required!',
            'quantity.min' => 'The min value of quantity field is 1',
        ];
        $validator = Validator::make($request->all(), [
            'TypeId' => 'required',
            'ItemId' => 'required',
            'quantity' => 'required|min:1',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $task_array = [
            'MissionId' => $request->MissionId,
            'TypeId' => $request->TypeId,
            'ItemId' => $request->ItemId,
            'quantity' => $request->quantity
        ];

        $created_task = $this->taskRep->create($task_array);
        if ($created_task) {
            session()->flash('success_message', 'Mission task created successfully');
//            return redirect('/firm/mission/'.$request->MissionId.'/tasks');
            return response()->json([
                'success_message' => 'Mission Task created successfully',
                'TaskId' => $created_task->id,
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
        $task = $this->taskRep->get($request->task_id);

        if ($image = $request->file) {
            $path = 'uploads/'.$task->mission->employee->firm->Slug.'/missions/mission_'.$task->mission->id.'/tasks/task_'.$task->id.'_attachments/';
            $image_new_name = time() . '_' . $image->getClientOriginalName();
            $image->move($path, $image_new_name);

            $attachment_array = [
                'TaskId' => $task->id,
                'attachment_url' => $path . $image_new_name,
                'mime_type' => $image->getClientMimeType()
            ];
            $this->attachmentRep->create($attachment_array);
        } else {
            session()->flash('success_message', 'Mission task created successfully');
            return redirect('/firm/mission/' . $request->mission_id . '/tasks');
        }
    }

    //***********************************************************************************
    public function getAttachments($MissionId, $TaskId)
    {
        return datatables()->of($this->attachmentRep->list('', $TaskId))->toJson();
    }

    //***********************************************************************************
    public function deleteAttachments($MissionId, $TaskId, $AttachmentId)
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
    public function edit($MissionId, $TaskId)
    {
        $task = $this->taskRep->get($TaskId);
        $items = $this->itemRep->list();
        $types = $this->typeRep->list();
        $attachments = $this->attachmentRep->list('', $task->id);
        $mission = $this->missionRep->get($MissionId);
        return view('firm.missions.tasks.edit')
            ->with([
                'task' => $task,
                'MissionId' => $MissionId,
                'items' => $items,
                'types' => $types,
                'attachments' => $attachments,
                'mission' => $mission
            ]);
    }

    //***********************************************************************************
    public function update($MissionId, $TaskId, Request $request)
    {
        $firm = \CurrentFirm::get();
        $messages = [
            'TypeId.required' => 'The type field is required!',
            'ItemId.required' => 'The item field is required!',
            'quantity.required' => 'The quantity field is required!',
            'quantity.min' => 'The min value of quantity field is 1',
        ];
        $validator = Validator::make($request->all(), [
            'TypeId' => 'required',
            'ItemId' => 'required',
            'quantity' => 'required|min:1',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $task_array = [
            'TypeId' => $request->TypeId,
            'ItemId' => $request->ItemId,
            'quantity' => $request->quantity,
        ];

        $updated_task = $this->taskRep->update($TaskId, $task_array);
        if ($updated_task) {
            session()->flash('success_message', 'Mission task updated successfully');
//            return redirect('/firm/mission/'.$MissionId.'/tasks');
            return response()->json([
                'success_message' => 'Mission Task updated successfully',
                'TaskId' => $updated_task->id,
                'MissionId' => $updated_task->MissionId,
                'TypeId' => $updated_task->TypeId,
                'ItemId' => $updated_task->ItemId,
                'quantity' => $updated_task->quantity,
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
    public function destroy($MissionId, $TaskId)
    {
        $task = $this->taskRep->get($TaskId);
        if (count($task->attachments) > 0) {
            foreach ($task->attachments as $attachment) {
                @unlink($attachment->getOriginal('attachment_url'));
            }
            $task->attachments()->delete();
        }

        $deleted_task = $this->taskRep->delete($TaskId);
        if ($deleted_task) {
            session()->flash('success_message', 'Mission task deleted successfully');
            return redirect('/firm/mission/' . $MissionId . '/tasks');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
