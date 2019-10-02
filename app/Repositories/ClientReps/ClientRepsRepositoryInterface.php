<?php

namespace App\Repositories\ClientReps;


interface ClientRepsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($ClientId, $first_name=null, $last_name=null);

    public function create(array $rep_array);

    public function update($id, array $rep_array);

    public function delete($id);

}