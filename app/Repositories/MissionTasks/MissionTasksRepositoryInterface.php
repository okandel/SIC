<?php

namespace App\Repositories\MissionTasks;

interface MissionTasksRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($MissionId, $TypeId=null, $ItemId=null, $quantity=null);

    public function create(array $mission_task_array);

    public function update($id, array $mission_task_array);

    public function delete($id);

}