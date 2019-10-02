<?php

namespace App\Repositories\IncidentMissionTasks;

interface IncidentMissionTasksRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($IncidentMissionId, $TypeId, $ItemId);

    public function create(array $incidentMission_task_array);

    public function update($id, array $incidentMission_task_array);

    public function delete($id);

}