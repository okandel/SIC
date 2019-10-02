<?php

namespace App\Repositories\Admins;


interface AdminsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list();

    public function create(array $admin_array);

    public function update($id, array $admin_array);

    public function delete($id);

}