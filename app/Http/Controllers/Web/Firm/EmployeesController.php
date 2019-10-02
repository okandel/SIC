<?php

namespace App\Http\Controllers\Web\Firm;

use App\Employee;
use App\Helpers\FilesystemHelper;
use App\Mission;
use App\Repositories\Devices\DevicesRepositoryInterface;
use App\Repositories\Employees\EmployeesRepositoryInterface;
use App\Repositories\Missions\MissionsRepositoryInterface;
use App\Repositories\Vehicles\VehiclesRepositoryInterface;
use App\Vehicle;
use App\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Snowfire\Beautymail\Beautymail;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; 
use App\Http\Controllers\Web\Firm\BaseFirmController;

class EmployeesController extends BaseFirmController
{
    protected $employeeRep;
    protected $missionRep;
    protected $vehicleRep;
    protected $deviceRep;

    //***********************************************************************************
    public function __construct(EmployeesRepositoryInterface $employeeRep,
                                MissionsRepositoryInterface $missionRep,
                                VehiclesRepositoryInterface $vehicleRep,
                                DevicesRepositoryInterface $deviceRep)
    {
        parent::__construct();
        $this->employeeRep = $employeeRep;
        $this->missionRep = $missionRep;
        $this->vehicleRep = $vehicleRep;
        $this->deviceRep = $deviceRep;
    }

    //***********************************************************************************
    public function index()
    {
        $employee = new Employee();
        $vehicles = $this->vehicleRep->list();
        return view('firm.employees.index')->with(['vehicles' => $vehicles, 'employee' => $employee]);
    }

    //***********************************************************************************
    public function get($EmpId)
    {
        $employee = $this->employeeRep->get($EmpId);
        $missions = $this->missionRep->listOccurance(["EmpId" => $EmpId]);
        $assets = $employee->vehicles;
        $devices = $employee->devices; 

        $new_missions = $missions->where('StatusId', '=', '1');
        $pending_missions = $missions->where('StatusId', '=', '2');
        $completed_missions = $missions->where('StatusId', '=', '3');
        $expired_missions = $missions->where('StatusId', '=', '4');
        $re_arranged_missions = $missions->where('StatusId', '=', '5');

        return view('firm.employees.profile')->with([
            'employee' => $employee,
            'missions' => $missions,
            'assets' => $assets,
            'devices' => $devices,
            'new_missions' => count($new_missions),
            'pending_missions' => count($pending_missions),
            'completed_missions' => count($completed_missions),
            'expired_missions' => count($expired_missions),
            're_arranged_missions' => count($re_arranged_missions),
        ]);
    }

    //***********************************************************************************
    public function getEmployees(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        return datatables()->of($this->employeeRep->list($first_name, $last_name))->toJson();
    }

    //***********************************************************************************
    public function create()
    {
        $employee = new Employee();
        return view('firm.employees.create')->with(['employee' => $employee]);
    }

