<?php

namespace App\Repositories\Plans;


use App\Plan;
use App\Repositories\BaseRepository;   
class PlansRepository extends BaseRepository implements PlansRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Plan::Query()); 
    }  

 
    public function list()
    {
        $plans = $this->getAll();
        return $plans;
    } 
    
}