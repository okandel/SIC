<?php

namespace App\Repositories\State;


use App\State;

use App\Repositories\BaseRepository;   
class StateRepository extends BaseRepository implements StateRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(State::Query()); 
    }  
     
    public function list($country_id,$name="")
    { 
        $list = $this->query()->where('country_id',$country_id); 
        if ($name)
        {
            $list = $list->where('name', 'like', '%'.$name.'%');
        }
        $list = $list->get();
        return $list; 
    } 
}   