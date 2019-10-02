<?php

namespace App\Repositories\MissionTaskTypes;


interface MissionTaskTypesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($name=null, $order=null);

    public function create(array $type_array);

    public function update($id, array $type_array);

    public function delete($id);

}