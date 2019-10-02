<?php

namespace App\Http\Controllers\Web\Firm;

use App\Client;
use App\ClientBranch;
use App\Employee;
use App\Mission;
use App\MissionPriority;
use App\Repositories\ClientBranches\ClientBranchesRepositoryInterface;
use App\Repositories\Employees\EmployeesRepositoryInterface;
use App\Repositories\Vehicles\VehiclesRepositoryInterface ; 
use App\Repositories\Clients\ClientsRepositoryInterface;
use App\Repositories\Missions\MissionsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator; 
use App\Http\Controllers\Web\Firm\BaseFirmController; 

class DashboardController extends BaseFirmController
{
    protected $employeeRep;
    protected $vehicleRep;
    protected $missionRep;
    protected $clientRep;
    protected $branchRep;

    //***********************************************************************************
    public function __construct(
        EmployeesRepositoryInterface $employeeRep,
        VehiclesRepositoryInterface $vehicleRep,
        MissionsRepositoryInterface $missionRep,
        ClientsRepositoryInterface $clientRep,
        ClientBranchesRepositoryInterface $branchRep
    )
    {
        parent::__construct();
        $this->employeeRep = $employeeRep;
        $this->vehicleRep = $vehicleRep;
        $this->missionRep = $missionRep;
        $this->clientRep = $clientRep;
        $this->branchRep = $branchRep;
    }

    //***********************************************************************************
    public function index(Request $request)
    { 
        // $firm_login = $request->session()->get('user_firm');  
        // return response()->json(['data' => $firm_login]);  
        $employees = $this->employeeRep->list();
        $vehicles = $this->vehicleRep->list();
        $clients = $this->clientRep->list();
        $branches = $this->branchRep->list();
        return view('firm.dashboard.index')
            ->with([
                'employees' => $employees,
                'vehicles' => $vehicles,
                'clients' => $clients,
                'branches' => $branches
            ]);
    }

    //***********************************************************************************
    public function index2(Request $request)
    {


        // $firm_login = $request->session()->get('user_firm');
        // return response()->json(['data' => $firm_login]);
        $employees = $this->employeeRep->list();
        $vehicles = $this->vehicleRep->list();
        $clients = $this->clientRep->list();
        $branches = $this->branchRep->list();
        return view('firm.dashboard.test')
            ->with([
                'employees' => $employees,
                'vehicles' => $vehicles,
                'clients' => $clients,
                'branches' => $branches
            ]);
    }

    //***********************************************************************************
    public function chat()
    {
        return view('firm.dashboard.chat');
    }

    //***********************************************************************************
    public function send_location()
    {
        return view('firm.dashboard.send-location');
    }

    //***********************************************************************************
    public function get_location()
    {
        return view('firm.dashboard.get-location');
    }
}
