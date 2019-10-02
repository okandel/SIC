<?php

namespace App\Http\Controllers\Web\Firm;

use App\Client;
use App\Repositories\Clients\ClientsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class SettingsController extends BaseFirmController
{
    private $request;

    //***********************************************************************************
    function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    //***********************************************************************************
    public function index(Request $request)
    {
        $array_settings = \App\Settings::get();
        return view('firm.settings.index')
            ->with('array_settings', $array_settings);
    }

    //***********************************************************************************
    public function edit(Request $request, $id)
    {
        $setting = \App\Settings::findOrFail($id);
        return view('firm.settings.edit')
            ->with('setting', $setting);
    }

    //***********************************************************************************
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "key" => "required",
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $setting = \App\Settings::findOrFail($id);
        $setting->value = $request->value;
        $saved = $setting->save();

        \Settings::clear();

        if ($saved)
            return redirect(action('Web\Firm\SettingsController@index'));
        else
            return redirect(action('Web\Firm\SettingsController@edit'), $id);

    }

}