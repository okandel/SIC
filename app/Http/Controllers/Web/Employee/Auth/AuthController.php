<?php

namespace App\Http\Controllers\Web\Employee\Auth;

use App\Employee; 
use App\EmployeeRecover; 
use DB;
use DateTime;
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Snowfire\Beautymail\Beautymail;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */ 

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */ 

    const TOKEN_LENGTH = 40;

    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']); 
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
        ]);
    }
 

    private function generateToken($user_id) {

        $today = new DateTime();
        $tokens_deleted = DB::table('token')->where('date_created', '<', $today->modify('-5 days'))->where('entity_code', '=', 'user')->where('entity_id', '=', $user_id)->delete();

        $new_token = str_random(self::TOKEN_LENGTH);

        $_token = new Token([
            'entity_code' => 'user',
            'entity_id' => $user_id,
            'token' => md5($new_token)
        ]);

        $_token->save();



        return $new_token;
    }


    

public function index(Request $request) {
    return view('employee.auth.login');
}

/**
 * 
 * @param Request $request
 * @return type
 */

public function login(Request $request) {
    $validator = Validator::make($request->all(), [
        "email" => "required",
        "password" => "required",
    ]);
    if ($validator->fails())
        return redirect()->back()->withErrors($validator->errors());
  
    $user_employee = Employee::where('email', $request->email)->first();
    if( $user_employee && !\Hash::check($request->password,$user_employee->password))
    {
        $user_employee= null;
    }

    if (!$user_employee)
        return redirect()->back()->withErrors(['errors', 'Please enter correct email and password']);
    if ($user_employee->email_verified_at=='0000-00-00 00:00:00')
        return redirect()->back()->withErrors(['errors', 'Email Entered is not verified!']);
    if ($request->remember_me) {
        $user_employee->remember_token = md5(rand() . time());
        $is_token_generated = $user_employee->save();
        if (!$is_token_generated)
            return redirect()->back()->withErrors(['errors', 'Database Error!']);
    }
    $request->session()->put('user_employee', $user_employee);
    if(Input::get('return_url')) 
        return redirect()->to(Input::get('return_url'));
    return redirect()->to('/employee');
}

public function logout(Request $request) {
    $request->session()->flush();
    return redirect()->to('/employee/auth/login');
}

    public function verify_email(Request $request, $token) {

        $hash = $token;
        $employee = Employee::where('hash', '=', $hash)
                ->first();
        if ($hash == null || $employee == null) {
            return view('employee/auth/verify-email')->with('error', "Invalid Token");
        } else {

            $employee->email_verified = true;
            $employee->save(); 

            return view('employee/auth/verify-email')->with('success', "Email Verified Successfully.");
        }
    }
 
}
