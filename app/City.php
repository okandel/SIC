<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{

    protected $fillable = ['name', 'country_id', 'state_id' ]; 
    protected $table = 'cities';
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
    public function state()
    {
        return $this->belongsTo('App\State', 'state_id');
    } 
 
}
