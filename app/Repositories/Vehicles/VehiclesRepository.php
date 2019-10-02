<?php

namespace App\Repositories\Vehicles;


use App\Vehicle;

use App\Repositories\BaseRepository;   
class VehiclesRepository extends BaseRepository implements VehiclesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Vehicle::Query()); 
    }  

    public function list($type=null, $brand=null, $year=null)
    {
        $vehicles = $this->query();
        if ($type)
        {
            $vehicles = $vehicles->where('type', 'like', '%'.$type.'%');
        }
        if ($brand)
        {
            $vehicles = $vehicles->where('brand', 'like', '%'.$brand.'%');
        }
        if ($year)
        {
            $vehicles = $vehicles->where('year', 'like', '%'.$year.'%');
        }

        $vehicles = $vehicles->get();
        return $vehicles;
    }
 
}