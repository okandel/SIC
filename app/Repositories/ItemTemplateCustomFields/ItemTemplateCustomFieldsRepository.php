<?php

namespace App\Repositories\ItemTemplateCustomFields;

use App\ItemTemplateCustomField;

use App\Repositories\BaseRepository;   
class ItemTemplateCustomFieldsRepository extends BaseRepository implements ItemTemplateCustomFieldsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(ItemTemplateCustomField::Query());
    } 
 

    public function list($ItemTemplateId, $display_name=null)
    {
        $fields = $this->query(); 
        $fields = $fields->where('ItemTemplateId', '=', $ItemTemplateId);
        if ($display_name)
        {
            $fields = $fields->where('display_name', 'like', '%'.$display_name.'%');
        }
        $fields = $fields->get();
        return $fields;
    }
 
}