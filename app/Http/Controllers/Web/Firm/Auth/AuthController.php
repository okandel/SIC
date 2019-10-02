<?php

namespace App\Http\Controllers\Web\Firm\Auth;

use App\FirmLogin;
use App\FirmLoginRecover;
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

class AuthController extends Controller
{
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

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }


    private function generateToken($user_id)
    {

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


    public function index(Request $request)
    {
        return view('firm.auth.login');
    }

    /**
     *
     * @param Request $request
     * @return type
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());

        $user_firm = FirmLogin::where('email', $request->email)->first();
        if ($user_firm && !\Hash::check($request->password, $user_firm->password)) {
            $user_firm = null;
        }

        if (!$user_firm)
            return redirect()->back()->withErrors(['errors', 'Please enter correct email and password']);
        if ($user_firm->email_verified_at == '0000-00-00 00:00:00')
            return redirect()->back()->withErrors(['errors', 'Email Entered is not verified!']);
        if ($request->remember_me) {
            $user_firm->remember_token = md5(rand() . time());
            $is_token_generated = $user_firm->save();
            if (!$is_token_generated)
                return redirect()->back()->withErrors(['errors', 'Database Error!']);
        }
        $request->session()->put('user_firm', $user_firm);
        if (Input::get('returnUrl')) {
            return redirect(url(Input::get('returnUrl')));
        } else {
            return redirect()->to('/firm');
        }

    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->to('/firm/auth/login');
    }

    public function verify_email(Request $request, $token)
    {

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
