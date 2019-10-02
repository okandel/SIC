<?php

namespace App\Auth\Api\v1;

use Illuminate\Foundation\Request;
use App\Employee;
use App\ClientRep;  
use App\EmployeeDevice;
use App\ClientRepDevice;


 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class UserAuthentication
{

  protected $request;
  protected $user;
  protected $userType;

  public function login(){

    $token = $this->request->header('x-auth-token');
    $this->userType = $this->request->header('x-user-type');
  
    if($this->userType == Config::get('constants.USER_TYPE_EMPLOYEE')){
  
      $employee = null;
      $employee_device = EmployeeDevice::with("Employee")
      ->where('token', $token) 
      ->first();
      if ($employee_device!= null)
      {
          $employee = $employee_device->Employee;
          if ($employee!= null)
          {   
            $this->user = $employee;  
          } 
      }  
    
    }else if($this->userType == Config::get('constants.USER_TYPE_CLIENTREP')){
  
      // $clientRep = null;
      // $clientRep_device = ClientRepDevice//::with('ClientRep')
      // ::where('token', $token) 
      // ->first(); 
        

      // if ($clientRep_device!= null)
      // { 
      //   $clientRep = ClientRep::where('id',$clientRep_device->clientRep_id)->first();
      //   if ($clientRep!= null)
      //   {  
      //     $clientRep = ClientRep::where('email', $clientRep->email)->first();   
        
      //     //$clientRep = ClientRep::where('token', $token)->first();  
      //     if($clientRep!= null){ 
      //       $this->user = $clientRep; 
      //     }
      //   }
      // }
      
    }

	//Log::info("login",["user"=>$this->user]);
		
      if($this->user!= null)
        return true;

    return false;
  }

  public function user(){
    return $this->user;
  }

  public function setRequest($request){

    $this->request = $request;
    return $this;
  }

  public function userType(){ 
    $this->userType = $this->request->header('x-user-type');
    return $this->userType;
  }

}
