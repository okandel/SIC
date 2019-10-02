<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Role; 
use Illuminate\Pagination\LengthAwarePaginator; 
use DB;
use Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Snowfire\Beautymail\Beautymail;
use Illuminate\Support\Facades\Cache;
use DateTime;
use Config;
use Swap;
use Carbon\Carbon; 
use Validator; 
use App\Helpers\CommonHelper; 
use App\Mission;
use App\MissionRecurringException;
class MissionHelper {
     
   
    public static function prepareCommingMissionData($currentDate) {
        
        $dayOfWeek = self::DayOfWeek($currentDate);
        $dayOfMonth = self::DayOfMonth($currentDate); 

        \Log::info("####");
        // \Log::info($currentDate);
        // \Log::info($dayOfWeek);
        // \Log::info($dayOfMonth);

        // Get Exception that matches $currentDate and select data in format $FirmID_$MissionId
        $recurring_Exception = MissionRecurringException::withoutGlobalScopes()  
            ->where(function ($query) use($currentDate ) {
                $query->where('exception_type', '=', 1) // Date
                ->whereDate('exception_value', $currentDate)
                        ;
            })
            ->orWhere(function ($query) use($dayOfWeek) {
                $query->where('exception_type', '=', 2)// Day of week 
                ->where('exception_value','like','"'.$dayOfWeek.'"')
                    ;
            })
            ->orWhere(function ($query) use($dayOfMonth) {
                $query->where('exception_type', '=', 3)// Day of Month 
                ->where('exception_value','like','"'.$dayOfMonth.'"');
        })->select('FirmId','MissionId')->get()->map(function($x)  {
            return '['.$x['FirmId']. '_' . ($x['MissionId']??'0').']';
        })->toArray(); 

        //\Log::info("recurring_Exception");
        //\Log::info($recurring_Exception);


        $recurring_Exception =implode("", $recurring_Exception);
        $missions = Mission::withoutGlobalScopes()
        ->join('employees', 'employees.id', '=', 'missions.EmpId') 
        
        // Ignore Exceptions in format $FirmID_$MissionId
        ->whereRaw("'".$recurring_Exception ."' not like CONCAT('%',employees.FirmId,'_0','%')")
        ->whereRaw("'".$recurring_Exception ."' not like CONCAT('%',employees.FirmId,'_',missions.id,'%')")
        
        ->where(function ($query) use($dayOfWeek,$dayOfMonth,$currentDate) {
            $query
                // Match Normal Missions - Not Recurring
                ->whereRaw(\DB::Raw("Date(start_date) = Date('".$currentDate."')"))
                
                // Match Recurring Missions
                ->orWhere(
                function ($query) use($dayOfWeek,$dayOfMonth,$currentDate){
                    $query->where(function ($query) use($dayOfWeek,$dayOfMonth) {
                        $query->where('recurring_type', '=', 1) // Daily
                        ->where('repeat_value','like','"'.$dayOfWeek.'"')
                                ;
                    })->orWhere(function ($query) use($dayOfWeek,$dayOfMonth) {
                            $query->where('recurring_type', '=', 2)// weekly
                            ->where('repeat_value','like','"'.$dayOfMonth.'"')
                                ;
                        }) ;
                });
        })->select('missions.*')->get(); 

        
        //\Log::info($missions);

        return $missions;
    }
    
    // Private Methods
    ////////////////////////////////////////////////////  
    private static function DayOfWeek($currentDate)
    { 
        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];
        $dayOfTheWeek =  $currentDate->dayOfWeek; 
        return $dayOfTheWeek;
    }
    private static function DayOfMonth($currentDate)
    { 
        return $currentDate->day;
    } 
}
