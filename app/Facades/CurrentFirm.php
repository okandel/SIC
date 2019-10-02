<?php

namespace App\Facades;
 

use Illuminate\Support\Facades\Facade;

 
class CurrentFirm extends Facade{ 
 
    protected static function getFacadeAccessor() { return 'currentFirm'; }

}