<?php

namespace App\Http\Controllers\Web\Firm;

use App\Client;
use App\Repositories\ClientBranches\ClientBranchesRepositoryInterface;
use App\Repositories\Clients\ClientsRepositoryInterface;
use App\Repositories\ClientReps\ClientRepsRepositoryInterface;
use App\Repositories\Missions\MissionsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class ClientsController extends BaseFirmController
{
    protected $clientRep;
    protected $missionRep;
    protected $branchRep;

    //***********************************************************************************
    public function __construct(ClientsRepositoryInterface $clientRep,
                                MissionsRepositoryInterface $missionRep,
                                ClientBranchesRepositoryInterface $branchRep)
    {
        parent::__construct();
        $this->clientRep = $clientRep;
        $this->missionRep = $missionRep;
        $this->branchRep = $branchRep;
    }

    //***********************************************************************************
    public function get($ClientId)
    {
        $client = $this->clientRep->get($ClientId);
        $missions = $this->missionRep->listOccurance(["ClientId" => $ClientId]);
        $branches = $this->branchRep->list($ClientId, '', '');

        $new_missions = $missions->where('start_date', '>=', date("Y-m-d", time()));
        $pending_missions = $missions->where('start_date', '<', date("Y-m-d", time()));
        $completed_missions = $missions->where('StatusId', '=', '3');
        $expired_missions = $missions->where('StatusId', '=', '4');
        $re_arranged_missions = $missions->where('StatusId', '=', '5');

        return view('firm.clients.profile')->with([
            'client' => $client,
            'missions' => $missions,
            'branches' => $branches,
            'new_missions' => count($new_missions),
            'pending_missions' => count($pending_missions),
            'completed_missions' => count($completed_missions),
            'expired_missions' => count($expired_missions),
            're_arranged_missions' => count($re_arranged_missions),
        ]);
    }

    //***********************************************************************************
    public function index()
    {
        return view('firm.clients.index');
    }

    //***********************************************************************************
    public function getClients(Request $request)
    {
        $contact_person = $request->contact_person;
        $email = $request->email;
        $phone = $request->phone;
        $status = $request->status;
        return datatables()->of($this->clientRep->list([
            "contact_person" => $contact_person,
            "email" => $email,
            "phone" => $phone,
            "status" => $status]))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $client = new Client();
        return view('firm.clients.create')->with(['client' => $client]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'contact_person.required' => 'The contact person field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
            'image.mimes' => 'The image must be valid image!'
        ];
        $validator = Validator::make($request->all(), [
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required',
            //'image' => 'mimes:jpg,jpeg,png,bmp,tiff'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $client_array = [
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'IsApproved' => $request->has('IsApproved') ? 1 : 0,
        ];

        $created_client = $this->clientRep->create($client_array);
        if ($created_client) {
            if ($image = $request->image) {
                $path = 'uploads/' . $created_client->firm->Slug . '/clients/client_'.$created_client->id.'/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $created_client->image = $path . $image_new_name;

                $created_client->save();
            }
            session()->flash('success_message', 'Client created successfully');
            return redirect('/firm/clients/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $client = $this->clientRep->get($id);
        return view('firm.clients.edit')->with(['client' => $client]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'contact_person.required' => 'The contact person field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
            'image.mimes' => 'The image must be valid image!'
        ];
        $validator = Validator::make($request->all(), [
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required',
            //'image' => 'mimes:jpg,jpeg,png,bmp,tiff'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $client_array = [
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'IsApproved' => $request->has('IsApproved') ? 1 : 0,
        ];
        if ($request->password) {
            $client_array['password'] = bcrypt($request->password);

        }
        $updated_client = $this->clientRep->update($id, $client_array);
        if ($updated_client) {
            if ($image = $request->image) {
                if ($updated_client->image) {
                    File::delete($updated_client->getOriginal('image'));
                }
                $path = 'uploads/' . $updated_client->firm->Slug . '/clients/client_'.$updated_client->id.'/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $updated_client->image = $path . $image_new_name;

                $updated_client->save();
            }
            session()->flash('success_message', 'Client updated successfully');
            return redirect('/firm/clients/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($id)
    {
        $client = $this->clientRep->get($id);
        if ($client->image) {
            @unlink($client->getOriginal('image'));
        }

        $client->reps()->delete();
        $client->branches()->delete();

        $deleted_client = $this->clientRep->delete($id);
        if ($deleted_client) {
            session()->flash('success_message', 'Client deleted successfully');
            return redirect('/firm/clients/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

    //***********************************************************************************
    public function checkRelations($id){
        $client = $this->clientRep->with(['branches','reps','branches.missions'])->get($id);
        $data = $client->branches->count() > 0
            || $client->reps->count() > 0
            || ($client->branches)->pluck('missions')->count() > 0;

        return response()->json(['data' => $data]);
    }
}
