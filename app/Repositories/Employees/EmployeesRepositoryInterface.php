<?php

namespace App\Repositories\Employees;


interface EmployeesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($first_name=null,$last_name=null);

    public function create(array $employee_array);

    public function update($id, array $employee_array);

    public function delete($id);

}