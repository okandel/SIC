<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Firms\FirmsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiFirmsController extends Controller
{
    protected $firm;

    public function __construct(FirmsRepositoryInterface $firm)
    {
        $this->firm = $firm;
    }

    public function get(Request $request)
    {
        $firm = $this->firm->get($request->id);
        return response()->json(['data' => $firm]);
    }

    public function list()
    {
        $firms = $this->firm->list();
        return response()->json(['data' => $firms]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TimezoneId' => 'required',
            'display_name' => 'required',
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $firm_array = [
            'PlanId' => $request->PlanId,
            'CustomCssId' => $request->CustomCssId,
            'TimezoneId' => $request->TimezoneId,
            'display_name' => $request->display_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone
        ];
        $firm = $this->firm->create($firm_array);

        return response()->json(['data' => $firm]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'TimezoneId' => 'required',
            'display_name' => 'required',
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $firm_array = [
            'PlanId' => $request->PlanId,
            'CustomCssId' => $request->CustomCssId,
            'TimezoneId' => $request->TimezoneId,
            'display_name' => $request->display_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone
        ];
        $firm = $this->firm->update($request->id ,$firm_array);

        return response()->json(['data' => $firm]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $firm = $this->firm->delete($request->id);
        return response()->json(['message' => 'Firm deleted successfully', 'deleted_firm' => $firm]);
    }

}
