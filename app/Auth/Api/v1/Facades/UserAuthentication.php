<?php

namespace App\Auth\Api\v1\Facades;

use Illuminate\Support\Facades\Facade;

class UserAuthentication extends Facade
{
  protected static function getFacadeAccessor(){
    return 'App\Auth\Api\v1\UserAuthentication';
  }
}
