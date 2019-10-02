<?php

namespace App\Http\Controllers\Web\Firm;

use App\ItemTemplateCustomField;
use App\Repositories\ItemTemplateCustomFields\ItemTemplateCustomFieldsRepositoryInterface;
use App\Repositories\ItemTemplates\ItemTemplatesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class ItemTemplateCustomFieldsController extends BaseFirmController
{
    protected $templateRep;
    protected $fieldRep;

    //***********************************************************************************
    public function __construct(
        ItemTemplatesRepositoryInterface $templateRep,
        ItemTemplateCustomFieldsRepositoryInterface $fieldRep
    )
    {
        parent::__construct();
        $this->templateRep = $templateRep;
        $this->fieldRep = $fieldRep;
    }

    //***********************************************************************************
    public function index($ItemTemplateId)
    {
        $template = $this->templateRep->get($ItemTemplateId);
        return view('firm.itemTemplates.customFields.index')->with(['ItemTemplateId' => $ItemTemplateId, 'template' => $template]);
    }

    //***********************************************************************************
    public function getFields(Request $request, $ItemTemplateId)
    {
        $display_name = $request->display_name;
        return datatables()->of($this->fieldRep->list($ItemTemplateId, $display_name))->toJson();
    }

    //***********************************************************************************
    public function create($id)
    {
        $item_template = $this->templateRep->get($id);
        $field = new ItemTemplateCustomField();
        return view('firm.itemTemplates.customFields.create')->with(['field' => $field, 'ItemTemplateId' => $item_template->id, 'template' => $item_template]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'display_name.required' => 'The display name field is required!',
            'type.required' => 'The type field is required!',
            'is_required.required' => 'The is required field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'display_name' => 'required',
            'type' => 'required',
            'is_required' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $field_array = [
            'ItemTemplateId' => $request->ItemTemplateId,
            'display_name' => $request->display_name,
            'type' => $request->type,
            'options' => $request->options,
            'default_value' => $request->default_value,
            'is_required' => $request->is_required,
        ];

        $created_field = $this->fieldRep->create($field_array);
        if ($created_field) {
            session()->flash('success_message', 'Item Template Custom Field created successfully');
            return redirect('/firm/item-template/' . $request->ItemTemplateId . '/custom-fields');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($ItemTemplateId, $id)
    {
        $field = $this->fieldRep->get($id);
        $template = $this->templateRep->get($ItemTemplateId);
        return view('firm.itemTemplates.customFields.edit')->with(['field' => $field, 'ItemTemplateId' => $ItemTemplateId, 'template' => $template]);
    }

    //***********************************************************************************
    public function update($ItemTemplateId, $id, Request $request)
    {
        $messages = [
            'display_name.required' => 'The display name field is required!',
            'type.required' => 'The type field is required!',
            'is_required.required' => 'The is required field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'display_name' => 'required',
            'type' => 'required',
            'is_required' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $field_array = [
            'display_name' => $request->display_name,
            'type' => $request->type,
            'options' => $request->options,
            'default_value' => $request->default_value,
            'is_required' => $request->is_required,
        ];

        $updated_field = $this->fieldRep->update($id, $field_array);
        if ($updated_field) {
            session()->flash('success_message', 'Item Custom Field updated successfully');
            return redirect('/firm/item-template/' . $ItemTemplateId . '/custom-fields');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($ItemTemplateId, $id)
    {
        $deleted_field = $this->fieldRep->delete($id);

        if ($deleted_field) {
            session()->flash('success_message', 'Item custom field deleted successfully');
            return redirect('/firm/item-template/' . $ItemTemplateId . '/custom-fields');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
