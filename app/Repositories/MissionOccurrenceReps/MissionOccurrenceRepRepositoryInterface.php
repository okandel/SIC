<?php

namespace App\Repositories\MissionOccurrenceReps;


interface MissionOccurrenceRepRepositoryInterface
{
    public function get($id,$fail=true);

    public function list();

    public function create(array $_array);

    public function update($id, array $_array);

    public function delete($id);

}