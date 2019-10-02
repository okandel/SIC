<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MissionAssets\MissionAssetsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiMissionAssetsController extends Controller
{
    protected $asset;

    public function __construct(MissionAssetsRepositoryInterface $asset)
    {
        $this->asset = $asset;
    }

    public function get(Request $request)
    {
        $asset = $this->asset->get($request->id);
        return response()->json(['data' => $asset]);
    }

    public function list(Request $request)
    {
        $assets = $this->asset->list($request->MissionId);
        return response()->json(['data' => $assets]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MissionId' => 'required',
            'VehicleId' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $asset_array = [
            'MissionId' => $request->MissionId,
            'VehicleId' => $request->VehicleId,
        ];
        $asset = $this->asset->create($asset_array);

        return response()->json(['data' => $asset]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'MissionId' => 'required',
            'VehicleId' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $asset_array = [
            'MissionId' => $request->MissionId,
            'VehicleId' => $request->VehicleId,        ];
        $asset = $this->asset->update($request->id ,$asset_array);

        return response()->json(['data' => $asset]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $asset = $this->asset->delete($request->id);
        return response()->json(['message' => 'Asset deleted successfully', 'deleted_asset' => $asset]);
    }

}
