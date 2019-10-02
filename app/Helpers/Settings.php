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
 

class Settings {


    // $plain_txt = "This is my plain text"; 
    // $t = Settings::encrypt($plain_txt);
    // return Settings::decrypt($t);


    private    $encrypt_method = "AES-256-CBC";
    private    $secret_key = 'keykeykeykeykeykkeykeykeykeykeyk';
    private    $secret_iv = 'keykeykeykeykeyk';
    
    public  function get ($key,$default=null) { 
        $settings = Cache::rememberForever('common_settings', function () {
            return  \App\Settings::get();
        }); 

        $s = collect($settings)->firstWhere('key',$key);
        if ($s!= null)
        {
            return $s->value;
        }
        return $default;
    }
    public  function clear() {  
        Cache::forget('common_settings');
        $settings = Cache::rememberForever('common_settings', function () {
            return  \App\Settings::get();
        }); 
    }

}
