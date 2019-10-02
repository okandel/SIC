<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Industries\IndustriesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiIndustriesController extends Controller
{
    protected $industry;

    public function __construct(IndustriesRepositoryInterface $industry)
    {
        $this->industry = $industry;
    }

    public function get(Request $request)
    {
        $industry = $this->industry->get($request->id);
        return response()->json(['data' => $industry]);
    }

    public function list()
    {
        $industries = $this->industry->list();
        return response()->json(['data' => $industries]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $industry_array = [
            'name' => $request->name
        ];
        $industry = $this->industry->create($industry_array);

        return response()->json(['data' => $industry]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $industry_array = [
            'name' => $request->name
        ];
        $industry = $this->industry->update($request->id ,$industry_array);

        return response()->json(['data' => $industry]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $industry = $this->industry->delete($request->id);
        return response()->json(['message' => 'Industry deleted successfully', 'deleted_industry' => $industry]);
    }

}
