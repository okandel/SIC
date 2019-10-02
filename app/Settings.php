<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use \App\Traits\CurrentFirmScope; 
	use \App\Traits\CurrentFirmScopeWrite;
	
	
	protected $connection = 'mysql';
	protected $label = 'settings';
    protected $fillable = ['FirmId', 'key', 'value'];
	public $timestamps = false;

}
