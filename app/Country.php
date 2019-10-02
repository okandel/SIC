<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{

    protected $fillable = ['name', 'iso3', 'iso2', 'phonecode','capital', 'currency' ]; 
    protected $table = 'countries';

    public function states()
    {
        return $this->hasMany('App\State', 'country_id');
    }
 
}
