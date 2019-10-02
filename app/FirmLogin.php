<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FirmLogin extends Model
{

    use \App\Traits\CurrentFirmScope; 
    use \App\Traits\CurrentFirmScopeWrite;
    use SoftDeletes;
    
    protected $fillable = [
        'FirmId',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'email_verified',
        'phone_verified',
        'remember_token',];
    protected $table = 'firms_logins';
 
 
}
