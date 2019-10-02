<?php

namespace App\Repositories\Items;

use App\Item;
use App\Repositories\BaseRepository;
class ItemsRepository extends BaseRepository implements ItemsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Item::Query());
    }

    public function list($name=null)
    {
        $items =$this->query();

        if ($name)
        {
            $items = $items->where('name', 'like', '%'.$name.'%');
        }
        $items = $items->get();
        return $items;
    } 
}