<?php

namespace App\Repositories\State;


interface StateRepositoryInterface
{
    public function get($id,$fail=true); 

    public function list($country_id,$name="");

    public function create(array $data_array);

    public function update($id, array $data_array);

    public function delete($id);

}