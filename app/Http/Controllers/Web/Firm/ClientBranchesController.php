<?php

namespace App\Http\Controllers\Web\Firm;

use App\Client;
use App\ClientBranch;
use App\ClientRep;
use App\Repositories\ClientBranches\ClientBranchesRepositoryInterface;
use App\Repositories\ClientReps\ClientRepsRepositoryInterface;
use App\Repositories\Clients\ClientsRepositoryInterface;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\State\StateRepositoryInterface;
use App\Repositories\City\CityRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Http\Controllers\Web\Firm\BaseFirmController;

class ClientBranchesController extends BaseFirmController
{
    protected $clientRep;
    protected $branchRep;
    protected $clientRepsRep;
    protected $countryRep;
    protected $stateRep;
    protected $cityRep;

    //***********************************************************************************
    public function __construct(
        ClientsRepositoryInterface $clientRep,
        ClientBranchesRepositoryInterface $branchRep,
        ClientRepsRepositoryInterface $clientRepsRep,
        CountryRepositoryInterface $countryRep,
        StateRepositoryInterface $stateRep,
        CityRepositoryInterface $cityRep
    )
    {
        parent::__construct();
        $this->clientRep = $clientRep;
        $this->branchRep = $branchRep;
        $this->clientRepsRep = $clientRepsRep;
        $this->countryRep = $countryRep;
        $this->stateRep = $stateRep;
        $this->cityRep = $cityRep;
    }

    //***********************************************************************************
    public function index($ClientId)
    {
        $client = $this->clientRep->get($ClientId);
        return view('firm.clients.branches.index')->with(['ClientId' => $ClientId, 'client' => $client]);
    }

    //***********************************************************************************
    public function getBranches(Request $request, $ClientId)
    {
        $display_name = $request->display_name;
        $contact_person = $request->contact_person;
        return datatables()->of($this->branchRep->list($ClientId, $display_name, $contact_person))->toJson();
    }

    //***********************************************************************************
    public function create($id)
    {
        $countries = $this->countryRep->list();
        $client = $this->clientRep->get($id);
        $branch = new ClientBranch();
        $reps = $this->clientRepsRep->list($id);
        return view('firm.clients.branches.create')->with([
            'branch' => $branch,
            'reps' => $reps,
            'ClientId' => $client->id,
            'countries' => $countries,
            'client' => $client
        ]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'display_name.required' => 'The display name field is required!',
            'contact_person.required' => 'The contact person field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
            'address.required' => 'The address field is required!',
            'CountryId.required' => 'The Country field is required!',
            'StateId.required' => 'The State field is required!'
        ];
        $validator = Validator::make($request->all(), [
            'display_name' => 'required',
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'CountryId' => 'required',
            'StateId' => 'required'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $branch_array = [
            'ClientId' => $request->ClientId,
            'display_name' => $request->display_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'CountryId' => $request->CountryId,
            'StateId' => $request->StateId,
            'CityId' => $request->CityId,
            'location' => new Point($request->lat, $request->lng)
        ];

        $created_branch = $this->branchRep->create($branch_array);
        if ($created_branch) {
            $created_branch->branch_reps()->attach($request->branch_reps);
            session()->flash('success_message', 'Client branch created successfully');
            return redirect('/firm/client/' . $request->ClientId . '/branches');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($ClientId, $id)
    {
        $branch = $this->branchRep->get($id);
        $reps = $this->clientRepsRep->list($ClientId);
        $countries = $this->countryRep->list();
        $client = $this->clientRep->get($ClientId);

        return view('firm.clients.branches.edit')->with(['branch' => $branch,
            'ClientId' => $ClientId,
            'reps' => $reps,
            'countries' => $countries,
            'client' => $client
        ]);
    }

    //***********************************************************************************
    public function update($ClientId, $id, Request $request)
    {
        $messages = [
            'display_name.required' => 'The display name field is required!',
            'contact_person.required' => 'The contact person field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
            'address.required' => 'The address field is required!',
            'CountryId.required' => 'The Country field is required!',
            'StateId.required' => 'The State field is required!'
        ];
        $validator = Validator::make($request->all(), [
            'display_name' => 'required',
            'contact_person' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'CountryId' => 'required',
            'StateId' => 'required'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $branch_array = [
            'display_name' => $request->display_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'CountryId' => $request->CountryId,
            'StateId' => $request->StateId,
            'CityId' => $request->CityId,
            'location' => new Point($request->lat, $request->lng)
        ];

        $updated_branch = $this->branchRep->update($id, $branch_array);
        if ($updated_branch) {
            $updated_branch->branch_reps()->detach();
            $updated_branch->branch_reps()->attach($request->branch_reps);
            session()->flash('success_message', 'Client branch updated successfully');
            return redirect('/firm/client/' . $ClientId . '/branches');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function destroy($ClientId, $id)
    {
        $deleted_branch = $this->branchRep->delete($id);

        if ($deleted_branch) {
            session()->flash('success_message', 'Client branch deleted successfully');
            return redirect('/firm/client/' . $ClientId . '/branches');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

}
