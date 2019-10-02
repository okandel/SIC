<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes; 
    use \App\Traits\CurrentFirmScope; 
    use \App\Traits\CurrentFirmScopeWrite; 
    protected $table = 'clients';
    
    protected $fillable = ['FirmId','IsApproved', 'image', 'contact_person', 'email', 'phone'];

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'FirmId');
    }

    public function branches()
    {
        return $this->hasMany('App\ClientBranch', 'ClientId');
    }
    public function reps()
    {
        return $this->hasMany('App\ClientRep', 'ClientId');
    }
 
    public function getimageAttribute($value) {
        if ($value)
        { 
            return asset($value);
        } 
        return asset("/uploads/defaults/client.png");
    }


    public function getStatistics() {
        $missions = $this->branches->pluck('missions')->flatten()->pluck('occurrence')->flatten(); 
        //$excptional_missionsOccurrences = $this->excptional_missionsOccurrences; 
        $all_missions = $missions;//->union($excptional_missionsOccurrences);
 
        $total_tasks = $all_missions->count();
        $new_tasks = $all_missions
            ->filter(function ($value, $key)   {
                return $value->StatusId != 3 &&  $value->StatusId != 5;
            })->count();
        $done_tasks = $all_missions->where('StatusId',3)->count();
        $Rearranged_tasks = $all_missions->where('StatusId',5)->count();
        $statistics = [
            "total_tasks"=>$total_tasks,
            "new_tasks"=>$new_tasks,
            "done_tasks"=>$done_tasks,
            "Rearranged_tasks"=>$Rearranged_tasks,
            "success_rate"=> round($done_tasks/$total_tasks*100,2),
        ];
        return $statistics;
    }

}
