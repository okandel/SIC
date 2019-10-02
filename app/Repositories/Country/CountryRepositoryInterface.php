<?php

namespace App\Repositories\Country;


interface CountryRepositoryInterface
{
    public function get($id,$fail=true);
     

    public function list($name=null);

    public function create(array $date_array);

    public function update($id, array $date_array);

    public function delete($id);

}