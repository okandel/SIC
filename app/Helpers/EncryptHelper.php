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
class EncryptHelper {


    // $plain_txt = "This is my plain text"; 
    // $t = EncryptHelper::encrypt($plain_txt);
    // return EncryptHelper::decrypt($t);


    private    $encrypt_method = "AES-256-CBC";
    private    $secret_key = 'keykeykeykeykeykkeykeykeykeykeyk';
    private    $secret_iv = 'keykeykeykeykeyk';
    
    public  function encrypt ($string) { 
        // hash
        $key = hash('sha256', $this->secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);

        $output = openssl_encrypt($string, $this->encrypt_method, 'keykeykeykeykeykkeykeykeykeykeyk', OPENSSL_RAW_DATA, 'keykeykeykeykeyk');
        $output = base64_encode($output);
        return $output; 
    }
    public  function decrypt($string) {  
        // hash
        $key = hash('sha256', $this->secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
        $output = openssl_decrypt(
            base64_decode($string)
            , $this->encrypt_method, 'keykeykeykeykeykkeykeykeykeykeyk',
            OPENSSL_RAW_DATA, 'keykeykeykeykeyk');
    
        return $output;
    }

}
