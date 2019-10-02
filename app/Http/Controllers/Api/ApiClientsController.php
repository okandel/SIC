<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\v1\Employee\BaseApiController;
use App\Repositories\Clients\ClientsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiClientsController extends BaseApiController
{
    protected $client;

    public function __construct(ClientsRepositoryInterface $client)
    {
        parent::__construct(); 
        $this->client = $client;
    }

    public function get(Request $request)
    {
        $client = $this->client->get($request->id);
        return response()->json(['data' => $client]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required',
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $client_array = [
            'FirmId' => $request->FirmId,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        $client = $this->client->create($client_array);

        return response()->json(['data' => $client]);
    }

    public function list()
    {
        $clients = $this->client->list();
        return response()->json(['data' => $clients]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'FirmId' => 'required',
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails())
            return response()->json(['validator error' => $validator]);

        $client_array = [
            'FirmId' => $request->FirmId,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        $client = $this->client->update($request->id ,$client_array);

        return response()->json(['data' => $client]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['validator error' => $validator]);

        $client = $this->client->delete($request->id);
        return response()->json(['message' => 'client deleted successfully', 'deleted_client' => $client]);
    }

}
