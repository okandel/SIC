<?php

namespace App\Repositories\MissionOccurrences;


interface MissionOccurrencesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($MissionId=null);

    public function create(array $occurrence_array);

    public function update($id, array $occurrence_array);

    public function delete($id);

}