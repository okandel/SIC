<?php

namespace App\Repositories\MissionPriorities;


interface MissionPrioritiesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($name=null, $order=null);

    public function create(array $priority_array);

    public function update($id, array $priority_array);

    public function delete($id);

}