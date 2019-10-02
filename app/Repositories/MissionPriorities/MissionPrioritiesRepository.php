<?php

namespace App\Repositories\MissionPriorities;


use App\MissionPriority;

use App\Repositories\BaseRepository;   
class MissionPrioritiesRepository extends BaseRepository implements MissionPrioritiesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionPriority::Query()); 
    }

    public function list($name=null, $order=null)
    {
        $priorities = $this->query();
        if ($name)
        {
            $priorities = $priorities->where('name', 'like', '%'.$name.'%');
        }
        if ($order)
        {
            $priorities = $priorities->where('order', '=', $order);
        }

        $priorities = $priorities->get();
        return $priorities;
    } 
}