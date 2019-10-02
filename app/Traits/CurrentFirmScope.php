<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; 

trait CurrentFirmScope 
{  
    public static function bootCurrentFirmScope()
    {   
       static::addGlobalScope(new \App\Scopes\CurrentFirmScope); 
    } 

}