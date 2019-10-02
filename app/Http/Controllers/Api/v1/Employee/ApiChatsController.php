<?php

namespace App\Http\Controllers\Api\v1\Employee;
use App\Http\Controllers\Api\v1\Employee\BaseApiController;

use App\Repositories\Chats\ChatsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiChatsController extends BaseApiController
{
    protected $messageRep;

    public function __construct(ChatsRepositoryInterface $messageRep)
    {
        parent::__construct();
        $this->messageRep = $messageRep;
    }

    public function get(Request $request)
    {
        $message = $this->messageRep->get($request->id);
        return response()->json(['data' => $message]);
    }

    public function getMessages(Request $request)
    {
        $UserId = $request->UserId;
        $EmployeeId = $request->EmployeeId;
        $messages = $this->messageRep->list($UserId, $EmployeeId);
        return response()->json(['data' => $messages]);
    }

    public function storeMessage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'from_entry_type' => 'required',
            'message' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $message_array = [
            'UserId' => $request->UserId,
            'EmployeeId' => $request->EmployeeId,
            'ClientRepId' => $request->ClientRepId,
            'MissionId' => $request->MissionId,
            'from_entry_type' => $request->from_entry_type,
            'GroupId' => $request->GroupId,
            'message' => $request->message,
        ];
        $message = $this->messageRep->create($message_array);

        return response()->json(['data' => $message]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'from_entry_type' => 'required',
            'message' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $message_array = [
            'UserId' => $request->UserId,
            'EmployeeId' => $request->EmployeeId,
            'ClientRepId' => $request->ClientRepId,
            'MissionId' => $request->MissionId,
            'from_entry_type' => $request->from_entry_type,
            'GroupId' => $request->GroupId,
            'message' => $request->message,
        ];
        $message = $this->messageRep->update($request->id ,$message_array);

        return response()->json(['data' => $message]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $message = $this->messageRep->delete($request->id);
        return response()->json(['message' => 'message deleted successfully', 'deleted_message' => $message]);
    }

}
