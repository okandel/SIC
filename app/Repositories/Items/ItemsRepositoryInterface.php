<?php

namespace App\Repositories\Items;


interface ItemsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($name=null);

    public function create(array $item_array);

    public function update($id, array $item_array);

    public function delete($id);

}