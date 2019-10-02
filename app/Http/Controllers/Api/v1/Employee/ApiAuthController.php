<?php

namespace App\Http\Controllers\Api\v1\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Employee\BaseApiController; 
 
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Snowfire\Beautymail\Beautymail;
use App\Helpers\FilesystemHelper;
use App\Country;
use App\Employee;
use App\EmployeeDevice;  
use App\EmployeeRecover; 
use Session;
use DB;
use ArrayObject;
use App\Transformers\EmployeesTransformer; 

//use Object;

class ApiAuthController extends BaseApiController {
    private $request; 
    function __construct(Request $request)
    { 
        parent::__construct(); 
        $this->request = $request;
    }
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function signup (Request $request) {
        
        $messages = [
            'first_name.required' => 'The first name field is required!',
            'last_name.required' => 'The last name field is required!',
            'email.required' => 'The email field is required!',
            'password.required' => 'The password field is required!',
            'phone.required' => 'The phone field is required!',
        ];

        $firm= \CurrentFirm::get();
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
        ], $messages);

        if($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } else {
            
                
            $hash = md5(uniqid(rand(), true));

            $employee = new Employee;
            $employee->first_name = $request->first_name;
            $employee->last_name =  $request->last_name;
            $employee->password = bcrypt($request->password);
            $employee->email = $request->email;  
            $employee->phone = $request->phone;

            $employee->email_verified = false;
            $employee->phone_verified = true; 
            $saved = $employee->save();
 
            $employee->token = md5(rand() . time());
            
            if ($saved) { 
                //Send Email 
                //$this->sendVerificationEmail($employee);  

                return response()->json(['token' => $employee->token,
                /*'verifyemail' =>  url('employee/verifyemail', array($hash))*/]); 
            } else {
                
                return self::errify(400, ['errors' => ['Failed' ]]);
            } 
        }
    }
         
 

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
                    "password" => "required",
                    "email" => "required",
        ]);
        if ($validator->fails()) { 
            return self::errify(400, ['validator' => $validator ]);
        } else {
             

            $employee = Employee::where('email', $request->email)->first();
            if( $employee && !\Hash::check($request->password,$employee->password))
            {
                $employee= null;
            } 
            if ($employee != null) {
                if ($employee->email_verified != true) {
                    return self::errify(400, ['errors' => ['auth.email_not_verified' ]]);
                }  
                
                $employee->token = md5(rand() . time());
                $employee = \Fractal::item($employee)
                ->transformWith(new EmployeesTransformer()) 
                ->withResourceName('data')
                ->toArray();
                return response()->json($employee); 
 
            } else { 
                return self::errify(400, ['errors' => ['Please enter correct email and password']]); 
            }
        }
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function forgotPassword(Request $request) {
         
        $validator = Validator::make($request->all(), ["email" => "required|email"]);
        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator ]);
        } else {
            $email = $request["email"];
            //match - case insestive
            $employee = Employee::where('email',$email)->first(); 
 
            if ($employee == null) { 
                return self::errify(400, ['errors' => ['auth.email_not_found' ]]); 
            } else {

                $hash = md5(uniqid(rand(), true)); 

                $employeeRecover = new EmployeeRecover;
                $employeeRecover->email = $employee->email;
                $employeeRecover->token = $hash; 
                $employeeRecover->save();
 

                // send Email
                global $emailTo;
                $emailTo = $employee->email;
                global $emailToName;
                $emailToName = $employee->name;

                $beautymail = app()->make(Beautymail::class);
                $beautymail->send('emails.employee.resetpassword', [
                    "token" => $hash,
                    "employee" => $employee], function($message) {
                    global $emailTo;
                    global $emailToName;
                    $message
                            ->from(env('MAIL_FROM'))
                            ->to($emailTo, $emailToName)
                            ->subject(trans('employee.mail_reset_password_subject'));
                });
                
                return response()->json(['status' => 'ok']); 
            }
        } 
    }

    
    public function resendEmailVerification (Request $request) {  

        $validator = Validator::make($request->all(), ["email" => "required|email"]);
        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator ]);
        } else {
            $email = $request["email"];
            //match - case insestive
            $employee = Employee::where('email', $email)->first(); 
 
            if ($employee == null) { 
                return self::errify(400, ['errors' => ['auth.email_not_found' ]]);  
            } else if ($employee->email_verified ) { 
                return self::errify(400, ['errors' => ['auth.email_already_verified' ]]); 
            }else {  
                // send Email 
                $this->sendVerificationEmail($employee); 
                
                return response()->json(['status' => 'ok']); 
            }
        }  
    }

    private function sendVerificationEmail($employee)
    { 
        global $emailTo;
        $emailTo = $employee->email;
        global $emailToName;
        $emailToName = $employee->full_name;

        $hash  = $employee->hash;

        $beautymail = app()->make(Beautymail::class);
        $beautymail->send('emails.employee.register', [
            "token" => $hash,
            "employee" => $employee], function($message) {
            global $emailTo;
            global $emailToName;
            $message
                    ->from(env('MAIL_FROM'))
                    ->to($emailTo, $emailToName)
                    ->subject(trans('employee.mail_confirm_email_subject'));
        }); 

         

    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function checkFaceBook_idFound($facebook_id) {
        $facebook_id_count = Employee::where('facebook_id', $facebook_id)->count();
        return $facebook_id_count;
        if ($facebook_id_count > 0) {
            return $facebook_id_count;
        } else {
            return 0;
        }
    }

    public function getTokenForFaceBookTokenFound($facebook_id) {
        $user_name_id = Employee::where('facebook_id', $facebook_id)->first();
       // dd($user_name_id);
        if ($user_name_id) {
            //return $user_name_id[0];
            $token = Employee::where('id', $user_name_id->id)->first();

            return $token->token;
        } else {
            return false;
        }
    }

    public function checkEmailISAlreadyTaken($email) {
        $token = Employee::where('email', $email)->first();
         //dd();
        if ($token) {
            return $token->token;
        }
        return false;
    }
 

    // public function logout(Request $request) {
    //     $employee = Auth::user();
    //     $employeeDB = EmployeeDB::where('email', $employee->email)->first();
    //     // if ($employeeDB != null) {
    //     //     $employeeDB->is_logged_in = 0;
    //     //     $employeeDB->save();
    //     //     return response()->json(['data' => "Logged Out Successfully."]);
    //     // } else
    //     //     return self::errify(400, ['errors' => ['employee.not_found' ]]);
    // }

    public function setDevice(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => "required",
            "device_id" => "required",
            "status" => "required",
            "firebase_token" => "required",
        ]);
        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        }
        $token = $this->request->header('x-auth-token');
   
        //$employee = Auth::user();
        $employee  = Employee::where("email",$request->email)->first();
        if ($employee==null)
        { 
            return self::errify(400, ['errors' => ['Failed to create token']]);
        } 

        $employee_device = EmployeeDevice::
            where('EmpId', $employee->id)
            //->where('token', $token)
            ->where('device_unique_id', $request->device_id)
            ->first();

        if (!$employee_device) {
            $employee_device = new EmployeeDevice(); 
            $employee_device->created_at = date('Y-m-d H:i:s');
        } 
            
        $employee_device->EmpId = $employee->id;
        $employee_device->device_unique_id = $request->device_id;
        
        ($request->status==1)? $employee_device->is_logged_in = 1 : $employee_device->is_logged_in = 0;
        $employee_device->token = $token;
        $employee_device->firebase_token = $request->firebase_token;
        $employee_device->updated_at = date('Y-m-d H:i:s');
        $employee_device->save();
        

        
        $firm =  \CurrentFirm::get();

        //\App\Helpers\FCMHelper::Subscribe_User_To_FireBase_Topic(Config::get('constants._EMPLOYEE_FIREBASE_TOPIC') ."_".$firm->id, [$request->firebase_token]);
        return response()->json(['data' => $employee_device]);
    }
}
