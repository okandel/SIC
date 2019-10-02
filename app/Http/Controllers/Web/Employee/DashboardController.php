<?php

namespace App\Http\Controllers\Web\Employee;

use App\Employee;
use App\Repositories\Employees\EmployeesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator; 
use App\Http\Controllers\Web\Employee\BaseEmployeeController;

class DashboardController extends BaseEmployeeController
{
    protected $employee;

    public function __construct(EmployeesRepositoryInterface $employee)
    {
        parent::__construct();
        $this->employee = $employee;
    }

    public function index()
    {
        return view('employee.dashboard.index');
    }

    
}
