<?php

namespace App\Http\Controllers\Web\Firm;

use App\Helpers\FilesystemHelper;
use App\Item;
use App\ItemTemplate;
use App\ItemTemplateCustomField;
use App\Repositories\Items\ItemsRepositoryInterface;
use App\Repositories\ItemTemplateCustomFields\ItemTemplateCustomFieldsRepositoryInterface;
use App\Repositories\ItemTemplates\ItemTemplatesRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemsController extends BaseFirmController
{
    protected $itemRep;
    protected $customFieldRep;
    protected $itemTemplateRep;

    //***********************************************************************************
    public function __construct(ItemsRepositoryInterface $itemRep,
                                ItemTemplateCustomFieldsRepositoryInterface $customFieldRep,
                                ItemTemplatesRepositoryInterface $itemTemplateRep
    )
    {
        parent::__construct();
        $this->itemRep = $itemRep;
        $this->customFieldRep = $customFieldRep;
        $this->itemTemplateRep = $itemTemplateRep;
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.items.index');
    }

    //***********************************************************************************
    public function get($id)
    {
        $item = $this->itemRep->get($id);
        return $item;
    }

    //***********************************************************************************
    public function getItems(Request $request)
    {
        $name = $request->name;
        return datatables()->of($this->itemRep->list($name))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $item = new Item();
        $item_templates = $this->itemTemplateRep->list();
        return view('firm.items.create')->with(['item' => $item, 'item_templates' => $item_templates]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'The name field is required!',
            'description.required' => 'The description field is required!',
            //'image.mimes' => 'The image must be valid image!'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            //'image' => 'mimes:jpg,jpeg,png,bmp,tiff'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $item_payload = [];
        $item_array = [
            'ItemTemplateId' => $request->ItemTemplateId,
            'name' => $request->name,
            'description' => $request->description,
        ];
        if ($request->ItemTemplateId) {
            $fields = $this->customFieldRep->list($request->ItemTemplateId);

            foreach ($fields as $field) {
                $name = 'field_' . $field->id;
                $item_payload[$name] = $request->input($name);
            }
            $item_array['item_payload'] = json_encode($item_payload);
        }

        $created_item = $this->itemRep->create($item_array);
        if ($created_item) {
            if ($image = $request->image) {
                $path = 'uploads/' . $created_item->firm->Slug . '/items/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $created_item->image = $path . $image_new_name;

                $created_item->save();
            }
            session()->flash('success_message', 'Item created successfully');
            return redirect('/firm/items/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $item = $this->itemRep->get($id);
        $item_templates = $this->itemTemplateRep->list();
//        $item_payload = json_decode($item->item_payload, true);
        return view('firm.items.edit')->with(['item' => $item, 'item_templates' => $item_templates]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'name.required' => 'The name field is required!',
            'description.required' => 'The description field is required!',
            //'image.mimes' => 'The image must be valid image!'
        ];

        $firm = \CurrentFirm::get();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            //'image' => 'mimes:jpg,jpeg,png,bmp,tiff'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $item_array = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->ItemTemplateId) {
            $fields = $this->customFieldRep->list($request->ItemTemplateId);
            $item_array['ItemTemplateId'] = $request->ItemTemplateId;

            if (count($fields) > 0) {
                foreach ($fields as $field) {
                    $name = 'field_' . $field->id;
                    $item_payload[$name] = $request->input($name);
                }
                $item_array['item_payload'] = json_encode($item_payload);
            }

        }

        $updated_item = $this->itemRep->update($id, $item_array);
        if ($updated_item) {
            if ($image = $request->image) {
                if ($updated_item->image) {
                    @unlink($updated_item->getOriginal('image'));
                }
                $path = 'uploads/' . $updated_item->firm->Slug . '/items/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $updated_item->image = $path . $image_new_name;

                $updated_item->save();
            }
            session()->flash('success_message', 'Item updated successfully');
            return redirect('/firm/items/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $deleted_item = $this->itemRep->delete($id);

        if ($deleted_item) {
            session()->flash('success_message', 'Item deleted successfully');
            return redirect('/firm/items/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

    //***********************************************************************************
    public function checkRelations($id){
        $item = $this->itemRep->get($id);

        if (count($item->tasks) > 0) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    //***********************************************************************************
    public function templates($id, Request $request, $ItemId = null)
    {
        $fields = $this->customFieldRep->list($id);
        if ($ItemId) {
            $item = $this->itemRep->get($ItemId);
            if ($request->ItemTemplateId == $item->ItemTemplateId) {
                $item_payload = json_decode($item->item_payload, true);
                $ItemTemplateId = $item->ItemTemplateId;
            } else {
                $item_payload = null;
                $ItemTemplateId = null;
            }

        } else {
            $item = null;
            $item_payload = null;
            $ItemTemplateId = null;
        }
        return view('firm.items._template')
            ->with([
                'fields' => $fields,
                'item' => $item,
                'item_payload' => $item_payload,
                'ItemTemplateId' => $ItemTemplateId,
                'readonly' => false
            ]);
    }
}
