<?php

namespace App;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class MissionRecurringException extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;

    protected $fillable = ['FirmId', 'MissionId', 'exception_type', 'exception_value'];

    protected $appends = ['ExceptionValueString', 'ExceptionValueInteger'];

    protected $spatialFields = [
        'display_name'
    ];

    public function getExceptionValueStringAttribute()
    {
        if ($this->exception_type == 1) { //Date
            return $this->exception_value;
        } else if ($this->exception_type == 2) { //Day of week
            $res = collect(json_decode($this->exception_value))->map(function ($v) {
                $v = (int)$v;
                return CommonHelper::GetDayOfWeekString($v);
            });
            return implode(" , ", $res->toArray());
        } else if ($this->exception_type == 3) { //Day of month
            return json_decode($this->exception_value);
        }
    }

    public function getExceptionValueIntegerAttribute()
    {
        if ($this->exception_type == 1) { //Date
            return $this->exception_value;
        } else if ($this->exception_type == 2) { //Day of week
            $res = collect(json_decode($this->exception_value))->map(function ($v) {
                $v = (int)$v;
                return $v;
            });
            return implode(",", $res->toArray());
        } else if ($this->exception_type == 3) { //Day of month
            $res = collect(json_decode($this->exception_value))->map(function ($v) {
                $v = (int)$v;
                return $v;
            });
            return implode(",", $res->toArray());
        }
    }

    public function mission()
    {
        return $this->belongsTo('App\Mission', 'MissionId');
    }
}
