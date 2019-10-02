<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 

class FirmLoginRecover extends Model
{ 
    use \App\Traits\CurrentFirmScope;  
    protected $table = 'firms_logins_recover';
    public $timestamps = false;
}
