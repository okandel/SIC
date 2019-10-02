<?php

namespace App\Repositories\MissionTaskAttachments;


use App\MissionTaskAttachment;

use App\Repositories\BaseRepository;   
class MissionTaskAttachmentsRepository extends BaseRepository implements MissionTaskAttachmentsRepositoryInterface
{
    public function __construct(){ 
        parent::__construct(MissionTaskAttachment::Query()); 
    }  

    public function list($MissionId=null, $TaskId=null)
    {
        $attachments = $this->query();
        if ($MissionId)
        {
            $attachments = $attachments->where('MissionId', '=', $MissionId);
        }
        if ($TaskId)
        {
            $attachments = $attachments->where('TaskId', '=', $TaskId);
        }
        $attachments = $attachments->get();
        return $attachments;
    }
 
}