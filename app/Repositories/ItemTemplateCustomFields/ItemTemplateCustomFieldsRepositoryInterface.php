<?php

namespace App\Repositories\ItemTemplateCustomFields;

interface ItemTemplateCustomFieldsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($ItemTemplateId, $display_name=null);

    public function create(array $field_array);

    public function update($id, array $field_array);

    public function delete($id);

}