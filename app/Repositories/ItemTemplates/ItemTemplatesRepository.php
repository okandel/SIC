<?php

namespace App\Repositories\ItemTemplates;

use App\ItemTemplate;

use App\Repositories\BaseRepository;   
class ItemTemplatesRepository extends BaseRepository implements ItemTemplatesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(ItemTemplate::Query());
    }  

    public function list($display_name=null)
    {
        $item_templates = $this->query();
        if ($display_name)
        {
            $item_templates = $item_templates->where('display_name', 'like', '%'.$display_name.'%');
        }
        $item_templates = $item_templates->get();
        return $item_templates;
    } 
 
}