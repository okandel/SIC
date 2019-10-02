<?php

namespace App\Facades;
 

use Illuminate\Support\Facades\Facade;

 
class EncryptHelper extends Facade{ 
 
    protected static function getFacadeAccessor() { return 'encryptHelper'; }

}