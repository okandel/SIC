<?php

namespace App\Repositories\ItemTemplates;


interface ItemTemplatesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($display_name=null);

    public function create(array $item_array);

    public function update($id, array $item_array);

    public function delete($id);


}