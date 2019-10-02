<?php
 
namespace App\Http\Controllers\Api\v1\Employee\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Employee\Common\BaseCommonController;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use Illuminate\Support\Facades\Config; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 
use App\Tutorial; 
use App\Logging;
use DB;
use App\Transformers\TutorialTransformer; 
use App\Helpers\Transformers\Common as CommonTransformer;
 
class ApiCommonController extends BaseCommonController {


    public function tutorial_list() {
        $tutorials = Tutorial::all();
         
        $tutorials = \Fractal::collection($tutorials)
        ->transformWith(new TutorialTransformer()) 
        ->withResourceName('data')
        ->toArray();
        return response()->json($tutorials);  
    }

    public function mobileVersioncheck(Request $request) {
        
        $validator = Validator::make($request->all(), [
            "user_platform" => "required", // 
            "version" => "required",
        ]);
        if ($validator->fails()) {
            return self::errify(400, ['validator' => $validator]);
        } 

        $userType = $request->header('x-user-type') ?? -1 ; 
          
        $is_client = ((int)$userType == Config::get('constants.USER_TYPE_CLIENT'));
        $is_employee = ((int)$userType == Config::get('constants.USER_TYPE_EMPLOYEE'));
        $version_min = "";
        $version_current = "";
         //return json_encode($request->user_platform == Config::get('constants.USER_PLATFORM_Android'));
        if ($request->user_platform == Config::get('constants.USER_PLATFORM_Android'))
        {
            if ($is_client)
            {
                $version_min = \Settings::get("android_client_version_min");  
                $version_current = \Settings::get("android_client_version_current");  
            }else if ($is_employee)
            {
                $version_min = \Settings::get("android_employee_version_min");  
                $version_current = \Settings::get("android_employee_version_current");  
            }else{
                return self::errify(400, ['errors' => ['Invalid Data' ]]);
            }
        }
        else if ($request->user_platform == Config::get('constants.USER_PLATFORM_Ios'))
        {
            if ($is_client)
            {
                $version_min = \Settings::get("ios_client_version_min");  
                $version_current = \Settings::get("ios_client_version_current"); 
            }else if ($is_employee)
            {
                $version_min = \Settings::get("ios_employee_version_min");  
                $version_current = \Settings::get("ios_employee_version_current");  
            }else{
                return self::errify(400, ['errors' => ['Invalid Data' ]]);
            }
        }else
        {
            return self::errify(400, ['errors' => ['Invalid Data' ]]);
        } 

        $status = 0;
        $check_version_min = version_compare($request->version, $version_min, '>=');
        $check_version_current = version_compare($request->version, $version_current, '==');
        if (! $check_version_current)
        {
            $status = 1;
        }
        if (! $check_version_min)
        {
            $status = 2;
        }
        return response()->json(['data' => 
        [
            'status' => $status , // 0 => No updates , 1 => optional , 2 => required
            'min' => $version_min , 
            'latest' => $version_current ] ]);   

        // return response()->json(['data' => 
        // [
        //     'status' => 0 , // 0 => No updates , 1 => optional , 2 => required
        //     'min' => "1.0.0" , 
        //     'latest' => "1.0.0" ] ]);   
       
    }

    public function log(Request $request) {
        return self::errify(404);
        // $validator = Validator::make($request->all(), [ 
        //     "errors" => "required" 
        // ]);
        // if ($validator->fails()) {
        //     return self::errify(400, ['validator' => $validator]);
        // } 

        // $userType = $request->header('x-user-type') ?? '' ; 
        // $token = $request->header('x-auth-token') ?? '' ;

        //  $db_errors = []; 
        //  $valid= true; 
        // foreach ($request->errors as $er) {
        //     $e = json_decode($er, true);
        //     if (is_array($e) && array_key_exists('error_message',$e))
        //     {
        //         $uuid = Str::uuid()->toString();
        //         // $logging = new Logging;
        //         // $logging->id = $uuid;
        //         // $logging->token = $token;
        //         // $logging->user_type = $userType;
    
    
        //         // $logging->url = $request->url; 
        //         // $logging->payload = $request->payload;
        //         // $logging->error = $request->error;
        //         // $logging->status_code = $request->status_code;
        //         // $logging->created_at = $request->created_at ?? date('Y-m-d H:i:s'); 
                
        //         $db_errors[]= [
        //             'id' =>  $uuid,
        //             'token' =>  $token,
        //             'user_type' =>  $userType,
        //             'url' =>  array_key_exists('url',$e)?$e['url']:null,
        //             'payload' => array_key_exists('payload',$e)?$e['payload']:null,
        //             'error_message' =>  array_key_exists('error_message',$e)?$e['error_message']:null,
        //             'status_code' =>  array_key_exists('status_code',$e)?$e['status_code']:null,
        //             'created_at' =>  array_key_exists('url',$e)?$e['created_at']: date('Y-m-d H:i:s'),

        //         ];
        //     }else{
        //         $valid = false;
        //     } 
        // }
        // if (count($db_errors))
        // {
        //     Logging::insert($db_errors); 
        // } 
        // if (!$valid)
        // { 
        //     return self::errify(400, ['errors' => ['Error Message is required' ]]);
        // }
        // return response()->json(['status' => 'ok']); 
         
       
    }
 
}
