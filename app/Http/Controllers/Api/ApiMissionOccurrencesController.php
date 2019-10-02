<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionOccurrences\MissionOccurrencesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionOccurrencesController extends Controller
{
    protected $occurrence;

    public function __construct(MissionOccurrencesRepositoryInterface $occurrence)
    {
        $this->occurrence = $occurrence;
    }

    public function get(Request $request)
    {
        $occurrence = $this->occurrence->get($request->id);
        return response()->json(['data' => $occurrence]);
    }

    public function list()
    {
        $occurrences = $this->occurrence->list();
        return response()->json(['data' => $occurrences]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MissionId' => 'required',
            'EmpId' => 'required',
            'StatusId' => 'required',
            'due_date' => 'required',
            'progress' => 'required',
            'notes' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $occurrence_array = [
            'MissionId' => $request->MissionId,
            'EmpId' => $request->EmpId,
            'StatusId' => $request->StatusId,
            'scheduled_date' => $request->due_date, 
            'comment' => $request->notes,
        ];
        $occurrence = $this->occurrence->create($occurrence_array);

        return response()->json(['data' => $occurrence]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'MissionId' => 'required',
            'EmpId' => 'required',
            'StatusId' => 'required',
            'due_date' => 'required',
            'progress' => 'required',
            'notes' => 'required',        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $occurrence_array = [
            'MissionId' => $request->MissionId,
            'EmpId' => $request->EmpId,
            'StatusId' => $request->StatusId,
            'due_date' => $request->due_date,
            'progress' => $request->progress,
            'notes' => $request->notes,        ];
        $occurrence = $this->occurrence->update($request->id ,$occurrence_array);

        return response()->json(['data' => $occurrence]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $occurrence = $this->occurrence->delete($request->id);
        return response()->json(['message' => 'Occurrence deleted successfully', 'deleted_occurrence' => $occurrence]);
    }

}
