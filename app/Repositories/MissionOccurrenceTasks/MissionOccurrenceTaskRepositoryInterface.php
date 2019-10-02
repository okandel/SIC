<?php

namespace App\Repositories\MissionOccurrenceTasks;


interface MissionOccurrenceTaskRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($missionOccurrenceId=null);

    public function create(array $occurrence_array);

    public function update($id, array $occurrence_array);

    public function delete($id);

}