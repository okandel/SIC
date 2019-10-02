<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ItemTemplateCustomFields\ItemCustomFieldsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiItemCustomFieldsController extends Controller
{
    protected $field;

    public function __construct(ItemCustomFieldsRepositoryInterface $field)
    {
        $this->field = $field;
    }

    public function get(Request $request)
    {
        $field = $this->field->get($request->id);
        return response()->json(['data' => $field]);
    }

    public function list(Request $request)
    {
        $fields = $this->field->list($request->ItemId);
        return response()->json(['data' => $fields]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ItemId' => 'required',
            'display_name' => 'required',
            'type' => 'required',
//            'options' => 'required',
//            'default_value' => 'required',
//            'is_required' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $field_array = [
            'ItemId' => $request->ItemId,
            'display_name' => $request->display_name,
            'type' => $request->type,
            'options' => $request->options,
            'default_value' => $request->default_value,
            'is_required' => $request->is_required
        ];
        $field = $this->field->create($field_array);

        return response()->json(['data' => $field]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'ItemId' => 'required',
            'display_name' => 'required',
            'type' => 'required',
//            'options' => 'required',
//            'default_value' => 'required',
//            'is_required' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $field_array = [
            'ItemId' => $request->ItemId,
            'display_name' => $request->display_name,
            'type' => $request->type,
            'options' => $request->options,
            'default_value' => $request->default_value,
            'is_required' => $request->is_required
        ];
        $field = $this->field->update($request->id ,$field_array);

        return response()->json(['data' => $field]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $field = $this->field->delete($request->id);
        return response()->json(['message' => 'Field deleted successfully', 'deleted_field' => $field]);
    }

}
