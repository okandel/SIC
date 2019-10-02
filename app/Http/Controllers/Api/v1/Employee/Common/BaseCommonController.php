<?php

namespace App\Http\Controllers\Api\v1\Employee\Common;

use Illuminate\Http\Request;  
use App\Helpers\CommonHelper;

use App\Http\Controllers\Api\v1\ApiController as BaseController;
use Illuminate\Support\Facades\Log;

abstract class BaseCommonController extends BaseController
{
  function __construct(){ 
  } 
}