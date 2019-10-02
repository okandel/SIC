<?php

namespace App\Repositories\MissionStatus;


use App\MissionStatus;

use App\Repositories\BaseRepository;   
class MissionStatusRepository extends BaseRepository implements MissionStatusRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionStatus::Query()); 
    }

    public function list($name=null, $order=null)
    {
        $status = $this->query();
        if ($name)
        {
            $status = $status->where('name', 'like', '%'.$name.'%');
        }
        if ($order)
        {
            $status = $status->where('order', '=', $order);
        }

        $status = $status->get();
        return $status;
    }

}