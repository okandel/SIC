<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 

class EmployeeRecover extends Model
{ 
    use \App\Traits\CurrentFirmScope;   
    use \App\Traits\CurrentFirmScopeWrite;

    protected $table = 'employees_recover';
    public $timestamps = false;
}
