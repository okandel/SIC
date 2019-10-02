<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRep extends Model
{
    protected $fillable = [
        'ClientId',
        'first_name',
        'last_name',
        'email',
        'phone',
        'image',
        'email_verified',
        'phone_verified',
        'position',
        'is_main_contact'
    ];
    use SoftDeletes;
    protected $table = 'client_reps';

    public function client()
    {
        return $this->belongsTo('App\Client', 'ClientId');
    }

    public function branches()
    {
        return $this->belongsToMany('App\ClientBranch', 'client_branch_reps', 'RepId', 'BranchId');
    }

    public function rep_branches()
    {
        return $this->belongsToMany('App\ClientBranch', 'client_branch_reps', 'RepId', 'BranchId');
    }

    public function getimageAttribute($value)
    {
        if ($value) {
            return asset($value);
        }
        return asset("/uploads/defaults/client.png");
    }
}

