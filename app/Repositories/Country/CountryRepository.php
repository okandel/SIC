<?php

namespace App\Repositories\Country;


use App\Country;

use App\Repositories\BaseRepository;   
class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Country::Query()); 
    } 
   
    public function list($name="")
    { 

        $list = $this->query(); 
        if ($name)
        {
            $list = $list->where('name', 'like', '%'.$name.'%');
        }
        $list = $list->get();
        return $list; 
    } 
}