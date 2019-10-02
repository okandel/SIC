<?php

namespace App\Repositories\MissionStatus;


interface MissionStatusRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($name=null, $order=null);

    public function create(array $status_array);

    public function update($id, array $status_array);

    public function delete($id);

}