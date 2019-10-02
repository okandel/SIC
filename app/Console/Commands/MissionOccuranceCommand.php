<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Auth;

use DB; 
use Carbon\Carbon; 
use Illuminate\Console\Command;
use App\Helpers\MissionHelper;
use App\MissionOccurrence;
class MissionOccuranceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission_occurance:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'process mission_occurance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
        \Log::info('==== process mission_occurance  1111111===');
        \Log::info('==== start ===');
      
        $currentDate = Carbon::Today()->add(1, 'day');
        $missions = MissionHelper::prepareCommingMissionData($currentDate);
        $missions = $missions->map(function($item) use($currentDate) {

            $start_date = Carbon::parse($item['start_date']); 
            $diff = 0;
            $diff = $start_date->diffInSeconds(Carbon::parse($start_date->todatestring()));
            $scheduled_date = $currentDate->copy()->add($diff, 'second'); 
            $x = array();
            $x['MissionId'] = $item['id']; 
            $x['EmpId'] = null;//$item['EmpId']; 
            $x['StatusId'] = 1;  
            $x['scheduled_date'] = $scheduled_date; 
            $x['comment'] = $item['notes']??""; 
            $x['created_at'] = Carbon::now(); 
            $x['updated_at'] = Carbon::now(); 
             
            return $x;
        });
     
        //\Log::info($missions);
        MissionOccurrence::insert($missions->toArray());

        \Log::info('==== success ===');
        \Log::info('==== end ===');
    }
}
