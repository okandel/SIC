<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth; 
use DB;
use Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Snowfire\Beautymail\Beautymail;
use DateTime;
use Config;  
use Illuminate\Support\Facades\Cache;
 
use App\Firm;

class CurrentFirm {
 
    public function get () { 

        $domain = \Request::getHttpHost();
     
        $firm = Firm::where('domain',$domain)->first();
        return $firm;
    }

}
