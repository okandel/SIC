<?php

namespace App\Http\Controllers\Api\v1\Employee;

use App\Auth\Api\v1\Facades\UserAuthentication as Auth;
use App\Helpers\CommonHelper;

use App\Http\Controllers\Api\v1\ApiController as BaseController;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Firm;
abstract class BaseApiController extends BaseController
{
  function __construct(){

    $this->middleware('user.auth', ['except'=>[ 
          'login','signup',
          'forgotPassword',
          'setDevice',
          'resendEmailVerification' 
          ]]);
    // $this->middleware('employee.auth', ['except'=>[ 
    //     'login','signup',
    //     'forgotPassword',
    //     'setDevice',
    //     'resendEmailVerification' 
    //     ]]);
  }
  
  
  // Formatter
  protected function formatEmployee( $employee) {
        if ($employee== null)
        {
            return null; 
        }
        unset($employee->token,$employee->password,$employee->hash);     
        return $employee;
    }  


}