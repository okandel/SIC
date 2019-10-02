<?php

namespace App\Repositories\Employees;


use App\Employee;
use App\Repositories\BaseRepository;   
class EmployeesRepository extends BaseRepository implements EmployeesRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(Employee::Query()); 
    }  

    public function list($first_name=null,$last_name=null)
    { 
        $employees =$this->query();
        if ($first_name)
        {
            $employees = $employees->where('first_name', 'like', '%'.$first_name.'%');
        }
        if ($last_name)
        {
            $employees = $employees->where('last_name', 'like', '%'.$last_name.'%');
        }

        $employees = $employees->get();
        return $employees;
    }
 
}