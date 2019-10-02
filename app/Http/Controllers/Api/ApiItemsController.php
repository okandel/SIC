<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ItemTemplates\ItemsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiItemsController extends Controller
{
    protected $item;

    public function __construct(ItemsRepositoryInterface $item)
    {
        $this->item = $item;
    }

    public function get(Request $request)
    {
        $item = $this->item->get($request->id);
        return response()->json(['data' => $item]);
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required'
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $items = $this->item->list($request->FirmId);
        $data = [];
        foreach ($items as $item) {
            if ($item->customFields)
            {
                if (count($item->customFields) >= 0) {
                    array_push($data, $item);
                }
            }
        }
        return response()->json(['data' => $data]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $item_array = [
            'FirmId' => $request->FirmId,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ];
        $item = $this->item->create($item_array);

        return response()->json(['data' => $item]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'FirmId' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $item_array = [
            'FirmId' => $request->FirmId,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ];
        $item = $this->item->update($request->id ,$item_array);

        return response()->json(['data' => $item]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $item = $this->item->delete($request->id);
        return response()->json(['message' => 'item task deleted successfully', 'deleted_item' => $item]);
    }

}
