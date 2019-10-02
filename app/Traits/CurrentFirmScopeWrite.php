<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; 

trait CurrentFirmScopeWrite
{  
    public static function bootCurrentFirmScopeWrite()
    {   
       static::creating(function($item){ 
            $firm= \CurrentFirm::get();
            if($firm!= null)
            { 
                $item->FirmId=$firm->id;
            }
        });
        static::updating(function($item){ 
            $firm= \CurrentFirm::get();
            if($firm)
            { 
                $item->FirmId=$firm->id;
            }
        });
    }

    public function firm()
    {
        return $this->belongsTo('App\Firm');
    }
     

}