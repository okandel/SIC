<?php

namespace App\Repositories\IncidentMissions;


interface IncidentMissionsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list(array $param = []);

    public function create(array $incidentIncidentMission_array);

    public function update($id, array $incidentIncidentMission_array);

    public function delete($id);  
}