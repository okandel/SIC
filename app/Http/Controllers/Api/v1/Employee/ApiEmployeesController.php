<?php

namespace App\Http\Controllers\Api\v1\Employee;

use Fractal;
use App\Http\Controllers\Api\v1\Employee\BaseApiController;
use App\Repositories\Employees\EmployeesRepositoryInterface;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use App\Transformers\EmployeesTransformer; 

class ApiEmployeesController extends BaseApiController
{
    protected $employee;
    protected $employeeTransformer;

    /******************************************************************/
    public function __construct(EmployeesRepositoryInterface $employee)
    {
        parent::__construct();
        $this->employee = $employee;
    }

    /******************************************************************/
    public function getInfo(Request $request)
    {

        $employee_auth = Auth::user();

        $employee_id = $employee_auth->id;
        $employee = $this->employee->with(['missions'])->get($employee_id);
        if (empty($employee)) {
            return self::errify(400, ['errors' => ['employee.not_found']]);
        }

        $employee = Fractal::item($employee)
            ->transformWith(new EmployeesTransformer())
            ->parseIncludes([
                'statistics'])
            ->withResourceName('data')
            ->toArray();
        return response()->json($employee);

    }

    /******************************************************************/
    public function updateInfo(Request $request)
    {
        $employee_auth = Auth::user();
        $employee = $employee_auth;

        $validator = Validator::make($request->all(), [
            "old_password" => "required_with:password",
        ],
            [
                'old_password.required_with' => 'Old password is required',
            ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } else {

            if ($request->first_name) {
                $employee->first_name = $request->first_name;
            }
            if ($request->last_name) {
                $employee->last_name = $request->last_name;
            }
            if ($request->password) {

                if (!\Hash::check($request->old_password, $employee->password)) {
                    return self::errify(400, ['errors' => ['Old password is not valid']]);
                }
                $employee->password = bcrypt($request->password);

                // //send notiifcation
                // $token = $request->header('x-auth-token');
                // $brands_firebase_tokens = Employee::
                //     join('employees_devices', 'employee.id', '=', 'employees_devices.employee_id')
                //     ->where('employee.email', $employee->email)
                //     ->where('employees_devices.token', '!=' , $token)
                //     ->get()
                //     ->pluck('firebase_token')
                //     ->toArray();
                // if (sizeof($brands_firebase_tokens)>0)
                // {
                //     \App\Helpers\FCMHelper::Send_Downstream_Message_Multiple($brands_firebase_tokens,
                //     null,null , [ "data"=> ["force_logout"=>true]]);
                // }
            }
            if ($request->phone) {
                $employee->phone = $request->phone;
            }

            if ($image = $request->image) {
                if ($employee->image) {
                    @unlink($employee->image);
                }
                $path = 'uploads/' . $employee->firm->display_name . '/employees/';
                $image_new_name = time() . '_' . $image->getClientOriginalName();
                $image->move($path, $image_new_name);
                $employee->image = $path . $image_new_name;

            }

            $saved = $employee->save();
            if ($saved) {

                $employee = Fractal::item($employee)
                    ->transformWith(new EmployeesTransformer())
                    ->withResourceName('data')
                    ->toArray();
                return response()->json($employee);


            } else {

                return self::errify(400, ['errors' => ['Failed']]);
            }
        }
    }

    /******************************************************************/
    public function updateStatus(Request $request)
    {
        $employee_auth = Auth::user();
        $employee = $employee_auth;

        $validator = Validator::make($request->all(), [
            "status" => "required|in:0,1"
        ],
            [
                'status.required' => 'Status is required',
            ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } else {

            $employee->duty_status = $request->status;

            $saved = $employee->save();
            if ($saved) {

                $employee = Fractal::item($employee)
                    ->transformWith(new EmployeesTransformer())
                    ->withResourceName('data')
                    ->toArray();
                return response()->json($employee);


            } else {

                return self::errify(400, ['errors' => ['Failed']]);
            }
        }
    }

    /******************************************************************/
    public function getLocation(Request $request)
    {

        $employee_auth = Auth::user();

        $employee_id = $employee_auth->id;
        $employee = $this->employee->with(['missions'])->get($employee_id);
        if (empty($employee)) {
            return self::errify(400, ['errors' => ['employee.not_found']]);
        }

        $employee = Fractal::item($employee)
            ->transformWith(new EmployeesTransformer())
            ->withResourceName('data')
            ->toArray();
        return response()->json($employee);

    }

    /******************************************************************/
    public function updateLocation(Request $request)
    {
        $employee_auth = Auth::user();
        $employee = $employee_auth;

        $validator = Validator::make($request->all(), [
            "lat" => "required",
            "lng" => "required"
        ],
            [
                'lat.required' => 'Current location is required',
                'lng.required' => 'Current location is required',
            ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } else {

            $employee->current_location = new Point($request->lat, $request->lng);
            $employee->alt = $request->alt;
            $employee->speed = $request->speed;
            $employee->bearing_heading = $request->bearing_heading;
            $saved = $employee->save();

            if ($saved) {
                $employee = Fractal::item($employee)
                    ->transformWith(new EmployeesTransformer())
                    ->withResourceName('data')
                    ->toArray();
                return response()->json($employee);
            } else {
                return self::errify(400, ['errors' => ['Failed']]);
            }
        }
    }

    /******************************************************************/
    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }
        $employee = $this->employee->get($request->id);
        if (empty($clientReps)) {
            return self::errify(400, ['errors' => ['employee.not_found']]);
        }
        // return using transformation
        $employee = Fractal::item($employee)
            ->transformWith(new EmployeesTransformer())
            ->withResourceName('data')
            ->toArray();
        return response()->json($employee);
    }

    /******************************************************************/
    public function list(Request $request)
    {
        $employees = $this->employee->list($request->first_name, $request->last_name);
//        return response()->json(['data' => $employees]);

        $employees = Fractal::collection($employees)
            ->transformWith(new EmployeesTransformer())
            ->withResourceName('data')
            ->toArray();
        return response()->json($employees);

    }

    /******************************************************************/
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'FirmId' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }

        $employee_array = [
            'FirmId' => $request->FirmId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified' => false,
            'phone_verified' => false,
        ];
        $employee = $this->employee->create($employee_array);

        return response()->json(['data' => $employee]);
    }

    /******************************************************************/
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'FirmId' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }
        $employee_array = [
            'FirmId' => $request->FirmId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        $employee = $this->employee->update($request->id, $employee_array);

        return response()->json(['data' => $employee]);
    }

    /******************************************************************/
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }
        $employee = $this->employee->delete($request->id);
        return response()->json(['message' => 'employee deleted successfully', 'deleted_employee' => $employee]);
    }

    /******************************************************************/
    public function verify_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }
        $employee_array = [
            'email_verified' => true,
        ];
        $employee = $this->employee->update($request->id, $employee_array);

        return response()->json(['data' => $employee]);
    }

    /******************************************************************/
    public function verify_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }
        $employee_array = [
            'phone_verified' => true,
        ];
        $employee = $this->employee->update($request->id, $employee_array);

        return response()->json(['data' => $employee]);
    }

}
