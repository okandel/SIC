<?php

namespace App\Http\Controllers\Web\Employee;

use Illuminate\Routing\Controller as BaseController;

abstract class BaseEmployeeController extends BaseController
{

  use \App\Traits\Response; 
  function __construct() {

    $this->middleware('employee.auth', ['except'=>[
      'home',
      'login',
    ]]);

  } 

}
