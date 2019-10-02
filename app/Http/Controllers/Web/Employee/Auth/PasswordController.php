<?php

namespace App\Http\Controllers\Web\Employee\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller; 
 
use App\Employee; 
use App\EmployeeRecover;
use App\Role;
use Datatables;
use DB;
use App\Helpers\CommonHelper; 
use Snowfire\Beautymail\Beautymail;
use Validator;
use App\ThirdParty\Nexmo\NexmoMessage;

class PasswordController extends Controller {
 
    public function __construct(  ) {
 
    }

    public function forgot_password() {
        return view('employee/auth/password', []);
    }

    public function postforgot_password(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => "required" 
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());
  
             
        $email = $request["email"];  
        $employee = Employee::where('email',$email)->first(); 
 
        if ($employee == null) { 
            return redirect()->back()->withInput($request->only('email'))
            ->withErrors(['auth.email_not_found' ]); 
        } else {

            $hash = md5(uniqid(rand(), true));


            $employeeRecover = new EmployeeRecover;
            $employeeRecover->email = $employee->email;
            $employeeRecover->token = $hash;
            $employeeRecover->save();
            

            // try {
            //     // send Email
            //     global $emailTo;
            //     $emailTo = $employee->email;
            //     global $emailToName;
            //     $emailToName = $employee->name;

            //     $beautymail = app()->make(Beautymail::class);
            //     $beautymail->send('emails.employee.resetpassword', [
            //         "token" => $hash,
            //         "employee" => $employee], function($message) {
            //         global $emailTo;
            //         global $emailToName;
            //         $message
            //                 ->from(env('MAIL_FROM'))
            //                 ->to($emailTo, $emailToName)
            //                 ->subject(trans('employee.mail_reset_password_subject'));
            //     });
            // } catch (Exception $e) { 
            // }

            return redirect()->back()->with('success', "Reset Email successfully sent.");
        }
    }

    public function reset($token = null) {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        return view('employee/auth/reset', [])->with('token', $token);
    }

    public function post_reset(Request $request) {

        $v = Validator::make($request->all(), [
                    'password' => 'required|confirmed|min:6',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput($request->only('email'))
                            ->withErrors($v->errors());
        }
        
        $password = $request["password"];
        $hash = $request["token"];

        $employeeRecover = EmployeeRecover::where('token', '=', $hash)
                ->first();
        if ($hash == null || $employeeRecover == null) {
            return redirect()->back()->with('error', "Invalid Token");
        } else {
 
            $email = $employeeRecover->email;
            $employee = Employee::where('email' , $email)->first(); 
            $employee->password = bcrypt($password);
            $employee->save();

            return redirect()->back()->with('success', "Password successfully changed.");
        }
        
    }

}
