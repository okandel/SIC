<?php

namespace App\Repositories\IncidentMissionTasks;

use App\IncidentMissionTask;

use App\Repositories\BaseRepository;   
class IncidentMissionTasksRepository extends BaseRepository implements IncidentMissionTasksRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(IncidentMissionTask::Query()); 
    }  
 
    public function list($IncidentMissionId, $TypeId=null, $ItemId=null)
    {
        $tasks = $this->query()->with('item')->with('type')
        ->where('IncidentMissionId', '=', $IncidentMissionId);
        if($TypeId)
        {
            $tasks = $tasks->where('TypeId', '=', $TypeId);
        }
        if($ItemId)
        {
            $tasks = $tasks->where('ItemId', '=', $ItemId);
        }
        $tasks = $tasks->get();
        return $tasks;
    }
 
}