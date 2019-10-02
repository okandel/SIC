<?php

namespace App\Http\Controllers\Web\Firm\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller; 
 
use App\FirmLogin; 
use App\FirmLoginRecover;
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
        return view('firm/auth/password', []);
    }

    public function postforgot_password(Request $request) {
        $validator = Validator::make($request->all(), [
            "email" => "required" 
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());
  
             
        $email = $request["email"];  
        $firmLogin = FirmLogin::where('email',$email)->first(); 
 
        if ($firmLogin == null) { 
            return redirect()->back()->withInput($request->only('email'))
            ->withErrors(['auth.email_not_found' ]); 
        } else {

            $hash = md5(uniqid(rand(), true));

            FirmLoginRecover::query()->where('email', $firmLogin->email)->delete();
            $firmLoginRecover = new FirmLoginRecover;
            $firmLoginRecover->email = $firmLogin->email;
            $firmLoginRecover->token = $hash;
            $firmLoginRecover->save();
            

            // try {
            //     // send Email
            //     global $emailTo;
            //     $emailTo = $firmLogin->email;
            //     global $emailToName;
            //     $emailToName = $firmLogin->name;

            //     $beautymail = app()->make(Beautymail::class);
            //     $beautymail->send('emails.firmLogin.resetpassword', [
            //         "token" => $hash,
            //         "firmLogin" => $firmLogin], function($message) {
            //         global $emailTo;
            //         global $emailToName;
            //         $message
            //                 ->from(env('MAIL_FROM'))
            //                 ->to($emailTo, $emailToName)
            //                 ->subject(trans('firmLogin.mail_reset_password_subject'));
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
        return view('firm/auth/reset', [])->with('token', $token);
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

        $firmLoginRecover = FirmLoginRecover::where('token', '=', $hash)
                ->first();
        if ($hash == null || $firmLoginRecover == null) {
            return redirect()->back()->with('error', "Invalid Token");
        } else {
 
            $email = $firmLoginRecover->email;
            $firmLogin = FirmLogin::where('email' , $email)->first(); 
            $firmLogin->password = bcrypt($password);
            $firmLogin->save();

            return redirect()->back()->with('success', "Password successfully changed.");
        }
        
    }

}
