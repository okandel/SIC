<?php

namespace App\Repositories\Missions;


interface MissionsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list(array $param = []);

    public function create(array $mission_array);

    public function update($id, array $mission_array);

    public function delete($id);

    public function setActive($missionId,$EmpId);

}