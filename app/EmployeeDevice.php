<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDevice extends Model
{
    
    protected $fillable = ['EmpId', 'device_unique_id', 'token', 'firebase_token', 'is_logged_in'];

    public function Employee()
    {
        return $this->belongsTo('App\Employee','EmpId');
    }
}
