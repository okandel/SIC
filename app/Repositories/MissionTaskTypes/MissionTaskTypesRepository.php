<?php

namespace App\Repositories\MissionTaskTypes;


use App\MissionTaskType;

use App\Repositories\BaseRepository;   
class MissionTaskTypesRepository extends BaseRepository implements MissionTaskTypesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionTaskType::Query()); 
    }  
 
    public function list($name=null, $order=null)
    {
        $types = $this->query();
        if ($name)
        {
            $types = $types->where('name', 'like', '%'.$name.'%');
        }
        if ($order)
        {
            $types = $types->where('order', '=', $order);
        }

        $types = $types->get();
        return $types;
    }

    
}