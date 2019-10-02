<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\IndustryDB; 
use App\Country; 
use Illuminate\Pagination\LengthAwarePaginator; 
use DB;
use Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Snowfire\Beautymail\Beautymail;
use DateTime;
use Config;
use Swap;
use Carbon\Carbon;
use App\Helpers\Polyline;
use Validator;
use Illuminate\Support\Facades\Cache;
use libphonenumber\PhoneNumberFormat;

class Helper {
   
    public static function truncate($string, $length, $html = true)
    {
        if (strlen($string) > $length) {
            if ($html) {
                // Grabs the original and escapes any quotes
                $original = str_replace('"', '\"', $string);
            }

            // Truncates the string
            $string = substr($string, 0, $length);

            // Appends ellipses and optionally wraps in a hoverable span
            if ($html) {
                $string = '<span title="' . $original . '">' . $string . '&hellip;</span>';
            } else {
                $string .= '...';
            }
        }

        return $string;
    }

}
