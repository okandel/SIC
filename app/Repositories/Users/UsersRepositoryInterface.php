<?php

namespace App\Repositories\Users;


interface UsersRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($first_name=null,$last_name=null);

    public function create(array $user_array);

    public function update($id, array $user_array);

    public function delete($id);

}