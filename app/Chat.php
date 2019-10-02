<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use \App\Traits\CurrentFirmScope;
    use \App\Traits\CurrentFirmScopeWrite;
    use SoftDeletes;
    protected $fillable = [
        'FirmId',
        'UserId',
        'EmployeeId',
        'ClientRepId',
        'MissionId',
        'from_entry_type',
        'GroupId',
        'message',
        'attachment_url',
        'mime_type'
    ];

    protected $table = 'chats';

    public function firm()
    {
        return $this->belongsTo('App\Firm', 'FirmId');
    }

    public function user()
    {
        return $this->belongsTo('App\FirmLogin', 'UserId');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'EmployeeId');
    }

    public function client_rep()
    {
        return $this->belongsTo('App\ClientRep', 'ClientRepId');
    }
}
