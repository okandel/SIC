<?php

namespace App\Http\Controllers\Web\Firm;

use App\Client;
use App\ClientRep;
use App\Repositories\ClientReps\ClientRepsRepositoryInterface;
use App\Repositories\Clients\ClientsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class ClientRepsController extends BaseFirmController
{
    protected $clientRep;
    protected $clientRepsRep;

    //***********************************************************************************
    public function __construct(
        ClientsRepositoryInterface $clientRep,
        ClientRepsRepositoryInterface $clientRepsRep
    )
    {
        parent::__construct();
        $this->clientRep = $clientRep;
        $this->clientRepsRep = $clientRepsRep;
    }

    //***********************************************************************************
    public function index($ClientId)
    {
        $client = $this->clientRep->get($ClientId);
        return view('firm.clients.reps.index')->with(['ClientId' => $ClientId, 'client' => $client]);
    }

    //***********************************************************************************
    public function getReps(Request $request, $ClientId)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        return datatables()->of($this->clientRepsRep->list($ClientId, $first_name, $last_name))->toJson();
    }

    //***********************************************************************************
    public function create($ClientId)
    {
        $client = $this->clientRep->get($ClientId);
        $rep = new ClientRep();
        return view('firm.clients.reps.create')->with(['rep' => $rep, 'ClientId' => $client->id, 'client' => $client]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'first_name.required' => 'The first name field is required!',
            'last_name.required' => 'The last name field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $rep_array = [
            'ClientId' => $request->ClientId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
        ];

        $created_rep = $this->clientRepsRep->create($rep_array);
        if ($created_rep) {
            if ($image = $request->image) {
                $path = 'uploads/' . $created_rep->client->firm->Slug . '/clients/client_'. $request->ClientId.'/reps/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $created_rep->image = $path . $image_new_name;

                $created_rep->save();
            }
            session()->flash('success_message', 'Client rep created successfully');
            return redirect('/firm/client/' . $request->ClientId . '/reps');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($ClientId, $id)
    {
        $rep = $this->clientRepsRep->get($id);
        $client = $this->clientRep->get($ClientId);
        return view('firm.clients.reps.edit')->with(['rep' => $rep, 'ClientId' => $ClientId, 'client' => $client]);
    }

    //***********************************************************************************
    public function update($ClientId, $id, Request $request)
    {
        $messages = [
            'first_name.required' => 'The first name field is required!',
            'last_name.required' => 'The last name field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
        ];
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $rep_array = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
        ];

        $updated_rep = $this->clientRepsRep->update($id, $rep_array);
        if ($updated_rep) {
            if ($image = $request->image) {
                if ($updated_rep->image) {
                    File::delete($updated_rep->getOriginal('image'));
                }
                $path = 'uploads/' . $updated_rep->client->firm->Slug . '/clients/client_'.$ClientId.'/reps/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $updated_rep->image = $path . $image_new_name;

                $updated_rep->save();
            }
            session()->flash('success_message', 'Client rep updated successfully');
            return redirect('/firm/client/' . $ClientId . '/reps');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($ClientId, $id)
    {
        $rep = $this->clientRepsRep->get($id);
        if ($rep->image) {
            @unlink($rep->getOriginal('image'));
        }

        $deleted_rep = $this->clientRepsRep->delete($id);
        if ($deleted_rep) {
            session()->flash('success_message', 'Client rep deleted successfully');
            return redirect('/firm/client/' . $ClientId . '/reps');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
