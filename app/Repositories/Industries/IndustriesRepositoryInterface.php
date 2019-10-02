<?php

namespace App\Repositories\Industries;


interface IndustriesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list();

    public function create(array $industry_array);

    public function update($id, array $industry_array);

    public function delete($id);

}