    //***********************************************************************************
    public function store(Request $request)
    {
        $messages = [
            'first_name.required' => 'The first name field is required!',
            'last_name.required' => 'The last name field is required!',
            'email.required' => 'The email field is required!',
            'password.required' => 'The password field is required!',
            'phone.required' => 'The phone field is required!',
            'image.mimes' => 'The image must be valid image!',
        ];

        $firm = \CurrentFirm::get();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'max:255',
                Rule::unique('employees')->where('FirmId', $firm->id),
            ],
            'password' => 'required|confirmed|min:6',
            'phone' => 'required',
            //'image' => 'mimes:jpg,jpeg,png,bmp,tiff'
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $employee_array = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'email_verified' => 0,
        ];

        $created_emp = $this->employeeRep->create($employee_array);
        if ($created_emp) {
            if ($image = $request->image) {
                $path = 'uploads/' . $created_emp->firm->Slug . '/employees/employee_'.$created_emp->id.'/';
//                $created_emp->image = FilesystemHelper::uploadRequestFile($request->file('image'),$path . '_' . $created_emp->id);
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $created_emp->image = $path . $image_new_name;

                $created_emp->save();
            }


            global $emailTo;
            $emailTo = $request->email;
            global $emailToName;
            $emailToName = $request->first_name . " " . $request->last_name;

            $hash = $created_emp->hash;

            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('emails.employee.register', [
                "token" => $hash,
                "employee" => $created_emp], function ($message) {
                global $emailTo;
                global $emailToName;
                $message
                    ->from(env('MAIL_FROM'))
                    ->to($emailTo, $emailToName)
                    ->subject(trans('employee.mail_confirm_email_subject'));
            });


            session()->flash('success_message', 'Employee created successfully');
            return redirect('/firm/employees/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }
    }

    //***********************************************************************************
    public function edit($id)
    {
        $employee = $this->employeeRep->get($id);
        return view('firm.employees.edit')->with(['employee' => $employee]);
    }

    //***********************************************************************************
    public function update($id, Request $request)
    {
        $messages = [
            'first_name.required' => 'The first name field is required!',
            'last_name.required' => 'The last name field is required!',
            'email.required' => 'The email field is required!',
            'phone.required' => 'The phone field is required!',
            'image.mimes' => 'The image must be valid image!'
        ];


        $firm = \CurrentFirm::get();
        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                    'required',
                    'max:255',
                    Rule::unique('employees')->where('FirmId', $firm->id)->ignore($id),
                ],
                'phone' => 'required',
                //'image' => 'mimes:jpg,jpeg,png,bmp,tiff',
                'password' => 'required|confirmed|min:6'
            ], $messages);
        } else {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                    'required',
                    'max:255',
                    Rule::unique('employees')->where('FirmId', $firm->id)->ignore($id),
                ],
                'phone' => 'required',
                'image' => 'image',
            ], $messages);
        }

        if ($validator->fails())
            return redirect()->back()->withInput(Input::all())->withErrors($validator);

        $employee_array = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        if ($request->password) {
            $employee_array['password'] = bcrypt($request->password);
        }

        $employee_array['hash'] = md5(rand() . time());

        $updated_emp = $this->employeeRep->update($id, $employee_array);
        if ($updated_emp) {
            if ($image = $request->image) {
                if ($updated_emp->image) {
                    @unlink($updated_emp->getOriginal('image'));
                }
                $path = 'uploads/' . $updated_emp->firm->Slug . '/employees/employee_'.$updated_emp->id.'/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $updated_emp->image = $path . $image_new_name;

                $updated_emp->save();
            }

            global $emailTo;
            $emailTo = $request->email;
            global $emailToName;
            $emailToName = $request->first_name . " " . $request->last_name;

            $hash = $updated_emp->hash;

            $beautymail = app()->make(Beautymail::class);
            $beautymail->send('emails.employee.register', [
                "token" => $hash,
                "employee" => $updated_emp], function ($message) {
                global $emailTo;
                global $emailToName;
                $message
                    ->from(env('MAIL_FROM'))
                    ->to($emailTo, $emailToName)
                    ->subject(trans('employee.mail_confirm_email_subject'));
            });

            session()->flash('success_message', 'Employee updated successfully');
            return redirect('/firm/employees/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back()->withInput(Input::all())->withErrors($validator);
        }


    }

    //***********************************************************************************
    public function destroy($id)
    {
        $employee = $this->employeeRep->get($id);
        if ($employee->image) {
            @unlink($employee->getOriginal('image'));
        }
        if ($employee->vehicles) {
            $employee->vehicles()->wherePivot('EmployeeId', '=', $employee->id)->detach();
        }
        if ($employee->devices) {
            $employee->devices()->wherePivot('EmpId', '=', $employee->id)->detach();
        }

        $deleted_emp = $this->employeeRep->delete($id);
        if ($deleted_emp) {
            session()->flash('success_message', 'Employee deleted successfully');
            return redirect('/firm/employees/index');
        } else {
            session()->flash('error_message', 'Something went wrong');
            return redirect()->back();
        }
    }

    //***********************************************************************************
    public function checkRelations($id){
        $employee = $this->employeeRep->get($id);

        if (count($employee->missions) > 0) {
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    //***********************************************************************************
    public function vehicles($id)
    {
        $employee = $this->employeeRep->get($id);
        $vehicles = $this->vehicleRep->list();
        return view('firm.employees._vehicles')->with(['_employee' => $employee, 'vehicles' => $vehicles]);
    }

    //***********************************************************************************
    public function save_vehicles($id, Request $request)
    {
        $employee = $this->employeeRep->get($id);
        $employee->vehicles()->detach();
        $employee->vehicles()->attach($request->employee_vehicles);
        return redirect('/firm/employees/index');
    }

    //***********************************************************************************
    public function devices($id)
    {
        $employee = $this->employeeRep->get($id);
        $devices = $this->deviceRep->list();
        return view('firm.employees._devices')->with(['_employee' => $employee, 'devices' => $devices]);
    }

    //***********************************************************************************
    public function save_devices($id, Request $request)
    {
        $employee = $this->employeeRep->get($id);
        $employee->devices()->detach();
        $employee->devices()->attach($request->employee_devices);
        return redirect('/firm/employees/index');
    }
}
