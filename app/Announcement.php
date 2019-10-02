<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;

    protected $fillable = ['FirmId', 'Client_IDs', 'Emp_IDs', 'subject', 'message', 'published_at'];
}
