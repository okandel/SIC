<?php

namespace App\Http\Controllers\Api\v1\Employee;
use App\Http\Controllers\Api\v1\Employee\BaseApiController;
 
use App\Repositories\Items\ItemsRepositoryInterface; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use App\Transformers\ItemTransformer; 
use Fractal;

class ApiItemsController extends BaseApiController
{
    protected $item;

    public function __construct(ItemsRepositoryInterface $item)
    {
        parent::__construct(); 
        $this->item = $item;
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            
        ]);

        if($validator->fails()){ 
            return self::errify(400, ['validator' => $validator]);
        }
        $item = $this->item->with(['customFields'])->get($request->id);
        if (empty($item))
        {
            return self::errify(400, ['errors' => ['item.not_found' ]]);    
        }
        $items = Fractal::item($item)
        ->transformWith(new ItemTransformer())
        ->parseIncludes(['customFields' ]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($items); 
    }

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $items = $this->item->with([])->list($request->name);
        if($request->name)
        {
            $items =$items->take(5); 
        }
           
        $items = Fractal::collection($items)
        ->transformWith(new ItemTransformer())
        ->parseIncludes([  ]) 
        ->withResourceName('data')
        ->toArray();
        
        return response()->json($items);  
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
