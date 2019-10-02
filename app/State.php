<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{

    protected $fillable = ['name', 'country_id' ]; 
    protected $table = 'states';
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
    public function cities()
    {
        return $this->hasMany('App\City', 'country_id');
    }
 
}
