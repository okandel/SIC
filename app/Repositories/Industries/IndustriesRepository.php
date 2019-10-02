<?php

namespace App\Repositories\Industries;


use App\Industry;

use App\Repositories\BaseRepository;   
class IndustriesRepository extends BaseRepository implements IndustriesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Industry::Query()); 
    } 
   

    public function list()
    {
        $industry = $this->getAll(); 
        return $industry;
    }
 
}