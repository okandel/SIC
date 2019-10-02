<?php

namespace App\Repositories\MissionOccurrences;


use App\MissionOccurrence;
use App\Repositories\MissionOccurrences\MissionOccurrencesRepositoryInterface;

use App\Repositories\BaseRepository;   
class MissionOccurrencesRepository extends BaseRepository implements MissionOccurrencesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionOccurrence::Query()); 
    }  

    public function list($MissionId=null)
    { 
        $occurrences = $this->query();
        if ($MissionId){
            $occurrences = $occurrences->where('MissionId', '=', $MissionId)->get();
        }
        return $occurrences;
    } 

    public function setActive($missionOccuranceId, $EmpId)
    {
        $this->query()
            ->where("EmpId", $EmpId)
            ->orWhereHas('mission', function ($query) use ($EmpId) {
                $query->where("EmpId", $EmpId);
            })->update([
                    'is_currently_active' => 0
            ]);
        $this->query()->where('id', '=', $missionOccuranceId)
            ->update([
                'is_currently_active' => 1
            ]);
    }
}