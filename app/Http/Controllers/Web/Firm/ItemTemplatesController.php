<?php

namespace App\Http\Controllers\Web\Firm;

use App\ItemTemplate;
use App\Repositories\ItemTemplates\ItemTemplatesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class ItemTemplatesController extends BaseFirmController
{
    protected $templateRep;

    //***********************************************************************************
    public function __construct(ItemTemplatesRepositoryInterface $templateRep)
    {
        parent::__construct();
        $this->templateRep = $templateRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.itemTemplates.index');
    }

    //***********************************************************************************
    public function getTemplates(Request $request)
    {
        $display_name = $request->display_name;
        return datatables()->of($this->templateRep->list($display_name))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $item_template = new ItemTemplate();
        return view('firm.itemTemplates.create')->with(['item_template' => $item_template]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'display_name.required' => 'The display name field is required!',
            'description.required' => 'The description field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'display_name' => 'required',
            'description' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $item_template_array = [
            'display_name' => $request->display_name,
            'description' => $request->description,
        ];

        $created_item_template = $this->templateRep->create($item_template_array);
        if ($created_item_template) {
            session()->flash('success_message', 'Item template created successfully');
            return redirect('/firm/item-templates/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $item_template = $this->templateRep->get($id);
        return view('firm.itemTemplates.edit')->with(['item_template' => $item_template]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'display_name.required' => 'The display name field is required!',
            'description.required' => 'The description field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'display_name' => 'required',
            'description' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $item_template_array = [
            'display_name' => $request->display_name,
            'description' => $request->description,
        ];

        $updated_item_template = $this->templateRep->update($id, $item_template_array);
        if ($updated_item_template) {
            session()->flash('success_message', 'Item template updated successfully');
            return redirect('/firm/item-templates/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $template = $this->templateRep->get($id);
        $template->customFields()->delete();

        $deleted_item_template = $this->templateRep->delete($id);

        if ($deleted_item_template) {
            session()->flash('success_message', 'Item template deleted successfully');
            return redirect('/firm/item-templates/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

    //***********************************************************************************
    public function checkRelations($id){
        $template = $this->templateRep->get($id);

        if (count($template->items) > 0) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }
}
