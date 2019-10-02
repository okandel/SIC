<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Settings\SettingsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiSettingsController extends Controller
{
    protected $setting;

    public function __construct(SettingsRepositoryInterface $setting)
    {
        $this->setting = $setting;
    }

    public function get(Request $request)
    {
        $setting = $this->setting->get($request->id);
        return response()->json(['data' => $setting]);
    }

    public function list()
    {
        $settings = $this->setting->list();
        return response()->json(['data' => $settings]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $setting_array = [
            'FirmId' => $request->FirmId,
            'key' => $request->key,
            'value' => $request->value,
        ];
        $setting = $this->setting->create($setting_array);

        return response()->json(['data' => $setting]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'FirmId' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $setting_array = [
            'FirmId' => $request->FirmId,
            'key' => $request->key,
            'value' => $request->value,
        ];
        $setting = $this->setting->update($request->id ,$setting_array);

        return response()->json(['data' => $setting]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $setting = $this->setting->delete($request->id);
        return response()->json(['message' => 'Setting deleted successfully', 'deleted_setting' => $setting]);
    }

}
