<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;

    protected $fillable = ['FirmId', 'title', 'content', 'image'];
    protected $table = 'tutorials';

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'FirmId');
    }

    public function getimageAttribute($value) {
        if ($value)
        { 
            return asset($value);
        } 
        return asset("/uploads/defaults/tutorial.jpg");
    }
}
