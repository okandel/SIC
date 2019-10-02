<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class ClientBranch extends Model
{
    public $currentFirmRelationPath="client";
    use \App\Traits\CurrentFirmScope; 
    use SpatialTrait; 
    use SoftDeletes;
    protected $table = 'client_branches';



    protected $fillable = [
        'ClientId',
        'display_name',
        'contact_person',
        'email',
        'phone',
        'CountryId',
        'StateId',
        'CityId',
        'address',
        'location'
    ];
    protected $appends = ['lat','lng'];
    
    protected $spatialFields = [
        'location' 
    ];
 
    public function getLatAttribute() {
        if($this->location)
        {
            return $this->location->getLat(); 
        } 
    }
    public function getLngAttribute() {
        if($this->location)
        {
            return $this->location->getLng();
        }
    }

    public function missions()
    {
        return $this->hasMany('App\Mission', 'ClientBranchId');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'ClientId');
    }
    public function reps()
    {
        return $this->belongsToMany('App\ClientRep', 'client_branch_reps', 'BranchId', 'RepId');
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'CountryId');
    }
    public function state()
    {
        return $this->belongsTo('App\State', 'StateId');
    }
    public function city()
    {
        return $this->belongsTo('App\City', 'CityId');
    } 
    public function branch_reps()
    {
        return $this->belongsToMany('App\ClientRep','client_branch_reps', 'BranchId', 'RepId');
    }



}
