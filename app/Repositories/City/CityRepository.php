<?php

namespace App\Repositories\City;


use App\City;

use App\Repositories\BaseRepository;   
class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(City::Query()); 
    }  

    public function list($state_id,$name="")
    {  
        $list = $this->query()->where('state_id',$state_id); 
        if ($name)
        {
            $list = $list->where('name', 'like', '%'.$name.'%');
        }
        $list = $list->get();
        return $list; 
    } 
}