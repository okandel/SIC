<?php

namespace App\Repositories\City;


interface CityRepositoryInterface
{
    public function get($id,$fail=true);
     
    public function list($state_id,$name="");

    public function create(array $data_array);

    public function update($id, array $data_array);

    public function delete($id);

}