<?php

namespace App\Repositories\Plans;


interface PlansRepositoryInterface
{
    public function get($id,$fail=true);

    public function list();

    public function create(array $plan_array);

    public function update($id, array $plan_array);

    public function delete($id);

}