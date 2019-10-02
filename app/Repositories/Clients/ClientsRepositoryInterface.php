<?php

namespace App\Repositories\Clients;


interface ClientsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list(array $param = []);

    public function create(array $client_array);

    public function update($id, array $client_array);

    public function delete($id);
}