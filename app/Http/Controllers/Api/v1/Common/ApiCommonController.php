<?php
 
namespace App\Http\Controllers\Api\v1\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Common\BaseCommonController;
use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use Illuminate\Support\Facades\Config; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Tag;
use App\Photographer;
use App\Business;
use App\Logging;
use DB;
use App\Helpers\Transformers\Common as CommonTransformer;

class ApiCommonController extends BaseCommonController {

      
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
