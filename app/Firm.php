<?php

namespace App;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firm extends Model
{

    protected $fillable = ['PlanId', 'CustomCssId', 'TimezoneId', 'domain','display_name', 'contact_person', 'email', 'phone'];
    use SoftDeletes;
    protected $table = 'firms';

    protected $appends = ['Slug'];

    protected $spatialFields = [
        'display_name'
    ];

    public function getSlugAttribute() {
        if($this->display_name)
        {
            return CommonHelper::slugify($this->display_name);
//            dd(CommonHelper::slugify($this->display_name));
        }
    }

    public function services()
    {
        return $this->hasMany('App\Service', 'FirmId');
    }

    public function clients()
    {
        return $this->hasMany('App\Client', 'FirmId');
    }
}
