<?php

namespace App\Repositories\MissionTasks;

use App\MissionTask;

use App\Repositories\BaseRepository;   
class MissionTasksRepository extends BaseRepository implements MissionTasksRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(MissionTask::Query());
    }

    public function list($MissionId, $TypeId = null, $ItemId = null, $quantity = null)
    {
        $tasks = $this->query()->with('item')->with('type')
            ->where('MissionId', '=', $MissionId);
        if ($TypeId) {
            $tasks = $tasks->where('TypeId', '=', $TypeId);
        }
        if ($ItemId) {
            $tasks = $tasks->where('ItemId', '=', $ItemId);
        }
        if ($quantity) {
            $tasks = $tasks->where('quantity', '=', $quantity);
        }
        $tasks = $tasks->get();
        return $tasks;
    }
}