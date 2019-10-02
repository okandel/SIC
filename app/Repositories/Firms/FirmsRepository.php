<?php

namespace App\Repositories\Firms;


use App\Firm;

use App\Repositories\BaseRepository;   
class FirmsRepository extends BaseRepository implements FirmsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Firm::Query()); 
    } 
  
    
    // public function getByDomain($domain)
    // { 
    //     $firm = Firm::first();
    //     return $firm;
    // }

    public function list()
    { 
        $firms = $this->getAll();
        return $firms;
    } 
}