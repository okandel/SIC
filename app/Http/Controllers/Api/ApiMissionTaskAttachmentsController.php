<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionTaskAttachments\MissionTaskAttachmentsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionTaskAttachmentsController extends Controller
{
    protected $attachment;

    public function __construct(MissionTaskAttachmentsRepositoryInterface $attachment)
    {
        $this->attachment = $attachment;
    }

    public function get(Request $request)
    {
        $attachment = $this->attachment->get($request->id);
        return response()->json(['data' => $attachment]);
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TaskId' => 'required',
        ]);

        $attachments = $this->attachment->list($request->TaskId);
        return response()->json(['data' => $attachments]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TaskId' => 'required',
            'attachment_url' => 'required',
            'mime_type' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $attachment_array = [
            'TaskId' => $request->TaskId,
            'attachment_url' => $request->attachment_url,
            'mime_type' => $request->mime_type,
        ];
        $attachment = $this->attachment->create($attachment_array);

        return response()->json(['data' => $attachment]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'TaskId' => 'required',
            'attachment_url' => 'required',
            'mime_type' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $attachment_array = [
            'TaskId' => $request->TaskId,
            'attachment_url' => $request->attachment_url,
            'mime_type' => $request->mime_type,       ];
        $attachment = $this->attachment->update($request->id ,$attachment_array);

        return response()->json(['data' => $attachment]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $attachment = $this->attachment->delete($request->id);
        return response()->json(['message' => 'Attachment deleted successfully', 'deleted_attachment' => $attachment]);
    }

}
