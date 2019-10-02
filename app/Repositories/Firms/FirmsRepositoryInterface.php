<?php

namespace App\Repositories\Firms;


interface FirmsRepositoryInterface
{
    public function get($id,$fail=true);
    
    //public function getByDomain($domain);

    public function list();

    public function create(array $firm_array);

    public function update($id, array $firm_array);

    public function delete($id);

}