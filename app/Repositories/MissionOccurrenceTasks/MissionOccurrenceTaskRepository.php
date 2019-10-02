<?php

namespace App\Repositories\MissionOccurrenceTasks;


use App\MissionOccurrenceTask;
use App\Repositories\MissionOccurrenceTasks\MissionOccurrenceTaskRepositoryInterface;

use App\Repositories\BaseRepository;   
class MissionOccurrenceTaskRepository extends BaseRepository implements MissionOccurrenceTaskRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionOccurrenceTask::Query()); 
    }  

    public function list($MissionOccurenceId=null)
    { 
        $occurrences = $this->query();
        if ($MissionOccurenceId){
            $occurrences = $occurrences->where('MissionOccurrenceId', '=', $MissionOccurenceId)->get();
        }
        return $occurrences;
    } 
}